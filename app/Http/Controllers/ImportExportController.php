<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use App;
class ImportExportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        if(@Auth::user()){
             $this->before(Auth::user()->group_id);
         }
        $this->locale = App::getLocale();
        
    }

    public function before($group_id)
   {
        if ($group_id == '1') {
            if($this->locale == "es"){  
                return Redirect::to("/es/administrator/dashboard")->send();
            }else{
                return Redirect::to("/administrator/dashboard")->send();
            }
       }
       if ($group_id == '2') {
            if($this->locale == "es"){  
                return Redirect::to('/es/admin/dashboard')->send();
            }else{
                return Redirect::to('/admin/dashboard')->send();
            }
       }
   }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Session::has('search_id')){
            Session::forget('search_id');
        }
        if(@$_POST){
            $post = $request->all();
            if($post['servicetype']=="Air Freight"){
                $selection = $post['importtype']; $services = $post['servicetype'];
                if($this->locale == "es"){  
                    return Redirect::to("/es/airfreight/{$selection}/airfreight");
                }else{
                    return Redirect::to("/airfreight/{$selection}/airfreight");
                }
            }else{
                $selection = $post['importtype']; $services = $post['servicetype'];
                if($this->locale == "es"){  
                    return Redirect::to("/es/containers/{$selection}/{$services}");
                }else{
                    return Redirect::to("/containers/{$selection}/{$services}");
                }
                //return Redirect::route('selected', array('selection' => $selection,'services'=>$services));
            }
           
        }

        return view('importexport.index');

    }

}
