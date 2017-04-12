<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Mail;
use Session;
use Auth;
use App\Models\Itinerary;
use App\Models\ItineraryOfr;
use Response;
use App;
class QuoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->user_id='';
        if(Auth::check()){
            $this->user_id = Auth::user()->id;
        }
        $this->additionalServices = \Config::get('constants.additional-services');
        $this->locale = App::getLocale();
        $this->userMsg = \Config::get('constants.user');
        if($this->locale == "es"){
            $this->userMsg = \Config::get('constants.es_user');
        }
        $this->incoterm = \Config::get('constants.incoterm');
        $this->trucking = \Config::get('constants.trucking');
        $this->locale = App::getLocale();
    }

    public function checkLogin(){
        if(!Auth::check()){
            if($this->locale == "es"){  
                return Redirect::to("/es/user/login");
            }else{
                return Redirect::to("/user/login");
            }
        }
    }
    public function authenticate(Request $request){
        $post = $request->all();
        //foreach ($post as $key => $value) {
        if(isset($post['ocean_route_id']) && !empty($post['ocean_route_id'])){ 
            $route_rate_id = $post['ocean_route_rate_id'];
        }else{
            $route_rate_id = $post['afr_route_rates_id'];
        }
        if (Auth::check()){
            $data = $request->session()->all();
            $type="airtime";
            if($data['containers']['servicetype'] == "Maritime"){
                $type="maritime";
            }
            $full_name = Auth::user()->name;
            $email = Auth::user()->email;
            if(isset($data['preSignUp']) && !empty($data['preSignUp'])){
                $full_name = $data['preSignUp']['full_name'];
                $email = $data['preSignUp']['email'];
            }
            $container = json_encode($data['containers']);
            $routes = json_encode($data['routes']);
            $datas = array(
                'user_id'=>$this->user_id,
                'full_name' => $full_name,
                'email' => $email,
                'containers' => $container,
                'quote_fee'=>$post['quote_fee'],
                'routes' => $routes,
                'afr_route_id'=>$post['afr_route_id'],
                'ocean_route_id'=>$post['ocean_route_id'],
                'route_rate_id'=>$route_rate_id,
                'ip'=>$request->ip(),
                'ff_id'=>$post['ff_id'],
                'type'=>$type,
                'user_agent'=>$request->header('User-Agent'),
                'per_item'=>$post['per_item'],
                'created' => CURRENT_DATETIME,
            );
            if($request->session()->has('search_id') ){
                $datas['modified'] = CURRENT_DATETIME;
                $search_id = Session::get('search_id');
                $search_id = DB::table('searches')->where('search_id',$search_id)->update($datas);
                Session::put('search_id', $search_id);
            }else{
                $datas['created'] = CURRENT_DATETIME;
                $search_id = DB::table('searches')->insertGetId($datas);
                $data=array();
                $data['url'] = "quote/additional_services/".$search_id;
                DB::table('searches')->where('search_id',$search_id)->update($data);
            }
            //dd($datas);
            Session::forget('ocean_route_id');
            Session::forget('route_rate_id');
            Session::forget('afr_route_id');
            Session::forget('ff_id');
            Session::forget('quote_fee');
            if($this->locale == "es"){  
                return Redirect::to("/es/quote/additional_services/$search_id");
            }else{
                return Redirect::to("/quote/additional_services/$search_id");
            }
        }else{
            Session::put('route_rate_id', $route_rate_id);
            Session::put('ocean_route_id', $post['ocean_route_id']);
            Session::put('afr_route_id', $post['afr_route_id']);
            Session::put('ff_id', $post['ff_id']);
            Session::put('quote_fee',$post['quote_fee']);
            if($this->locale == "es"){  
                return Redirect::to("/es/user/login");
            }else{
                return Redirect::to("/user/login");
            }
        }
    }
    
    
    
    public function getServices(Request $request, $search_id, $add_service=Null){
        $data = $request->session()->all();
        $searches = DB::table('searches')->select('searches.*')->where('searches.search_id','=',$search_id)
        	->where('searches.user_id','=',$this->user_id)->first();
       if(!@$searches){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
            if($this->locale == "es"){  
                return Redirect::to("/es/home")->with('error',$this->userMsg['not_found']);
            }else{
                return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
            }
        }
        $data['service_url'] = $request->session()->get('containers.servicetype').'/search';
        $data['search_id'] = $searches->search_id;
        $data['searches'] = json_decode($searches->containers);
        $data['routes'] = json_decode($searches->routes);
        if($search_id && $add_service){
            $data['result'] = DB::table('additional_services')->select('*')->where('additional_service_id','=',$add_service)->first();
        }
        return view('search.additional_service')->with('data',$data);
    }
    public function postServices(Request $request){
        $post = $request->all();
        $type = $post['servicetype'];
        $this->validate($request, [
            'commercial_invoice' => 'required_if:commercial_invoice_validate,1',
            'vendors_packing'=>'required_if:vendors_packing_validate,1',
            'shipping_packing'=>'required_if:shipping_packing_validate,1',
            'cargo_technical' => 'required_if:cargo_technical_validate,1',
            'cargo_image' => 'required_if:cargo_image_validate,1',
            'catalog' => 'required_if:catalog_validate,1',
            'import_declaration'=>'required_if:import_declaration_validate,1',
            'export_registration_doc' => 'required_if:export_registration_doc_validate,1',
            'origin_autograde' => 'required_if:origin_autograde_validate,1',
            'dian_approval' => 'required_if:dian_approval_validate,1',
            'ica_approval' => 'required_if:ica_approval_validate,1',
            'loading_approval' => 'required_if:loading_approval_validate,1',
            'plant_health' => 'required_if:plant_health_validate,1',
        ]);
        $url = '/admin/additionalRates/'.$post['search_id'].'/'.$type;
        $data = DB::table('searches')->select('users.email','users.name','additional_info.additional_info_id')->join('users','users.id','=','searches.ff_id')->leftjoin('additional_info','additional_info.search_id','=','searches.search_id')->where('searches.search_id','=',$post['search_id'])->first();
        $data = (array) $data;
        $i = 0;
        
        if($this->locale == "es"){
        $html_start ="<p>El numero de referencia de tu cotizacion es: ".$post['search_id'].". <p>El usuario selecciono tu ruta, pero no ha escogido ningun servicio adicional. Por favor agrega las tarifas adicionales a la cotizacion. <a href='".newurl($url)."'>Por favor haga click aca para agregar tarifas.</a></p>";
        }else{
            $html_start ="<p>Your quote reference number is: ".$post['search_id'].". <p>The user has selected your route, but has not selected any additional service. Please fill add rates for the mentioned quote. <a href='".newurl($url)."'>Please click here to add rates.</a></p>";    
        }
        $html_end = $html_center="";
        $check_array = array();
        foreach ($post as $key => $value) {
            if($value =="yes"){
                $i++;
                $check_array[$key]=$value;
                $html_center .= "<li>".$this->additionalServices['check'][$key]."</li>";
            }
        }
        $file = Input::file();
        $new_name = array();
        foreach ($file as $key => $value) {
            $file = $value;
            $Orname = $file->getClientOriginalName();
            $filename= str_random(6).'_'.$key;
            $imageName = $value->getClientOriginalName();
            $destination_path = base_path() . '/public/additional_service/'.$this->user_id;
            $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
            $extension = $file->getClientOriginalExtension();
            $new_name[$key]= $filename.'.'.$extension;
            $file->move($destination_path,$new_name[$key]);
        }
        $insurance = (isset($post['insurance_check']) && $post['insurance_check']=='yes')? 1:0;
        $tariff_classification = (isset($post['tariff_classification_check']) && $post['tariff_classification_check']=='yes')? 1:0;

        Session::put('insurance',$insurance);   
        Session::put('tariff_classification',$tariff_classification);  

        $final_stats['check'] =$check_array;
        $final_stats['certificate'] = $new_name;
        $datas = array(
            'content' => json_encode($final_stats),
            'user_id' => $this->user_id,
            'search_id' => $post['search_id'],
            'insurance'=>$insurance,
            'tariff_classification'=>$tariff_classification,
            'created' => CURRENT_DATETIME,
        );
        DB::delete('delete from additional_services where search_id='.$post['search_id']);
        if(isset($data['additional_info_id']) && @$data['additional_info_id'] && $tariff_classification){
            DB::delete('delete from cargo_details where additional_info_id='.$data['additional_info_id']);
        }
        
        $additional_id = DB::table('additional_services')->insertGetId($datas);
        //if($i >= 1){
             $this->locale = App::getLocale();
             if($this->locale == "es"){ 
                $data['subject'] ='Servicios adicionales Email';
                $html_start ="<p>El numero de referencia de tu cotizacion es: ".$post['search_id'].". <p>
                    El usuario ha seleccionado algunos servicios adicionales.<a href='".newurl($url)."'>Por favor agregue las tarifas adicionales </a></p><p>Por favor haga click aqui para agregarlas</p><ul>";
            }else{
                $data['subject'] ='Additional Services Email';
                if($i >= 1){
                    $html_start ="<p>Your quote reference number is: ".$post['search_id'].". <p>The user has picked up some additional services. Please fill other rates for quote. <a href='".newurl($url)."'>Please click here to add rates.</a></p><p>Here is list of additional services</p><ul>";
                }else{
                    $html_start ="<p>Your quote reference number is: ".$post['search_id'].". <p>Please fill other rates for quote. <a href='".newurl($url)."'>Please click here to add rates.</a></p><ul>";
                }
            }

        //}
        //if($i >= 1){
            $html_end .="</ul>";
       //}
        
        
        $data['html'] = $html_start.$html_center.$html_end;
        $data['user_email'] = Auth::user()->email;
        $view = 'emails.forwarder.additional_services'; 
        //if($i >= 1){
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['email'])->subject($data['subject']);
            });
        //}

        if($i >= 1){
            $data['name'] = Auth::user()->name;
            $data['html'] = '<p>Your quote reference number is: '.$post['search_id'].'. </p><p>Here is list of additional services selecetd by you.</p><ul>'.$html_center.$html_end;
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['user_email'])->subject($data['subject']);
            });
        } 
        $data=array();
        $data['url'] = "quote/additional_info/".$post['search_id'];

        DB::table('searches')->where('search_id',$post['search_id'])->update($data);
        //dd($data['url']);
        if($this->locale == "es"){  
            return Redirect::to("/es/quote/additional_info/".$post['search_id']);
        }else{
            return Redirect::to("/quote/additional_info/".$post['search_id']);
        }
    }
    
    public function postInfo(Request $request){
        $post = $request->all();
        $data = $request->session()->all();
        $this->validate($request, [
            'check_itinerary' => 'required',
            'cargo_ready_date'=>'required',
            'depature_date'=>'required',
			'invoice'=>'required_if:insurance,1',
            'item.*.6digit' => 'required_if:tariff_classification,1',
            'item.*.12digit' => 'required:tariff_classification,1',
            'item.*.number' => 'required:tariff_classification,1',
            'item.*.discription' => 'required:tariff_classification,1',
            'item.*.dangerous_good' => 'required:tariff_classification,1',
            'pickup.address' => 'required_if:pic_del,pickup',
            'pickup.postal_code' => 'required_if:pic_del,pickup',
            'pickup.city' => 'required_if:pic_del,pickup',
            'pickup.country' => 'required_if:pic_del,pickup',
            'delivery.address' => 'required_if:pic_del,delivery',
            'delivery.postal_code' => 'required_if:pic_del,delivery',
            'delivery.city' => 'required_if:pic_del,delivery',
            'delivery.country' => 'required_if:pic_del,delivery',
        ]);
        if($post['check_itinerary']){
            $datas = array(
                'search_id' =>$post['search_id'],
                'user_id'=>$this->user_id,
                'itinerary_id' => $post['check_itinerary'],
                'cargo_ready_date' => date('Y-m-d',strtotime($post['cargo_ready_date'])),
                'depature_date'=>date('Y-m-d',strtotime($post['depature_date'])),
                'created' => CURRENT_DATETIME,
            );
            if(@$post['pickup']['address']){
                $datas['pickup_address'] = $post['pickup']['address'];
                $datas['pickup_postal_code'] = $post['pickup']['postal_code'];
                $datas['pickup_city'] = $post['pickup']['city'];
                $datas['pickup_country'] = $post['pickup']['country'];
            }

            if(@$post['delivery']['address']){
                $datas['delivery_address'] = $post['delivery']['address'];
                $datas['delivery_postal_code'] = $post['delivery']['postal_code'];
                $datas['delivery_city'] = $post['delivery']['city'];
                $datas['delivery_country'] = $post['delivery']['country'];
            }
            if(isset($data['additional_info_id']) && @$data['additional_info_id']){
                DB::delete('delete from additional_info where search_id='.$post['search_id']);
            }
            $additional_info_id = DB::table('additional_info')->insertGetId($datas);
            if(isset($post['item']) && $post['item']){
                $items = $post['item'];
                $this->save_cargo_details($additional_info_id,$items);
            }
           //dd($post);
            if($post['insurance'] == 1){
            	DB::table('international_insurances')->insertGetId(array('search_id'=>$post['search_id'],'invoice' => $post['invoice'],'incoterm'=>$post['incoterm']));
            }
            $url = "/quote/additional_info/".$post['search_id']."/".$additional_info_id;
            if($this->locale == "es"){  
                $url = '/es'.$url;
            }

            $data=array();
            $data['url'] = $url;
            DB::table('searches')->where('search_id',$post['search_id'])->update($data);
            $view = 'emails.forwarder.additional_info'; 
            $data['name'] = Auth::user()->name;
            $data['user_email'] = Auth::user()->email;
            if($this->locale == "es"){ 
                $data['subject'] ='Información Adicional Email';
                $data['html'] = "Por favor espera la cotizacion completa del Agene de carga seleccionado, durante las proximas 48 horas en tu correo. 
                El numero de referencia de tu cotzacion es : ".$post['search_id'].".
                 Realizada el Jueves ".date('l jS \of F Y h:i:s A',strtotime(CURRENT_DATETIME));
            }else{
                $data['subject'] ='Additional Info Email';
                $data['html'] = "Please wait for your selected Freight Forwarder full quote in under 48 hours in your mail.
                      Your quote reference number is: ".$post['search_id'].".
                       Submitted on ".date('l jS \of F Y h:i:s A',strtotime(CURRENT_DATETIME));
                  
            }
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['user_email'])->subject($data['subject']);
            });
            return Redirect::to($url)->with('success','Please wait for ff');
        }
    }
    public function save_cargo_details($additional_info_id,$items){
        foreach ($items as $value) {
            $datas=array(
                'additional_info_id' => $additional_info_id,
                'cargo_6digit'=>$value['6digit'],
                'cargo_12digit'=>$value['12digit'],
                'number'=>$value['number'],
                'discription'=>$value['discription'],
                'dangerous_good'=>$value['dangerous_good'],
            );
            DB::table('cargo_details')->insert($datas);
        }
    }

    public function getadditionalinfo(Request $request, $search_id, $additional_info_id=NULL){ 
    	
        //dd($data['searches']);
        $week = date('W', strtotime(CURRENT_DATETIME));
        $data = $request->session()->all();
        $data['service_url'] = $request->session()->get('containers.servicetype').'/search';
        $data['search_id']   = $search_id;
        Session::put('search_id', $search_id);
        $data['additional_info_id'] = $additional_info_id;
        if(@$additional_info_id){
            $data['additional_info'] = DB::table('additional_info')->select('additional_info.created')->where('additional_info.additional_info_id','=',$additional_info_id)
                ->where('additional_info.user_id','=',$this->user_id)->first();
        }
        $data['searches'] = DB::table('searches')->select('searches.*')->where('searches.search_id','=',$search_id)
                ->where('searches.user_id','=',$this->user_id)->first();
        if(!@$data['searches']){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        $data['containers'] = json_decode($data['searches']->containers);
        if($data['containers']->servicetype != "airtime"){
            $data['searches'] = DB::table('searches')->select('searches.*','oop.port_title as o_port_title','dop.port_title as d_port_title','o_city.title as o_city','d_city.title as d_city','o_country.title as o_country','d_country.title as d_country')->where('searches.search_id','=',$search_id)
                ->leftjoin('ocean_routes','ocean_routes.ocean_route_id','=','searches.ocean_route_id')
                ->leftjoin('ocean_ports as oop','oop.ocean_port_id','=','ocean_routes.origin_ocean_port_id')
                ->leftjoin('ocean_ports as dop','dop.ocean_port_id','=','ocean_routes.destination_ocean_port_id')
                ->leftjoin('countries as o_country','o_country.country_id','=','oop.country_id')
                ->leftjoin('countries as d_country','d_country.country_id','=','dop.country_id')
                ->leftjoin('cities as o_city','o_city.city_id','=','oop.city_id')
                ->leftjoin('cities as d_city','d_city.city_id','=','dop.city_id')
                ->where('searches.user_id','=',$this->user_id)->first();
            if(isset($data['routes']['origin_postal_code'])){
                $data['searches']->postalcode_origin = $data['routes']['origin_postal_code'];
            }
            if(isset($data['routes']['destination_postal_code'])){
                $data['searches']->postalcode_destination = $data['routes']['destination_postal_code'];
            }
        }
        $data['additional_service'] = DB::table('additional_services')->select('additional_services.insurance','additional_services.tariff_classification')
            ->where('additional_services.search_id','=',$search_id)
            ->where('additional_services.user_id','=',$this->user_id)->orderby('additional_services.additional_service_id','DESC')->first();                
        if(@$data['searches']){
            if($data['searches']->type == "airtime"){
                $data['routes'] = json_decode($data['searches']->routes);
                $data['itinerary'] = DB::table('itinerary')->select('itinerary.*')
                    ->where('itinerary.afr_route_id','=',$data['searches']->afr_route_id)->get();
                $data['location']['origin'] = DB::table('airports')->select('airports.city_id','airports.country_id')
                    ->where('airports.airport_id','=',$data['routes']->origin_airport)->first();
                $data['location']['destination'] = DB::table('airports')->select('airports.city_id','airports.country_id')
                    ->where('airports.airport_id','=',$data['routes']->destination_airport)->first();
            }else{
                $data['routes'] = json_decode($data['searches']->routes);
                $data['location']['origin'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select('ocean_ports.city_id','ocean_ports.country_id')
                    ->where('ocean_ports.ocean_port_id','=',$data['routes']->origin_port_id)->first();
                $data['location']['destination'] = DB::table('ocean_ports')
                    ->select('ocean_ports.city_id','ocean_ports.country_id')
                    ->where('ocean_ports.ocean_port_id','=',$data['routes']->destination_port_id)->first();
                $data['itinerary'] = DB::table('itinerary_ofr')->select('itinerary_ofr.*')
                    ->where('itinerary_ofr.ocean_route_id','=',$data['searches']->ocean_route_id)->get();
                
            }
        }
        $data['countries'] = DB::table('countries')->select('countries.country_id','countries.title as country')
            ->where('is_active','=',1)->orderby('countries.title')->get();
        $data['cities'] = DB::table('cities')->select('cities.city_id','cities.title as city')
            ->where('is_active','=',1)->orderby('cities.title')->get();
        $data['tariff_classification'] = $data['additional_service']->tariff_classification;
		$data['insurance'] = $data['additional_service']->insurance;
		$data['incoterm']=$this->incoterm;
        return view('search.additional_info')->with('data',$data);
    }

    public function getInternationalInsurance(Request $request, $search_id, $add_service=NULL){
        $data = $request->session()->all();
        $data['search_id']= $search_id;
        $data['searches'] = DB::table('searches')->select('searches.quote_fee','searches.routes')->where('searches.search_id','=',$search_id)->where('searches.user_id','=',$this->user_id)->first();
        if(!@$data['searches']){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        $data['data'] = DB::table('international_insurances')->select('international_insurances.*')->where('search_id','=',$search_id)->first();
        $data['incoterms']=$this->incoterm;

        //dd($data);

        return view('search.international_insurance')->with('data',$data);
    }

    public function internationalInsurance(Request $request){
        //dd($request);
        $data = $request->session()->all();
        $post = $request->all();
        //dd($post);
        // $this->validate($request, [
        //     'invoice' => 'required',
        //     'cargo_cfr_cost' => 'required',
        //     'insurance_fee' => 'required',
        //     'cargo_cif' => 'required',
        //     'vat_percentage' => 'required',
        //     'vat' => 'required',
        //     'total' => 'required',
        //     'cargo_total' => 'required',
        // ]);
        $datas=array(
            'invoice' => $post['invoice'],
            'incoterm'=>$post['incoterm'],
            'cargo_cfr_cost'=>$post['cargo_cfr_cost'],
            'insurance_fee'=>$post['insurance_fee'],
            'cargo_cif'=>$post['cargo_cif'],
            'customs_percentage'=>(isset($post['customs_percentage']))? $post['customs_percentage']: '',
            'customs'=>(isset($post['customs']))? $post['customs']:'',
            'vat_percentage'=>$post['vat_percentage'],
            'vat'=>$post['vat'],
            'inland'=>(isset($post['inland']))? $post['inland']:'',
            'total'=>$post['totals'],
            'cargo_total'=>$post['cargo_total'],
            'modified' => CURRENT_DATETIME,
        );
        DB::table('international_insurances')->where('search_id', $post['search_id'])->update($datas);
        $data=array();
        $data['url'] = "quote/quote_details/".$post['search_id'];
        DB::table('searches')->where('search_id',$post['search_id'])->update($data);
        if($this->locale == "es"){  
            return Redirect::to("/es/quote/quote_details/".$post['search_id']);
        }else{
            return Redirect::to("/quote/quote_details/".$post['search_id']);
        }
        //return view('search.international_insurance')->with('data',$data);
    }
    
    public function getQuote(Request $request, $search_id, $add_service=NULL){
        $data = $request->session()->all();
        $data['service_url'] = $request->session()->get('containers.servicetype').'/search';
        $data['search_id']   = $search_id;
        Session::put('search_id', $search_id);
        $data['add_service'] = $add_service;
        $searches = DB::table('searches')->select('searches.*')->where('searches.search_id','=',$search_id)
            ->where('searches.user_id','=',$this->user_id)->first();
        if(!@$searches){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        $data= $this->quote_detail($search_id,$data,$searches);
        
        if(@$data['quote']){
            return view('search.quote')->with('data',$data);
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/home")->with('error','No record found');
            }else{
                return Redirect::to("/home")->with('error','No record found');
            }
        }
    }

    public function quote_detail($search_id,$data,$searches){
        $data['itinerary_departures'] = (object) array();
        $data['containers'] = json_decode($searches->containers);
        $data['routes'] = json_decode($searches->routes);
        $data['searches']['created'] = $searches->created;
        $data['searches']['quote_fee'] = $searches->quote_fee;
        $data['ff'] = DB::table('users')->select('users.name')->where('users.id','=',$searches->ff_id)->first();
        $data['additional_info'] = DB::table('additional_info')->select('depature_date','itinerary_id')
                ->where('additional_info.search_id','=',$data['search_id'])->orderby('additional_info_id','desc')->first();
        if($data['containers']->servicetype == "airfreight"){
            // $data['insurance'] = DB::table('international_insurances')->select('total')
            //     ->where('international_insurances.search_id','=',$data['search_id'])->orderby('international_insurance_id','desc')->first();
            $data['location']['origin'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                ->leftjoin('countries','countries.country_id','=','airports.country_id')
                ->select('airports.*','cities.title as city','countries.title as country')
                ->where('airports.airport_id','=',$data['routes']->origin_airport)
                ->orderby('countries.title')->first();
            $data['location']['destination'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                ->leftjoin('countries','countries.country_id','=','airports.country_id')
                ->select('airports.*','cities.title as city','countries.title as country')
                ->where('airports.airport_id','=',$data['routes']->destination_airport)
                ->orderby('countries.title')->first();
            $data['itinerary_departures'] = DB::table('itinerary')->select('cargo_day')
                ->where('itinerary.itinerary_id','=',$data['additional_info']->itinerary_id)->orderby('itinerary_id','desc')->first();
            $data['itinerary_departures']->departure_date = $data['additional_info']->depature_date;
        }else{
            $data['location']['origin'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                ->select('ocean_ports.*','cities.title as city','countries.title as country')
                ->where('ocean_ports.ocean_port_id','=',$data['routes']->origin_port_id)
                ->orderby('countries.title')->first();
            $data['location']['destination'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                ->select('ocean_ports.*','cities.title as city','countries.title as country')
                ->where('ocean_ports.ocean_port_id','=',$data['routes']->destination_port_id)
                ->orderby('countries.title')->first();
            
            
            $data['itinerary_departures'] = DB::table('itinerary_ofr')->select('estimated_transit_time as cargo_day')
                ->where('itinerary_ofr.itinerary_id','=',$data['additional_info']->itinerary_id)->orderby('itinerary_id','desc')->first();
            $data['itinerary_departures']->departure_date = $data['additional_info']->depature_date;
        }
        $data['insurance'] = DB::table('international_insurances')->select('total')
                ->where('international_insurances.search_id','=',$data['search_id'])->orderby('international_insurance_id','desc')->first();
        $data['quote'] = DB::table('quotes')->select('quotes.*')->join('searches','searches.search_id','=','quotes.search_id')
            ->where('quotes.search_id','=',$search_id)
            ->where('searches.user_id','=',$this->user_id)->first();
        return $data;
    }
    public function postQuote(Request $request){
        $post = $request->all();
        $datas=array(
            'final_total' => $post['final_total'],
            'modified' => CURRENT_DATETIME,
        );
        if(DB::table('quotes')->where('search_id', $post['search_id'])->update($datas)){
            $data=array();
            $data['url'] = "quote/booking/".$post['search_id'];
            DB::table('searches')->where('search_id',$post['search_id'])->update($data);

            $data = (array) DB::table('searches')->select('searches.*','users.email','users.name')
            	->join('users','users.id','=','searches.ff_id')->where('searches.search_id','=',$post['search_id'])
            ->where('searches.user_id','=',$this->user_id)->first();
            if($this->locale == "es"){ 
                $data['subject'] = "Presupuesto de reserva";
            }else{
                $data['subject'] = "Quote Booking";
            }
            $view = 'emails.forwarder.additional_services';
            $data['html'] = '<p>Your quote booked by user please insert advance document as soon as possible.</p>
            	<p><a href="'.BASE_URL.'/admin/quote/details/'.$post['search_id'].'">Click Here to see quote.</a></p>';
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['email'])->subject($data['subject']);
            });
            if($this->locale == "es"){  
                return Redirect::to("/es/quote/booking/".$post['search_id']);
            }else{
                return Redirect::to("/quote/booking/".$post['search_id']);
            }
        }
    }

    public function getBooking(Request $request,$search_id){
        $data['search_id']   = $search_id;
        //dd($data);
        $searches = DB::table('searches')->select('searches.*')->where('searches.search_id','=',$search_id)
            ->where('searches.user_id','=',$this->user_id)->first();
        if(!@$searches){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        
        if(@$searches){

            $data['containers'] = json_decode($searches->containers);
            $data['routes'] = json_decode($searches->routes);
            $data['searches']['created'] = $searches->created;
            $data['searches']['quote_fee'] = $searches->quote_fee;
            $data['ff_id'] = $searches->ff_id;
            $data['ff'] = DB::table('users')->select('users.name')->where('users.id','=',$searches->ff_id)->first();
            $data['additional_info'] = DB::table('additional_info')
                                           ->select('additional_info.*')
                                           ->where('additional_info.search_id','=',$data['search_id'])
                                           ->orderby('additional_info_id','desc')
                                           ->first();
            if($data['containers']->servicetype == "airfreight"){
                $data['insurance'] = DB::table('international_insurances')->select('total','incoterm')
                    ->where('international_insurances.search_id','=',$data['search_id'])->orderby('international_insurance_id','desc')->first();
                $data['location']['origin'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select('airports.*','cities.title as city','countries.title as country')
                    ->where('airports.airport_id','=',$data['routes']->origin_airport)
                    ->orderby('countries.title')->first();
                $data['location']['destination'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select('airports.*','cities.title as city','countries.title as country')
                    ->where('airports.airport_id','=',$data['routes']->destination_airport)
                    ->orderby('countries.title')->first();
                if(@$data['containers']->item){ $totalcbm = $totalkgs =0;
                    foreach ($data['containers']->item as $key => $value) {
                        $totalkgs += $value->container_number * $value->cbm->weight;
                        $totalcbm += $value->container_number * $value->cbm->total;
                    }
                }

                $col_rate = $this->col_rate($data);
                $colrate = $this->colRates($totalkgs,$totalcbm,$col_rate);
                if($data['routes']->include_pickup == "Yes" || $data['routes']->include_delivery == "Yes"){
                    $trucking = $this->col_inland($data);
                }
                $datas=array(
                    'origin_col_rate' => (isset($colrate['origin']))? $colrate['origin']['sum']: 0,
                    'destination_col_rate' => (isset($colrate['destination']))? $colrate['destination']['sum'] : 0,
                    'col_pickup_truck_rate' => (isset($trucking['pickup']))? $trucking['pickup']['rate']: 0,
                    'col_delivery_truck_rate' => (isset($trucking['delivery']))? $trucking['delivery']['rate'] : 0,
                    'modified' => CURRENT_DATETIME,
                );
                DB::table('quotes')->where('search_id', $search_id)->update($datas);
                $data['quote'] = DB::table('quotes')->select('quotes.*','itinerary_departures.*')
                    ->leftjoin('additional_info','additional_info.search_id','=','quotes.search_id')
                    ->leftjoin('itinerary_departures','itinerary_departures.itinerary_departure_id','=','additional_info.itinerary_departure_id')
                    ->where('quotes.search_id','=',$search_id)->first();
            }else{
                $data['insurance'] = DB::table('international_insurances')->select('total','incoterm')
                    ->where('international_insurances.search_id','=',$data['search_id'])->orderby('international_insurance_id','desc')->first();
                $data['location']['origin'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.ocean_port_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select('ocean_ports.*','cities.title as city','countries.title as country')
                    ->where('ocean_ports.ocean_port_id','=',$data['routes']->origin_port_id)
                    ->orderby('countries.title')->first();
                $data['location']['destination'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.ocean_port_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select('ocean_ports.*','cities.title as city','countries.title as country')
                    ->where('ocean_ports.ocean_port_id','=',$data['routes']->destination_port_id)
                    ->orderby('countries.title')->first();
                if(@$data['containers']->item){ $total_number =$totalcbm = $totalkgs =0;
                    if($data['containers']->load_type == "lcl" ){
                        foreach ($data['containers']->item as $key => $value) {
                            $totalkgs += $value->container_number * $value->cbm->weight;
                            $totalcbm += $value->container_number * $value->cbm->total;
                        }
                    }
                }
                $col_rate = $this->col_ofr_rate($data);
                
                if($data['containers']->load_type == "lcl" ){

                    $colrate = $this->colRatesLcl($totalkgs,$totalcbm,$col_rate);
                    //dd($data);
                }
                if($data['containers']->load_type == "fcl" ){
                    $colrate = $this->colRatesFcl($data['containers']->item,$col_rate);
                }
                if($data['routes']->include_pickup == "Yes" || $data['routes']->include_delivery == "Yes"){
                    $trucking = $this->col_inland($data);
                }



                $datas=array(
                    'origin_col_rate' => (isset($colrate['origin']))? $colrate['origin']['sum']: 0,
                    'destination_col_rate' => (isset($colrate['destination']))? $colrate['destination']['sum'] : 0,
                    'col_pickup_truck_rate' => (isset($trucking['pickup']))? $trucking['pickup']['rate']: 0,
                    'col_delivery_truck_rate' => (isset($trucking['delivery']))? $trucking['delivery']['rate'] : 0,
                    'modified' => CURRENT_DATETIME,
                );
                DB::table('quotes')->where('search_id', $search_id)->update($datas);
                $data['quote'] = DB::table('quotes')->select('quotes.*','itinerary_ofr_departures.*')
                    ->leftjoin('additional_info','additional_info.search_id','=','quotes.search_id')
                    ->leftjoin('itinerary_ofr_departures','itinerary_ofr_departures.itinerary_ofr_departure_id','=','additional_info.itinerary_departure_id')
                    ->where('quotes.search_id','=',$search_id)->first();


            }
            return view('search.booking')->with('data',$data);
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/home")->with('error','No record found');
            }else{
                return Redirect::to("/home")->with('error','No record found');
            }
        }
        //dd($data);
    }

    public function postBooking(Request $request){
        $post = $request->all();
        $this->validate($request, [
            'pending' => 'required',
            'advance'=>'required',
            'grand_total' => 'required',
            'agree' => 'required',
        ]);
        $datas=array(
            'pending_amount' => $post['pending'],
            'advance' => (float)str_replace(',', '', $post['advance']),
            'grand_total' => $post['grand_total'],
            'agree' => 1,
            'modified' => CURRENT_DATETIME,
        ); 
        //dd($datas);
        if(DB::table('quotes')->where('quote_id', $post['quote_id'])->update($datas)){
            $data=array();
            $data['url'] = "quote/payment/".$post['search_id'];
            DB::table('searches')->where('search_id',$post['search_id'])->update($data);
            if($this->locale == "es"){  
                return Redirect::to("/es/quote/payment/".$post['search_id']);
            }else{
                return Redirect::to("/quote/payment/".$post['search_id']);
            }
        }
    }

    public function getFinalPayment(Request $request,$search_id){
        $searches = DB::table('searches')->select('searches.*')->where('searches.search_id','=',$search_id)
            ->where('searches.user_id','=',$this->user_id)->first();
        if(!@$searches){
            return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        if(@$search_id){
            $data['quote'] = DB::table('quotes')->select('quotes.search_id','quotes.quote_id','quotes.advance','quotes.pending_amount','quotes.grand_total','quotes.pending_payment_document')->where('search_id','=',$search_id)->first();
            return view('search.final')->with('data',$data);
        }
    }

    public function getpayment(Request $request,$search_id){
    	$searches = DB::table('searches')
                    ->select('searches.*')
                    ->where('searches.search_id','=',$search_id)
                    ->where('searches.user_id','=',$this->user_id)
                    ->first();
        if(!@$searches){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        if(@$search_id){
            $data['quote'] = DB::table('quotes')
                             ->leftjoin('payment','payment.quote_id','=','quotes.quote_id')
                             ->select('quotes.search_id','quotes.advance','quotes.pending_amount','quotes.grand_total','quotes.advance_payment_document','payment.*','quotes.quote_id')
                             ->where('search_id','=',$search_id)
                             ->first();

            //dd($data);
            return view('search.payment')->with('data',$data);
        }else{

        }
    }
    
    public function getResponse($status=Null, $codRespuesta=Null, $paymentRef=Null, $token=Null, $numAprobacion=Null, $fechaTransaccion=Null){
        $data['subject'] = "Payment Conformation";
        $data['html'] = "15% Advance payment scuccessfully recived by FF|| ". $status. " || " . $codRespuesta. "||" . $paymentRef. "||" . $token. "||" . $numAprobacion. "||" . $fechaTransaccion;
        $data['email'] = 'harpreet.s@ldh.01s.in';
        $data['name'] = 'Harpreet Singh';
        $view = 'emails.forwarder.additional_services'; 
        Mail::send($view, $data, function ($message) use($data){
            $message->to($data['email'])->subject($data['subject']);
        });
        //dd("fsd");
    }

    public function postResponse(Request $request){
        $post = $request->all();

        
        
        $booking_number = "";
        //preg_match_all('!\d+!', $post['paymentRef'], $matches);


        if($post['status'] == "Aprobado"){
            // $booking = DB::table('booking_no')->select('booking_no.booking_number')->first();
            // $booking_number = $booking->booking_number + 1;
            //$booking_number = "1";
            $booking_number = "B".time();
        }
        
        //list($alpha,$numeric) = sscanf($post['paymentRef'], "%[A-Z]%d"); 
        //$result = preg_split('#(?<=\d)(?=[a-z])#i', $post['paymentRef']);
        preg_match_all('!\d+!', $post['paymentRef'], $matches);
//dd($matches);exit();
        //dd($numeric);
        //$quote_id = $numeric;
        $quote_id = $matches[0][0];
        //$quote_id =$post['paymentRef'];
        $datas=array(
            'quote_id' => $quote_id,
            'booking_number' => $booking_number,
            'payment_ref' => $post['paymentRef'],
            'state' => $post['status'],
            'num_aprobacion' => $post['numAprobacion'],
            'transaction_date' => $post['fechaTransaccion'],
            'cod_respuesta' => $post['codRespuesta'],
            'token' => $post['token'],
            'mode' => "ADVANCE",
            'created' => CURRENT_DATETIME,
        );
        DB::table('payment')->insertGetId($datas);

        

        if($post['status'] == "Aprobado"){
            $data['booking_number'] = $booking_number;
            DB::table('booking_no')->insert($data);
            $quote = (array) DB::table('quotes')->select('quotes.search_id','users.name','users.email')
                ->join('searches','searches.search_id','=','quotes.search_id')
                ->join('users','users.id','=','searches.ff_id')
                ->where('quotes.quote_id','=',$quote_id)->first();
            //dd($quote);
            $data=array();
            // $data['url'] = '';
            // DB::table('searches')->where('search_id',$quote['search_id'])->update($data);

            $data['subject'] = "Payment Confirmation";
            $data['html'] = "15% Advance payment scuccessfully recived by FF";
            $data['email'] = Auth::user()->email;
            $data['name'] = Auth::user()->name;
            $view = 'emails.forwarder.additional_services'; 
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['email'])->subject($data['subject']);
            });

            $datas['subject'] = "Payment Received";
            $datas['html'] = "15% Advance payment successfully paid by user. Please <a href='".newurl('/admin/quote/details/'.$quote['search_id'])."'>click here</a> to upload final payment document.";
            $datas['email'] = $quote['email'];
            $datas['name'] = $quote['name'];
            $view = 'emails.forwarder.additional_services'; 
            Mail::send($view, $datas, function ($message) use($datas){
                $message->to($datas['email'])->subject($datas['subject']);
            });

            return response()->json(['response' => 'success']);
        }else{
            return response()->json(['response' => 'error']);
        }
    }


    public function postfinalResponse(Request $request){
        $post = $request->all();
        
        
        
        preg_match_all('!\d+!', $post['paymentRef'], $matches);
//dd($matches);exit();
        //dd($numeric);
        //$quote_id = $numeric;
        $quote_id = $matches[0][0];
        
        // Get Booking Number
        $payment = DB::table('payment')->select('payment.booking_number')
                   ->where('payment.quote_id','=',$quote_id)
                   ->first();
        $booking_number = $payment->booking_number;

        $datas=array(
            'quote_id' => $quote_id,
            'booking_number' => $booking_number,
            'payment_ref' => $post['paymentRef'],
            'state' => $post['status'],
            'num_aprobacion' => $post['numAprobacion'],
            'transaction_date' => $post['fechaTransaccion'],
            'cod_respuesta' => $post['codRespuesta'],
            'token' => $post['token'],
            'mode' => 'Final',
            'created' => CURRENT_DATETIME,
        );
        DB::table('payment')->insertGetId($datas);
        if($post['status'] == "Aprobado"){
            

            //$data['booking_number'] = $booking_number;
            //DB::table('booking_no')->insert($data);
            $quote = (array) DB::table('quotes')->select('quotes.search_id','users.name','users.email')
                ->join('searches','searches.search_id','=','quotes.search_id')
                ->join('users','users.id','=','searches.ff_id')
                ->where('quotes.quote_id','=',$quote_id)->first();
            $data=array();
            $data['url'] = '';
            DB::table('searches')->where('search_id',$quote['search_id'])->update($data);


            $data = array();
            $data['search_id'] = $quote['search_id'];
            $data['quote_id'] = $quote_id;
            $data['booking_number'] = $booking_number;
            DB::table('bookings')->insert($data);

            // Update Quote 
            $data=array();
            $data['final_payment'] = '1';
            $data['pending_amount'] = '0.00';
            DB::table('quotes')->where('search_id',$quote['search_id'])->update($data);



            $data['subject'] = "Payment Confirmation";
            $data['html'] = "Pending payment scuccessfully recived by FF";
            $data['email'] = Auth::user()->email;
            $data['name'] = Auth::user()->name;
            $view = 'emails.forwarder.additional_services'; 
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['email'])->subject($data['subject']);
            });

            $datas['subject'] = "Payment Received";
            $datas['html'] = "Here is booking number ".$booking_number.".Pending payment scuccessfully paid by user.";
            $datas['email'] = $quote['email'];
            $datas['name'] = $quote['name'];
            $view = 'emails.forwarder.additional_services'; 
            Mail::send($view, $datas, function ($message) use($datas){
                $message->to($datas['email'])->subject($datas['subject']);
            });

            return response()->json(['response' => 'success']);
        }else{
            return response()->json(['response' => 'error']);
        }
    }

    public function MyOrders(){
        
        $data= array();
        $query = DB::table('searches')
                ->select('users.name','searches.*','quotes.*','payment.*')
                ->join('users','users.id','=','searches.user_id')
                ->join('quotes','quotes.search_id','=','searches.search_id')
                ->join('payment','payment.quote_id','=','quotes.quote_id')
                ->where('quotes.final_payment','=',"1")  
                ->where('searches.user_id','=',$this->user_id)
                ->groupBy('searches.search_id')
                ->get();
        //dd($query);
        foreach ($query as $value) {
            
            $containers = json_decode($value->containers);
            $routes = json_decode($value->routes); 
            //dd($routes);
            $info=array();
            if($containers->servicetype == "airfreight"){

                $info['origin']= DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select(DB::raw("CONCAT(airports.name,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('airports.airport_id','=',$routes->origin_airport)
                    ->orderby('countries.title')->first();
                $info['destination'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select(DB::raw("CONCAT(airports.name,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('airports.airport_id','=',$routes->destination_airport)
                    ->orderby('countries.title')->first();
            }else{

                $info['origin'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select(DB::raw("CONCAT(ocean_ports.port_title,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('ocean_ports.ocean_port_id','=',$routes->origin_port_id)
                    ->orderby('countries.title')->first();
                $info['destination'] = DB::table('ocean_ports')
                    ->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select(DB::raw("CONCAT(ocean_ports.port_title,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('ocean_ports.ocean_port_id','=',$routes->destination_port_id)
                    ->orderby('countries.title')->first();
            }
            // echo "<pre>";
            // print_r($info);
            // echo "</pre>";
            if((@$info['origin']) && (@$info['destination'])){
                $data[] = (object) array_merge((array)$value, (array)$info);    
            }

        }
        //dd($data);

        return view('search.my_orders')->with('data',$data);
    }

    public function getMyOrder($search_id){
        $selecetd = DB::table('searches')
            ->select('users.name','payment.payment_ref','quotes.final_total','quotes.pending_amount','quotes.advance','searches.*','quotes.*')
            ->join('users','users.id','=','searches.user_id')
            ->join('quotes','quotes.search_id','=','searches.search_id')
            ->join('payment','payment.quote_id','=','quotes.quote_id')
            ->where('searches.search_id','=',$search_id)->where('searches.user_id','=',$this->user_id)->First();
        if(!@$selecetd){
        	return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        $data = array();
        if(@$selecetd){
            $data['search_id']   = $selecetd->search_id;
            $data['containers'] = json_decode($selecetd->containers);
            $data['routes'] = json_decode($selecetd->routes);
            $data['searches']['created'] = $selecetd->created;
            $data['searches']['quote_fee'] = $selecetd->quote_fee;
            if($data['containers']->servicetype == "airfreight"){
                $data['location']['origin'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select('airports.*','cities.title as city','countries.title as country')
                    ->where('airports.airport_id','=',$data['routes']->origin_airport)
                    ->orderby('countries.title')->first();
                $data['location']['destination'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select('airports.*','cities.title as city','countries.title as country')
                    ->where('airports.airport_id','=',$data['routes']->destination_airport)
                    ->orderby('countries.title')->first();
            }else{
                $data['location']['origin'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.ocean_port_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select('ocean_ports.*','cities.title as city','countries.title as country')
                    ->where('ocean_ports.ocean_port_id','=',$data['routes']->origin_port_id)
                    ->orderby('countries.title')->first();
                $data['location']['destination'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.ocean_port_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select('ocean_ports.*','cities.title as city','countries.title as country')
                    ->where('ocean_ports.ocean_port_id','=',$data['routes']->destination_port_id)
                    ->orderby('countries.title')->first();
            }
        }
        return view('search.order')->with('data',$data);
    }

    public function MyPendingOrders(){
        $data= array();
        $query = DB::table('searches')
                ->join('users','users.id','=','searches.user_id')
                ->join('quotes','quotes.search_id','=','searches.search_id')
                //->leftjoin('additional_services','additional_services.search_id','=','searches.search_id')
                ->leftjoin('payment','payment.quote_id','=','quotes.quote_id')            
                ->where('searches.user_id','=',$this->user_id)
                ->where('quotes.final_payment','=',"0")                
                ->groupBy('searches.search_id')
                ->select('users.name','searches.*','quotes.*','payment.*')
                ->get();
        
        foreach ($query as $value) {
            
            $containers = json_decode($value->containers);
            $routes = json_decode($value->routes); 
            //dd($routes);
            $info=array();
            if($containers->servicetype == "airfreight"){

                $info['origin']= DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select(DB::raw("CONCAT(airports.name,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('airports.airport_id','=',$routes->origin_airport)
                    ->orderby('countries.title')->first();
                $info['destination'] = DB::table('airports')->leftjoin('cities','cities.city_id','=','airports.city_id')
                    ->leftjoin('countries','countries.country_id','=','airports.country_id')
                    ->select(DB::raw("CONCAT(airports.name,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('airports.airport_id','=',$routes->destination_airport)
                    ->orderby('countries.title')->first();
            }else{

                $info['origin'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select(DB::raw("CONCAT(ocean_ports.port_title,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('ocean_ports.ocean_port_id','=',$routes->origin_port_id)
                    ->orderby('countries.title')->first();
                $info['destination'] = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.ocean_port_id')
                    ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                    ->select(DB::raw("CONCAT(ocean_ports.port_title,', ',cities.title, ', ',countries.title)  AS path"))
                    ->where('ocean_ports.ocean_port_id','=',$routes->destination_port_id)
                    ->orderby('countries.title')->first();
            }
            // echo "<pre>";
            // print_r($info);
            // echo "</pre>";
            if((@$info['origin']) && (@$info['destination'])){
                $data[] = (object) array_merge((array)$value, (array)$info);    
            }
            
        }
        
        //dd($data);
        return view('search.pending')->with('data',$data);
    }

    public function trackQuote(Request $request){
        $post = $request->all();
        $this->validate($request, [
            'quote' => 'required'
        ]);
        if(!Auth::check()){
            return Redirect::to("user/login");
        }
        $data = DB::table('searches')
                ->join('quotes','quotes.search_id','=','searches.search_id')
                ->leftjoin('reports','reports.search_id','=','searches.search_id')
                ->where('quotes.final_payment','=','1')
                ->where('searches.user_id','=',$this->user_id)
                ->where('searches.search_id','=',$post['quote'])
                ->groupBy('searches.search_id')
                ->first();
        //dd($data);
        if(@$data){
            //dd($data);
            return Redirect::to('/track/'.$post['quote']);
            //return Redirect::to("/track_qoute")->with('data',$data);
            return view('track_qoute')->with('data',$data);
        }else{
            return Redirect::back()->with('error',"Inavid quote number.");
        }
    }

    public function track($search_id){
        //die('d');
        if(!Auth::check()){
            return Redirect::to("user/login");
        }
        $data = DB::table('searches')
                ->join('quotes','quotes.search_id','=','searches.search_id')
                ->leftjoin('reports','reports.search_id','=','searches.search_id')
                ->where('quotes.final_payment','=','1')
                ->where('searches.user_id','=',$this->user_id)
                ->where('searches.search_id','=',$search_id)
                ->groupBy('searches.search_id')
                ->first();
        //dd($data);
        if(@$data){
           
            return view('track_qoute')->with('data',$data);
        }else{
            return Redirect::back()->with('error',"Inavid quote number.");
        }
    }


    /** COl rate calculations**/
    public function col_ofr_rate($stats){
        $data['origin'] = DB::table('ocean_local_terminal_rates')
            ->select('ocean_local_terminal_rates.ocean_local_terminal_rate_id','ocean_local_terminal_rates.minimum_value')
            ->where('ocean_local_terminal_rates.user_id','=',$stats['ff_id'])
            ->where('ocean_local_terminal_rates.ocean_port_id','=',$stats['location']['origin']->ocean_port_id)->orderby('ocean_local_terminal_rates.ocean_local_terminal_rate_id','desc')->first();
        $data['origin'] = (array) $data['origin'];
        if(@$data['origin']){
            $data['origin']['rate'] = DB::table('ocean_terminal_load_charges')
                ->select('ocean_terminal_load_charges.lcl','ocean_terminal_load_charges.lcl_min','ocean_terminal_load_charges.l20','ocean_terminal_load_charges.l40','ocean_terminal_load_charges.40hc')
                ->where('ocean_terminal_load_charges.ocean_local_terminal_rate_id','=',$data['origin']['ocean_local_terminal_rate_id'])->get();
        }
        $data['destination'] = DB::table('ocean_local_terminal_rates')->select('ocean_local_terminal_rates.ocean_local_terminal_rate_id','ocean_local_terminal_rates.minimum_value')
            ->where('ocean_local_terminal_rates.user_id','=',$stats['ff_id'])
            ->where('ocean_local_terminal_rates.ocean_port_id','=',$stats['location']['destination']->ocean_port_id)->orderby('ocean_local_terminal_rates.ocean_local_terminal_rate_id','desc')->first();
        $data['destination'] = (array) $data['destination'];
        if(@$data['destination']){
            $data['destination']['rate'] = DB::table('ocean_terminal_load_charges')
                ->select('ocean_terminal_load_charges.lcl','ocean_terminal_load_charges.lcl_min','ocean_terminal_load_charges.l20','ocean_terminal_load_charges.l40','ocean_terminal_load_charges.40hc')
                ->where('ocean_terminal_load_charges.ocean_local_terminal_rate_id','=',$data['destination']['ocean_local_terminal_rate_id'])->get();
        }
        return $data;
    }
    public function colRatesFcl($containers,$col_rates){

        $total = 0.00; 
        $data= array();
        if(@$col_rates['destination'] && isset($col_rates['destination']['rate']) && @$col_rates['destination']['rate']){
            
            foreach ($containers as $value) {
                foreach ($col_rates['destination']['rate'] as $col_rate) {
                    $type= '40hc';
                    if($value->container_type == "20"){ $type= 'l20';}
                    if($value->container_type == "40"){ $type= 'l40';}
                    $total += $col_rate->$type * $value->container_number;
                }    
            }
            if($total > $col_rates['destination']['minimum_value']){
                $data['destination']['sum'] = round($total,2);
            }else{
                $data['destination']['sum'] = round($col_rates['destination']['minimum_value'],2);
            }
        }
        if(@$col_rates['origin'] && isset($col_rates['origin']['rate']) && @$col_rates['origin']['rate']){

            
            foreach ($containers as $value) {
                foreach ($col_rates['origin']['rate'] as $col_rate) {
                    $type= '40hc';

                    if($value->container_type == "20"){ $type= 'l20';}
                    if($value->container_type == "40"){ $type= 'l40';}
                    $total += $col_rate->$type * $value->container_number;
                }    
            }
            if($total > $col_rates['origin']['minimum_value']){
                $data['origin']['sum'] = round($total,2);
            }else{
                $data['origin']['sum'] = round($col_rates['origin']['minimum_value'],2);
            }
        }
        return $data;
    }

    public function colRatesLcl($totalkgs,$totalcbm,$col_rate){
        $total = $mintotal = 0.00;

        $data = array();
        if(@$col_rates['destination'] && isset($col_rates['destination']['rate']) && @$col_rates['destination']['rate']){
            foreach ($containers as $value) {
                foreach ($col_rates['destination']['rate'] as $col_rate) {
                    $total += $col_rate->lcl * $totalkgs;
                    $mintotal += $col_rate->lcl_min * $totalkgs;
                }    
            }
            if($total > $mintotal){
                $data['destination']['sum'] = round($total,2);
            }else{
                $data['destination']['sum'] = round($mintotal,2);
            }
        }
        if(@$col_rates['origin'] && isset($col_rates['origin']['rate']) && @$col_rates['origin']['rate']){
            foreach ($containers as $value) {
                foreach ($col_rates['origin']['rate'] as $col_rate) {
                    $total += $col_rate->lcl * $totalkgs;
                    $mintotal += $col_rate->lcl_min * $totalkgs;
                }    
            }
            if($total > $mintotal){
                $data['origin']['sum'] = round($total,2);
            }else{
                $data['origin']['sum'] = round($mintotal,2);
            }
        }
        return $data;
    }

    public function colRates($totalkgs,$totalcbm,$col_rates){
        $sum = 0.00; $data=array();
        foreach ($col_rates as $col_rate){
            if(@$col_rates['destination']){
                $rate = $col_rates['destination'];
                $discharge_rate = round($col_rates['destination']->discharge_rate,2);
                $sum = round($sum,2) + ($col_rates['destination']->discharge_unit == 1)?  $totalkgs * $discharge_rate : $totalcbm * $discharge_rate;
                $totalSum = $this->col_rate_sum($rate,$sum,$totalkgs,$totalcbm);
                if($totalSum > $rate->minimum_value){
                    $data['destination']['sum'] = round($totalSum,2);
                }else{
                    $data['destination']['sum'] = round($rate->minimum_value,2);
                }
            }
            if(@$col_rates['origin']){
                $rate = $col_rates['origin'];
                $load_rate = round($col_rates['origin']->load_rate,2);
                $sum = round($sum,2) + ($col_rates['origin']->load_unit == 1)?  $totalkgs * $load_rate : $totalcbm * $load_rate;
                $totalSum = $this->col_rate_sum($rate,$sum,$totalkgs,$totalcbm);
                if($totalSum > $rate->minimum_value){
                    $data['origin']['sum'] = round($totalSum,2);
                }else{
                    $data['origin']['sum'] = round($rate->minimum_value,2);
                }
            }
        }
        return $data;
    }
    public function col_rate_sum($colrate,$sum,$totalkgs,$totalcbm){
        $airport_fee = round($colrate->airport_fee,2);
        $ground_charges = round($colrate->ground_charges,2);
        $airport_transfer = round($colrate->airport_transfer,2);
        $consolidation = round($colrate->consolidation,2);
        $deconsolidation = round($colrate->deconsolidation,2);
        $sum = $sum + ($colrate->airport_unit == 1)?  $totalkgs * $airport_fee : $totalcbm * $airport_fee;
        $sum = $sum + ($colrate->ground_unit == 1)?  $totalkgs * $ground_charges : $totalcbm * $ground_charges;
        $sum = $sum + ($colrate->airport_transfer_unit == 1)?  $totalkgs * $airport_transfer : $totalcbm * $airport_transfer;
        $sum = $sum + ($colrate->consolidation_unit == 1)?  $totalkgs * $consolidation : $totalcbm * $consolidation;
        $sum = $sum + ($colrate->deconsolidation_unit == 1)?  $totalkgs * $deconsolidation : $totalcbm * $deconsolidation;
        return round($sum,2);
    }

    public function col_rate($stats){
        $data['origin'] = DB::table('local_terminal_air_rates')->select('local_terminal_air_rates.*')
            ->where('user_id','=',$stats['ff_id'])
            ->where('origin_airport_id','=',$stats['routes']->origin_airport)->orderby('local_terminal_air_rates_id','desc')->first();
        $data['destination'] = DB::table('local_terminal_air_rates')->select('local_terminal_air_rates.*')
            ->where('user_id','=',$stats['ff_id'])
            ->where('origin_airport_id','=',$stats['routes']->destination_airport)->orderby('local_terminal_air_rates_id','desc')->first();
        return $data;
    }

    public function col_inland($stats){
        $data=array();
        if($stats['routes']->include_pickup == "Yes"){
            $pickup = $this->pickup_col($stats);
            
            $type = $stats['containers']->item[0]->container_type;
            if($stats['containers']->servicetype == "airfreight"){
                $type= 'lcl';
            }
            $field = $this->trucking[$type];
            $data['pickup']['rate'] = 0;
            $data['pickup']['field'] = $field;
            if(@$pickup){    
                $data['pickup']['field'] = $field;
            }
        }
        if($stats['routes']->include_delivery == "Yes"){
            $delivery = $this->delivery_col($stats);

            $type = $stats['containers']->item[0]->container_type;
            
            if($stats['containers']->servicetype == "airfreight"){
                $type= 'lcl';
            }

            $field =$this->trucking[$type];
            $data['delivery']['rate'] = 0;
            $data['delivery']['field'] = $field;
            if(@$pickup){    
                $data['delivery']['rate'] = $delivery->$field;
            }
        }
        return $data;
    }
    public function pickup_col($stats){
        return DB::table('col_routes')->select('col_rates.small_truck','col_rates.medium_truck','col_rates.large_truck')
            ->join('col_rates','col_rates.col_route_id','=','col_routes.col_route_id')
            ->where('col_routes.org_city_id','=',$stats['additional_info']->pickup_city)
            ->where('col_routes.dest_city_id','=',$stats['location']['origin']->city_id)->first();
    }
    public function delivery_col($stats){
        return DB::table('col_routes')->select('col_rates.small_truck','col_rates.medium_truck','col_rates.large_truck')
            ->join('col_rates','col_rates.col_route_id','=','col_routes.col_route_id')
            ->where('col_routes.org_city_id','=',$stats['location']['destination']->city_id)
            ->where('col_routes.dest_city_id','=',$stats['additional_info']->delivery_city)->first();
    }


    public function deleteQuote($search_id){
        $additional = DB::table('additional_info')->select('additional_info_id')->where('search_id','=',$search_id)
            ->orderby('additional_info.search_id','desc')->first();
        if(@$additional){
            DB::delete('delete from cargo_details where additional_info_id='.$additional->additional_info_id);
        }
        DB::delete('delete from searches where search_id='.$search_id);
        DB::delete('delete from quotes where search_id='.$search_id);
        DB::delete('delete from additional_services where search_id='.$search_id);
        return Redirect::back();
    }

    public function download($quote_id, $type){
        $data = DB::table('quotes')->select($type)->where('search_id','=',$quote_id)->orderby('quote_id','desc')->first();
        if(isset($data->$type) && @$data->$type){
            $ext = pathinfo($data->$type, PATHINFO_EXTENSION);
            if($ext == 'png' || 'PNG'){
                $headers = array(
                  'Content-Type' => 'image/png',
                );
            }

            if($ext == 'jpg' || 'jpeg' || 'JPEG' || 'JPG'){
              $headers = array(
                  'Content-Type' => 'image/jpeg',
                );
              }
            if($ext == 'pdf'){
                $headers = array(
                  'Content-Type: application/pdf',
                );
            }

            if($ext == 'doc'){
                $headers = array(
                  'Content-Type: application/msword',
                );
            }
            $file= public_path().'/payment/'.$quote_id.'/'.$data->$type;
            return Response::download($file, 'advance_payment.'.$ext, $headers);
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/home")->with('error',$this->userMsg['not_found']);
            }else{
                return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
            }
        }
    }

    public function htmlToPdf(Request $request, $search_id, $add_service=NULL){
        $data = $request->session()->all();
        $data['service_url'] = $request->session()->get('containers.servicetype').'/search';
        $data['search_id']   = $search_id;
        Session::put('search_id', $search_id);
        $data['add_service'] = $add_service;
        $searches = DB::table('searches')->select('searches.*')->where('searches.search_id','=',$search_id)
            ->where('searches.user_id','=',$this->user_id)->first();
        if(!@$searches){
            return Redirect::to("/home")->with('error',$this->userMsg['not_found']);
        }
        $other_charges = 0;
        $data = $this->quote_detail($search_id,$data,$searches);
        $content = "<div id='accordion'><h3>".trans('messages.quotes')."</h3><div class='box-body'><div class='col-md-12'>
            <div class='col-md-12 col-xs-12 quotebackground'><label class='col-sm-6 col-xs-6 quoteborder'>".trans('messages.QUOTE_DATE')."</label><fieldset class='col-sm-6 col-xs-6 quoteborder'>".date('D, d-M-Y',strtotime($data['searches']['created']))."</fieldset></div><div class='col-md-12 col-xs-12 quotebackground'><label class='col-sm-6 col-xs-6 quoteborder'>".trans('messages.qUOTE NUMBER')."</label><fieldset class='col-sm-6 col-xs-6 quoteborder'>".$data['search_id']."</fieldset></div><div class='col-md-12 col-xs-12 quotebackground'><label class='col-sm-6 col-xs-6 quoteborder'>".trans('messages.EXCHANGE SELECTION')."</label><fieldset class='col-sm-6 col-xs-6 quoteborder'>".$data['containers']->importtype."</fieldset></div><div class='col-md-12 col-xs-12 quotebackground'>
                        <label class='col-sm-6 col-xs-6 quoteborder'>".trans('messages.MEAN OF TRANSPORTATION SELECTION')."</label>
                        <fieldset class='col-sm-6 col-xs-6 quoteborder'>".($data['containers']->servicetype == "airfreight")? "Air Freight": "Maritime"."</fieldset></div>";
        if($data['containers']->servicetype != "airfreight"):
        endif;
        if($data['routes']->include_pickup == "Yes"): 
            if(isset($data['routes']->origin_postal_code)){
                 $data['routes']->postalcode_origin = $data['routes']->origin_postal_code; }
             $content .= '<div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.PICK-UP POSTAL CODE').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">
                          '.$data['routes']->postalcode_origin.'</fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.PICK-UP CITY').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['origin']->city.'</fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.PICK-UP COUNTRY').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['origin']->country.'</fieldset>
                        </div>';
        endif;
        if($data['routes']->include_delivery == "Yes"): 
            if(isset($data['routes']->destination_postal_code)){$data['routes']->postalcode_destination = $data['routes']->destination_postal_code;}
             $content .= '<div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.DELIEVERY POSTAL CODE').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['routes']->postalcode_destination.'</fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.DELIVERY CITY').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['destination']->city.'</fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.DELIVERY COUNTRY').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['destination']->country.'</fieldset>
                        </div>';
        endif; if($data['containers']->servicetype == "Maritime"):
             $content .= '<div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.PORT OF LOADING').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['origin']->port_title.'</fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.PORT OF DISCHARGE').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['destination']->port_title.'</fieldset>
                        </div>';
        else:
            $content .= '<div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.AIRPORT/ PORT OF LOADING').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.$data['location']['origin']->name.' ('.$data['location']['origin']->iata_code.')'.'</fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.AIRPORT/ PORT OF DISCHARGE').'</label>
                          <fieldset class="col-sm-6-4 col-xs-6 quoteborder">'.$data['location']['destination']->name.' ('.$data['location']['origin']->iata_code.')'.'</fieldset>
                        </div>';
        endif; if($data['routes']->include_pickup == "Yes"):
            $content .='<div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.ESTIMATED_pICK-UP').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"> '.date('d-m-Y',strtotime($data['itinerary_departures']->departure_date)).'</fieldset>
                        </div>';
        endif;
        if($data['routes']->include_delivery == "Yes"):
            $content .='<div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">'.trans('messages.ESTIMATED_dELIVERY DATE').'</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder">'.date('d-m-Y',strtotime($data['itinerary_departures']->cargo_date)).'</fieldset>
                        </div>';
        endif;
            $content .='</div>
                    <div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left">  
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn">'.trans('messages.next').'</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <h3>'.trans('messages.Origin_ChargEs').'</h3>
                  <div class="box-body ">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th></th>
                            <th>'.trans('messages.IteM').'#</th>
                            <th>'.trans('messages.Total_Prize').'</th>
                            <th>'.trans('messages.company').'</th>
                          </tr>
                        </thead>
                        <tbody>';
                $totalContainer=0; foreach ($data['containers']->item as $value) { $totalContainer += $value->container_number; }
                if($data['routes']->include_pickup == "Yes"):
                    $content .= '<tr>
                              <td><p class="quote-para">'.trans('messages.Inland FOT Origin').'</p></td>
                              <td>'.$value->container_number.'</td>
                              <td>$'.$totalContainer.'<input type="hidden" placeholder="'.$totalContainer.'" class="form-control quoteinput"></td>
                              <td>'.$data['ff']->name.'</td>
                            </tr>';
                endif; 
                    if(isset($data['quote']->international_custom_content) && @$data['quote']->international_custom_content){
                      $custom = json_decode($data['quote']->international_custom_content);
                      $totalContainer = $totalContainer + $custom->customs_brokerage_documentation->charge;
                        $content .='<tr>
                              <td><p class="quote-para">'.trans('messages.Origin Customs Brokerage Fee').'</p></td>
                              <td>'.$value->container_number.'</td>
                              <td>$'.$custom->customs_brokerage_documentation->charge.'</td>
                              <td>'.$data['ff']->name.'</td>
                            </tr>';
                    }
                    $content .='<tr>
                            <td><p class="quote-para">'.trans('messages.Load / Discharge At Origin Terminal').'</p></td>
                            <td>'.$value->container_number.'</td>
                            <td></td>
                            <td>'.$data['ff']->name.'</td>
                          </tr>
                          
                          <tr>
                            <td><p class="quote-para">'.trans('messages.Other Origin Port/Airport Charges').'</p></td>
                            <td>'.$value->container_number.'</td>
                            <td></td>
                            <td>'.$data['ff']->name.'</td>
                        </tr>
                          <tr>
                            <td><p class="quote-para">'.trans('messages.Other Origin Charges').'</p></td>
                            <td>'.$value->container_number.'</td>
                            <td></td>
                            <td>'.$data['ff']->name.'</td>
                          </tr>
                        </tbody>
                      </table>
                    
                    <div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left"> 
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 nextbtn backbtn">'.trans('messages.next').'</button>
                          <button class="btn btn-info btncolor pull-right hideDiv previous">'.trans('messages.back').'</button>
                        </div>
                      </div>
                    </div>
                  </div>';
            if($data['quote']->additional_service_content):
                $content .= '<h3>'.trans('messages.Additional Services').'</h3>
                  <div class="box-body ">';
                $additional=array(); $insurance_check = 0; $additional_services = json_decode($data['quote']->additional_service_content); 
                    foreach ($additional_services as $key => $value) {
                      if($key == "other"){
                        foreach ($value as $other_value) { 
                          if(@$other_value->value){
                            $other_charges = $other_charges + $other_value->value;
                            $content .='<div class="add-other-fields-js">
                              <div class="col-md-12 additionalrate">
                                <div class="form-group has-feedback">
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="">Others:</label>
                                  </div>
                                  <div class="col-sm-3">
                                    '.$other_value->value.'
                                  </div>  
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                                  </div>
                                  <div class="col-sm-3">
                                    '.$other_value->note.'
                                  </div>                                  
                                </div>
                              </div>
                              <div class="col-md-12 additionalrate">
                                <div class="form-group has-feedback">
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="">Section Description:</label>
                                  </div>
                                  <div class="col-sm-9">
                                    '.$other_value->section.'
                                  </div>  
                                </div>
                              </div>
                              <div class="col-md-12 additionalrate">
                                <div class="form-group has-feedback">
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="">Item  Description:</label>
                                  </div>
                                  <div class="col-sm-9">'.$other_value->item.'</div>  
                                </div>
                              </div>
                            </div>';
                          }
                        }
                      }else{ $other_charges = $other_charges + $value->value;
                        $content .='<div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">'.ucwords(str_replace('_', ' ',$key)).':</label>
                            </div>
                            <div class="col-sm-3">'.$value->value.'</div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                            </div>
                            <div class="col-sm-3">'.$value->note.'</div>                                  
                          </div>
                        </div>';
                        if($key == "collect_freight_check"){
                          echo '<div class="col-md-12 additionalrate">
                            <div class="form-group has-feedback">
                              <div class="security-align">
                                <label class="col-sm-3 control-label" for="">Collect Freight Minimum:</label>
                              </div>
                              <div class="col-sm-3">'.$value->min_value.'</div>  
                              <div class="security-align">
                                <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                              </div>
                              <div class="col-sm-3">'.$value->min_note.'</div>                                  
                            </div>
                          </div>';
                        }
                      }
                    }
                    $content .='<div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left"> 
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 nextbtn backbtn">'.trans('messages.next').'</button>
                          <button class="btn btn-info btncolor pull-right hideDiv previous">'.trans('messages.back').'</button>
                        </div>
                      </div>
                    </div>
                  </div>';
                endif;
                $content .='<h3>'.trans('messages.Foreign Origin/Destination_Charges').'</h3>';
                $foreign = json_decode($data['quote']->foreign_charges_content); 
                    foreach ($foreign->general as $key => $value) {
                      $other_charges = $other_charges + $value->charge;
                    }
                $content .='<div class="box-body ">
                    <p class="additionalspan">General</p>';
                if(isset($foreign->general->origin_handling->charge) && @$foreign->general->origin_handling->charge){
                    $content .='<div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">'.trans('messages.Origin_Handling Charge').':</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_handling->charge)){
                            echo $foreign->general->origin_handling->charge;}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_handling->note)){
                            echo $foreign->general->origin_handling->note;}?>
                        </div>                                  
                      </div>
                    </div>';
                } if(isset($foreign->general->origin_documentation->charge) && @$foreign->general->origin_documentation->charge){    
                    $content .='<div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">'.trans('messages.Origin_Documentation').':</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_documentation->charge)){
                            echo $foreign->general->origin_documentation->charge;}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_documentation->note)){
                            echo $foreign->general->origin_documentation->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->foreign_custom_documentation->charge) && @$foreign->foreign_custom_documentation->origin_documentation->charge){ ?>     
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Foreign_Customs Documentation').':</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->foreign_custom_documentation->charge)){ echo $foreign->general->foreign_custom_documentation->charge;}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">
                            <input type="text" value="<?php if(isset($foreign->general->foreign_custom_documentation->note)){ echo $foreign->general->foreign_custom_documentation->note;}?>" name="foreign_charges_content[general][foreign_custom_documentation][note]" class="form-control" placeholder="ABC">
                          </div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->destination_handling->charge) && @$foreign->general->destination_handling->charge){
                        $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Destination_Handling Charges').':</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_handling->charge)){ echo $foreign->general->destination_handling->charge;}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_handling->note)){ echo $foreign->general->destination_handling->note;}?>
                          </div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->destination_documentation->charge) && @$foreign->general->destination_documentation->charge){
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Destination_Documentation').':</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_documentation->charge)){ echo $foreign->general->destination_documentation->charge;}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_documentation->note)){ echo $foreign->general->destination_documentation->note;}?>
                          </div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->docs_rad->charge) && @$foreign->general->docs_rad->charge){ 
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Docs RAD:</label>
                          </div>
                          <div class="col-sm-3">
                            '.$foreign->general->docs_rad->charge.'
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                            if(isset($foreign->general->docs_rad->note)){ $content .= $foreign->general->docs_rad->note;}
                        $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->caf->charge) && @$foreign->general->caf->charge){
                    $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">CAF:</label>
                          </div>
                          <div class="col-sm-3">
                            '.$foreign->general->caf->charge.'
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                            if(isset($foreign->general->caf->note)){ $content .= $foreign->general->caf->note;}
                        $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->release->charge) && @$foreign->general->release->charge){
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.release').':</label>
                          </div>
                          <div class="col-sm-3">
                            '.$foreign->general->release->charge.'
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                            if(isset($foreign->general->release->note)){ $content .= $foreign->general->release->note;}
                          $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->anti_narcotics->charge) && @$foreign->general->anti_narcotics->charge){
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.ANTI_Narcotics').':</label>
                          </div>
                          <div class="col-sm-3">
                            '.$foreign->general->anti_narcotics->charge.'
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                            if(isset($foreign->general->anti_narcotics->note)){ $content .= $foreign->general->anti_narcotics->note;}
                          $content .='</div>
                        </div>
                      </div>';
                    } if(isset($foreign->general->dian_inspection->charge) && @$foreign->general->dian_inspection->charge){
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">DIAN '.trans('messages.inspection').':</label>
                          </div>
                          <div class="col-sm-3">'.$foreign->general->dian_inspection->charge.'</div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                           if(isset($foreign->general->dian_inspection->note)){ $content .= $foreign->general->dian_inspection->note;}$content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->extra_weight_surcharge->charge) && @$foreign->general->extra_weight_surcharge->charge){ 
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Extra_Weight Surcharge').':</label>
                          </div>
                          <div class="col-sm-3">'.$foreign->general->extra_weight_surcharge->charge.'</div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                        if(isset($foreign->general->extra_weight_surcharge->note)){ $content .=$foreign->general->extra_weight_surcharge->note;}
                         $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->extra_length_surcharge->charge) && @$foreign->general->extra_length_surcharge->charge){
                    $content .= '<div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">'.trans('messages.Extra_Lenght Surcharge').':</label>
                        </div>
                        <div class="col-sm-3">'.$foreign->general->extra_length_surcharge->charge.'</div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                        </div>
                        <div class="col-sm-3">';
                        if(isset($foreign->general->extra_length_surcharge->note)){ $content .=$foreign->general->extra_length_surcharge->note;}
                        $content .='</div>                                  
                      </div>
                    </div>';
                    } if(isset($foreign->general->dangerous_cargo_surcharge->charge) && @$foreign->general->dangerous_cargo_surcharge->charge){ 
                    $content .='<div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">'.trans('messages.Dangerous_Cargo Surcharge').':</label>
                        </div>
                        <div class="col-sm-3">'.$foreign->general->dangerous_cargo_surcharge->charge.'</div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                        </div>
                        <div class="col-sm-3">';
                        if(isset($foreign->general->dangerous_cargo_surcharge->note)){ $content .= $foreign->general->dangerous_cargo_surcharge->note;}
                        $content .='</div>                                  
                      </div>
                    </div>';
                    } if(isset($foreign->general->courrier_charge->charge) && @$foreign->general->courrier_charge->charge){ 
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Courier_Charges').':</label>
                          </div>
                          <div class="col-sm-3">'.$foreign->general->courrier_charge->charge.'</div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                        if(isset($foreign->general->courrier_charge->note)){ $content .= $foreign->general->courrier_charge->note;}
                        $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->freight_certification->charge) && @$foreign->general->freight_certification->charge){
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Freight_Certification').':</label>
                          </div>
                          <div class="col-sm-3">'.$foreign->general->freight_certification->charge.'
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                        if(isset($foreign->general->freight_certification->note)){ $content .=$foreign->general->freight_certification->note;}
                        $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->dest_BL_emission->charge) && @$foreign->general->dest_BL_emission->charge){ 
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Dest BL '.trans('messages.emission').':</label>
                          </div>
                          <div class="col-sm-3">'.$foreign->general->dest_BL_emission->charge.'</div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                      if(isset($foreign->general->dest_BL_emission->note)){ $content .= $foreign->general->dest_BL_emission->note;}
                          $content .='</div>                                  
                        </div>
                      </div>';
                    } if(isset($foreign->general->dest_BL_charge->charge) && @$foreign->general->dest_BL_charge->charge){
                    $content .='<div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">Dest BL '.trans('messages.changes').' :</label>
                        </div>
                        <div class="col-sm-3">'.$foreign->general->dest_BL_charge->charge.'</div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                        </div>
                        <div class="col-sm-3">';
                        if(isset($foreign->general->dest_BL_charge->note)){ $content .= $foreign->general->dest_BL_charge->note;}
                        $content .='</div>                                  
                      </div>
                    </div>';
                    } if($data['containers']->servicetype == "Maritime"): if($data['containers']->load_type == "lcl"): 
                      $content .='<span class="additionalspan">OFR / LCL</span>';
                      if(isset($foreign->ofr->dest_charge_flat_rate->charge) && @$foreign->ofr->dest_charge_flat_rate->charge){ 
                        $content .='<div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Dest '.trans('messages.Charges_Flat Rate').':</label>
                            </div>
                            <div class="col-sm-3">'.$foreign->ofr->dest_charge_flat_rate->charge.'
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                            </div>
                            <div class="col-sm-3">';
                            if(isset($foreign->ofr->dest_charge_flat_rate->note)){ $content .= $foreign->ofr->dest_charge_flat_rate->note;}
                            $content .='</div>                                  
                          </div>
                        </div>';
                    } if(isset($foreign->ofr->densite_surcharge->charge) && @$foreign->ofr->densite_surcharge->charge){ 
                        $content .='<div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">'.trans('messages.Density_Overload').':</label>
                            </div>
                            <div class="col-sm-3">'.$foreign->ofr->densite_surcharge->charge.'</div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                            </div>
                            <div class="col-sm-3">';
                            if(isset($foreign->ofr->densite_surcharge->note)){ $content .= $foreign->ofr->densite_surcharge->note;}
                            $content .='</div>                                  
                          </div>
                        </div>';
                    } endif; if($data['containers']->load_type == "fcl"): 
                      $content .='<span class="additionalspan">OFR / FCL</span>';
                      if(isset($foreign->ofr->deposite->charge) && $foreign->ofr->deposite->charge){ 
                        $content .='<div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">'.trans('messages.deposite').':</label>
                            </div>
                            <div class="col-sm-3">'.$foreign->ofr->deposite->charge.'</div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                            </div>
                            <div class="col-sm-3">';
                            if(isset($foreign->ofr->deposite->note)){ $content .= $foreign->ofr->deposite->note;}
                            $content .='</div>                                  
                          </div>
                        </div>';
                      } if(isset($foreign->ofr->drope_off->charge) && @$foreign->ofr->drope_off->charge){ 
                        $content .='<div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Drop-Off:</label>
                            </div>
                            <div class="col-sm-3">'.$foreign->ofr->drope_off->charge.'</div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                            </div>
                            <div class="col-sm-3">';
                            if(isset($foreign->ofr->drope_off->note)){ $content .= $foreign->ofr->drope_off->note;}
                        $content .='</div>                                  
                          </div>
                        </div>';
                    } if(isset($foreign->ofr->container_loan_contract->charge) && @$foreign->ofr->container_loan_contract->charge){
                      $content .='<div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">'.trans('messages.Container_Loan Contract').':</label>
                          </div>
                          <div class="col-sm-3">'.$foreign->ofr->container_loan_contract->charge.'</div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">'.trans('messages.Note').':</label>
                          </div>
                          <div class="col-sm-3">';
                        if(isset($foreign->ofr->container_loan_contract->note)){ $content .= $foreign->ofr->container_loan_contract->note;}
                        $content .= '</div>                                  
                        </div>
                      </div>';
                    } endif; endif; if(@$data['insurance'] && $data['insurance']->total){ 
                      $totalContainer = $other_charges + $data['insurance']->total + $totalContainer;  }else{
                        $totalContainer = $other_charges + $totalContainer + $data['searches']['quote_fee']; } 
                    $content .='<div class="box-footer box-footers">
                      <div class=" col-md-4 box-body table-responsive userfont btnfont">  
                        <div class = "pull-left">Total = '.$totalContainer.'</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';

        
        pdfConverter($content);
    }
}
