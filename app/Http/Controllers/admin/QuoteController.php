<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Mail;
use App;
use Illuminate\Support\Facades\Input;
use App\Models\OceanRoute;
class QuoteController extends Controller
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
        $this->locale = App::getLocale();
        $this->additionalServices = \Config::get('constants.additional-services');
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
    }

    public function before($group_id){
        if ($group_id == '1') {
            return Redirect::to('/administrator/dashboard')->send();
            if($this->locale == "es"){  
                return Redirect::to('/es/administrator/dashboard')->send();
            }else{
                return Redirect::to('admin/dashboard');
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

    public function viewtruckAssignments(){

       $company_id = Auth::user()->company_id; 
       $query =  DB::table('truck_assignment')
                ->join('bookings', 'truck_assignment.booking_id', '=', 'bookings.booking_id')
                ->where('truck_assignment.company_id','=',$company_id); 
       $result = $query->paginate(PAGENATE); 
       return view('admin.quote.view')->with('data',$result);    
    }

    public function truckAssignments($quote_id=NULL,$booked_id=NULL,$assignment_id=NULL){

        if(@$assignment_id){
            $data = DB::table('truck_assignment')
                    ->join('bookings', 'truck_assignment.booking_id', '=', 'bookings.booking_id')
                    ->where('truck_assignment.truck_assignment_id','=',$assignment_id)
                    ->select('truck_assignment.*','bookings.booking_number as booking_number')
                    ->first();
            //dd($data);        
            return view('admin.quote.truck')->with('data',$data);
        }elseif(@$booked_id){
            $data = DB::table('bookings')
                    ->where('booking_id','=',$booked_id)
                    ->select('bookings.*')
                    ->first();
            //dd($data);        
            return view('admin.quote.truck')->with('data',$data);
        }elseif(@$quote_id){
                 
            if($this->locale == "es"){  
                return Redirect::to("/es/admin/truckAssignments")->with('error',$this->freightforwarderMsg['not_found']);
            }else{
                return Redirect::to("/admin/truckAssignments")->with('error',$this->freightforwarderMsg['not_found']);
            }
        
        }
        return view('admin.quote.truck'); 
    }
    public function gettruckAssignments(Request $request){
        
        $post = $request->all();
        //dd($post);
        $company_id = Auth::user()->company_id;
        if(@$post['submit_data']){
            $datas = array(
                'trucking_company' => $post['trucking_company'],
                'licence_plate' => $post['licence_plate'],
                'drivers_name' => $post['drivers_name'],
                'pickup_address' => $post['pickup_address'],
                'pickup_city' => $post['pickup_city'],
                'delivery_address' => $post['delivery_address'],
                'pickup_date' => date("Y-m-d",strtotime($post['pickup_date'])),
                'pickup_time' => $post['pickup_time'],
                'delivery_date' => date("Y-m-d",strtotime($post['delivery_date'])),
                'delivery_time' => $post['delivery_time'],
            );
            if(@$post['truck_assignment_id']){
                DB::table('truck_assignment')->where('company_id',  $company_id )->where('truck_assignment_id', $post['truck_assignment_id'])->update($datas);
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/truckAssignments".DIRECTORY_SEPARATOR.$post['quote_id'].DIRECTORY_SEPARATOR.$post['booking_id'].DIRECTORY_SEPARATOR.$post['truck_assignment_id'])->with('success',$this->freightforwarderMsg['update']);
                }else{
                    return Redirect::to("/admin/truckAssignments".DIRECTORY_SEPARATOR.$post['quote_id'].DIRECTORY_SEPARATOR.$post['booking_id'].DIRECTORY_SEPARATOR.$post['truck_assignment_id'])->with('success',$this->freightforwarderMsg['update']);
                }
            }else{
               $datas['company_id'] =  $company_id;
               $datas['quote_id'] =  $post['quote_id'];
               $datas['booking_id'] = $post['booking_id']; 
               $truck_assignment_id = DB::table('truck_assignment')->insertGetId($datas);
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/truckAssignments".DIRECTORY_SEPARATOR.$post['quote_id'].DIRECTORY_SEPARATOR.$post['booking_id'].DIRECTORY_SEPARATOR.$truck_assignment_id)->with('success',$this->freightforwarderMsg['success']);
                }else{
                    return Redirect::to("/admin/truckAssignments".DIRECTORY_SEPARATOR.$post['quote_id'].DIRECTORY_SEPARATOR.$post['booking_id'].DIRECTORY_SEPARATOR.$truck_assignment_id)->with('success',$this->freightforwarderMsg['success']);
                }
            }
            //dd($truck_assignment_id);
        }elseif(@$post['quote_id']){
            $bookings = DB::table('bookings')
                        ->where('search_id','=',$post['quote_id'])
                        ->select('bookings.*')
                        ->first();
            if(@$bookings){
               $assignments = DB::table('truck_assignment')
                            ->where('quote_id','=',$bookings->quote_id)
                            ->where('booking_id','=',$bookings->booking_id)
                            ->select('truck_assignment.*')
                            ->first();
                if(@$assignments){
                    if($this->locale == "es"){  
                        return Redirect::to("/es/admin/truckAssignments".DIRECTORY_SEPARATOR.$bookings->quote_id.DIRECTORY_SEPARATOR.$bookings->booking_id.DIRECTORY_SEPARATOR.$assignments->truck_assignment_id)->send();
                    }else{
                        return Redirect::to("/admin/truckAssignments".DIRECTORY_SEPARATOR.$bookings->quote_id.DIRECTORY_SEPARATOR.$bookings->booking_id.DIRECTORY_SEPARATOR.$assignments->truck_assignment_id)->send();
                    } 
                }else{
                    if($this->locale == "es"){  
                        return Redirect::to("/es/admin/truckAssignments".DIRECTORY_SEPARATOR.$bookings->quote_id.DIRECTORY_SEPARATOR.$bookings->booking_id)->send();
                    }else{
                        return Redirect::to("/admin/truckAssignments".DIRECTORY_SEPARATOR.$bookings->quote_id.DIRECTORY_SEPARATOR.$bookings->booking_id)->send();
                    }
                } 
            }else{
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/truckAssignments".DIRECTORY_SEPARATOR.$post['quote_id'])->send();
                }else{
                    return Redirect::to("/admin/truckAssignments".DIRECTORY_SEPARATOR.$post['quote_id'])->send();
                }
            }        
           
        }

        return view('admin.quote.truck')->with('data',$data); 
    }

    public function additional_info($quote_id=NULL,$booked_id=NULL){

        if(@$booked_id){

        }elseif(@$quote_id){
            $data['quotes'] =  DB::table('quotes')
                ->join('searches', 'searches.search_id', '=', 'quotes.search_id')
                ->leftjoin('pickup_info','quotes.quote_id','=','pickup_info.quote_id')
                ->leftjoin('additional_services','searches.search_id','=','additional_services.search_id')
                ->where('quotes.search_id','=',$quote_id)
                ->where('searches.ff_id','=',$this->user_id)
                ->select('quotes.*','pickup_info.id','pickup_info.pickup_date','pickup_info.pickup_time','pickup_info.pickup_address','pickup_info.pickup_city','pickup_info.pickup_department','pickup_info.pickup_country','pickup_info.delivery_address','pickup_info.delivery_city','pickup_info.delivery_department','pickup_info.delivery_country','additional_services.user_id as service_user_id','additional_services.content')
                ->first();
            if(@$data['quotes']){
                 //dd($data);
                 return view('admin.quote.additionalinfo')->with('data',$data);
            } 
           
           
        }

        return view('admin.quote.additionalinfo'); 
    }

    public function getadditional_info(Request $request){
        $post = $request->all();

        if(@$post['quote_id']){
            
            $quotes =  DB::table('quotes')
                    ->join('searches', 'searches.search_id', '=', 'quotes.search_id')
                    ->where('quotes.search_id','=',$post['quote_id'])
                    ->where('searches.ff_id','=',$this->user_id)
                    ->select('quotes.*')
                    ->first(); 

			
            if(@$quotes){
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/quote/additional_info/".$post['quote_id'])->send();
                }else{
                    return Redirect::to("/admin/quote/additional_info/".$post['quote_id'])->send();
                }
            }else{
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/quote/additional_info")->with('error',$this->freightforwarderMsg['not_found']);
                }else{
                    return Redirect::to("/admin/quote/additional_info")->with('error',$this->freightforwarderMsg['not_found']);
                }
            }
            
        }
        
        //die("fdsf");
    }

    public function addadditional_info(Request $request){
        $post = $request->all();
        $quotes =  DB::table('quotes')
                    ->join('searches', 'searches.search_id', '=', 'quotes.search_id')
                    ->where('quotes.quote_id','=',$post['quote_id'])
                    ->where('searches.ff_id','=',$this->user_id)
                    ->select('quotes.*')
                    ->first(); 
        if(@$quotes){
            $datas = array(
                'quote_id' => $post['quote_id'],
                'pickup_date' => date("Y-m-d",strtotime($post['pickup_date'])),
                'pickup_time' => $post['pickup_time'],
                'pickup_address' => $post['pickup_address'],
                'pickup_city' => $post['pickup_city'],
                'pickup_department' => $post['pickup_department'],
                'pickup_country' => $post['pickup_country'],
                'delivery_address' => $post['delivery_address'],
                'delivery_city' => $post['delivery_city'],
                'delivery_department' => $post['delivery_department'],
                'delivery_country' => $post['delivery_country'],
            );
            if($pickup_info_id = DB::table('pickup_info')->insertGetId($datas)){
				//dd("adw");
                if($this->locale == "es"){  
                    return Redirect::to("/es/admin/quote/additional_info/".$post['quote_id'])->with('error',$this->freightforwarderMsg['not_found']);
                }else{
                    return Redirect::to("/admin/quote/additional_info/".$post['quote_id'])->with('error',$this->freightforwarderMsg['not_found']);
                }  
            }
            
        }
        dd($post);
    }

    public function getQuote($search_id = NULL){
        //dd($search_id);
        if(@$search_id){
            $data['search'] = DB::table('searches')
                                ->leftjoin('additional_info','additional_info.search_id','=','searches.search_id')
                                ->leftjoin('cargo_details','cargo_details.additional_info_id','=','additional_info.additional_info_id')
                                ->leftjoin('additional_services','additional_services.search_id','=','searches.search_id')
                                ->select('searches.*','cargo_details.discription as cargo_description','additional_services.*')
                                ->where('searches.search_id','=',$search_id)
                                ->where('searches.ff_id','=',$this->user_id)
                                ->first();

            //dd($data['search']->ocean_route_id);
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


                    if($data['containers']->load_type == "fcl"){

                        $data['rates'] = DB::table('ocean_fcl_rates')
                                         ->leftjoin('origin_doc_emission_fees','origin_doc_emission_fees.origin_doc_emission_fee_id','=','ocean_fcl_rates.origin_doc_emission_fee_id')
                                         ->leftjoin('foreign_terminal_charges','foreign_terminal_charges.foreign_terminal_charge_id','=','ocean_fcl_rates.foreign_terminal_charge_id')
                                         ->where('ocean_fcl_rates.ocean_route_id','=',$data['search']->ocean_route_id)
                                         ->first();
                        
                        //dd($data['rates']);
                    }

                }
                $data['quote'] = DB::table('quotes')->select('quotes.*')->where('search_id','=',$search_id)->first();
                //dd($data);
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

                $data['international_insurances'] = DB::table('international_insurances')->select('international_insurances.*')->where('search_id','=',$search_id)->first();
                //dd($data);
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
    public function getQuoteInfo($quote_id=NULL){
        if(@$quote_id){
            
            $data['search'] = DB::table('searches')
                    ->where('searches.search_id','=',$quote_id)
                    ->leftjoin('additional_services','additional_services.search_id','=','searches.search_id')
                    ->where('searches.search_id','=',$quote_id)
                    ->where('searches.ff_id','=',$this->user_id)
                    ->select('searches.*','additional_services.*')
                    ->first();
            //dd($data['search']);
            if(@$data['search']){
                $data['containers'] = json_decode($data['search']->containers);
                $data['routes'] = json_decode($data['search']->routes);
                $data['ff'] = DB::table('users')->select('users.name')->where('users.id','=',$data['search']->ff_id)->first();
                if(isset($data['routes']->postalcode_origin)){
                    $data['routes']->origin_postal_code = $data['routes']->postalcode_origin;
                }
                if(isset($data['routes']->postalcode_destination)){
                    $data['routes']->destination_postal_code = $data['routes']->postalcode_destination;
                }
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

                $data['additionalServices'] = $this->additionalServices;
                $data['cargo'] = DB::table('additional_info')->select('cargo_details.discription')->leftjoin('cargo_details','cargo_details.additional_info_id','=','additional_info.additional_info_id')
                ->where('additional_info.search_id','=',$data['search']->search_id)->orderby('additional_info.additional_info_id','desc')->first();
                 //dd($data);
                return view('admin.quote.info')->with('data',$data);
            }else{
                if($this->locale == "es"){
                    return Redirect::to("/es/admin/quote/info/")->with('error',$this->freightforwarderMsg['not_found']);
                }else{
                    return Redirect::to("/admin/quote/info/")->with('error',$this->freightforwarderMsg['not_found']);
                }
            }
        }

        return view('admin.quote.info'); 
    }

    public function postQuoteInfo(Request $request){

        $post = $request->all();
        $this->validate($request, [
            'search_id' => 'required',
        ]);
        if(@$post['search_id']){
            if($this->locale == "es"){
                    return Redirect::to("/es/admin/quote/info/".$post['search_id'])->send();
            }else{
                return Redirect::to("/admin/quote/info/".$post['search_id'])->send();
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