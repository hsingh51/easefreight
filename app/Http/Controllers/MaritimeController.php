<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use File;
use Image;
use Illuminate\Support\Facades\Input;
use Session;
use App\Models\OceanRoute;
use Mail;
use App;
class MaritimeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        if(Auth::check()){
            $this->user_id = Auth::user()->id;
        }
        $this->ratings = \Config::get('constants.ratings');
        $this->locale = App::getLocale();
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $post['airports'] = DB::table('airports')
            ->leftjoin('cities','cities.city_id','=','airports.city_id')
            ->leftjoin('countries','countries.country_id','=','airports.country_id')
            ->select('airports.*','cities.title as city','countries.title as country')
            ->orderby('countries.title')
            ->get();
        if(@$_POST){
            $post = $request->all();
            //dd($post);
            if($post['servicetype']=="Air Freight"){
                return view('importexport.airfreight')->with('postdata',$post);
            }else{
                return view('importexport.maritime')->with('postdata',$post);
            }
            //dd($post);
        }

        return view('importexport.index');

    }
    public function getContainerDetails($selection,$services)
    {
        $stats['selection']= $selection;
        $stats['services']= $services;

        return view('importexport.maritime')->with('stats',$stats);
    }

    public function addContainerDetails(Request $request)
    {

        $post = $request->all();
        $this->validate($request, [
            'load_type' => 'required',
            'item.*.container_type' => 'required',
            'item.*.container_number' => 'required',
            'item.*.cbm.long' => 'required_if:load_type,lcl',
            'item.*.cbm.width' => 'required_if:load_type,lcl',
            'item.*.cbm.height' => 'required_if:load_type,lcl',
            'item.*.cbm.total' => 'required_if:load_type,lcl',
            'item.*.cbm.weight' => 'required_if:load_type,lcl',
            'item.*.cbf.long' => 'required_if:load_type,lcl',
            'item.*.cbf.width' => 'required_if:load_type,lcl',
            'item.*.cbf.height' => 'required_if:load_type,lcl',
            'item.*.cbf.total' => 'required_if:load_type,lcl',
            'item.*.cbf.weight' => 'required_if:load_type,lcl',
            'item.*.cbm.pound' => 'required_if:load_type,lcl',
        ]);
        
        foreach ($post as $key => $value) {
            Session::put('containers.'.$key, $value);
        }
        if($this->locale == "es"){  
            return Redirect::to("/es/containers/transportation");
        }else{
            return Redirect::to("/containers/transportation");
        }
    }

    public function getTransportation(Request $request)
    {
        $data['session'] = $request->session()->all();
        $data['countries'] = DB::table('countries')->select('countries.country_id','countries.title as country')
            ->where('is_active','=',1)->orderby('countries.title')->get();
        $data['cities'] = DB::table('cities')->select('cities.city_id','cities.title as city','countries.title as country')->leftjoin('countries','countries.country_id','=','cities.country_id')
            ->where('cities.is_active','=',1)->orderby('cities.title')->get();
        $data['ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title','countries.title as country')
            ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')->where('ocean_ports.is_active','=','1')->orderby('ocean_ports.port_title')->get();
        return view('importexport.transportation')->with('data',$data);
    }

    public function transportation(Request $request)
    {
        $post = $request->all();
        $this->validate($request, [
            'include_pickup' => 'required',
            'include_delivery' => 'required',
            'origin_postal_code' => 'required_if:include_pickup,yes',
            'destination_postal_code' => 'required_if:include_delivery,yes',
            'origin_country_id' => 'required_if:include_pickup,yes',
            'destination_country_id' => 'required_if:include_delivery,yes',
            'origin_port_id' => 'required',
            'destination_port_id' => 'required',
        ]);
        foreach ($post as $key => $value) {
            Session::put('routes.'.$key, $value);
        }
        if (Auth::check()){
            $service = $request->session()->get('containers.servicetype').'/search';
            Session::put('preSignUp.email', Auth::user()->email);
            Session::put('preSignUp.full_name', Auth::user()->name);
            return Redirect::to($service);
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/user/pre-sign-up");
            }else{
                return Redirect::to("/user/pre-sign-up");
            }
        }
    }
    public function getsearch(Request $request){
        $data = $request->session()->all();
        if(@$data['containers']['item']){
            foreach ($data['containers']['item'] as $key => $value) {
                $stats['totalweight'][$key] = $this->getFclWeight($value,$data['containers']['load_type']);
                $stats['totalweight'][$key]['container_number'] = $value['container_number'];
            }
        }
        if(isset($data['containers'])){
            $stats['containers'] = $data['containers'];
            $stats['routes'] = $data['routes'];
            $containerType ='1'; $table="ocean_lcl_rates";
            if($data['containers']['load_type'] == "fcl"){
                $containerType ='2'; $table="ocean_fcl_rates";
            }
            
            $field = str_replace('s', '', $table).'_id';
            $stats['oceanContainer'] = $containerType;
            $stats['routes'] = $this->getRoute($data,$containerType);
            $stats['freight_forwarder'] = $this->getFreightForwarder($data,$table,$field);
            $stats['type_freight'] = "Maritime";
            $stats['field'] = $field;
            
            $stats['rating'] = $this->ratings;
            $port_origin = (isset($stats['routes']->o_port) && $stats['routes']->o_port)? $stats['routes']->o_port:'';
            $port_destination = (isset($stats['routes']->d_port) &&  $stats['routes']->d_port)? $stats['routes']->d_port:'';
            if($stats['freight_forwarder']->count() > 0){
                $email['html'] = '<table border="1" style="border:1px solid #ccc; margin-left:245px; margin-bottom: 40px; margin-top:40px;">
                    <tr>
                        <th style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Type of Freight</th>
                        <th style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Port of Origin</th>
                        <th style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Port of Destination</th>';
                        if(@$stats['routes']->origin_postal_code){
                            $email['html'] .= '<th style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Postal Code of Origin</th>';
                        }
                        if(@$stats['routes']->postalcode_destination){
                            $email['html'] .= '<th style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Postal Code of Destination</th>';
                        }
                    $email['html'] .= '</tr><tr>
                        <td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$stats["type_freight"].'</td>
                         <td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$port_origin.'</td>
                        <td style="border-color:transparent; text-align:center; font-size:13px; padding:8px;">'.$port_destination.'</td>';
                if(@$stats['routes']->origin_postal_code){
                    $email['html'] .= '<td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$stats['routes']->origin_postal_code.'</td>';
                }
                if(@$stats['routes']->postalcode_destination){
                    $email['html'] .= '<td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$stats['routes']->postalcode_destination.'</td>';
                }
                $email['html'] .= '</tr></table>';

                $email['html'] .= '<table border="1" style="border:1px solid #ccc; margin-bottom:40px; margin-top:40px;">             
                    <tr>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">FORWADER</th>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">FF RATING</th>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Direct / Via</th>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Frequency</th> 
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Transit Time</th>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Next Departure Date</th> 
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">CARRIER</th>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Rates</th>
                      <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">';
                      $email['html'] .= ($stats['oceanContainer'] =="1")? "LCL" : "FCL";
                      $email['html'] .='</th>                               
                    </tr>'; $i=1;
                foreach ($stats['freight_forwarder'] as $route) { if($i <= 3){ $i++; if(!@$route->rating){ $route->rating=0; }
                    $email['html'] .= '<tr class="showmore" >
                    <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->company_name.'</td>
                       <td style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;"><img src="'.BASE_URL.'/assets/img/'.$this->ratings[$route->rating].'">
    </td>
                       <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->direct_via.'</td>
                      <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->frequency.'</td>
                      <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->estimated_transit_time.'</td>
                      <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;"><ul>';
                        // foreach ($route->front_itinerary as $front_itinerary) {
                        //     foreach ($front_itinerary->fornt_itineraryDeparture as $fornt_itineraryDeparture){
                        //         $departure = $fornt_itineraryDeparture->departure_date.' '.$fornt_itineraryDeparture->departure_time;
                        //         $email['html'] .= '<li>'.date('Y-m-d H:i A',strtotime($departure)).'</li>';
                        //     }
                        // }
                    $start_date = date('M d, Y', strtotime("+7 day")); $days=array();
                    if($route->frequency == "spot"){
                      $operating_days = array();
                      $itinerary_dates = oceanfreightdates($route->discontinue_date, $operating_days,'1','10',date("d-m-Y"),'spot',date("Y-m-d",strtotime($route->spot_date)));
                    }elseif($route->frequency == "weekly"){
                      $operating_days = explode(',',str_replace("'","",$route->operating_days));
                      //print_r($operating_days);
                      $itinerary_dates = oceanfreightdates($route->discontinue_date,$operating_days,'1','10',date("d-m-Y"),'weekly');
                    }elseif($route->frequency == "fortnightly"){
                      $operating_days[] = $route->first_departure_day;
                      $operating_days[] = $route->second_departure_day; 
                      $itinerary_dates = oceanfreightdates($route->discontinue_date,$operating_days);
                    }else{
                      $operating_days[] = $route->first_departure_day;
                      $itinerary_dates = oceanfreightdates($route->discontinue_date,$operating_days);
                    }
                    //dd($itinerary_dates);
                    $itinerary_dates = oceanfreightdates(date('Y-m-d',strtotime($route->discontinue_date)),$days,0,5,$start_date);
                    //print_r($itinerary_dates);
                    //foreach ($itinerary_dates as $itinerary_date){
                        if(isset($itinerary_dates[0]) && @$itinerary_dates[0]){
                        $departure = $itinerary_dates[0].' '.$route->departure_hour;
                        $email['html'] .= '<li>'.date('Y-m-d H:i A',strtotime($departure)).'</li>';
                    }
                    //}
                    $email['html'] .= '</ul></td>
                      <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; border-bottom:1px solid #ccc; font-size:13px; padding:8px;">'.$route->carrier.'</td>
                      <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'; $lclrates=0;
                            foreach ($stats['totalweight'] as $value) {
                                if($stats['containers']['load_type'] == "fcl"){
                                    $ofc = $route['rate_'.$value['0'].'_ofc'];
                                    $baf = $route['rate_'.$value['0'].'_baf'];
                                    $pss = $route['rate_'.$value['0'].'_pss'];
                                    $sum = floatval($ofc)+floatval($baf)+floatval($pss);
                                    $lclrates = floatval($lclrates)+ floatval($sum);
                                    $email['html'] .= $value['0'].' = $ '.floatval($sum).'<br/>';
                                    $lclrates = $lclrates * $value['container_number'];
                                }
                                if($stats['containers']['load_type'] == "lcl"){
                                    $min_ofr = $route['min_OFR'];
                                    $min_baf = $route['min_BAF'];
                                    $rate_ofr = $route['rate_OFR'];
                                    $rate_baf = $route['rate_BAF'];
                                    $min = floatval($min_ofr)+floatval($min_baf);
                                    $rate = floatval($rate_ofr)+floatval($rate_baf);
                                    if($rate > $min){
                                        //$lclrates = floatval($lclrates)+ (floatval($rate) * $value['0']);
                                        $email['html'] .= $value['0']." * $ ".$rate.'<br/>';
                                        $lclrates = floatval($lclrates)+floatval($rate);
                                    }else{
                                        //$lclrates = floatval($lclrates)+ (floatval($min) * $value['0']);
                                        $email['html'] .= $value['0']." * $ ".$min.'<br/>';
                                        $lclrates = floatval($lclrates)+floatval($min);
                                    }
                                    $lclrates = $lclrates * $value['container_number'];
                                }
                            }
                    $email['html'] .='</td>
                        <td class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;"> $ '.$lclrates.'</td></tr>';
                }}
                $email['html'] .='</table>';
                $email['name'] = (Auth::check())? Auth::user()->name:$data['preSignUp']['full_name'];
                $email['email']= (Auth::check())? Auth::user()->email:$data['preSignUp']['email'];
                $view = 'emails.forwarder.search_result'; $email['subject'] ='Ease Freight Quote Details';
                Mail::send($view, $email, function ($message) use($email){
                    $message->to($email['email'])->subject($email['subject']);
                    $message->to('neha.sharma@ldh.01s.in')->subject($email['subject']);
                });
            }
            return view('search.results')->with('search',$stats);
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/importexport");
            }else{
                return Redirect::to("/importexport");
            }
        }
    }

    public function getFclWeight($value,$type){
        $totalweight = 0;
        if($type == "fcl"){
            $stats[0] = $value['container_type'];
        }else{
            $stats[0] = $value['cbm']['weight'];
        }
        return $stats;
    }

     public function getRoute($data,$containerType){
        $result = DB::table('ocean_routes')
            ->leftjoin('ocean_ports as o_ocean_ports','o_ocean_ports.ocean_port_id','=','ocean_routes.origin_ocean_port_id')
            ->leftjoin('ocean_ports as d_ocean_ports','d_ocean_ports.ocean_port_id','=','ocean_routes.destination_ocean_port_id')
            ->leftjoin('countries as oc','oc.country_id','=','o_ocean_ports.country_id')
            ->leftjoin('countries as dc','dc.country_id','=','d_ocean_ports.country_id')
            ->where('ocean_routes.origin_ocean_port_id','=',$data['routes']['origin_port_id'])
            ->where('ocean_routes.destination_ocean_port_id','=',$data['routes']['destination_port_id'])
            ->select('ocean_routes.*','o_ocean_ports.port_title as o_port', 'oc.title as ocountry','d_ocean_ports.port_title as d_port', 'dc.title as dcountry')->first();
        
        $details['origin_postal_code'] = $data['routes']['origin_postal_code'];
        $details['postalcode_destination'] = $data['routes']['destination_postal_code'];
        if($result){
            $result->origin_postal_code = $data['routes']['origin_postal_code'];
            $result->postalcode_destination = $data['routes']['destination_postal_code'];
        }else{
            
            $origin = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                ->select('ocean_ports.port_title','cities.title as city','countries.title as country')
                ->where('ocean_ports.ocean_port_id','=',$data['routes']['origin_port_id'])
                ->orderby('countries.title')->first();
            $details['o_port'] = $origin->port_title;
            $details['ocountry'] = $origin->country;
            $destination = DB::table('ocean_ports')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id')
                ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')
                ->select('ocean_ports.port_title','cities.title as city','countries.title as country')
                ->where('ocean_ports.ocean_port_id','=',$data['routes']['destination_port_id'])
                ->orderby('countries.title')->first();
            $details['d_port'] = $destination->port_title;
            $details['dcountry'] = $destination->country;
            $result = (object) $details;
        }
        return $result;
    }
    public function getFreightForwarder($data,$table,$field){
        $query = OceanRoute::join($table,$table.'.ocean_route_id','=','ocean_routes.ocean_route_id')
            ->join('companies','companies.company_id','=','ocean_routes.company_id')
            ->join('itinerary_ofr','itinerary_ofr.ocean_route_id','=','ocean_routes.ocean_route_id')
            ->join('users','users.company_id','=','ocean_routes.company_id')
            ->leftjoin('ratings','ratings.ff_id','=','users.id')
            ->leftjoin('airlines as c_airlines', $table.'.carrier', '=', 'c_airlines.airline_id')
            ->select('ratings.rating','users.id as user_id','users.name','users.email','users.picture','users.website','users.message', 'companies.name as company_name','companies.name as company_name','ocean_routes.ocean_route_id',$table.'.validity',$table.'.*','itinerary_ofr.discontinue_date','itinerary_ofr.first_departure_day','itinerary_ofr.second_departure_day','itinerary_ofr.estimated_transit_time','itinerary_ofr.frequency','itinerary_ofr.operating_days')
            ->where('ocean_routes.origin_ocean_port_id','=',$data['routes']['origin_port_id'])
            ->where('ocean_routes.destination_ocean_port_id','=',$data['routes']['destination_port_id']);
        if(isset($data['containers']['dangerous_good'])){
            $query = $query->where('users.dangerous_good','=',1);
        }
        $query = $query->take(5)->orderby('ratings.rating','desc')->get();
        return $query;
    }
}