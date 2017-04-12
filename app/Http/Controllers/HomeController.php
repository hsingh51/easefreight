<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use Illuminate\Support\Facades\Redirect;
use App;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->locale = App::getLocale();
        $this->userMsg = \Config::get('constants.user');
        if($this->locale == "es"){
            $this->userMsg = \Config::get('constants.es_user');
        }

        
    }
    public function before($group_id)
    {
        //dd($group_id);
        if ($group_id == '1') {
            return Redirect::to('/administrator/dashboard')->send();
        }
        elseif ($group_id == '2') {
            return Redirect::to('/admin/dashboard')->send();
        }
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(@Auth::user()->group_id){
            $this->before(Auth::user()->group_id);
        }
       return view('welcome');
    }


    
    public function getLogin() {  
        return view('auth.login'); //or just use the default login page  
    }  
  
    public function postLogin(Request $request){
        $this->validate($request, [
            'password' => 'required|min:6',
            'email' => 'required|email|max:255',
        ]);

        $credentials = $this->getCredentials($request); 
        $email =$credentials['email'];
        $password = $credentials['password'];
        
        if (Auth::attempt(array('email' => $email, 'password' => $password, 'group_id' => 3,'is_active'=> '1')))  
        {  
            //echo "success";  
            return Redirect::to('home'); 
        }else {  
            dd($this->userMsg['error']);
            return Redirect::to('login')->with('error',$this->userMsg['error']); 
        }  
    }
    public function citybycountry($country_id){
        //dd($country_id);
        $cities = DB::table('cities')->where('country_id','=',$country_id)->orderBy('cities.title')->get();
        $ports = DB::table('ocean_ports')->where('country_id','=',$country_id)->orderBy('ocean_ports.port_title')->get();
        
        
        //$country = DB::table('countries')->where('country_id','=',$country_id)->get();
        
        $data['flag'] = false;
        $data['html']= '';
        $cities_html ="";
        $ports_html ="";
        if($cities){
            $cities_html .= '<option value="0">Select City</option>';
            foreach ($cities as $value) {
                $cities_html .= '<option value="'.$value->city_id.'" >'.$value->title.'</option>';
            }
            
            $data['flag'] = true;
        }
        if($ports){
            $ports_html .= '<option value="0">Select Port</option>';
            foreach ($ports as $value) {
                $ports_html .= '<option value="'.$value->ocean_port_id.'" >'.$value->port_title.'</option>';
            }            
            $data['flag'] = true;
        }
        $data['html']['cities'] = $cities_html;
        $data['html']['ports'] = $ports_html;

        return json_encode($data);
    }

    public function portbycity($city_id){
        //dd($country_id);
        $ports = DB::table('col_city_ports')->where('city_id','=',$city_id)->orderBy('col_city_ports.title')->get();
        
        //$country = DB::table('countries')->where('country_id','=',$country_id)->get();
        
        $data['flag'] = false;
        $data['html']= '';
        $ports_html ="";
        if($ports){
            $ports_html .= '<option value="0">Select Port</option>';
            foreach ($ports as $value) {
                $ports_html .= '<option value="'.$value->col_city_port_id.'" >'.$value->title.'</option>';
            }            
            $data['flag'] = true;
        }
        $data['html']['ports'] = $ports_html;

        return json_encode($data);
    }

    public function oceanPortBycity($city_id){
        $ports = DB::table('ocean_ports')->where('city_id','=',$city_id)->orderBy('ocean_ports.port_title')->get();
        $data['flag'] = false;
        $data['html']= '';
        $ports_html ="";
        if($ports){
            //$ports_html .= '<option value="0">Select Port</option>';
            foreach ($ports as $value) {
                $ports_html .= '<option value="'.$value->ocean_port_id.'" >'.$value->port_title.'</option>';
            }            
            $data['flag'] = true;
        }
        $data['html']['ports'] = $ports_html;
        return json_encode($data);
    } 

    public function terminalbyport($port_id){
        //dd($country_id);
        
        
        $terminals = DB::table('terminals')
           ->select('terminals.*')
           ->where('terminals.is_active','=','1')
           ->where('terminals.ocean_port_id','=',$port_id)
           ->get();



        $data['flag'] = false;
        $data['html']= '';
        $terminals_html ="";
        
        if($terminals){
            $terminals_html .= '<option value="0">Select Terminal</option>';
            foreach ($terminals as $value) {
                $terminals_html .= '<option value="'.$value->terminal_id.'" >'.$value->title.'</option>';
            }
            
            $data['flag'] = true;
        }
        
        $data['html']['terminals'] = $terminals_html;
        return json_encode($data);
    } 

    public function portbycountry($country_id){
        //dd($country_id);
        $ports = DB::table('ocean_ports')->where('country_id','=',$country_id)->orderBy('ocean_ports.port_title')->get();
        //$country = DB::table('countries')->where('country_id','=',$country_id)->get();
        
        $data['flag'] = false;
        $data['html']= '';
        $ports_html ="";
        if($ports){
            $ports_html .= '<option value="0">Select City</option>';
            foreach ($ports as $value) {
                $ports_html .= '<option value="'.$value->ocean_port_idPrimary.'" >'.$value->port_title.'</option>';
            }
            
            $data['flag'] = true;
        }
        $data['html']['ports'] = $ports_html;

        return json_encode($data);
    } 

    public function citybyports($city_id){
        //dd($country_id);
        $airports = DB::table('airports')->where('city_id','=',$city_id)->orderBy('airports.name')->get();

        $col_departments= DB::table('col_departments')->select('col_departments.name','col_departments.col_department_id','col_departments.zipcode')
            ->where('col_departments.is_active','=','1')
            ->where('col_departments.city_id','=',$city_id)
            ->orderBy('col_departments.name')->get();

        $data['flag'] = false;
        $data['html']= '';
        $airports_html ="";
        $airports_html .= '<option value="0">Select Airport IATA CODE</option>';
        $departments_html ="";
        $departments_html .= '<option value="0">Select Department</option>';
        if($airports){            
            foreach ($airports as $value) {
                $airports_html .= '<option value="'.$value->airport_id.'" >'.$value->name." (".$value->iata_code.")".'</option>';
            }            
            $data['flag'] = true;
        }

        if($col_departments){
            
            foreach ($col_departments as $value) {
                $departments_html .= '<option value="'.$value->col_department_id.'" >'.$value->name.'</option>';
            }
            
            $data['flag'] = true;
        }

        $data['html']['airports'] = $airports_html;
        $data['html']['departments'] = $departments_html;

        return json_encode($data);
    } 
    public function countries(){
        $countryi = DB::table('countries')
                   ->join('cities','cities.country_id','=','countries.country_id')
                   ->select('countries.country_id')
                   ->groupby('countries.country_id')
                   ->get();
        foreach ($countryi as $key => $value) {
           $cids[] = $value->country_id;
        }
         $c = implode(",",$cids);
        
        $country = DB::select('SELECT title
FROM countries
WHERE country_id NOT
IN ('.$c.')');
        
        echo "<pre>";
        print_r($country);
        die;
    }
    public function getCitiesByCountries($country_id){
        $cities = DB::table('cities')->where('country_id','=',$country_id)->get();
        $country = DB::table('countries')->where('country_id','=',$country_id)->get();
        
        $data['flag'] = false;
        $data['html']= '';
        $data['html']= '';
        $cities_html ="";
        $brachies_html = "";
        if($cities){
            $cities_html = '<select class="form-control" name="city_id">';
                foreach ($cities as $value) {
                    $cities_html .= '<option value="'.$value->city_id.'" >'.$value->title.'</option>';
                }
            $cities_html .= '</select>';
            $brachies_html = '<select class="form-control" name="branches">';
                foreach ($cities as $value) {
                    $brachies_html .= '<option value="'.$value->city_id.'" >'.$value->title.'</option>';
                }
            $brachies_html .= '</select>';
            $data['flag'] = true;
        }
        //$country_html = 
        $data['html']['country_code'] = $country[0]->country_code;
        //$data['html']['country_code'] = ""
        $data['html']['cities'] = $cities_html;
        $data['html']['brachies'] = $brachies_html;
        return json_encode($data);
    }
    public function contact_us(){
        return view('contact_us');
    }
    public function post_contact_us(Request $request){
        $data = $request->all();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name'=>'required',
            'email'=>'required',
            'phone' => 'required',
            'messages' => 'required',
        ]);
        
        if($this->locale == "es"){ 
            $data['subject'] = "Contáctenos email";
        }else{
            $data['subject'] = "Contact us email";
        }
        $view = 'emails.contact_us';
        Mail::send($view, $data, function ($message) use($data){
            $message->to(AdminEmail)->subject($data['subject']);
        });
        return Redirect::to("contact_us")->with('success','Ease-Freight team will contact you shortly.');
    }
    public function about_us(){
        return view('about_us');
    }
    public function track_qoute(){
        return view('track_qoute');
    }
    public function tools(){
        return view('tools');
    }
    public function services(){
        return view('services');
    }
    public function news(){
        return view('news');
    }
    public function how_to_cude(){
        return view('how_to_cude');
    }
    public function conversion(){
        return view('conversion');
    }
}
