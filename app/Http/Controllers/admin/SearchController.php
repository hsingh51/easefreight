<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App;
class SearchController extends Controller
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
        $this->before(Auth::user()->group_id);
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
    }

    public function before($group_id){
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

    public function additional_services(){
        //die('df');
        $data = DB::table('additional_services')
                ->join('searches','searches.search_id','=','additional_services.search_id')
                ->join('users','searches.user_id','=','users.id')
                ->join('countries','countries.country_id','=','users.country_id')
                ->orderBy('additional_services.created','desc')
                ->where('searches.ff_id','=',$this->user_id)
                ->select('additional_services.*','users.name as company_name','users.name as full_name','users.position as position','users.email as email','users.phone as cell_phone','countries.title as country')
                ->paginate(PAGENATE);
        //dd($data);
        return view('admin.search.view')->with('data',$data);
    }
}