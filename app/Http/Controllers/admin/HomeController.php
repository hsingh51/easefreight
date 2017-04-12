<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Crypt;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Session;
use Image;
use Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App;
class HomeController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectTo = '/admin/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest', ['except' => ['logout','getLogout','getAirportsByCountries','getCitiesByCountries']]);
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin() {  
        //die('d');
        return view('admin.auth.login'); //or just use the default login page  
    }  
  
    public function postLogin(Request $request){

        $this->validate($request, [
            'password' => 'required|min:6',
            'email' => 'required|email|max:255',
        ]);

        $credentials = $this->getCredentials($request); 
        $email =$credentials['email'];
        $password = $credentials['password'];
        $locale = App::getLocale();
        if (Auth::attempt(array('email' => $email, 'password' => $password, 'group_id' => 2,'is_active'=> '1'))){  
            return redirect()->intended($this->redirectPath());
            if($locale == "es"){  
                return Redirect::to('/es/admin/dashboard');
            }else{
                return Redirect::to('/admin/dashboard');
            } 
        } else {  
            if($locale == "es"){  
                return Redirect::to('/es/admin/login')->with('error',$this->freightforwarderMsg['auth']['error']);
            }else{
                return Redirect::to('/admin/login')->with('error',$this->freightforwarderMsg['auth']['error']);
            }
        }  
    }  
    
    

    public function getLogout()
    {
        Auth::logout();
        return redirect('admin/login');
    }

    public function getFreightRegister() { 
        $stats['countries'] = DB::table('countries')->orderBy('title')->select('countries.country_id','countries.title')->where('is_active','=','1')
            ->get();
        $stats['cities'] = DB::table('cities')->orderBy('title')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        return view('admin.auth.register')->with('stats',$stats); //or just use the default login page  
    }
    public function successRegister(){
        return view('admin.auth.success');
    }
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function freightRegister(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $data['enc'] = Crypt::encrypt(16);
        $data['ticket_id'] = 6;
        $view = 'emails.forwarder.welcome'; $data['subject'] ='Welcome To EASE FREIGHT Forwarder Account';
        
        $to = "neha.sharma@ldh.01s";
        $subject = $data['subject'];
        $txt = "Hello world!";
        $headers = "From: neha.sharma@ldh.01s" . "\r\n";

        // mail($to,$subject,$txt,$headers);

        // Mail::send($view, $data, function ($message) use($data){
        //     $message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
        //     $message->to($data['email'])->subject($data['subject']);
        // });
        // Mail::send($view, $data, function ($message) use($data){
        //     $message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
        //     $message->to('neha.sharma@ldh.01s')->subject($data['subject']);
        // });
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',            
            'company' => 'required',
            'company_ID' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'city_id' => 'required',
            'website' => 'required',
            'country_id' =>'required',
            'persons.*.full_name' => 'required',
            'persons.*.person_position' => 'required',
            'persons.*.working_email' => 'required',
            'persons.*.cell_phone' => 'required',
            //'persons.*.picture' => 'required|mimes:jpeg,png,jpg|max:50000',
            'quality_management_system' => 'mimes:jpeg,png,jpg|max:50000',
            'no_answer' => 'mimes:jpeg,png,jpg|max:50000',
            'BASC' => 'mimes:jpeg,png,jpg|max:50000',
            'account_type' => 'required',
            'account_number' => 'required',
            'finacial_entity' => 'required',
            'shareholder.*.share_name' => 'required',
            'shareholder.*.identification' => 'required',




            //'password' => 'required|confirmed|min:6',
            //'password_confirmation'=>'required|min:6',
            //'branches' => 'required',
            //'message' => 'required',
            //'who_certifies' => 'required',
            //'payment_instrument' => 'required',
            //'branch_office' => 'required',
            //'security_city_id' => 'required',
            //'shareholder.*.type' => 'required',
            //'economic' => 'required',
            //'capital' => 'required',
            //'source_fund' => 'required',
            //'way_pay' => 'required',
            //'financial' => 'required',
        ]);
        
        //$file = Input::file();
       // dd($data);
        // foreach ($data['persons'] as $key => $value) {
        //     print_r($key);
        //     dd($file['persons'][$key]['picture']);
        //     echo $Orname = $file[$key]['picture']->getClientOriginalName();
        // }
        $data['password'] = $this->randomPassword();
        //dd($data);
        $datas = array(
            'name'=>$data['company'],
            'com_id' => $data['company_ID'],
            'created' => CURRENT_DATETIME
        );
        if(@$data['branches']){
            $datas['branches'] = implode(",",$data['branches']);  
        }
        $com_id = DB::table('companies')->insertGetId($datas);
        $user = new \App\User;
        
        $dangerous_good = (isset($data['dangerous_good']))? 1 : 0;
        $user->group_id = $data['group_id'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->company_id = $com_id;
        $user->username = $data['company'];
        $user->name = $data['company'];
        $user->phone = $data['phone_ext'].$data['phone'];
        //$user->position = $data['position'];
        $user->address = $data['address'];
        $user->city_id = $data['city_id'];
        $user->website = $data['website'];
        $user->message = $data['message'];
        $user->dangerous_good = $dangerous_good;
        $user->is_active = 2;
        //Save user
        $user->save();
        
        // save data into other tables
        $file = Input::file();
        $this->personInCharge($data['persons'],$user->id,$file);
        $this->securityQuality($data,$user->id,$file);
        $file = Input::file('identification_copy');
        $this->shareHolders($data['shareholder'],$user->id,$file);
        //$this->finantialInformation($data,$user->id);

        //Create ticket
        $datas = array(
            'user_id' => $user->id,
            'current_status'=>'Proccessing',
            'created' => CURRENT_DATETIME
        );
        $data['enc'] = Crypt::encrypt($user->id);
        $data['ticket_id'] = DB::table('tickets')->insertGetId($datas);

        $view = 'emails.forwarder.welcome'; 
        if($this->locale == "es"){ 
            $data['subject'] ='Bienvenido a EASE FREIGHT Forwarder Account';
        }else{
            $data['subject'] ='Welcome To EASE FREIGHT Forwarder Account';
        }
        Mail::send($view, $data, function ($message) use($data){
            //$message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
            $message->to($data['email'])->subject($data['subject']);
        });
        $locale = App::getLocale();
        if($locale == "es"){  
            return Redirect::to('/es/freight/success')->with('success',$this->freightforwarderMsg['register']['success']);
        }else{
            return Redirect::to('/freight/success')->with('success',$this->freightforwarderMsg['register']['success']);
        }
    }

    public function confirmation($ticket_user,$ticket)
    {
        if(!empty($ticket_user) && !empty($ticket)){
            $user_id = Crypt::decrypt($ticket_user);
            $locale = App::getLocale();
            if(DB::table('tickets')->where('user_id', $user_id)->where('ticket_id', $ticket)->update(['is_active' => 1])){
                if($locale == "es"){  
                    return Redirect::to('/es/freight/register')->with('success',$this->freightforwarderMsg['register']['success']);
                }else{
                    return Redirect::to('/freight/register')->with('success',$this->freightforwarderMsg['register']['success']);
                }
            }else{
                if($locale == "es"){  
                    return Redirect::to('/es/freight/register')->with('error',$this->freightforwarderMsg['register']['error']);
                }else{
                    return Redirect::to('/freight/register')->with('error',$this->freightforwarderMsg['register']['error']);
                }
            }
        }
    }

    public function securityQuality($post,$user_id,$file){
        $filename = array('quality_management_system'=>'','no_answer'=>'','BASC'=>'','aci'=>'','iata'=>'');
        if(@$file){
            foreach ($file as $key => $value) {
                if($key == "quality_management_system" || $key == "no_answer" || $key == "BASC" || $key == "iata"
                    || $key == "aci"){
                    $file = $value;
                    $imageName = $value->getClientOriginalName();
                    $destination_path = base_path() . '/public/securityQuality/';
                    $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
                    $extension = $file->getClientOriginalExtension();
                    $filename[$key]= $user_id.'_'.$key.'.'.$extension;
                    $file->move($destination_path,$filename[$key]);
                }
            }
        }    

        if(@$post['payment_instrument']){

        }else{
            $post['payment_instrument'] = "";
        }
        if(@$post['branch_office']){
            $post['branch_office'] = implode(",",$post['branch_office']);
        }else{
            $post['branch_office'] = "";
        }
        if(@$post['security_city_id']){
           
        }else{
            $post['security_city_id'] = "";
        }

        $datas = array(
            'user_id' => $user_id,
            'basc_check'=>$post['basc_check'],
            'quality_check'=>$post['quality_check'],
            'answer_check'=>$post['answer_check'],
            'management_system' => $filename['quality_management_system'],
            'no_answer' => $filename['no_answer'],
            'who' => $post['who_certifies'],
            'basc' => $filename['BASC'],
            'is_aci' => $post['is_aci'],
            'is_iata' => $post['is_iata'],
            'belong_network' => $post['belong_network'],
            'belong_network_text' => $post['belong_network_text'],
            'payment_instrument' => $post['payment_instrument'],
            'account_type' => $post['account_type'],
            'account_number' => $post['account_number'],
            'financial_entity' => $post['finacial_entity'],
            'branch_office' => $post['branch_office'],
            'city_id' => $post['security_city_id'],
            'created' => CURRENT_DATETIME
        );
        DB::table('security_qualities')->insert($datas);
    }

    public function personInCharge($post,$user_id,$file){
        foreach ($post as $key => $value) {
            //dd($file);
            
            if(@$file['persons'][$key]['picture']){
                $Orname = $file['persons'][$key]['picture']->getClientOriginalName();
                $destination_path='personInCharges/';
                $filename= str_random(6).'_'.$Orname;
                $file['persons'][$key]['picture']->move($destination_path,$filename);
                $image = Image::make(sprintf('personInCharges/%s', $filename))->resize(200, 200)->save();
            }else{
                $filename = "";
            }
            

            $datas = array(
                'user_id' => $user_id,
                'picture' => $filename,
                'full_name' => $value['full_name'],
                'position' => $value['person_position'],
                'working_email' => $value['working_email'],
                'cell_phone' => $value['cell_phone_ext'].$value['cell_phone'],
                'created' => CURRENT_DATETIME
            );
            DB::table('person_in_charge')->insert($datas);
        }
        
    }

    public function shareHolders($post,$user_id,$file){
        foreach ($post as $value) {
            $filename='';
            if(@$file['shareholder'][$key]['identification_copy']){
                $Orname = $file['shareholder'][$key]['identification_copy']->getClientOriginalName();
                $destination_path='identification_copy/';
                $filename= str_random(6).'_'.$Orname;
                $file['shareholder'][$key]['identification_copy']->move($destination_path,$filename);
                $image = Image::make(sprintf('identification_copy/%s', $filename))->resize(200, 200)->save();
            }
            $datas = array(
                'name' => $value['share_name'],
                'identification' => $value['identification'],
                'user_id' => $user_id,
                'identification_copy' => $filename,
                'created' => CURRENT_DATETIME
            );
            DB::table('representatives')->insert($datas);
        }
    }
    public function finantialInformation($post,$user_id){
        $datas = array(
            'economic_activity' => $post['economic'],
            'registered_capital' => $post['capital'],
            'funds_source' => $post['source_fund'],
            'pay_way' => $post['way_pay'],
            'financial_institution' => $post['financial'],
            'user_id' => $user_id,
            'created' => CURRENT_DATETIME
        );
        DB::table('finantial_informations')->insert($datas);
    }

    public function getCitiesByCountries($country_id){
        $cities = DB::table('cities')->where('country_id','=',$country_id)->orderBy('title')->get();
        $country = DB::table('countries')->where('country_id','=',$country_id)->orderBy('title')->get();
        
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
    public function getCodeByCountries($country_id){
        //$countries = DB::table('countries')->where('country_id','=',$country_id)->get();
        
    }

    public function getAirportsByCountries($country_id){
        //$airports = DB::table('airports')->where('country_id','=',$country_id)->where('is_active','=',1)->orderBy('name')->get();


        $airports = DB::table('airports')
                                ->leftjoin('cities','cities.city_id','=','airports.city_id')
                                ->leftjoin('countries','countries.country_id','=','airports.country_id')
                                ->where('country_id','=',$country_id)
                                ->where('is_active','=',1)
                                ->select('airports.*','cities.title as city','countries.title as country')
                                ->orderby('airports.name')
                                ->get();

        
        $data['flag'] = false;
        $data['html']= '';
        $data['html']= '';
        $airport_html ="";
        $brachies_html = "";
        if($airports){
            $airport_html = '<select class="form-control" name="city_id">';
                $airport_html .= '<option value="0" >Please Select Airport</option>';
                foreach ($airports as $value) {
                    $airport_html .= '<option value="'.$value->airport_id.'" >'.$value->city.', '.$value->country.','.$value->name.'</option>';
                }
            $airport_html .= '</select>';
            $data['flag'] = true;
        }
        $data['html']['airports'] = $airport_html;
        return json_encode($data);
    } 

    
}
