<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Models\OceanRoute;
use App;
class Quote1Controller extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->user_id = Auth::user()->id;
        $this->company_id = Auth::user()->company_id;
        $this->middleware('auth');
        $this->incoterm = \Config::get('constants.incoterm');
        $this->before(Auth::user()->group_id);
        $this->additionalServices = \Config::get('constants.additional-services');
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
    }

    public function before($group_id){
        if ($group_id == '1') {
            if($this->locale == "es"){
                return Redirect::to('/es/administrator/dashboard')->send();
            }else{
                return Redirect::to('/administrator/dashboard')->send();
            }
        }
        if ($group_id == '3') {
            if($this->locale == "es"){
                return Redirect::to('/es/home')->send();
            }else{
                return Redirect::to('/home')->send();
            }
        }
    }

    

    
    public function getQuote($search_id = NULL){
        //dd($search_id);
        if(@$search_id){
            $data['search'] = DB::table('searches')
                ->leftjoin('additional_info','additional_info.search_id','=','searches.search_id')
                ->leftjoin('cargo_details','cargo_details.additional_info_id','=','additional_info.additional_info_id')
                ->select('searches.*','cargo_details.discription as cargo_description')
                ->where('searches.search_id','=',$search_id)
                ->where('searches.ff_id','=',$this->user_id)
                ->first();

            if(@$data['search']){
                $data['containers'] = json_decode($data['search']->containers);
                $data['routes'] = json_decode($data['search']->routes);
                $data['ff'] = DB::table('users')->select('users.name')->where('users.id','=',$data['search']->ff_id)->first();
                if($data['containers']->servicetype == "airfreight"){
                    $data['insurance'] = DB::table('international_insurances')->select('total')
                        ->where('international_insurances.search_id','=',$search_id)->orderby('international_insurance_id','desc')->first();
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
                    $data['insurance'] = DB::table('international_insurances')->select('total')
                        ->where('international_insurances.search_id','=',$search_id)->orderby('international_insurance_id','desc')->first();
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
                }
                $data['quote'] = DB::table('quotes')->select('quotes.*')->where('search_id','=',$search_id)->first();
                if(!@$data['quote']){
                    if($this->locale == "es"){
                        return Redirect::to("/es/admin/quote/details/")->with('error',$this->freightforwarderMsg['not_found']);
                    }else{
                        return Redirect::to("/admin/quote/details/")->with('error',$this->freightforwarderMsg['not_found']);
                    }
                }
                if(isset($data['containers']->load_type) && $data['containers']->load_type == "fcl"){
                    $data['container']['rate'] = $this->getFreightForwarder($data);
                }
                return view('admin.quote.details')->with('data',$data);

            }else{
                if($this->locale == "es"){
                    return Redirect::to("/es/admin/quote/details/")->with('error',$this->freightforwarderMsg['not_found']);
                }else{
                    return Redirect::to("/admin/quote/details/")->with('error',$this->freightforwarderMsg['not_found']);
                }
            }
        }
       return view('admin.quote.details'); 
    }
    public function postQuote(Request $request){

        $post = $request->all();
        $this->validate($request, [
            'search_id' => 'required',
        ]);
        if(@$post['search_id']){
            if($this->locale == "es"){
                return Redirect::to("/es/admin/quote/details/".$post['search_id'])->send();
            }else{
                return Redirect::to("/admin/quote/details/".$post['search_id'])->send();
            }
        }                
        
    }
    public function postPaymentDocument(Request $request){
        $post = $request->all();
        $this->validate($request, [
            'search_id' => 'required',
            'quote_id'=>'required',
        ]);
        $file = Input::file('advance_payment'); $full_filename="";
        if(@$file){
            $Orname = $file->getClientOriginalName();
            $filename= 'advance_payment';
            $imageName = $file->getClientOriginalName();
            $destination_path = base_path() . '/public/payment/'.$post['search_id'];
            $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
            $extension = $file->getClientOriginalExtension();
            $full_filename= $filename.'.'.$extension;
            $file->move($destination_path,$full_filename);
            $datas['advance_payment_document'] = $full_filename;
            $datas['modified'] =CURRENT_DATETIME;
            DB::table('quotes')->where('quote_id', $post['quote_id'])->update($datas);
            $data = (array) DB::table('searches')->where('search_id', $post['search_id'])->join('users','users.id','=','searches.user_id')->select('users.name','users.email')->first();
            $view = 'emails.forwarder.additional_services'; 
            $data['subject'] ='Advance Document';
            $data['html'] = '<p><a href="'.newurl('/quote/payment/'.$post['search_id']).'"> Click here</a> to proceed for payment.</p><p>Please find the attach document for Advance Payment.</p>';
            $data['attach'] = $destination_path.'/'.$full_filename;
            Mail::send($view, $data, function ($message) use($data){
                $message->attach($data['attach']);
                $message->to($data['email'])->subject($data['subject']);
            });
        }
        $file = Input::file('pending_payment_document'); $full_filename="";
        if(@$file){
            $Orname = $file->getClientOriginalName();
            $filename= 'pending_payment_document';
            $imageName = $file->getClientOriginalName();
            $destination_path = base_path() . '/public/payment/'.$post['search_id'];
            $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
            $extension = $file->getClientOriginalExtension();
            $full_filename= $filename.'.'.$extension;
            $file->move($destination_path,$full_filename);
            $datas['pending_payment_document'] = $full_filename;
            $datas['modified'] =CURRENT_DATETIME;
            DB::table('quotes')->where('quote_id', $post['quote_id'])->update($datas);
            $data = (array) DB::table('searches')->where('search_id', $post['search_id'])->join('users','users.id','=','searches.user_id')->select('users.name','users.email')->first();
            $view = 'emails.forwarder.additional_services'; 
            $data['subject'] ='Final Payment Document';
            $data['html'] = '<p><a href="'.newurl('/quote/final_payment/'.$post['search_id']).'"> Click here</a> to proceed for payment.</p>
                <p>Please find the attach document for Advance Payment.</p>';
            $data['attach'] = $destination_path.'/'.$full_filename;
            Mail::send($view, $data, function ($message) use($data){
                $message->attach($data['attach']);
                $message->to($data['email'])->subject($data['subject']);
            });
        }
        
        if(@$post['search_id']){
            if($this->locale == "es"){
                return Redirect::to("/es/admin/quote/details/".$post['search_id'])->send();
            }else{
                return Redirect::to("/admin/quote/details/".$post['search_id'])->send();
            }
        }                
        
    }

    public function getFreightForwarder($data){
        //dd($data['routes']);
        $query = DB::table('ocean_routes')->join('ocean_fcl_rates','ocean_fcl_rates.ocean_route_id','=','ocean_routes.ocean_route_id')
            ->select('ocean_fcl_rates.validity','ocean_fcl_rates.rate_20_ofc','ocean_fcl_rates.rate_20_baf','ocean_fcl_rates.rate_20_pss','ocean_fcl_rates.rate_40_ofc','ocean_fcl_rates.rate_40_baf','ocean_fcl_rates.rate_40_pss','ocean_fcl_rates.rate_40hc_ofc','ocean_fcl_rates.rate_40hc_baf','ocean_fcl_rates.rate_40hc_pss','ocean_fcl_rates.carrier')
            ->where('ocean_routes.origin_ocean_port_id','=',$data['routes']->origin_port_id)
            ->where('ocean_routes.destination_ocean_port_id','=',$data['routes']->destination_port_id)
            ->where('ocean_routes.company_id','=',$this->company_id);
        $query = $query->first();
        return $query;
    }
}