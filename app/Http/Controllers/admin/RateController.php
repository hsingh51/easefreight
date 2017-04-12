<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App;
class RateController extends Controller
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
        $this->before(Auth::user()->group_id);
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
    }

    public function before($group_id)
    {
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

    public function viewTarifasAFR()
    {
        
        $query =  DB::table('afr_route_rates')->where('afr_route_rates.user_id','=',$this->user_id)
            ->join('afr_routes','afr_routes.afr_route_id','=','afr_route_rates.afr_route_id')
            ->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
            ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
            ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
            ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
            ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
            ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')
            ->leftjoin('airlines as c_airlines', 'afr_route_rates.carrier', '=', 'c_airlines.airline_id')
            ->leftjoin('itinerary', 'itinerary.afr_route_rates_id', '=', 'afr_route_rates.afr_route_rates_id')
            ->select('afr_routes.*','afr_route_rates.*',
                'afr_route_rates.due_carrier','afr_route_rates.due_agent','afr_route_rates.direct_via',
                'ocity.title as ocity_title','ocountry.title as ocountry_title',
                'dcity.title as dcity_title','dcountry.title as dcountry_title',
                'oairports.name as oair_name','oairports.iata_code as oiata_code',
                'dairports.name as dair_name','dairports.iata_code as diata_code',
                'itinerary.itinerary_id as itinerary_id','itinerary.afr_route_rates_id as itinerary_rates_id', 
                DB::raw('concat(c_airlines.title, ", ", c_airlines.iata_designator) as carrier'));
            
        if((isset($_GET['origin_airport_id']) && !empty($_GET['origin_airport_id']))){
            $query->where('afr_routes.origin_airport_id','=',$_GET['origin_airport_id']);
            //$query = $query->Where(function ($query) {
                // $query->orwhere('ocity.title','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('ocountry.title','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('dcity.title','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('dcountry.title','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.minimum','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.1kgs','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.50kgs','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.100kgs','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.300kgs','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.500kgs','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.transit_time','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.frequency','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.validity','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.awb_documentation','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.due_carrier','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.due_agent','LIKE','%'.$_GET['search'].'%')
                //     ->orwhere('afr_route_rates.carrier','LIKE','%'.$_GET['search'].'%');
            //});
        }
        if((isset($_GET['destination_airport_id']) && !empty($_GET['destination_airport_id']))){
            $query->where('afr_routes.destination_airport_id','=',$_GET['destination_airport_id']);
        }
        $result = $query->paginate(PAGENATE);
        $data['airports'] = DB::table('airports')->leftjoin('cities','airports.city_id','=','cities.city_id')
            ->select(DB::raw('concat(cities.title, ", ", airports.name) as name'),'airports.airport_id','airports.iata_code')->where('airports.is_active','=','1')->orderBy('airports.name')->get();
        //dd($result);
        return view('admin.rates.view')->with(array('data'=>$result,'stats'=>$data));
    }
    public function getTarifasAFR($route_id=NULL,$id=NULL,$route_result=null)
    {
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->orderBy('countries.title')->where('is_active','=','1')->get();
        $stats['cities'] = "";
		$stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code')->where('is_active','=','1')->orderBy('airports.name')->get();
        
		$stats['airlines'] = DB::table('airlines')->select('airlines.airline_id','airlines.title','airlines.iata_designator')->orderBy('airlines.title')->get();
		
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;
        $stats['params']['route_result'] = $route_result;
        $stats['frequencies'] = DB::table('frequencies')->select('*')->where('status','=','1')->get(); 
        if(@$route_id){
            $stats['air_routes'] = DB::table('afr_routes')
                ->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
                ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
                ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
                ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
                ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
                ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')
                ->select('afr_routes.destination_airport_id','afr_routes.origin_airport_id','afr_routes.origin_city_id','afr_routes.destination_city_id','afr_routes.destination_country_id','afr_routes.origin_country_id','afr_routes.afr_route_id','ocity.title as ocity','ocountry.title as ocountry','oairports.name as oairport',
                    'dcity.title as dcity','dcountry.title as dcountry','dairports.name as dairport')
                ->where('afr_routes.afr_route_id','=',$route_id)
            ->first();
            $stats['ocities'] = DB::table('cities')->select('title','city_id')->where('cities.country_id','=',$stats['air_routes']->origin_country_id)->get();
            $stats['dcities'] = DB::table('cities')->select('title','city_id')->where('cities.country_id','=',$stats['air_routes']->destination_country_id)->get();
            $stats['oairports'] = DB::table('airports')->select('name','airport_id','iata_code')->where('airports.country_id','=',$stats['air_routes']->origin_country_id)->where('airports.city_id','=',$stats['air_routes']->origin_city_id)->get();
            $stats['dairports'] = DB::table('airports')->select('name','airport_id','iata_code')->where('airports.country_id','=',$stats['air_routes']->destination_country_id)->where('airports.city_id','=',$stats['air_routes']->destination_city_id)->get();
        }
        
        return view('admin.rates.add')->with('stats',$stats);
    }

    // UserController.php
    public function addTarifasAFR(Request $request) {
        $post = $request->all();
        $company_id = Auth::user()->company_id;
        $this->validate($request, [
            'minium_rate' => 'required|numeric',
            // '1kg' => 'required|numeric',
            // '50kg' => 'required|numeric',
            'less_100kg' => 'required|numeric',
            'more_100kg' => 'required|numeric',
            'more_300kg' => 'required|numeric',
            'more_500kg' => 'required|numeric',
            //'transit_time' => 'required',
            //'frequency' => 'required',
            'validity' => 'required',
            'awb' => 'required|numeric',
            'due_carrier' => 'required|numeric',
            'due_agent' => 'required|numeric',
            'carrier' => 'required',
            'direct'=>'required',
            'direct_via'=>'required_if:direct,no',
        ]);

        $afr_route_id = $post['afr_route_id'];
        $direct_via = ($post['direct']=='yes')? 'Direct':implode(',', $post['direct_via']);
        //dd($direct_via);
        $datas = array(
            'user_id' =>$this->user_id,
            'afr_route_id' => $afr_route_id,
            'minimum' => $post['minium_rate'],
            // '1kgs' => $post['1kg'],
            // '50kgs' => $post['50kg'],
            'less_100kgs' => $post['less_100kg'],
            'more_100kgs' => $post['more_100kg'],
            'more_300kgs' => $post['more_300kg'],
            'more_500kgs' => $post['more_500kg'],
            //'transit_time' => $post['transit_time'],
            //'frequency' => $post['frequency'],
            'validity' => date('Y-m-d',strtotime($post['validity'])),
            'awb_documentation' => $post['awb'],
            'due_carrier' => $post['due_carrier'],
            'due_agent' => $post['due_agent'],
            'carrier' => $post['carrier'],
            'other' => $post['other'],
            'direct_via' => $direct_via,
            'created' => CURRENT_DATETIME,
        );
        if(DB::table('afr_route_rates')->insert($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/tarifasAFR/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/tarifasAFR/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/tarifasAFR/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/tarifasAFR/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function deleteTarifasAFR($id)
    {
        $user_id = $this->user_id;
        DB::table('afr_route_rates')->where('afr_route_rates.user_id','=',$user_id)->where('afr_route_rates.afr_route_rates_id','=',$id)->delete();
        if($this->locale == "es"){
            return Redirect::to('/es/admin/tarifasAFR/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/tarifasAFR/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    public function geteditTarifasAFR($route_id=NULL,$id=NULL)
    {
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;   
        if(!isset($id) && empty($id)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/tarifasAFR/View');
            }else{
                return Redirect::to('/admin/tarifasAFR/View'); 
            }
        }
        
        $stats['data'] = DB::table('afr_route_rates')->select('afr_route_rates.*')
            ->where('afr_route_rates.afr_route_rates_id','=',$id)->first();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')
            ->get();
        $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code')->where('is_active','=','1')->orderBy('airports.name')->get();
        $stats['airlines'] = DB::table('airlines')->select('airlines.airline_id','airlines.title','airlines.iata_designator')->orderBy('airlines.title')->get();
        $stats['frequencies'] = DB::table('frequencies')->select('*')->where('status','=','1')->get();    
        
        $stats['air_routes'] = DB::table('afr_routes')
            ->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
            ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
            ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
            ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
            ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
            ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')
            ->select('afr_routes.afr_route_id','ocity.title as ocity','ocountry.title as ocountry','oairports.name as oairport','dcity.title as dcity',
                'dcountry.title as dcountry','dairports.name as dairport')
            ->where('afr_routes.afr_route_id','=',$route_id)
            ->first();
        //dd($stats['data']);    
        return view('admin.rates.edit')->with('stats',$stats);
    }
    public function editTarifasAFR(Request $request)
    {
        
        $post = $request->all();
        //dd($post);
        $comany_id = Auth::user()->comany_id;
        $this->validate($request, [
            'afr_route_id' => 'required',
            'minium_rate' => 'required|numeric',
            // '1kg' => 'required|numeric',
            // '50kg' => 'required|numeric',
            'less_100kg' => 'required|numeric',
            'more_100kg'=>'required|numeric',
            'more_300kg' => 'required|numeric',
            'more_500kg' => 'required|numeric',
            //'transit_time' => 'required',
            //'frequency' => 'required',
            'validity' => 'required|date|date_format:m/d/Y',
            'awb' => 'required',
            'due_carrier' => 'required',
            'due_agent' => 'required',
            'carrier' => 'required',
            'direct'=>'required',
            'direct_via'=>'required_if:direct,no',
        ]);
        $direct_via = ($post['direct']=='yes')? 'Direct':implode(',', $post['direct_via']);
        $datas = array(
            'afr_route_id' => $post['afr_route_id'],
            'minimum' => $post['minium_rate'],
            // '1kgs' => $post['1kg'],
            // '50kgs' => $post['50kg'],
            'less_100kgs' => $post['less_100kg'],
            'more_100kgs' => $post['more_100kg'],
            'more_300kgs' => $post['more_300kg'],
            'more_500kgs' => $post['more_500kg'],
            //'transit_time' => $post['transit_time'],
            //'frequency' => $post['frequency'],
            'validity' => date('Y-m-d',strtotime($post['validity'])),
            'awb_documentation' => $post['awb'],
            'due_carrier' => $post['due_carrier'],
            'due_agent' => $post['due_agent'],
            'carrier' => $post['carrier'],
            'other' => $post['other'],
            'direct_via' => $direct_via,
            'modified' => CURRENT_DATETIME,
        );
        //dd($post);
        DB::table('afr_route_rates')->where('afr_route_rates_id', $post['terminal_rates'])->update($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/tarifasAFR/View')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('/admin/tarifasAFR/View')->with('success',$this->freightforwarderMsg['update']); 
        }
       
    }

    //Ocean Lcl start
    public function viewOceanLCL()
    {
        $query =  DB::table('ocean_lcl_rates')
            ->select('ocean_lcl_rates.*','oport.port_title as oport_title','dport.port_title as dport_title','ocountries.title as ocountry','dcountries.title as dcountry','oterminal.title as oplace','dterminal.title as dplace','demission.dest_doc_fee_dest','oemaission.org_doc_fee_origin','oemaission.org_doc_fee_dest','oemaission.org_doc_emssion_fee_dest as org_doc_emssion_fee_dest','demission.dest_ems_emssion_fee_dest','oc.destination_charges','oc.origin_charges')
            ->where('ocean_lcl_rates.company_id','=',$this->company_id)
            ->join('ocean_routes','ocean_lcl_rates.ocean_route_id','=','ocean_routes.ocean_route_id')
            ->leftjoin('ocean_ports as oport','ocean_routes.origin_ocean_port_id','=','oport.ocean_port_id')
            ->leftjoin('ocean_ports as dport','ocean_routes.destination_ocean_port_id','=','dport.ocean_port_id')
            ->leftjoin('countries as ocountries','ocean_routes.origin_country_id','=','ocountries.country_id')
            ->leftjoin('countries as dcountries','ocean_routes.destination_country_id','=','dcountries.country_id')
            ->leftjoin('terminals as oterminal','ocean_routes.origin_terminal_id','=','oterminal.terminal_id')
            ->leftjoin('terminals as dterminal','ocean_routes.destination_terminal_id','=','dterminal.terminal_id')
            ->leftjoin('destination_doc_emission_fees as demission','ocean_lcl_rates.destination_doc_emission_fee_id','=','demission.destination_doc_emission_fee_id')
            ->leftjoin('origin_doc_emission_fees as oemaission','ocean_lcl_rates.origin_doc_emission_fee_id','=','oemaission.origin_doc_emission_fee_id')
            ->leftjoin('other_charges as oc','ocean_lcl_rates.other_charge_id','=','oc.other_charge_id');

        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->Where(function ($query) {
                $query->orwhere('oport.port_title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('dport.port_title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocountries.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('dcountries.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.ocean_lcl_rate_id','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.min_OFR','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.min_BAF','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.CBM','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.MTON','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.rate_OFR','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.rate_BAF','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.estimated_transit','LIKE','%'.$_GET['search'].'%')
                    //->orwhere('ocean_lcl_rates.frequency','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.carrier','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_lcl_rates.validity','LIKE','%'.$_GET['search'].'%'); 
            });
        }
        $result = $query->paginate(PAGENATE);
        return view('admin.rates.oceanLCL.view')->with('data',$result);
    }
    public function getOceanLCL($route_id=NULL,$id=NULL,$route_result=null)
    { 
        $company_id = Auth::user()->company_id;
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy('countries.title')->get();
        
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;
        $stats['params']['route_result'] = $route_result;
		$stats['frequencies'] = DB::table('frequencies')->select('*')->where('status','=','1')->get();
        if(@$route_id){
            $stats['ocean_routes'] =  DB::table('ocean_routes')
                ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
                ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
                ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
                ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
                ->select('ocean_routes.*','oport.port_title as oport_title','ocountry.title as ocountry_title', 'dport.port_title as dport_title','dcountry.title as dcountry_title')
                ->where('ocean_routes.ocean_route_id','=',$route_id)
                ->first();
            $stats['oports'] = DB::table('ocean_ports')->select('port_title','ocean_port_id')->where('ocean_ports.country_id','=',$stats['ocean_routes']->origin_country_id)->get();
            $stats['dports'] = DB::table('ocean_ports')->select('port_title','ocean_port_id')->where('ocean_ports.country_id','=',$stats['ocean_routes']->destination_country_id)->get();
            $stats['oterminal'] = DB::table('terminals')->select('title','terminal_id')->where('terminals.country_id','=',$stats['ocean_routes']->origin_country_id)->where('terminals.ocean_port_id','=',$stats['ocean_routes']->origin_ocean_port_id)->get();
            $stats['dterminal'] = DB::table('terminals')->select('title','terminal_id')->where('terminals.country_id','=',$stats['ocean_routes']->destination_country_id)->where('terminals.ocean_port_id','=',$stats['ocean_routes']->destination_ocean_port_id)->get();


            $stats['ocean_fcl_rates'] = DB::table('ocean_fcl_rates')
                                        ->select('ocean_fcl_rates.*')
                                        ->where('ocean_fcl_rates.company_id','=',$company_id)
                                        ->where('ocean_fcl_rates.ocean_route_id','=',$route_id)
                                        ->first();


            $rates = DB::table('ocean_lcl_rates')
                ->select('ocean_lcl_rates.*')
                ->where('ocean_lcl_rates.company_id','=',$company_id)
                ->where('ocean_lcl_rates.ocean_route_id','=',$route_id)
                ->first();
            if(@$rates){
                if($this->locale == "es"){
                    return Redirect::to('/es/admin/oceanLCL/Edit/'.$route_id.'/'.$rates->ocean_lcl_rate_id);
                }else{
                    return Redirect::to('/admin/oceanLCL/Edit/'.$route_id.'/'.$rates->ocean_lcl_rate_id); 
                }
            } 
        }    
        
        return view('admin.rates.oceanLCL.add')->with('stats',$stats);
    }
    public function addOceanLCL(Request $request) {

        
        $post = $request->all();
       
       
        $company_id = Auth::user()->company_id;
        $this->validateOceanLCL($request);

        $post['org_doc_carrier_agent']='';
        $post['dest_doc_carrier_agent']='';
        $post['dest_ems_carrier_agent']='';
        $post['org_ems_carrier_agent']='';

        $origin_doc_emission_fee_id = $this->origin_doc_emission_fee($post,$company_id);        
        $foreign_terminal_charge_id = $this->foreign_terminal_charge($post,$company_id);

        $datas = array(
            'origin_doc_emission_fee_id'=>$origin_doc_emission_fee_id,
            'foreign_terminal_charge_id'=>$foreign_terminal_charge_id,
            'ocean_route_id'=>$post['route_id'],
            'company_id' => $this->company_id,
            'CBM' => $post['CBM'],
            //'MTON' => $post['MTON'],
            'rate_OFR' => $post['rate_OFR'],
            'rate_BAF' => $post['rate_BAF'],
            //'estimated_transit' => $post['estimated_transit'],
            //'frequency' => $post['frequency'],
            'carrier' => $post['carrier'],
            'validity' => date("Y-m-d",strtotime($post['validity'])),
            'created' => CURRENT_DATETIME
        );
        //dd($datas);
        if(DB::table('ocean_lcl_rates')->insertGetId($datas)){           
           //DB::table('ocean_fcl_rates')->where('ocean_route_id', $post['route_id'])->update(array('frequency'=>$post['frequency']));           
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanLCL/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/oceanLCL/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanLCL/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/oceanLCL/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function deleteOceanLCL($ocean_id,$dest_id,$org_id,$for_id,$other_id)
    {
        $company_id = Auth::user()->company_id;
        DB::table('ocean_lcl_rates')->where('company_id','=',$company_id)->where('ocean_lcl_rate_id','=',$ocean_id)->delete();
        $this->deleteOtherRates($dest_id, $org_id, $for_id, $other_id);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/oceanLCL/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/oceanLCL/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }

    public function geteditOceanLCL($route_id=NULL,$id=NULL)
    {
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;    
        
        $stats['ocean_routes'] =  DB::table('ocean_routes')
            ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
            ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
            ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
            ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
            ->select('ocean_routes.*','oport.port_title as oport_title','ocountry.title as ocountry_title', 'dport.port_title as dport_title',
                'dcountry.title as dcountry_title')
            ->where('ocean_routes.ocean_route_id','=',$route_id)
            ->get();
        $stats['edit'] =  DB::table('ocean_lcl_rates')
            ->leftjoin('destination_doc_emission_fees as ddef', 'ocean_lcl_rates.destination_doc_emission_fee_id', '=', 'ddef.destination_doc_emission_fee_id')
            ->leftjoin('origin_doc_emission_fees as odef', 'ocean_lcl_rates.origin_doc_emission_fee_id', '=', 'odef.origin_doc_emission_fee_id')
            ->leftjoin('foreign_terminal_charges as ftc', 'ocean_lcl_rates.foreign_terminal_charge_id', '=', 'ftc.foreign_terminal_charge_id')
            ->leftjoin('other_charges as oc', 'ocean_lcl_rates.other_charge_id', '=', 'oc.other_charge_id')
            ->select('ocean_lcl_rates.*','ddef.*','odef.*','ftc.*','oc.*')
            ->where('ocean_lcl_rates.ocean_lcl_rate_id','=',$id)
            ->first();

        $stats['frequencies'] = DB::table('frequencies')->select('*')->where('status','=','1')->get();
        return view('admin.rates.oceanLCL.edit')->with('stats',$stats);
    }
    public function editOceanLCL(Request $request) {
        
        //die('fff');
        $post = $request->all();
        //dd($post);
        //dd($request);
        $this->validateOceanLCL($request);
        $company_id = Auth::user()->company_id;
        $post['org_doc_carrier_agent']='';
        $post['dest_doc_carrier_agent']='';
        $post['dest_ems_carrier_agent']='';
        $post['org_ems_carrier_agent']='';
        //$this->destination_doc_emission_fee($post,$company_id,true);
        $this->origin_doc_emission_fee($post,$company_id,true);
        $this->foreign_terminal_charge($post,$company_id,true);
        //$this->other_charge($post,$company_id,true);
        $datas = array(
            //'min_OFR' => $post['min_OFR'],
            //'min_BAF' => $post['min_BAF'],
            'CBM' => $post['CBM'],
            //'MTON' => $post['MTON'],
            'rate_OFR' => $post['rate_OFR'],
            'rate_BAF' => $post['rate_BAF'],
            //'estimated_transit' => $post['estimated_transit'],
            //'frequency' => $post['frequency'],
            'carrier' => $post['carrier'],
            'validity' => date("Y-m-d",strtotime($post['validity'])),
            'modified' => CURRENT_DATETIME
        );
       
        if(DB::table('ocean_lcl_rates')->where('ocean_lcl_rate_id', $post['ocean_lcl_rate_id'])->update($datas)){
           
           //DB::table('ocean_fcl_rates')->where('ocean_route_id', $post['route_id'])->update(array('frequency'=>$post['frequency']));
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanLCL/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/oceanLCL/View')->with('success',$this->freightforwarderMsg['success']); 
            } 
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanLCL/Edit/'.$post['route_id'].'/'.$post['ocean_lcl_rate_id'])->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/oceanLCL/Edit/'.$post['route_id'].'/'.$post['ocean_lcl_rate_id'])->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function validateOceanLCL($request){
        $this->validate($request, [
            'route_id'=>'required|numeric',
            'CBM' => 'required|numeric',
            //'MTON' => 'required|numeric',
            'rate_OFR' => 'required|numeric',
            'rate_BAF' => 'required|numeric',
            //'estimated_transit' => 'required',
            //'frequency' => 'required',
            'carrier' => 'required',
            'validity' => 'required',
            //'org_doc_carrier_key' => 'required',
            'org_doc_fee_origin' => 'required|numeric',
            'org_doc_fee_dest' => 'required|numeric',
            'org_doc_emssion_fee_dest' => 'required|numeric',            
            //'wharfage_city_port' => 'required',
            //'wharfage_airport_terminal' => 'required',
            'wharfage_lcl' => 'required|numeric',
            'wharfage_lcl_min' => 'required|numeric',            
            //'handling_charges_city_port' => 'required|numeric',
            //'handling_charges_airport_terminal' => 'required|numeric',
            'handling_charges_lcl' => 'required|numeric',
            'handling_charges_lcl_min' => 'required|numeric',
            //'load_charges_city_port' => 'required|numeric',
            //'load_charges_city_terminal' => 'required|numeric',
            'load_charges_lcl' => 'required|numeric',
            'load_charges_lcl_min' => 'required|numeric',
            //'terminal_security_city'=>'required',
            //'terminal_security_terminal'=>'required|numeric',
            //'terminal_security_charges'=>'required',
        ]);
    }
    // Ocean LCL End

    //Ocean FCL Start
    public function viewOceanFCL()
    {
        $query =  DB::table('ocean_fcl_rates')
            ->select('ocean_fcl_rates.*','oport.port_title as oport_title','dport.port_title as dport_title','ocountries.title as ocountry','dcountries.title as dcountry','oterminal.title as oplace','dterminal.title as dplace','demission.dest_doc_fee_dest', 'oemaission.org_doc_fee_origin', 'oemaission.org_doc_fee_dest', 'oemaission.org_ems_emssion_fee_dest','oemaission.org_doc_emssion_fee_dest as org_doc_emssion_fee_dest','demission.dest_ems_emssion_fee_dest','oc.destination_charges','oc.origin_charges')
            ->where('ocean_fcl_rates.company_id','=',$this->company_id)
            ->join('ocean_routes','ocean_fcl_rates.ocean_route_id','=','ocean_routes.ocean_route_id')
            ->leftjoin('ocean_ports as oport','ocean_routes.origin_ocean_port_id','=','oport.ocean_port_id')
            ->leftjoin('ocean_ports as dport','ocean_routes.destination_ocean_port_id','=','dport.ocean_port_id')
            ->leftjoin('countries as ocountries','ocean_routes.origin_country_id','=','ocountries.country_id')
            ->leftjoin('countries as dcountries','ocean_routes.destination_country_id','=','dcountries.country_id')
            ->leftjoin('terminals as oterminal','ocean_routes.origin_terminal_id','=','oterminal.terminal_id')
            ->leftjoin('terminals as dterminal','ocean_routes.destination_terminal_id','=','dterminal.terminal_id')
            ->leftjoin('destination_doc_emission_fees as demission','ocean_fcl_rates.destination_doc_emission_fee_id','=','demission.destination_doc_emission_fee_id')
            ->leftjoin('origin_doc_emission_fees as oemaission','ocean_fcl_rates.origin_doc_emission_fee_id','=','oemaission.origin_doc_emission_fee_id')
            ->leftjoin('other_charges as oc','ocean_fcl_rates.other_charge_id','=','oc.other_charge_id');

        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->Where(function ($query) {
                $query->orwhere('oport.port_title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('dport.port_title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocountries.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('dcountries.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.ocean_fcl_rate_id','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_20_ofc','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_20_baf','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_20_pss','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_40_ofc','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_40_baf','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_40_pss','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_40hc_ofc','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_40hc_baf','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.rate_40hc_pss','LIKE','%'.$_GET['search'].'%')
                    //->orwhere('ocean_fcl_rates.transit_time','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.frequency','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.carrier_key','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocean_fcl_rates.validity','LIKE','%'.$_GET['search'].'%');
            });
        }
        $result = $query->paginate(PAGENATE);
        return view('admin.rates.oceanFCL.view')->with('data',$result);
    }
    public function getOceanFCL($route_id=NULL,$id=NULL,$route_result=null)
    { 
        $company_id = Auth::user()->company_id;
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy('countries.title')->get();
        // $stats['terminals'] = DB::table('terminals as ocltr')
        //     ->where('ocltr.company_id','=',$this->company_id)
        //     ->leftjoin('cities','ocltr.city_id','=','cities.city_id')
        //     ->select('ocean_ports.port_title as place','ocltr.terminal_id','cities.title as city')
        //     ->leftjoin('ocean_ports','ocltr.port_id','=','ocean_ports.port_id')
        //     ->where('ocltr.is_active','=','1')->get();

        $stats['ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
            ->where('is_active','=','1')->get();
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;
        $stats['params']['route_result'] = $route_result;
		$stats['frequencies'] = DB::table('frequencies')->select('*')->where('status','=','1')->get();
        if(@$route_id){
            $stats['ocean_routes'] =  DB::table('ocean_routes')
                ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
                ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
                ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
                ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
                //->leftjoin('ocean_local_terminal_rates as ocltr', 'ocean_routes.origin_terminal_id', '=', 'ocltr.ocean_local_terminal_rate_id')
                //->leftjoin('ocean_local_terminal_rates as docltr', 'ocean_routes.origin_terminal_id', '=', 'docltr.ocean_local_terminal_rate_id')
                ->select('ocean_routes.*','oport.port_title as oport_title','ocountry.title as ocountry_title', 'dport.port_title as dport_title','dcountry.title as dcountry_title')
                ->where('ocean_routes.ocean_route_id','=',$route_id)
                ->first();

            $stats['oports'] = DB::table('ocean_ports')->select('port_title','ocean_port_id')->where('ocean_ports.country_id','=',$stats['ocean_routes']->origin_country_id)->get();
            $stats['dports'] = DB::table('ocean_ports')->select('port_title','ocean_port_id')->where('ocean_ports.country_id','=',$stats['ocean_routes']->destination_country_id)->get();
            $stats['oterminal'] = DB::table('terminals')->select('title','terminal_id')->where('terminals.country_id','=',$stats['ocean_routes']->origin_country_id)->where('terminals.ocean_port_id','=',$stats['ocean_routes']->origin_ocean_port_id)->get();
            $stats['dterminal'] = DB::table('terminals')->select('title','terminal_id')->where('terminals.country_id','=',$stats['ocean_routes']->destination_country_id)->where('terminals.ocean_port_id','=',$stats['ocean_routes']->destination_ocean_port_id)->get();

            $stats['ocean_lcl_rates'] = DB::table('ocean_lcl_rates')
                                        ->select('ocean_lcl_rates.*')
                                        ->where('ocean_lcl_rates.company_id','=',$company_id)
                                        ->where('ocean_lcl_rates.ocean_route_id','=',$route_id)
                                        ->first();


            $rates = DB::table('ocean_fcl_rates')
                ->select('ocean_fcl_rates.*')
                ->where('ocean_fcl_rates.company_id','=',$company_id)
                ->where('ocean_fcl_rates.ocean_route_id','=',$route_id)
                ->first();
            if(@$rates){
                if($this->locale == "es"){
                    return Redirect::to('/es/admin/oceanFCL/Edit/'.$route_id.'/'.$rates->ocean_fcl_rate_id);
                }else{
                    return Redirect::to('/admin/oceanFCL/Edit/'.$route_id.'/'.$rates->ocean_fcl_rate_id); 
                }
            }         
            //dd($rates);
        }    
        
        return view('admin.rates.oceanFCL.add')->with('stats',$stats);
    }
    public function addOceanFCL(Request $request) {

        $post = $request->all();
        //dd($request);
       
        $company_id = Auth::user()->company_id;
        $this->validateOceanFCL($request);

        //$post['org_doc_carrier_key']='';
        $post['dest_doc_carrier_key']='';
        $post['dest_ems_carrier_key']='';
        $post['org_ems_carrier_key']='';
        //$destination_doc_emission_fee_id = $this->destination_doc_emission_fee($post,$company_id);
        $origin_doc_emission_fee_id = $this->origin_doc_emission_fee($post,$company_id);
        $foreign_terminal_charge_id = $this->foreign_terminal_charge($post,$company_id);
       // $other_charge_id = $this->other_charge($post,$company_id);
        $direct_via = ($post['direct']=='yes')? 'Direct':implode(',', $post['direct_via']);
        $datas = array(
            //'destination_doc_emission_fee_id'=> $destination_doc_emission_fee_id,
            'origin_doc_emission_fee_id'=>$origin_doc_emission_fee_id,
            'foreign_terminal_charge_id'=>$foreign_terminal_charge_id,
            //'other_charge_id'=>$other_charge_id,
            'ocean_route_id'=>$post['route_id'],
            'company_id' => $company_id,
            'rate_20_ofc' => $post['rate_20_ofc'],
            'rate_20_baf' => $post['rate_20_baf'],
            'rate_20_pss' => $post['rate_20_pss'],
            'rate_40_ofc' => $post['rate_40_ofc'],
            'rate_40_baf' => $post['rate_40_baf'],
            'rate_40_pss' => $post['rate_40_pss'],
            'rate_40hc_ofc' => $post['rate_40hc_ofc'],
            'rate_40hc_baf' => $post['rate_40hc_baf'],
            'rate_40hc_pss' => $post['rate_40hc_pss'],
            //'transit_time' => $post['transit_time'],
            //'frequency' => $post['frequency'],
            'validity' => date("Y-m-d",strtotime($post['validity'])),
            'direct_via' =>$direct_via,
            'created' => CURRENT_DATETIME
        );
        if(@$post['carrier_key']){
            $datas['carrier'] = $post['carrier_key'];
        }
       //dd($datas);
        if(DB::table('ocean_fcl_rates')->insertGetId($datas)){
            //DB::table('ocean_lcl_rates')->where('ocean_route_id', $post['route_id'])->update(array('frequency'=>$post['frequency']));
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanFCL/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/oceanFCL/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanFCL/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/oceanFCL/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function deleteOceanFCL($ocean_id,$dest_id,$org_id,$for_id,$other_id)
    {
        $company_id = Auth::user()->company_id;
        DB::table('ocean_fcl_rates')->where('company_id','=',$company_id)->where('ocean_fcl_rate_id','=',$ocean_id)->where('ocean_fcl_rate_id','=',$ocean_id)->delete();
        $this->deleteOtherRates($dest_id, $org_id, $for_id, $other_id);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/oceanFCL/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/oceanFCL/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    
    public function geteditOceanFCL($route_id=NULL,$id=NULL)
    {
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;
        $stats['ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
            ->where('is_active','=','1')->get();
        $stats['ocean_routes'] =  DB::table('ocean_routes')
            ->join('terminals as oterminal', 'oterminal.terminal_id', '=', 'ocean_routes.origin_terminal_id')
            ->join('terminals as dterminal', 'dterminal.terminal_id', '=', 'ocean_routes.destination_terminal_id')
            ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
            ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
            ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
            ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
            ->select('ocean_routes.*','oterminal.title as origin_terminal','dterminal.title as destination_terminal','oport.port_title as oport_title','ocountry.title as ocountry_title', 'dport.port_title as dport_title','dcountry.title as dcountry_title')
            ->where('ocean_routes.ocean_route_id','=',$route_id)
            ->get();
        //dd($stats['ocean_routes']);    
        $stats['edit'] =  DB::table('ocean_fcl_rates')
            ->leftjoin('origin_doc_emission_fees as odef', 'ocean_fcl_rates.origin_doc_emission_fee_id', '=', 'odef.origin_doc_emission_fee_id')
            ->leftjoin('foreign_terminal_charges as ftc', 'ocean_fcl_rates.foreign_terminal_charge_id', '=', 'ftc.foreign_terminal_charge_id')
            ->select('ocean_fcl_rates.*','odef.*','ftc.*')
            ->where('ocean_fcl_rates.ocean_fcl_rate_id','=',$id)
            ->first();
        $stats['frequencies'] = DB::table('frequencies')->select('*')->where('status','=','1')->get();
        //dd($stats);
        return view('admin.rates.oceanFCL.edit')->with('stats',$stats);
    }
    public function editOceanFCL(Request $request)
    {
        $post = $request->all();
        
        $this->validateOceanFCL($request);
        
        $company_id = Auth::user()->company_id;
        //$post['org_doc_carrier_key']='';
        $post['dest_doc_carrier_key']='';
        $post['dest_ems_carrier_key']='';
        $post['org_ems_carrier_key']='';
        //$this->destination_doc_emission_fee($post,$company_id,true);
        $this->origin_doc_emission_fee($post,$company_id,true);
        $this->foreign_terminal_charge($post,$company_id,true);
        //$this->other_charge($post,$company_id,true);
        
        $datas = array(
            'rate_20_ofc' => $post['rate_20_ofc'],
            'rate_20_baf' => $post['rate_20_baf'],
            'rate_20_pss' => $post['rate_20_pss'],
            'rate_40_ofc' => $post['rate_40_ofc'],
            'rate_40_baf' => $post['rate_40_baf'],
            'rate_40_pss' => $post['rate_40_pss'],
            'rate_40hc_ofc' => $post['rate_40hc_ofc'],
            'rate_40hc_baf' => $post['rate_40hc_baf'],
            'rate_40hc_pss' => $post['rate_40hc_pss'],
            //'transit_time' => $post['transit_time'],
            //'frequency' => $post['frequency'],
            'carrier' => $post['carrier_key'],
            'validity' => date("Y-m-d",strtotime($post['validity'])),
            'modified' => CURRENT_DATETIME
        );
       if(@$post['direct_via']){
            $direct_via = ($post['direct']=='yes')? 'Direct':implode(',', $post['direct_via']);
            $datas['direct_via'] = $direct_via;
        }
        if(DB::table('ocean_fcl_rates')->where('ocean_fcl_rate_id', $post['ocean_fcl_rate_id'])->update($datas)){
           //DB::table('ocean_lcl_rates')->where('ocean_route_id', $post['route_id'])->update(array('frequency'=>$post['frequency']));
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanFCL/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/oceanFCL/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/oceanFCL/Edit/'.$post['route_id'].'/'.$post['ocean_fcl_rate_id'])->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/oceanFCL/Edit/'.$post['route_id'].'/'.$post['ocean_fcl_rate_id'])->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function validateOceanFCL($request){
        // echo "<pre>";
        // print_r($_POST);
        // die();
        $this->validate($request, [
            'route_id'=>'required',
            'rate_20_ofc' => 'required',
            'rate_20_baf' => 'required',
            'rate_20_pss' => 'required',
            'rate_40_ofc' => 'required',
            'rate_40_baf' => 'required',
            'rate_40_pss' => 'required',
            'rate_40hc_ofc' => 'required',
            'rate_40hc_baf' => 'required',
            'rate_40hc_pss' => 'required',
            //'transit_time' => 'required',
            //'frequency' => 'required',
            'carrier_key' => 'required',
            'validity' => 'required',
            'org_doc_fee_origin' => 'required|numeric',
            'org_doc_fee_dest' => 'required|numeric',
            'org_doc_emssion_fee_dest' => 'required',
            'wharfage_20' => 'required|numeric',
            'wharfage_40' => 'required|numeric',
            'wharfage_40hc' => 'required|numeric',
            'handling_charges_20' => 'required|numeric',
            'handling_charges_40' => 'required|numeric',
            'handling_charges_40hc' => 'required|numeric',
            'load_charges_20'=>'required',
            'load_charges_40'=>'required|numeric',
            'load_charges_40hc'=>'required|numeric',
            //'terminal_security_charges'=>'required|numeric'
        ]);
    }
    // ocean FCL end

    //Colombia rates Start
    public function viewColombiaRates()
    {
        $query =  DB::table('col_rates')
            ->select('col_rates.*','ocities.title as ocity','dcities.title as dcity','ocd.name as o_dep_name','ocd.zipcode as o_dep_zipcode','dcd.name as d_dep_name','dcd.zipcode as d_dep_zipcode')
            ->join('col_routes','col_rates.col_route_id','=','col_routes.col_route_id')
            ->leftjoin('cities as ocities','col_routes.org_city_id','=','ocities.city_id')
            ->leftjoin('cities as dcities','col_routes.dest_city_id','=','dcities.city_id')
            ->leftjoin('col_departments as ocd','col_routes.org_col_department_id','=','ocd.col_department_id')
            ->leftjoin('col_departments as dcd','col_routes.dest_col_department_id','=','dcd.col_department_id')
            ->where('col_rates.company_id','=',$this->company_id);
            
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('ocd.name','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('dcd.name','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('ocd.zipcode','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('dcd.zipcode','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('ocities.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('dcities.title','LIKE','%'.$_GET['search'].'%');

            $query = $query->orwhere('col_rates.col_rate_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.small_truck','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.small_stand_hours','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.medium_truck','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.medium_stand_hours','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.large_truck','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.large_stand_hours','LIKE','%'.$_GET['search'].'%');
            // $query = $query->orwhere('col_rates.c_16TON','LIKE','%'.$_GET['search'].'%');
            // $query = $query->orwhere('col_rates.c_16TON_stand_hours','LIKE','%'.$_GET['search'].'%');
            // $query = $query->orwhere('col_rates.c_25TON','LIKE','%'.$_GET['search'].'%');
            // $query = $query->orwhere('col_rates.c_25TON_stand_hours','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_rates.created','LIKE','%'.$_GET['search'].'%');
        }

        $result = $query->paginate(PAGENATE);
        return view('admin.rates.colombia.view')->with('data',$result);
    }
    public function getColombiaRates($route_id=NULL,$id=NULL,$route_result=null)
    { 

        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('country_id','=','42')->where('is_active','=','1')->orderBy('cities.title')->get();
        
        $company_id = Auth::user()->company_id;
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;
        $stats['params']['route_result'] = $route_result;
        if(@$route_id){
            $stats['col_routes'] =  DB::table('col_routes')
                ->select('col_routes.*','ocities.title as ocity','dcities.title as dcity','ocd.name as o_dep_name','ocd.zipcode as o_dep_zipcode',
                'dcd.name as d_dep_name','dcd.zipcode as d_dep_zipcode')
                 ->leftjoin('cities as ocities','col_routes.org_city_id','=','ocities.city_id')
                ->leftjoin('cities as dcities','col_routes.dest_city_id','=','dcities.city_id')
                ->leftjoin('col_departments as ocd','col_routes.org_col_department_id','=','ocd.col_department_id')
                ->leftjoin('col_departments as dcd','col_routes.dest_col_department_id','=','dcd.col_department_id')
                ->where('col_route_id','=',$route_id)
                ->first();
            $stats['odepartments'] = DB::table('col_departments')->select('col_departments.*')->where('col_departments.city_id','=',$stats['col_routes']->org_city_id)->where('col_departments.is_active','=','1')->get();
            $stats['ddepartments'] = DB::table('col_departments')->select('col_departments.*')->where('col_departments.city_id','=',$stats['col_routes']->dest_city_id)->where('col_departments.is_active','=','1')->get();
            //dd($stats['col_routes']);
            $rates = DB::table('col_rates')
                     ->where('col_route_id','=',$route_id)
                     ->where('company_id','=',$company_id)
                     ->first();
            if(@$rates){
                if($this->locale == "es"){
                    return Redirect::to('/es/admin/colombiaRates/Edit/'.$route_id.'/'.$rates->col_rate_id);
                }else{
                    return Redirect::to('/admin/colombiaRates/Edit/'.$route_id.'/'.$rates->col_rate_id); 
                }
            }
            //dd($rates);          
        }    
        return view('admin.rates.colombia.add')->with('stats',$stats);
    }
    public function addColombiaRates(Request $request) {

        $post = $request->all();
        //dd($request);
       
        $company_id = Auth::user()->company_id;
        $this->validateColombiaRates($request);
        $datas = array(
            'col_route_id'=>$post['route_id'],
            'company_id' => $company_id,
            'small_truck' => $post['small_truck'],
            'small_stand_hours' => $post['small_stand_hours'],
            'medium_truck' => $post['medium_truck'],
            'medium_stand_hours' => $post['medium_stand_hours'],
            'large_truck' => $post['large_truck'],
            'large_stand_hours' => $post['large_stand_hours'],
            'created' => CURRENT_DATETIME
        );
        if(DB::table('col_rates')->insertGetId($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/colombiaRates/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/colombiaRates/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/colombiaRates/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/colombiaRates/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function deleteColombiaRates($col_rate_id)
    {
        
        $company_id = Auth::user()->company_id;
        DB::table('col_rates')->where('company_id','=',$company_id)->where('col_rate_id','=',$col_rate_id)->delete();
        //$this->deleteOtherRates($dest_id, $org_id, $for_id, $other_id);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/colombiaRates/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/colombiaRates/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    
    public function geteditColombiaRates($route_id=NULL,$id=NULL)
    {
        $stats['params']['route_id'] = $route_id;
        $stats['params']['id'] = $id;    
        $stats['col_routes'] =  DB::table('col_routes')
                ->select('col_routes.*','ocities.title as ocity','dcities.title as dcity','ocd.name as o_dep_name','ocd.zipcode as o_dep_zipcode','dcd.name as d_dep_name','dcd.zipcode as d_dep_zipcode')
                 ->leftjoin('cities as ocities','col_routes.org_city_id','=','ocities.city_id')
                ->leftjoin('cities as dcities','col_routes.dest_city_id','=','dcities.city_id')
                ->leftjoin('col_departments as ocd','col_routes.org_col_department_id','=','ocd.col_department_id')
                ->leftjoin('col_departments as dcd','col_routes.dest_col_department_id','=','dcd.col_department_id')->get();
        $stats['edit'] =  DB::table('col_rates')
                           ->where('col_rate_id','=',$id)
                           ->first();
        
        return view('admin.rates.colombia.edit')->with('stats',$stats);
    }
    public function editColombiaRates(Request $request)
    {
        $post = $request->all();
        $this->validateColombiaRates($request);
        $company_id = Auth::user()->company_id;
        $datas = array(
            'col_route_id'=>$post['route_id'],
            'company_id' => $company_id,
            'small_truck' => $post['small_truck'],
            'small_stand_hours' => $post['small_stand_hours'],
            'medium_truck' => $post['medium_truck'],
            'medium_stand_hours' => $post['medium_stand_hours'],
            'large_truck' => $post['large_truck'],
            'large_stand_hours' => $post['large_stand_hours'],
            // 'c_1TON' => $post['c_1TON'],
            // 'c_1TON_stand_hours' => $post['c_1TON_stand_hours'],
            // 'c_4TON' => $post['c_4TON'],
            // 'c_4TON_stand_hours' => $post['c_4TON_stand_hours'],
            // 'c_8TON' => $post['c_8TON'],
            // 'c_8TON_stand_hours' => $post['c_8TON_stand_hours'],
            // 'c_16TON' => $post['c_16TON'],
            // 'c_16TON_stand_hours' => $post['c_16TON_stand_hours'],
            // 'c_25TON' => $post['c_25TON'],
            // 'c_25TON_stand_hours' => $post['c_25TON_stand_hours'],
            'created' => CURRENT_DATETIME
        );
        if(DB::table('col_rates')->where('col_rate_id', $post['col_rate_id'])->update($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/colombiaRates/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/colombiaRates/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/colombiaRates/Edit/'.$post['route_id'].'/'.$post['col_rate_id'])->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/colombiaRates/Edit/'.$post['route_id'].'/'.$post['col_rate_id'])->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function validateColombiaRates($request){
        $this->validate($request, [
            'route_id'=>'required',
            'small_truck'=>'numeric',
            'small_stand_hours'=>'numeric',
            'medium_truck'=>'numeric',
            'medium_stand_hours'=>'numeric',
            'large_truck'=>'numeric',
            'large_stand_hours'=>'numeric',
            // 'c_1TON'=>'numeric',
            // 'c_1TON_stand_hours'=>'numeric',
            // 'c_4TON'=>'numeric',
            // 'c_4TON_stand_hours'=>'numeric',
            // 'c_8TON'=>'numeric',
            // 'c_8TON_stand_hours'=>'numeric',
            // 'c_16TON'=>'numeric',
            // 'c_16TON_stand_hours'=>'numeric',
            // 'c_25TON'=>'numeric',
            // 'c_25TON_stand_hours'=>'numeric',

        ]);
    }
    // Colomiba rates end

    //common functions for fcl and lcl
    public function destination_doc_emission_fee($post,$company_id,$edit=false){
        $datas = array(
            'company_id' => $company_id,
            'dest_doc_carrier_key' => $post['dest_doc_carrier_key'],
            'dest_ems_carrier_key' => $post['dest_ems_carrier_key'],
            'dest_doc_carrier_agent' => $post['dest_doc_carrier_agent'],
            'dest_ems_carrier_agent' => $post['dest_ems_carrier_agent'],
            'dest_doc_fee_origin' => $post['dest_doc_fee_origin'],
            'dest_doc_fee_dest' => $post['dest_doc_fee_dest'],
            'dest_doc_emssion_fee_dest' => $post['dest_doc_emssion_fee_dest'],
            'dest_ems_doc_fee_origin' => $post['dest_ems_doc_fee_origin'],
            'dest_ems_doc_fee_dest' => $post['dest_ems_doc_fee_dest'],
            'dest_ems_emssion_fee_dest' => $post['dest_ems_emssion_fee_dest'],
            'created' => CURRENT_DATETIME
        );
        if($edit){
            $datas['modified'] = CURRENT_DATETIME;
            return DB::table('destination_doc_emission_fees')->where('destination_doc_emission_fee_id','=',$post['destination_doc_emission_fee_id'])->update($datas);
        }else{
            $datas['created'] = CURRENT_DATETIME;
            return DB::table('destination_doc_emission_fees')->insertGetId($datas);
        }
    }

    public function origin_doc_emission_fee($post,$company_id,$edit=false){
        $datas = array(
            'company_id' => $company_id,
            //'org_doc_carrier_key' => $post['org_doc_carrier_key'],
            'org_doc_fee_origin' => $post['org_doc_fee_origin'],
            'org_doc_fee_dest' => $post['org_doc_fee_dest'],
            'org_doc_emssion_fee_dest' => $post['org_doc_emssion_fee_dest'],
            'org_ems_carrier_key' => '',
            'org_doc_carrier_agent' => '',
            'org_ems_carrier_agent' => '',
            'org_ems_doc_fee_origin' => '',
            'org_ems_doc_fee_dest' => '',
            'org_ems_emssion_fee_dest' => '',
            'created' => CURRENT_DATETIME
        );
        if(@$post['org_doc_city_port']){
           // $datas['org_doc_city_port'] = $post['org_doc_city_port'];
        }
        if(@$post['org_doc_port_terminal']){
            //$datas['org_doc_port_terminal'] = $post['org_doc_port_terminal'];
        }
        
        if($edit){
            $datas['modified'] = CURRENT_DATETIME;
            return DB::table('origin_doc_emission_fees')->where('origin_doc_emission_fee_id','=',$post['origin_doc_emission_fee_id'])->update($datas);
        }else{
            $datas['created'] = CURRENT_DATETIME;
            return DB::table('origin_doc_emission_fees')->insertGetId($datas);
        }
    }

    public function foreign_terminal_charge($post,$company_id,$edit=false){
        $datas = array(
            //'wharfage_city_port' => $post['wharfage_city_port'],
            //'wharfage_airport_terminal' => $post['wharfage_airport_terminal'],
            //'handling_charges_city_port' => $post['handling_charges_city_port'],
            //'handling_charges_airport_terminal' => $post['handling_charges_airport_terminal'],            
            'handling_charges_afr' => '',
            'handling_charges_bb' => '',
            //'load_charges_city_port' => $post['load_charges_city_port'],
            //'load_charges_city_terminal' => $post['load_charges_city_terminal'],
            //'terminal_security_city' => $post['terminal_security_city'],
            //'terminal_security_terminal' => $post['terminal_security_terminal'],
            //'terminal_security_charges' => $post['terminal_security_charges'],
            'created' => CURRENT_DATETIME
        );
        if(@$post['wharfage_lcl']){
            $datas['wharfage_lcl'] = $post['wharfage_lcl'];
        }
        if(@$post['wharfage_lcl_min']){
            $datas['wharfage_lcl_min'] = $post['wharfage_lcl_min'];
        }
        if(@$post['wharfage_20']){
            $datas['wharfage_20'] = $post['wharfage_20'];
        }
        if(@$post['wharfage_40']){
            $datas['wharfage_40'] = $post['wharfage_40'];
        }
        if(@$post['wharfage_40hc']){
            $datas['wharfage_40hc'] = $post['wharfage_40hc'];
        }
        if(@$post['handling_charges_lcl']){
            $datas['handling_charges_lcl'] = $post['handling_charges_lcl'];
        }
        if(@$post['handling_charges_lcl_min']){
            $datas['handling_charges_lcl_min'] = $post['handling_charges_lcl_min'];
        }
        if(@$post['handling_charges_20']){
            $datas['handling_charges_20'] = $post['handling_charges_20'];
        }
        if(@$post['handling_charges_40']){
            $datas['handling_charges_40'] = $post['handling_charges_40'];
        }
        if(@$post['handling_charges_40hc']){
            $datas['handling_charges_40hc'] = $post['handling_charges_40hc'];
        }
        if(@$post['load_charges_lcl']){
            $datas['load_charges_lcl'] = $post['load_charges_lcl'];
        }
        if(@$post['load_charges_lcl_min']){
            $datas['load_charges_lcl_min'] = $post['load_charges_lcl_min'];
        }
        if(@$post['load_charges_20']){
            $datas['load_charges_20'] = $post['load_charges_20'];
        }
        if(@$post['load_charges_40']){
            $datas['load_charges_40'] = $post['load_charges_40'];
        }
        if(@$post['load_charges_40hc']){
            $datas['load_charges_40hc'] = $post['load_charges_40hc'];
        }
        if($edit){
            $datas['modified'] = CURRENT_DATETIME;
            return DB::table('foreign_terminal_charges')->where('foreign_terminal_charge_id','=',$post['foreign_terminal_charge_id'])->update($datas);
        }else{
            $datas['created'] = CURRENT_DATETIME;
            return DB::table('foreign_terminal_charges')->insertGetId($datas);
        }
    }

    public function other_charge($post,$company_id,$edit=false){
        $datas = array(
            'origin_description' => $post['origin_description'],
            'origin_charges' => $post['origin_charges'],
            'destination_description' => $post['destination_description'],
            'destination_charges' => $post['destination_charges'],
        );
        if($edit){
            $datas['modified'] = CURRENT_DATETIME;
            return DB::table('other_charges')->where('other_charge_id','=',$post['other_charge_id'])->update($datas);
        }else{
            $datas['created'] = CURRENT_DATETIME;
            return DB::table('other_charges')->insertGetId($datas);
        }
    }

    public function deleteOtherRates($dest_id, $org_id, $for_id, $other_id){
        $company_id = Auth::user()->company_id;
        DB::table('destination_doc_emission_fees')->where('company_id','=',$company_id)->where('destination_doc_emission_fee_id','=',$dest_id)->delete();
        DB::table('origin_doc_emission_fees')->where('company_id','=',$company_id)->where('origin_doc_emission_fee_id','=',$org_id)->delete();
        DB::table('foreign_terminal_charges')->where('foreign_terminal_charge_id','=',$for_id)->delete();
        DB::table('other_charges')->where('other_charge_id','=',$other_id)->delete();
    }
}