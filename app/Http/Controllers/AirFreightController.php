<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Mail;
use DB;
use Session;
use Auth;
use App\Models\AfrRoute;
use App;
class AirFreightController extends Controller
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
    public function index($selection){

        $items = Session::get('item');
        if(@$items){
           $post['items'] = $items; 
        }
        //dd($items);

        $data['airports'] = DB::table('airports')
                                ->leftjoin('cities','cities.city_id','=','airports.city_id')
                                ->leftjoin('countries','countries.country_id','=','airports.country_id')
                                ->select('airports.*','cities.title as city','countries.title as country')
                                ->orderby('countries.title')
                                ->get();
        $post['importtype'] = $selection;
        $post['servicetype'] = "airfreight";
        return view('airfreight.quantity')->with('postdata',$post);                        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function postquantity(Request $request)
    {
        $post = $request->all();
        $this->validate($request, [
            'item.*.cbm.long' => 'required',
            'item.*.cbm.width' => 'required',
            'item.*.cbm.height' => 'required',
            'item.*.cbm.total' => 'required',
            'item.*.cbm.weight' => 'required',
            'item.*.cbf.long' => 'required',
            'item.*.cbf.width' => 'required',
            'item.*.cbf.height' => 'required',
            'item.*.cbf.total' => 'required',
            'item.*.cbf.weight' => 'required',
            'item.*.cbm.pound' => 'required',
        ]);                 
        foreach ($post as $key => $value) {
            Session::put('containers.'.$key, $value);
        }
        if($this->locale == "es"){  
            return Redirect::to("/es/airfreight/route");
        }else{
            return Redirect::to("/airfreight/route");
        }
    }
    public function getquantity()
    {
        $data['airports'] = DB::table('airports')
                                ->leftjoin('cities','cities.city_id','=','airports.city_id')
                                ->leftjoin('countries','countries.country_id','=','airports.country_id')
                                ->select('airports.*','cities.title as city','countries.title as country')
                                ->orderby('cities.title')
                                ->get();
        $data['countries'] = DB::table('countries')->select('countries.country_id','countries.title as country')
            ->where('is_active','=',1)->orderby('countries.title')->get();
        return view('airfreight.route')->with('data',$data); 

    }
    public function route(Request $request){
        $post = $request->all();
        $this->validate($request, [
            'postalcode_origin'=>'required_if:include_pickup,Yes',
            'postalcode_destination'=>'required_if:include_delivery,Yes',
            'origin_airport' => 'required',
            'destination_airport' => 'required',
        ]); 
        foreach ($post as $key => $value) {
            Session::put('routes.'.$key, $value);
        }
        if (Auth::check()){
            if($this->locale == "es"){  
                return Redirect::to("/es/airfreight/search");
            }else{
                return Redirect::to("/airfreight/search");
            }
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
        //dd($data);
        if(@$data['containers']['item']){
            foreach ($data['containers']['item'] as $key => $value) {
                $stats['totalweight'][$key] = $this->getWeight($value);
            }
        }
        $stats['type_freight'] = "Air Freight";
        if((@$data['routes']['origin_airport']) && (@$data['routes']['destination_airport'])){
            $stats['routes'] = $this->getRoute($data);
            $stats['freight_forwarder'] = $this->getFreightForwarder($data);
            $stats['oceanContainer'] = '3';
            $port_origin = (isset($stats['routes']->o_port) && $stats['routes']->o_port)? $stats['routes']->o_port:'';
            $port_destination = (isset($stats['routes']->d_port) &&  $stats['routes']->d_port)? $stats['routes']->d_port:'';
            if($stats['freight_forwarder']->count() > 0){
                $this->search_email($stats,$port_origin,$port_destination,BASE_URL,$data);
            }
            $stats['rating'] = $this->ratings;

            //dd( $stats);

            return view('search.results')->with('search',$stats);
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/importexport");
            }else{
                return Redirect::to("/importexport");
            }     
        }
    }
    public function getWeight($value){
        $totalweight = 0;
        $totalweight = $totalweight + ($value['container_number'] * $value['cbm']['weight']);
        if($totalweight >= 0 &&  $totalweight <= MINIMUM){
            $stats['minimum'] = "Minimum";
        }
        if($totalweight > MINIMUM && $totalweight < 100){
            $stats['less_100kgs'] = "- 100 kgs";
        }
        if($totalweight >= 100 && $totalweight < 300){
            $stats['more_100kgs'] = "+ 100 kgs";
        }
        if($totalweight >= 300 && $totalweight < 500){
            $stats['more_300kgs'] = "+ 300 kgs";
        }
        if($totalweight >= 500){
            $stats['more_500kgs'] = "+ 500 kgs";
        }
        $stats['totalweight'] = $totalweight;
        $totalweight = 0;
        return $stats;
    }
    public function getRoute($data){
        $result = DB::table('afr_routes')
            ->leftjoin('airports as oa','oa.airport_id','=','afr_routes.origin_airport_id')
            ->leftjoin('airports as da','da.airport_id','=','afr_routes.destination_airport_id')
            ->select('afr_routes.*',DB::raw('concat(oa.name, " (", oa.iata_code,")") as o_port'),
                DB::raw('concat(da.name, " (", da.iata_code,")") as d_port'))
            ->where('afr_routes.origin_airport_id','=',$data['routes']['origin_airport'])
            ->where('afr_routes.destination_airport_id','=',$data['routes']['destination_airport'])
            ->First();
        
        $details['origin_postal_code'] = $data['routes']['postalcode_origin'];
        $details['postalcode_destination'] = $data['routes']['postalcode_destination'];
        if($result){
            $result->origin_postal_code = $data['routes']['postalcode_origin'];
            $result->postalcode_destination = $data['routes']['postalcode_destination'];
        }else{
            $origin = DB::table('airports')->select(DB::raw('concat(airports.name, " (", airports.iata_code,")") as o_port'))
                ->where('airports.airport_id','=',$data['routes']['origin_airport'])->first();
            $details['o_port'] = $origin->o_port;
            $destination = DB::table('airports')->select(DB::raw('concat(airports.name, " (", airports.iata_code,")") as d_port'))
                ->where('airports.airport_id','=',$data['routes']['destination_airport'])->first();
            $details['d_port'] = $destination->d_port;
            $result = (object) $details;
        }
        return $result;
    }
    public function getFreightForwarder($data){
        //$week = date('W', strtotime(CURRENT_DATETIME));
        $query = AfrRoute::join('afr_route_rates','afr_route_rates.afr_route_id','=','afr_routes.afr_route_id')
             ->join('itinerary','itinerary.afr_route_rates_id','=','afr_route_rates.afr_route_rates_id')
             ->join('companies','companies.company_id','=','afr_routes.company_id')
             ->join('users','users.company_id','=','afr_routes.company_id')
             ->leftjoin('ratings','ratings.ff_id','=','users.id')
             ->leftjoin('airlines as c_airlines', 'afr_route_rates.carrier', '=', 'c_airlines.airline_id')
             ->select('ratings.rating','users.id as user_id','users.name','users.email','users.picture','users.website','users.message', 'companies.name as company_name','afr_routes.afr_route_id as afr_route_id','afr_route_rates.validity','itinerary.estimated_transit_time','afr_route_rates.minimum','afr_route_rates.1kgs','afr_route_rates.50kgs','afr_route_rates.less_100kgs','afr_route_rates.more_100kgs','afr_route_rates.more_300kgs','afr_route_rates.more_500kgs','afr_route_rates.afr_route_rates_id','afr_route_rates.direct_via','afr_route_rates.other',DB::raw('concat(c_airlines.title, ", ", c_airlines.iata_designator) as carrier'),'itinerary.discontinue_date','itinerary.operating_days','itinerary.departure_hour','itinerary.frequency')
            ->where('afr_routes.origin_airport_id','=',$data['routes']['origin_airport'])
            ->where('afr_routes.destination_airport_id','=',$data['routes']['destination_airport']);
        if(isset($data['containers']['dangerous_good'])){
            $query = $query->where('users.dangerous_good','=',1);
        }
        $query = $query->limit(5)->orderby('ratings.rating','desc')->get();
        //dd($query);
        // $query_state = array();
        // foreach ($query as $value) { $itinerary_info = DB::table('itinerary')->select('itinerary.discontinue_date','itinerary.operating_days','itinerary.departure_hour')
        //         ->where('itinerary.afr_route_id','=',$value['afr_route_id'])->first();
        //     $query_state[] = (object) array_merge((array) $value, (array)$itinerary_info);
        // }
        return $query;
    }

    public function email_route_info($stats,$port_origin,$port_destination){
        $email['html'] = '<table border="1" style="border:1px solid #ccc; margin-left:245px; margin-bottom: 40px; margin-top:40px;">
            <tr>
                <th style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Type of Freight</th>
                <th style="border-color:transparent; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">City of Origin</th>
                <th style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">City of Destination</th>';
                if(@$stats['routes']->origin_postal_code){
                    $email['html'] .= '<th style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Postal Code of Origin</th>';
                }
                if(@$stats['routes']->postalcode_destination){
                    $email['html'] .= '<th style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Postal Code of Destination</th>';
                }
            $email['html'] .= '</tr><tr>
                <td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$stats["type_freight"].'</td>
                 <td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$port_origin.'</td>
                <td style="border-color:transparent; text-align:center; font-size:13px; padding:8px;">'.$port_destination.'</td></tr>';
        if(@$stats['routes']->origin_postal_code){
            $email['html'] .= '<tr><th>Postal Code of Origin</th><th>'.$stats['routes']->origin_postal_code.'</th></tr>';
        }
        if(@$stats['routes']->postalcode_destination){
            $email['html'] .= '<tr><th>Postal Code of Destination</th><th>'.$stats['routes']->postalcode_destination.'</th></tr>';
        }
        $email['html'] .= '</table>';
        return $email['html'];
    }
    public function search_email($stats,$port_origin,$port_destination,$base_url,$data){
        $email['html'] = $this->email_route_info($stats,$port_origin,$port_destination);
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
              <th class="border borders userfont" style="border-color:transparent; border-bottom:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">Total Charge</th>                               
            </tr>'; 
            $i=1;
            foreach ($stats['freight_forwarder'] as $route) { 
        		if($i <= 3){ 
        			$i++; 
        			if(!@$route->rating){ 
        					$route->rating=0; 
        			}
        			$transit_time = str_replace('/',':',$route->estimated_transit_time);
		            $email['html'] .= '<tr class="showmore" >
		            <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->company_name.'</td>
		               <td style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;"><img src="'.$base_url.'/assets/img/'.$this->ratings[$route->rating].'"></td>
		            <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->direct_via.'</td>
		            <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->frequency.'</td>
		            <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$transit_time.'</td>
		            <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;"><ul>';
            		$start_date = date('M d, Y', strtotime("+7 day"));
            		$itinerary_dates = airfreightdates(date('Y-m-d',strtotime($route->discontinue_date)),explode(',', str_replace("'", '',$route->operating_days)),0,1,$start_date);

		            //print_r($itinerary_dates);
		            //foreach ($itinerary_dates as $itinerary_date){
		            if(isset($itinerary_dates[0]) && @$itinerary_dates[0]){
		                $departure = $itinerary_dates[0].' '.$route->departure_hour;
		                $email['html'] .= '<li>'.date('Y-m-d H:i A',strtotime($departure)).'</li>';
		            }
		           // }
		            $email['html'] .= '</ul></td>
		              <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'.$route->carrier.'</td>
		              <td class="border borders userfont" style="border-color:transparent; border-right:1px solid #ccc; text-align:center; font-size:13px; padding:8px;">'; $lclrates=0;
		            foreach ($stats['totalweight'] as $value) {
		                $kgs_filed = array_keys($value);
		                $lclrates = floatval($lclrates)+floatval($route->$kgs_filed['0']);
		                $email['html'] .=$value[$kgs_filed['0']].' = $ '.floatval($route->$kgs_filed['0']).'<br/>';
		            }
            		$email['html'] .='</td>
                	<td class="border borders userfont" style="border-color:transparent; text-align:center; font-size:13px; padding:8px;"> $ '.$lclrates.'</td></tr>';
       			}
       		}

       	$email['html'] .= "</table>";
       	// echo $email['html'];
       	// die;

        $email['name'] = (Auth::check())? Auth::user()->name:$data['preSignUp']['full_name'];
        $email['email']= (Auth::check())? Auth::user()->email:$data['preSignUp']['email'];
        $view = 'emails.forwarder.search_result'; $email['subject'] ='Ease Freight Quote Details';
        Mail::send($view, $email, function ($message) use($email){
            $message->to($email['email'])->subject($email['subject']);
        });
    }
}