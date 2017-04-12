<?php

namespace App\Http\Controllers\administrator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use App\user;
use Session;
use App\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class HomeController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectTo = '/administrator/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest', ['except' => ['logout','getLogout']]);
        $this->freightforwarderMsg = \Config::get('constants.administrator');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin() {  
        return view('administrator.auth.login'); //or just use the default login page  
    }  
  
    public function postLogin(Request $request){

        $credentials = $this->getCredentials($request); 
        $email =$credentials['email'];
        $password = $credentials['password'];
        if (Auth::attempt(array('email' => $email, 'password' => $password, 'group_id' => 1, 'is_active' => 1)))  
        {  
            //echo "success";  
            return Redirect::to('administrator/dashboard'); 
        }  
        else {  
            return Redirect::to('administrator/login')->with('error',$this->freightforwarderMsg['auth']['error']); 
        }  
    }  
    
    

    public function getLogout()
    {
        Auth::logout();
        return redirect('administrator/login');
    }

    public function getFreightRegister() {  
        return view('auth.register'); //or just use the default login page  
    }

    
}
