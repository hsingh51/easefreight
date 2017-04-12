<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App\Models\ItineraryOfr;
use App\Models\Itinerary;
use Helpers;
use App;
class ItineraryController extends Controller
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
        $this->before(Auth::user()->group_id);
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
    //itinerary
    public function viewRouteItinerary() {
        $query =  Itinerary::
                  join('afr_route_rates as rates', 'rates.afr_route_rates_id', '=', 'itinerary.afr_route_rates_id')
                  ->leftjoin('afr_routes', 'rates.afr_route_id', '=', 'afr_routes.afr_route_id')
                  ->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
                  ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
                  ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
                  ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
                  ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
                  ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')
                  ->leftjoin('airlines', 'airlines.airline_id', '=', 'rates.carrier')
                  ->leftjoin('aircrafts', 'aircrafts.aircarft_id', '=', 'itinerary.equipment')
                  ->select('itinerary.*','ocity.title as ocity_title','ocountry.title as ocountry_title',
                    'dcity.title as dcity_title','dcountry.title as dcountry_title',
                    'oairports.name as oair_name','oairports.iata_code as oiata_code',
                    'dairports.name as dair_name','dairports.iata_code as diata_code','airlines.title as carrier_name','rates.direct_via as directvia','aircrafts.name as equipment')
                  ->where('itinerary.user_id','=',$this->user_id)
                  ->groupBy('itinerary.afr_route_rates_id');

        if(isset($_GET['search']) && !empty($_GET['search'])){
            
            $query = $query->Where(function ($query) {
                $query->orwhere('afr_routes.afr_route_id','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocity.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('ocountry.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('dcity.title','LIKE','%'.$_GET['search'].'%')
                    ->orwhere('dcountry.title','LIKE','%'.$_GET['search'].'%');
            });
        }
        $result = $query->paginate(PAGENATE);
        $i = 0;
        foreach ($result as  $value) {
            $subquery =  Itinerary::
                  select('itinerary.*')
                  ->where('user_id','=',$this->user_id)
                  ->where('afr_route_id','=',$value->afr_route_id)
                  ->get();
            $result[$i]->subquery =  $subquery;     
            $i++;     
        }
        
        
        return view('admin.rates.itinerary.view')->with('data',$result);
    }
    public function selectRouteItinerary() { 
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->get();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code')
            ->where('is_active','=','1')->get();
        return view('admin.rates.itinerary.select')->with('stats',$stats);
    }
    public function getRouteItinerary($rates_id=NULL,$id=NULL,$route_result=null) {

        //die($rates_id);


        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->orderBy('countries.title')->where('is_active','=','1')->get();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code')
            ->where('is_active','=','1')->get();
        $stats['aircrafts'] = DB::table('aircrafts')->select('aircrafts.aircarft_id','aircrafts.name')->where('is_active','=','1')->get();




        $stats['params']['rates_id'] = $rates_id;
        $stats['params']['id'] = $id;
        $stats['params']['route_result'] = $route_result;    
        if(@$rates_id){
            $stats['afr_route_rates'] = DB::table('afr_route_rates')
                                        ->join('afr_routes', 'afr_routes.afr_route_id', '=', 'afr_route_rates.afr_route_id')
                                        ->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
                                        ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
                                        ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
                                        ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
                                        ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
                                        ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')                
                                        ->select('afr_routes.destination_airport_id','afr_routes.origin_airport_id','afr_routes.origin_city_id','afr_routes.destination_city_id','afr_routes.destination_country_id','afr_routes.origin_country_id','afr_routes.afr_route_id','ocity.title as ocity','ocountry.title as ocountry','oairports.name as oairport','dcity.title as dcity','dcountry.title as dcountry','dairports.name as dairport')
                                        ->where('afr_route_rates.afr_route_rates_id','=',$rates_id)
                                        ->first();
            //dd($stats['afr_route_rates']);
            $stats['ocities'] = DB::table('cities')->select('title','city_id')->where('cities.country_id','=',$stats['afr_route_rates']->origin_country_id)->get();
            $stats['dcities'] = DB::table('cities')->select('title','city_id')->where('cities.country_id','=',$stats['afr_route_rates']->destination_country_id)->get();
            $stats['oairports'] = DB::table('airports')->select('name','airport_id','iata_code')->where('airports.country_id','=',$stats['afr_route_rates']->origin_country_id)->where('airports.city_id','=',$stats['afr_route_rates']->origin_city_id)->get();
            $stats['dairports'] = DB::table('airports')->select('name','airport_id','iata_code')->where('airports.country_id','=',$stats['afr_route_rates']->destination_country_id)->where('airports.city_id','=',$stats['afr_route_rates']->destination_city_id)->get();

            $stats['airlines'] = DB::table('airlines')->select('airlines.airline_id','airlines.title','airlines.iata_designator')->orderBy('airlines.title')->get();
            //dd($stats['ocities']);
        }
        //dd($stats);
        return view('admin.rates.itinerary.add')->with('stats',$stats);
    }
    public function addRouteItinerary(Request $request) {

        $post = $request->all();
       
        // echo "<pre>";
        // print_r(implode("','",$post['operating_days']));
        // echo "</pre>";
        // dd($post['operating_days']);
        $company_id = Auth::user()->company_id;
        $this->validate($request, [
            'afr_route_rates_id' => 'required',
            //'frequency' => 'required',
        ]);

        $rates = DB::table('afr_route_rates')->where('afr_route_rates.afr_route_rates_id','=',$post['afr_route_rates_id'])->select('afr_route_rates.afr_route_id')->first();
         //dd($rates);
        $afr_route_id =  $rates->afr_route_id;
        $add = "0";
        
        //dd($value);
        $datas = array();
        $datas['user_id'] = $this->user_id;
        $datas['afr_route_id'] = $afr_route_id;
        $datas['afr_route_rates_id'] = $post['afr_route_rates_id'];
        $datas['operating_days'] = "'".implode("','",$post['operating_days'])."'";
        $datas['departure_hour'] = $post['departure_hour'];
        $datas['estimated_arrival_hour'] = $post['estimated_arrival_hour']; 
        $datas['estimated_transit_time'] = $post['estimated_transit_hour']."/".$post['estimated_transit_min']; 
        $datas['cargo_day'] = $post['cargo_day'];
        $datas['cargo_hour'] = $post['cargo_hour'];
        // $datas['direct'] = $post['direct'];
        // $datas['direct_via'] = implode(",",$post['direct_via']);
        $datas['equipment'] = $post['equipment'];
        // $datas['carrier'] = $post['carrier'];
        $datas['flight'] = $post['flight'];
        $datas['discontinue_date'] = date("Y-m-d",strtotime($post['discontinue_date']));         

        //dd($datas);
                   
        $itinerary_id = DB::table('itinerary')->insertGetId($datas); 
        
        if(@$itinerary_id){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/routeItinerary/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/routeItinerary/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/routeItinerary/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/routeItinerary/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }
    public function deleteRouteItinerary($route_id,$id=NULL) {
        DB::table('itinerary')->where('itinerary.user_id','=',$this->user_id)->where('itinerary.afr_route_id','=',$route_id)->delete();
        //DB::table('afr_route_rates')->where('afr_route_rates.afr_route_id','=',$id)->delete();
        if($this->locale == "es"){
            return Redirect::to('/es/admin/routeItinerary/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/routeItinerary/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    public function geteditRouteItinerary($rates_id=NULL,$id=NULL){
        
       
        if(!isset($id) && empty($id)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/routeItinerary/View');
            }else{
                return Redirect::to('/admin/routeItinerary/View'); 
            }
        }
        $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code')
            ->where('is_active','=','1')->get();
        $stats['aircrafts'] = DB::table('aircrafts')->select('aircrafts.aircarft_id','aircrafts.name')->where('is_active','=','1')->get();
        $stats['airlines'] = DB::table('airlines')->select('airlines.airline_id','airlines.title','airlines.iata_designator')->orderBy('airlines.title')->get();
        $stats['data'] = Itinerary::
            join('afr_routes','afr_routes.afr_route_id','=','itinerary.afr_route_id')
            ->leftjoin('cities as ocity', 'afr_routes.origin_city_id', '=', 'ocity.city_id')
            ->leftjoin('countries as ocountry', 'afr_routes.origin_country_id', '=', 'ocountry.country_id')
            ->leftjoin('cities as dcity', 'afr_routes.destination_city_id', '=', 'dcity.city_id')
            ->leftjoin('countries as dcountry', 'afr_routes.destination_country_id', '=', 'dcountry.country_id')
            ->leftjoin('airports as oairports', 'afr_routes.origin_airport_id', '=', 'oairports.airport_id')
            ->leftjoin('airports as dairports', 'afr_routes.destination_airport_id', '=', 'dairports.airport_id')
            ->leftjoin('afr_route_rates', 'afr_routes.afr_route_id', '=', 'afr_route_rates.afr_route_id')
            ->where('itinerary.itinerary_id','=',$id)
            ->select('itinerary.*','afr_routes.afr_route_id','ocity.title as ocity','ocountry.title as ocountry','oairports.name as oairport','dcity.title as dcity','dcountry.title as dcountry','dairports.name as dairport')
            ->first();
        //dd($stats['data']);   
        
        return view('admin.rates.itinerary.edit')->with('stats',$stats);
    }
    public function editRouteItinerary(Request $request){
        $post = $request->all();
        
        $company_id = Auth::user()->company_id;
        $this->validate($request, [
            'afr_route_id' => 'required',
            //'frequency' => 'required',
        ]);
        $afr_route_id = $post['afr_route_id'];
        $add = "0";
        
        $datas = array();
        //$datas['user_id'] = $this->user_id;
        $datas['operating_days'] = "'".implode("','",$post['operating_days'])."'";
        $datas['departure_hour'] = $post['departure_hour'];
        $datas['estimated_arrival_hour'] = "'".$post['estimated_arrival_hour']; 
        $datas['estimated_transit_time'] = $post['estimated_transit_hour']."/".$post['estimated_transit_min']; 
        $datas['cargo_day'] = $post['cargo_day'];
        $datas['cargo_hour'] = $post['cargo_hour'];
        //$datas['direct'] = $post['direct'];
        // if(@$datas['direct'] && ($datas['direct'] == "yes")){
        //     $datas['direct'] = "yes";
        //     $datas['direct_via'] = "";
        // }elseif(@$post['direct_via']){
        //     $datas['direct'] = "no";
        //     $datas['direct_via'] = "'".implode(",",$post['direct_via'])."'";
        // }
        $datas['equipment'] = $post['equipment'];
        //$datas['carrier'] = $post['carrier'];
        $datas['flight'] = $post['flight'];
        $datas['discontinue_date'] = date("Y-m-d",strtotime($post['discontinue_date'])); 

        //dd($post);

        if(DB::table('itinerary')->where('user_id', $this->user_id)->where('itinerary_id', $post['itinerary_id'])->update($datas)) {
            if($this->locale == "es"){
                return Redirect::to('/es/admin/routeItinerary/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/routeItinerary/View')->with('success',$this->freightforwarderMsg['success']); 
            } 
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/routeItinerary/View')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/routeItinerary/View')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function viewOFRItinerary(){

        $query =  ItineraryOfr::
            join('ocean_routes', 'itinerary_ofr.ocean_route_id', '=', 'ocean_routes.ocean_route_id')
            ->leftjoin('ocean_fcl_rates as frates', 'frates.ocean_route_id', '=', 'itinerary_ofr.ocean_route_id')
            ->leftjoin('ocean_lcl_rates as lrates', 'lrates.ocean_route_id', '=', 'itinerary_ofr.ocean_route_id')
            ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
            ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
            ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
            ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
            ->leftjoin('terminals as oterminal','ocean_routes.origin_terminal_id','=','oterminal.terminal_id')
            ->leftjoin('terminals as dterminal','ocean_routes.destination_terminal_id','=','dterminal.terminal_id')
            ->select('itinerary_ofr.*','frates.direct_via as fdirectvia','lrates.direct_via as ldirectvia','frates.carrier as fcarrier','lrates.carrier as lcarrier','oport.port_title as oport_title','ocountry.title as ocountry_title','dport.port_title as dport_title','dcountry.title as dcountry_title', 'oterminal.title as oplace','dterminal.title as dplace')
            ->where('itinerary_ofr.user_id','=',$this->user_id)
            ->groupBy('itinerary_ofr.ocean_route_id');
        
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->Where(function ($query) {
                $query->orwhere('ocean_routes.ocean_route_id','LIKE','%'.$_GET['search'].'%')
                ->orwhere('oport.port_title','LIKE','%'.$_GET['search'].'%')
                ->orwhere('ocountry.title','LIKE','%'.$_GET['search'].'%')
                ->orwhere('dport.port_title','LIKE','%'.$_GET['search'].'%')
                ->orwhere('dcountry.title','LIKE','%'.$_GET['search'].'%');
            });
        }
        $result = $query->paginate(PAGENATE);
        $i = 0;
        foreach ($result as  $value) {
            $subquery =  ItineraryOfr::
                    select('itinerary_ofr.*')
                  ->where('user_id','=',$this->user_id)
                  ->where('ocean_route_id','=',$value->ocean_route_id)
                  ->get();
            //dd($subquery[0]->itineraryOfrDeparture);      
            $result[$i]->subquery =  $subquery;     
            $i++;     
        }
        //dd($result);
        return view('admin.rates.itineraryOFR.view')->with('data',$result);
    }

    public function getOFRItinerary($route_id=NULL,$id=NULL,$route_result=null){
		
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->orderBy('countries.title')->where('is_active','=','1')->get();
        // $stats['terminals'] = DB::table('ocean_local_terminal_rates as ocltr')
        //     ->leftjoin('cities','ocltr.city_id','=','cities.city_id')
        //     ->select('ocltr.place','ocltr.ocean_local_terminal_rate_id','cities.title as city')
        //     ->where('ocltr.is_active','=','1')->get();

        // $stats['terminals'] = DB::table('ocean_local_terminal_rates as ocltr')
        //    ->leftjoin('cities','ocltr.city_id','=','cities.city_id')
        //    ->select('col_city_ports.title as place','ocltr.ocean_local_terminal_rate_id','cities.title as city')
        //    ->leftjoin('col_city_ports','ocltr.col_city_port_id','=','col_city_ports.col_city_port_id')
        //    ->where('ocltr.is_active','=','1')->get();

        // $stats['ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
        //     ->where('ocean_ports.is_active','=','1')->get();
        $stats['params']['ocean_route_id'] = $route_id;
        $stats['params']['id'] = $id;
        $stats['params']['route_result'] = $route_result;
        if(@$route_id){

            $stats['ocean_routes'] =  DB::table('ocean_routes')
                ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
                ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
                ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
                ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
                ->leftjoin('terminals as ocltr', 'ocean_routes.origin_terminal_id', '=', 'ocltr.terminal_id')
                ->leftjoin('terminals as docltr', 'ocean_routes.destination_terminal_id', '=', 'docltr.terminal_id')
                ->select('ocean_routes.*','oport.port_title as oport_title','ocountry.title as ocountry_title', 'dport.port_title as dport_title','dcountry.title as dcountry_title','ocltr.title as oplace','docltr.title as dplace')
                ->where('ocean_routes.ocean_route_id','=',$route_id)
                ->first();
            $stats['ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
            ->where('is_active','=','1')->get();
            $stats['oports'] = DB::table('ocean_ports')->select('port_title','ocean_port_id')->where('ocean_ports.country_id','=',$stats['ocean_routes']->origin_country_id)
            ->where('ocean_ports.ocean_port_id','=',$stats['ocean_routes']->origin_ocean_port_id)->get();
            $stats['dports'] = DB::table('ocean_ports')->select('port_title','ocean_port_id')->where('ocean_ports.country_id','=',$stats['ocean_routes']->destination_country_id)
            ->where('ocean_ports.ocean_port_id','=',$stats['ocean_routes']->destination_ocean_port_id)->get();
            $stats['oterminal'] = DB::table('terminals')->select('title','terminal_id')->where('terminals.country_id','=',$stats['ocean_routes']->origin_country_id)->where('terminals.ocean_port_id','=',$stats['ocean_routes']->origin_ocean_port_id)->get();
            $stats['dterminal'] = DB::table('terminals')->select('title','terminal_id')->where('terminals.country_id','=',$stats['ocean_routes']->destination_country_id)->where('terminals.ocean_port_id','=',$stats['ocean_routes']->destination_ocean_port_id)->get();

            // if($rate = DB::table('ocean_fcl_rates')->select('ocean_fcl_rates.frequency')->where('ocean_fcl_rates.ocean_route_id',$route_id)->first()){
            //     $stats['ocean_routes']->frequency = $rate->frequency;
            //     //dd($stats); 
            // }
            // if($rate = DB::table('ocean_lcl_rates')->select('ocean_lcl_rates.frequency')->where('ocean_lcl_rates.ocean_route_id',$route_id)->first()){
            //     $stats['ocean_routes']->frequency = $rate->frequency;
            //     //dd($rate); 
            // }
              

        //dd($stats['ocean_routes']);
        } 
        return view('admin.rates.itineraryOFR.add')->with('stats',$stats);
    }

    public function addOFRItinerary(Request $request){
        $post = $request->all();
        
        $this->validate($request, [
            'ocean_route_id' => 'required',
            //'carrier' => 'required',
            'voyage' => 'required',
            'frequency' => 'required',
            'first_departure_day' => 'required',
            'second_departure_day' => 'required_if:frequency,monthly',
            'estimated_transit_time' => 'required',
            //'estimated_arrival_date' => 'required',
            'cargo_cut_OFF' => 'required',
            'cargo_cut_OFF_Hour' => 'required',
            //'direct' => 'required',
            //'direct_via' => 'required_if:direct,no',
            'motor_vessel_name' => 'required',
            'discontinue_date' => 'required',
        ]);
        //dd($post);
        if(@$post['second_departure_day']){

        }else{
            $post['second_departure_day'] = "";
        }
        $datas = array(
            'ocean_route_id' => $post['ocean_route_id'],
            'user_id'=>$this->user_id,
            //'carrier' => $post['carrier'],
            //'voyage' => $post['voyage'],
            'frequency' => $post['frequency'],
            'first_departure_day' => $post['first_departure_day'],
            'second_departure_day' => $post['second_departure_day'],
            'estimated_transit_time' => $post['estimated_transit_time'],
            //'estimated_arrival_date' => date('Y-m-d',strtotime($post['estimated_arrival_date'])),
            'cargo_cut_OFF' => $post['cargo_cut_OFF'],
            'cargo_cut_OFF_Hour' =>$post['cargo_cut_OFF_Hour'],
            //'direct' => $post['direct'],
            //'direct_via' => (isset($post['direct_via']))? $post['direct_via']:'',
            'motor_vessel_name' => $post['motor_vessel_name'],
            'discontinue_date' => date('Y-m-d',strtotime($post['discontinue_date'])),
            'created' => CURRENT_DATETIME
        );
        if(@$post['operating_days']){
            $datas['operating_days'] = "'".implode("','",$post['operating_days'])."'";
        }
        if(@$post['spot_date']){
            $datas['spot_date'] = date("Y-m-d",strtotime($post['spot_date']));
        }

        if(DB::table('itinerary_ofr')->insertGetId($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/ofrItinerary/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/ofrItinerary/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/ofrItinerary/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/ofrItinerary/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function geteditOFRItinerary($itinerary_ofr,$id){
        
        if(!isset($id) && empty($id)){
            return Redirect::to('admin/ofrItinerary/View');
        }
        $stats['ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
            ->where('is_active','=','1')->get();
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->get();
        $stats['data'] = DB::table('itinerary_ofr')->
         join('ocean_routes','ocean_routes.ocean_route_id','=','itinerary_ofr.ocean_route_id')
         ->leftjoin('ocean_ports as oport', 'ocean_routes.origin_ocean_port_id', '=', 'oport.ocean_port_id')
         ->leftjoin('countries as ocountry', 'ocean_routes.origin_country_id', '=', 'ocountry.country_id')
         ->leftjoin('ocean_ports as dport', 'ocean_routes.destination_ocean_port_id', '=', 'dport.ocean_port_id')
         ->leftjoin('countries as dcountry', 'ocean_routes.destination_country_id', '=', 'dcountry.country_id')
         ->leftjoin('terminals as ocltr', 'ocean_routes.origin_terminal_id', '=', 'ocltr.terminal_id')
         ->leftjoin('terminals as docltr', 'ocean_routes.destination_terminal_id', '=', 'docltr.terminal_id')
         ->where('itinerary_ofr.user_id','=',$this->user_id)
         ->where('itinerary_ofr.itinerary_id','=',$id)
         ->select('itinerary_ofr.*','itinerary_ofr.cargo_cut_OFF_Hour as cargo_hour','itinerary_ofr.cargo_cut_OFF as cargo_cut','oport.port_title as oport_title','ocountry.title as ocountry_title', 'dport.port_title as dport_title','dcountry.title as dcountry_title','ocltr.title as oplace','docltr.title as dplace')
         ->first();
        return view('admin.rates.itineraryOFR.edit')->with('stats',$stats);
    }
    public function editOFRItinerary(Request $request){
        $post = $request->all();
        //dd($post);
        $this->validate($request, [
            //'carrier' => 'required',
            //'voyage' => 'required',
            'frequency' => 'required',
            'first_departure_day' => 'required',
            'second_departure_day' => 'required_if:frequency,monthly',
            'estimated_transit_time' => 'required',
            //'estimated_arrival_date' => 'required',
            'cargo_cut_OFF' => 'required',
            'cargo_cut_OFF_Hour' => 'required',
            //'direct' => 'required',
            //'direct_via' => 'required_if:direct,no',
            'motor_vessel_name' => 'required',
            'discontinue_date' => 'required',
        ]);
        $datas = array(
            //'carrier' => $post['carrier'],
            //'voyage' => $post['voyage'],
            'frequency' => $post['frequency'],
            'first_departure_day' => $post['first_departure_day'],
            'second_departure_day' => $post['second_departure_day'],
            'estimated_transit_time' => $post['estimated_transit_time'],
            //'estimated_arrival_date' => date('Y-m-d',strtotime($post['estimated_arrival_date'])),
            'cargo_cut_OFF' => $post['cargo_cut_OFF'],
            'cargo_cut_OFF_Hour' => $post['cargo_cut_OFF_Hour'],
            //'direct' => $post['direct'],
            //'direct_via' => (isset($post['direct_via']))? $post['direct_via']:'',
            'motor_vessel_name' => $post['motor_vessel_name'],
            'discontinue_date' => date('Y-m-d',strtotime($post['discontinue_date'])),
            'modified' => CURRENT_DATETIME
        );
        if(@$post['voyage']){
            $datas['voyage'] = $post['voyage'];
        }
        if((@$post['operating_days'])){
            $datas['operating_days'] = "'".implode("','",$post['operating_days'])."'";
        }
        if((@$post['spot_date'])){
            $datas['spot_date'] = date("Y-m-d",strtotime($post['spot_date']));
        }

        //dd($datas);
        if(DB::table('itinerary_ofr')->where('itinerary_id', $post['itinerary_id'])->where('itinerary_id', $post['itinerary_id'])->update($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/ofrItinerary/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/ofrItinerary/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/ofrItinerary/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/ofrItinerary/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }
    public function deleteOFRtinerary($route_id,$id=NULL) {
        //die($route_id);
        $its = DB::table('itinerary_ofr')
               ->where('ocean_route_id','=',$route_id)
               ->where('user_id','=',$this->user_id)
               ->select('itinerary_ofr.itinerary_id')
               ->get();
        if(@$its){
            foreach ($its as $value) {
                DB::table('itinerary_ofr_departures')->where('itinerary_ofr_departures.itinerary_ofr_id','=',$value->itinerary_id)->delete(); 
                DB::table('itinerary_ofr')->where('itinerary_ofr.itinerary_id','=',$value->itinerary_id)->delete();    
               //dd($value->itinerary_id); 
            }
        }
        //DB::table('afr_route_rates')->where('afr_route_rates.afr_route_id','=',$id)->delete();
        if($this->locale == "es"){
            return Redirect::to('/es/admin/ofrItinerary/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/ofrItinerary/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    //fetach air routes
    public function getAirRoute(Request $request){
        $post = $request->all();
        //dd($_POST);
        $country = $post['country_id'];
        $city = $post['city_id'];
        $air = $post['air'];
        $dcountry = $post['destination_country_id'];
        $dcity = $post['destination_city_id'];
        $dair = $post['destination_airport_id'];
        $company_id = Auth::user()->company_id;
        $query = DB::table('afr_routes')->select('afr_routes.*','countries.title as country','cities.title as city',
            'airports.name','airports.iata_code')
            ->where('afr_routes.origin_country_id','=',$country)->where('afr_routes.origin_city_id','=',$city)
            ->where('afr_routes.origin_airport_id','=',$air)->where('afr_routes.company_id','=',$company_id)
            ->where('afr_routes.destination_country_id','=',$dcountry)->where('afr_routes.destination_city_id','=',$dcity)
            ->where('afr_routes.destination_airport_id','=',$dair)
            ->leftjoin('countries','afr_routes.destination_country_id','=','countries.country_id')
            ->leftjoin('cities','afr_routes.destination_city_id','=','cities.city_id')
            ->leftjoin('airports','afr_routes.destination_airport_id','=','airports.airport_id');
        $stats['afr_route'] = $query->first();
        if(@$stats){
            $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->get();
            $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
            $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code')
                ->where('is_active','=','1')->get();
            return view('admin.rates.itinerary.add')->with('stats',$stats);
        }
    }

    public function moreweek(){
        //die("sdf");
        return view('admin.rates.itinerary.weekair')->with('week_number','2');
    }
    public function moredate($key){
        //die("sdf");
        return view('admin.rates.itinerary.rowair')->with('key',$key);
    }

    public function get_afrdates($itinerary_id,$limit=Null){
        $query = DB::table('itinerary')
                 ->select('itinerary.*')
                 ->where('itinerary.itinerary_id','=',$itinerary_id)
                 ->first();
        $today = time();
        $today_date = date("Y-m-d");
        $last = strtotime($query->discontinue_date);
        if($today <= $last){

            //echo $dw = date("w",strtotime("2016-08-21"));

        }
        //echo $today."--".$last;
        dd($query);

    }

}
