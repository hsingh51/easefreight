<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Mail;
use Illuminate\Support\Facades\Input;
use App;
class AdditionalController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_id = Auth::user()->id;
        $this->company_id = Auth::user()->company_id;
        $this->middleware('auth');
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
        $this->incoterm = \Config::get('constants.incoterm');
        $this->before(Auth::user()->group_id);
        
    }

    public function before($group_id)
    {
        if ($group_id == '1') {
            return Redirect::to('/administrator/dashboard')->send();
            if($this->locale == "es"){  
                return Redirect::to('/es/freight/register')->with('error',$this->freightforwarderMsg['register']['error']);
            }else{
                return Redirect::to('/freight/register')->with('error',$this->freightforwarderMsg['register']['error']);
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

    public function getAdditionalRate($search_id = NULL,$type = NULL)
    {
        if(@$search_id){
            $data = DB::table('additional_services')
                        ->join('searches', 'additional_services.search_id', '=', 'searches.search_id');
            $data = $data->select('quotes.*','additional_services.*','additional_info.*','searches.*',
                'users.email','users.name','international_insurances.invoice',
                'international_insurances.vat_percentage','international_insurances.insurance_fee_percentage','international_insurances.insurance_min_fee','international_insurances.vat_percentage as insurances_vat_percentage','international_insurances.customs_percentage as insurances_customs_percentage','international_insurances.deductible as insurances_deductible','international_insurances.inland as insurances_inland','international_insurances.incoterm as incoterm_value');            
            if($type == "airtime" || $type == "airfreight"){
               	$data = $data->join('afr_routes', function($join)
                                                        {
                                                            $join->on('afr_routes.afr_route_id', '=', 'searches.afr_route_id')
                                                                 ->where('searches.type', '=', "airtime");
                                                        });
                $data = $data->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
                ->leftjoin('users', 'users.id', '=', 'additional_services.user_id')
                ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
                ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
                ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
                ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
                ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')
                ->leftjoin('additional_info', 'additional_info.search_id', '=', 'searches.search_id')
                ->leftjoin('cargo_details', 'cargo_details.additional_info_id', '=', 'additional_info.additional_info_id')
                ->leftjoin('international_insurances', 'international_insurances.search_id', '=', 'searches.search_id')
                ->leftjoin('quotes', 'quotes.search_id', '=', 'searches.search_id');
                
                $data = $data->addSelect('afr_routes.afr_route_id','ocity.title as ocity','ocountry.title as ocountry','oairports.name as oairport','dcity.title as dcity','dcountry.title as dcountry','dairports.name as dairport','cargo_details.cargo_12digit','cargo_details.number','cargo_details.discription','cargo_details.dangerous_good','cargo_details.cargo_detail_id','cargo_details.cargo_6digit','quotes.voyage'); 
            }elseif ($type == "maritime" || $type=="Maritime") {
                $data = $data->join('ocean_routes', function($join){
                        $join->on('ocean_routes.ocean_route_id', '=', 'searches.ocean_route_id')
                        ->where('searches.type', '=', 'maritime');
                    });
                $data = $data->leftjoin('users', 'users.id', '=', 'additional_services.user_id')
                ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
                ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
                ->leftjoin('ocean_ports as oports', 'ocean_routes.origin_ocean_port_id', '=', 'oports.ocean_port_id')
                ->leftjoin('ocean_ports as dports', 'ocean_routes.destination_ocean_port_id', '=', 'dports.ocean_port_id')
                ->leftjoin('additional_info', 'additional_info.search_id', '=', 'additional_services.search_id')
                ->leftjoin('cargo_details', 'cargo_details.additional_info_id', '=', 'additional_info.additional_info_id')
                ->leftjoin('quotes', 'quotes.search_id', '=', 'searches.search_id')
                ->leftjoin('cities as o_city', 'oports.city_id', '=', 'o_city.city_id')
                ->leftjoin('international_insurances', 'international_insurances.search_id', '=', 'searches.search_id')
                ->leftjoin('cities as d_city', 'dports.city_id', '=', 'd_city.city_id')
                ->leftjoin('terminals as o_terminals', 'o_terminals.terminal_id', '=', 'ocean_routes.origin_terminal_id')
                ->leftjoin('terminals as d_terminals', 'd_terminals.terminal_id', '=', 'ocean_routes.destination_terminal_id');
                $data = $data->addSelect('ocean_routes.ocean_route_id','o_city.title as ocity','ocountry.title as ocountry','oports.port_title as oport_title','d_city.title as dcity','dcountry.title as dcountry','dports.port_title as dport_title','o_terminals.title as oterminal','d_terminals.title as dterminal','cargo_details.cargo_12digit','cargo_details.number','cargo_details.discription','cargo_details.dangerous_good','cargo_details.cargo_detail_id','cargo_details.cargo_6digit','quotes.voyage'); 
            }            
            $data = $data->where('additional_services.search_id','=',$search_id);
            $data = $data->where('searches.ff_id','=',$this->user_id);
            $data = $data->first();

            if(@$data){
                $data->incoterm = $this->incoterm;
                $data->search_id = $search_id;

                //dd($data);

                return view('admin.additional.view')->with('data',$data);
            }else{
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/additionalRates")->with('error','Invaild id');
                }else{
                    return Redirect::to("/admin/additionalRates")->with('error','Invaild id');
                }
            }
        }else{
            return view('admin.additional.view');    
        }
        
    }
    public function postAdditionalRate(Request $request){

        $post = $request->all();
        $this->validate($request, [
            'search_id' => 'required',
        ]);

        $data = DB::table('additional_services')
            ->join('searches', 'additional_services.search_id', '=', 'searches.search_id')
            ->leftjoin('international_insurances', 'international_insurances.search_id', '=', 'searches.search_id')
            ->select('additional_services.*','searches.type','international_insurances.invoice','international_insurances.incoterm')
            ->where('additional_services.search_id','=',$post['search_id'])->first();
        if(@$data){
            if($this->locale == "es"){  
                return Redirect::to("/es/admin/additionalRates".DIRECTORY_SEPARATOR.$post['search_id'].DIRECTORY_SEPARATOR.$data->type)->send();
            }else{
                return Redirect::to("/admin/additionalRates".DIRECTORY_SEPARATOR.$post['search_id'].DIRECTORY_SEPARATOR.$data->type)->send();
            } 
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/admin/additionalRates/0")->send();
            }else{
                return Redirect::to("/admin/additionalRates/0")->send();
            }
        }                
        
    }

    public function saveAdditionalRate(Request $request){

        $post = $request->all();
        //dd($post);
        // $this->validate($request, [
        //     'search_id' => 'required',
        //     'additional_service_id' => 'required',
        //     // 'origin_handling' => 'required',
        //     // 'origin_documentation' => 'required',
        //     // 'foreign_custom_documentation' => 'required',
        //     // 'destination_handling' => 'required',
        //     // 'destination_documentation' => 'required',
        //     // 'docs_rad' => 'required',
        //     // 'caf' => 'required',
        //     // 'release' => 'required',
        //     // 'anti_narcotics' => 'required',
        //     // 'dian_inspection' => 'required',
        //     // 'extra_weight_surcharge'=>'required',
        //     // 'extra_length_surcharge'=>'required',
        //     // 'dangerous_cargo_surcharge'=>'required',
        //     // 'courrier_charge'=>'required',
        //     // 'freight_certification'=>'required',
        //     // 'dest_BL_emission'=>'required',
        //     // 'dest_BL_charge'=>'required',
        //     'vat_percentage'=>'required_if:insurance_check,1',
        //     'insurance_fee_percentage'=>'required_if:insurance_check,1',
        //     'insurance_min_fee'=>'required_if:insurance_check,1',
        //     //'inland'=>'required_if:insurance_check,1',
        //     //'deductible'=>'required_if:insurance_check,1',
        //     'customs_brokerage_documentation"'=>'required',
        // ]);
        $international_cutoms_content="";
        $insurance_id = '';
        if($post['insurance_check']){
            $insurance_id = $this->saveInsurance($post['insurance'],$post['search_id'],$post['quote_id']);
        }
        $additional_service_content = json_encode($post['additional']);
        $foreign_charges_content = json_encode($post['foreign_charges_content']);
        $international_custom_content = (isset($post['international_custom_content']))? json_encode($post['international_custom_content']): "";
        $voyage = "";
        if(@$post['voyage']){
            $voyage = $post['voyage'];
        }
        $datas = array(
            'search_id' => $post['search_id'],
            'additional_service_id' => $post['additional_service_id'],
            'additional_info_id' => $post['additional_info_id'],
            'cargo_detail_id' => $post['cargo_detail_id'],
            'insurance_id' => $insurance_id,
            'international_custom_content' => $international_custom_content,
            'additional_service_content' => $additional_service_content,
            'eur_usd_exchange_rate' => $post['eur_usd_exchange_rate'],
            'pickup_inland_fort' => (isset($post['pickup_inland_fort']))? $post['pickup_inland_fort'] : '',
            'pickup_inland_fort_note' => (isset($post['pickup_inland_fort_note']))? $post['pickup_inland_fort_note'] : '',
            'foreign_port_charges' => (isset($post['foreign_port_charges']))? $post['foreign_port_charges'] : '',
            'foreign_port_charges_note' => (isset($post['foreign_port_charges_note']))? $post['foreign_port_charges_note'] : '',
            'foreign_charges_content' => $foreign_charges_content,
            'voyage' => $voyage,
        ); 

        if(@$post['quote_id']){
            $datas['modified'] =CURRENT_DATETIME;
            DB::table('quotes')->where('quote_id', $post['quote_id'])->update($datas);
        }else{
            $datas['created'] =CURRENT_DATETIME;
            DB::table('quotes')->insert($datas);
        }
        $data['name'] = $post['user_name'];
        $data['user_email'] = $post['user_email'];
        $url = '/quote/quote_details/'.$post['search_id'];
        if($post['insurance_check']){
           $url = '/quote/international_insurance/'.$post['search_id'];
        }
        if($this->locale == "es"){  
            $url = BASE_URL.'/es'.$url;
        }else{
            $url = BASE_URL.$url;
        }
        $view = 'emails.forwarder.additional_services'; 

        $this->locale = App::getLocale();
        if($this->locale == "es"){ 
            $data['subject'] ='Detalle de la cotización final';
            $data['html'] = '<p>El numero de referencia de tu cotizacion es: '.$post['search_id'].'.<p>
            La cotizacion ha sido actualizada por el Agente de Carga de Easefreight. <a href="'.$url.'">Por favor haga click aca para continuar.</a></p>';
        }else{
            $data['subject'] ='Final Quote Detail';
            $data['html'] = '<p>Your quote reference number is: '.$post['search_id'].'.<p>Quote rate updated by Ease Freight Forwarder. Please <a href="'.$url.'">click here to proceed next</a>.</p>';   
        }



        Mail::send($view, $data, function ($message) use($data){
            $message->to($data['user_email'])->subject($data['subject']);
        });
        $data=array();
        $data['url'] = $url;
        DB::table('searches')->where('search_id',$post['search_id'])->update($data);
        if($this->locale == "es"){  
            return Redirect::to("/es/admin/additionalRates")->with('success',$this->freightforwarderMsg['success']);
        }else{
            return Redirect::to("/admin/additionalRates")->with('success',$this->freightforwarderMsg['success']);
        }
    }
    public function saveInsurance($insurance,$search_id,$quote_id = null){
        $inland = (isset($insurance['inland']))? $insurance['inland']: "";
        $datas = array(
            'search_id' => $search_id,
            //'cargo_cfr_cost'=>$insurance['cargo_cfr_cost'],
            'customs_percentage'=>(isset($insurance['customs_percentage']))? $insurance['customs_percentage']/100: '',
            'insurance_fee_percentage'=>$insurance['insurance_fee_percentage'] / 100,
            'vat_percentage'=>$insurance['vat_percentage'] / 100,
            'insurance_min_fee'=>$insurance['insurance_min_fee'],
            'inland'=> $inland,
            'deductible'=>$insurance['deductible'],
        );
        if(@$search_id){
            $datas['modified'] =CURRENT_DATETIME;
            $insurance = DB::table('international_insurances')->select('international_insurances.international_insurance_id')->where('search_id','=',$search_id)->first();
            $insurance_id = $insurance->international_insurance_id;
            DB::table('international_insurances')->where('international_insurance_id', $insurance_id)->update($datas);
        }
        return $insurance_id;
    }
    public function editAdditionalRate(Request $request){
        $post = $request->all();
        $data = DB::table('additional_services')
                        ->join('searches', 'additional_services.search_id', '=', 'searches.search_id')
                        ->select('additional_services.content','additional_services.search_id','searches.type')
                        ->where('additional_services.additional_service_id','=',$post['additional_service_id'])
                        ->first();
        if(@$data){
            $content = json_decode($data->content);
            foreach ($content as $key => $value) {
                $newcontent[$key] = $value;                
            }
            $newcontent['value'] = $post['value'];
            $newcontent['note'] = $post['note'];
            $datas['content'] = json_encode($newcontent);
            //dd($datas); 
            $return = DB::table('additional_services')->where('additional_service_id', $post['additional_service_id'])->update($datas);
            if($this->locale == "es"){  
                return Redirect::to("/es/admin/additionalRates".DIRECTORY_SEPARATOR.$data->search_id.DIRECTORY_SEPARATOR.$data->type)->send();
            }else{
                return Redirect::to("/admin/additionalRates".DIRECTORY_SEPARATOR.$data->search_id.DIRECTORY_SEPARATOR.$data->type)->send();
            } 
        }

        
        //dd($post);     
    }
}