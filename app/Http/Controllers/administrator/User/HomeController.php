<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
class HomeController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest', ['except' => 'getLogout']);
        $this->freightforwarderAuth = \Config::get('constants.freight-forwarder.auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin() {  
        return view('admin.auth.login'); //or just use the default login page  
    }  
  
    public function postLogin(Request $request){

        $credentials = $this->getCredentials($request); 
        $email =$credentials['email'];
        $password = $credentials['password'];
        if (Auth::attempt(array('email' => $email, 'password' => $password, 'is_active' => 1)))  
        {  
            //echo "success";  
            $request->session()->flash('success', $this->freightforwarderAuth['success']);
            return redirect('admin/dashboard');
        }  
        else {  
            $request->session()->flash('error',$this->freightforwarderAuth['error']);
            return redirect('admin/login');
        }  
    }  

    public function dashboard()
    {
        return view('admin.home');
    }

     public function showProfile($id)
    {
        return view('admin.profile', ['user' => User::findOrFail($id)]);
    }
}
