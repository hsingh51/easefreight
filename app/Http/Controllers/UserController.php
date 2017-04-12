<?php

namespace App\Http\Controllers;

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
class UserController extends Controller
{
  use AuthenticatesAndRegistersUsers, ThrottlesLogins;
  //protected $redirectTo = '/admin/dashboard';
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(){
    //$this->middleware('guest', ['except' => ['logout','getLogout']]);
    $this->locale = App::getLocale();
    $this->userLogin = \Config::get('constants.user');
    if($this->locale == "es"){
        $this->userLogin = \Config::get('constants.es_user');
    }
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function getregister(){
    $stats['countries'] = DB::table('countries')->orderBy('title')->select('countries.country_id','countries.title')
      ->where('is_active','=','1')->get();
    $stats['cities'] = DB::table('cities')->orderBy('title')->select('cities.city_id','cities.title')
      ->where('is_active','=','1')->get();
    return view('user.register')->with('stats',$stats); 
  }
  public function postregister(Request $request){
    $this->validate($request, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6',
      'password_confirmation'=>'required|min:6',
      //'company' => 'required',
      'username' => 'required|unique:users',
      //'phone' => 'required|numeric',
      'phone_ext' => 'required',
      'cell_phone' => 'required|numeric',
      'position' => 'required',
      //'address' => 'required',
      'country_id' => 'required',
      //'city_id' => 'required',
      'website' => 'required',
      'message' => 'required',
    ]);
    $data = $request->all();  
    $user = new \App\User;
    $user->name = $data['name'];
    $user->group_id = $data['group_id'];
    $user->email = $data['email'];
    $user->password = bcrypt($data['password']);
    $user->company_name = $data['company_name'];
    $user->username = $data['username'];
    //$user->phone = $data['phone'];
    $user->phone_ext = $data['phone_ext'];
    $user->mobile = $data['cell_phone'];
    $user->position = $data['position'];
    //$user->address = $data['address'];
    $user->country_id = $data['country_id'];
    //$user->city_id = $data['city_id'];
    $user->website = $data['website'];
    $user->message = $data['message'];
    $user->is_active = 1;
    $user->save();
    if (Auth::attempt(array('email' => $data['email'], 'password' => $data['password'], 'group_id' => 3,'is_active'=> '1'))){
      if($request->session()->has('preSignUp')){
        $data = $request->session()->all();
        $container = json_encode($data['containers']);
        $routes = json_encode($data['routes']);
        $type="airtime";
        if($data['containers']['servicetype'] == "Maritime"){
            $type="maritime";
        }
        $datas = array(
          'user_id'=>Auth::user()->id,
          'full_name' => $data['preSignUp']['full_name'],
          'email' => $data['preSignUp']['email'],
          'containers' => $container,
          'quote_fee'=>$data['quote_fee'],
          'routes' => $routes,
          'type'=>$type,
          'ff_id'=>$data['ff_id'],
          'ocean_route_id'=>$data['ocean_route_id'],
          'afr_route_id'=>$data['afr_route_id'],
          'route_rate_id'=>$data['route_rate_id'],
          'ip'=>$request->ip(),
          'user_agent'=>$request->header('User-Agent'),
          'created' => CURRENT_DATETIME,
        );
        if($request->session()->has('search_id')){
           $datas['modified'] = CURRENT_DATETIME;
            $search_id = Session::get('search_id');
            DB::table('searches')->where('search_id',$search_id)->update($datas);
        }else{
            $datas['created'] = CURRENT_DATETIME;
            $search_id = DB::table('searches')->insertGetId($datas);
            Session::put('search_id', $search_id);
        }
        Session::forget('ocean_route_id');
        Session::forget('route_rate_id');
        Session::forget('afr_route_id');
        Session::forget('ff_id');
        $data = array();
        $data['url'] = "quote/additional_services/".$search_id;
        DB::table('searches')->where('search_id',$search_id)->update($data);
        if($this->locale == "es"){  
            return Redirect::to("/es/quote/additional_services/$search_id");
        }else{
            return Redirect::to("/quote/additional_services/$search_id");
        }
      }else{
        if($this->locale == "es"){  
            return Redirect::to("/es/home");
        }else{
            return Redirect::to("/home");
        }
      }
    }else{
      if($this->locale == "es"){  
        return Redirect::to("/es/user/login");
      }else{
        return Redirect::to("/user/login");
      }
    }
  }

  // profile update
  public function profile(){
    $stats['countries'] = DB::table('countries')->orderBy('title')->select('countries.country_id','countries.title')
      ->where('is_active','=','1')->get();
    $stats['cities'] = DB::table('cities')->orderBy('title')->select('cities.city_id','cities.title')
      ->where('is_active','=','1')->get();
    $stats['user'] = \App\User::find(Auth::user()->id);
    return view('user.updateprofile')->with('stats',$stats); 
  }

  public function getProfile(){
    $stats['countries'] = DB::table('countries')->orderBy('title')->select('countries.country_id','countries.title')
      ->where('is_active','=','1')->get();
    $stats['cities'] = DB::table('cities')->orderBy('title')->select('cities.city_id','cities.title')
      ->where('is_active','=','1')->get();
    $stats['user'] = \App\User::find(Auth::user()->id);
    return view('user.profile')->with('stats',$stats); 
  }

  public function postprofile(Request $request){
    $data = $request->all();  
    //dd($data);
    $this->validate($request, [
      'name' => 'required|max:255',
      'username' => 'required',
      'phone_ext' => 'required',
      'cell_phone' => 'required|numeric',
      'position' => 'required',
      'country_id' => 'required',
      'website' => 'required',
      'message' => 'required',
    ]);

    
    //$user = new \App\User;
    $user = \App\User::find(Auth::user()->id);
    $user->name = $data['name'];
    if(@$data['password']){
      $user->password = bcrypt($data['password']);
    }
    $user->company_name = $data['company_name'];
    $user->username = $data['username'];
    $user->phone_ext = $data['phone_ext'];
    $user->mobile = $data['cell_phone'];
    $user->position = $data['position'];
    $user->country_id = $data['country_id'];
    $user->website = $data['website'];
    $user->message = $data['message'];
    $user->save();
    if($this->locale == "es"){  
      return Redirect::to('/es/user/profile')->with('success',$this->userLogin['login']['success']);
    }else{
      return Redirect::to('/user/profile')->with('success',$this->userLogin['login']['error']);
    }
  }
  
  public function getLogin() {  
    return view('user.login'); //or just use the default login page  
  }

  public function postLogin(Request $request){
    $this->validate($request, [
       'password' => 'required|min:6',
       'email' => 'required|email|max:255',
    ]);
    $credentials = $this->getCredentials($request);
    $email =$credentials['email'];
    $password = $credentials['password'];
    //dd($credentials);
    if (Auth::attempt(array('email' => $email, 'password' => $password, 'group_id' => 3,'is_active'=> '1'))){  

      if($request->session()->has('preSignUp') && $request->session()->has('quote_fee')){
        $data = $request->session()->all();
        $container = json_encode($data['containers']);
        $routes = json_encode($data['routes']);
        $type="airtime";
        if($data['containers']['servicetype'] == "Maritime"){
            $type="maritime";
        }
        $route_rate_id = $afr_route_id = $ocean_route_id = "";
        if(isset($data['ocean_route_id']) && @$data['ocean_route_id']){
          $ocean_route_id = $data['ocean_route_id'];
        }
        if(isset($data['afr_route_id']) && @$data['afr_route_id']){
          $afr_route_id = $data['afr_route_id'];
        }
        if(isset($data['route_rate_id']) && @$data['route_rate_id']){
          $route_rate_id = $data['route_rate_id'];
        }
        $datas = array(
          'user_id'=>Auth::user()->id,
          'full_name' => $data['preSignUp']['full_name'],
          'email' => $data['preSignUp']['email'],
          'containers' => $container,
          'quote_fee'=>$data['quote_fee'],
          'routes' => $routes,
          'type'=>$type,          
          //'ocean_route_id'=>$data['ocean_route_id'],
          //'afr_route_id'=>$data['afr_route_id'],
          //'route_rate_id'=>$data['route_rate_id'],
          'ip'=>$request->ip(),
          'user_agent'=>$request->header('User-Agent'),
          'created' => CURRENT_DATETIME,
        );
        if(@$data['ff_id']){
          $datas['ff_id'] = $data['ff_id'];
        }
        if(@$data['ocean_route_id']){
          $datas['ocean_route_id'] = $data['ocean_route_id'];
        }
        if(@$data['afr_route_id']){
          $datas['afr_route_id'] = $data['afr_route_id'];
        }
        if(@$data['route_rate_id']){
          $datas['route_rate_id'] = $data['route_rate_id'];
        }
        if($request->session()->has('search_id')){
           $datas['modified'] = CURRENT_DATETIME;
            $search_id = Session::get('search_id');
            DB::table('searches')->where('search_id',$search_id)->update($datas);
        }else{
            $datas['created'] = CURRENT_DATETIME;
            $search_id = DB::table('searches')->insertGetId($datas);
            Session::put('search_id', $search_id);
        }
        Session::forget('ocean_route_id');
        Session::forget('route_rate_id');
        Session::forget('afr_route_id');
        Session::forget('ff_id');
        $data = array();
        $data['url'] = "quote/additional_services/".$search_id;
        DB::table('searches')->where('search_id',$search_id)->update($data);
        if($this->locale == "es"){  
          return Redirect::to("/es/quote/additional_services/$search_id");
        }else{
          return Redirect::to("/quote/additional_services/$search_id");
        }
      }else{
        if($this->locale == "es"){  
          return Redirect::to("/es/home");
        }else{
          return Redirect::to("/home");
        }
      }
    }else {  
      if($this->locale == "es"){  
        return Redirect::to('/es/user/login')->with('error',$this->userLogin['login']['error']);
      }else{
        return Redirect::to('/user/login')->with('error',$this->userLogin['login']['error']);
      }
    }
  }

  /** pre sign up**/
  public function getPreSignUp() {  
    return view('user.pre-sign-up'); //or just use the default login page  
  }  

  public function postPreSignUp(Request $request){
    $this->validate($request, [
      'full_name' => 'required|min:6',
      'email' => 'required|email|max:255',
    ]);

    $post = $request->all();
    Session::put('preSignUp.email', $post['email']);
    Session::put('preSignUp.full_name', $post['full_name']);
    $service = $request->session()->get('containers.servicetype').'/search';
    //return Redirect::to($service);
    if($this->locale == "es"){  
        return Redirect::to('/es/'.$service);
      }else{
        return Redirect::to('/'.$service);
      }
  }

  public function emaillayout(){
    return view('emails.forwarder.check');
  }

}
