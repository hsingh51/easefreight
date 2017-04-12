<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use File;
use Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App;
class UploadrateController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->user_id = Auth::user()->id;
        $this->company_id = Auth::user()->company_id;
        $this->before(Auth::user()->group_id);
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
    }

    public function before($group_id)
    {
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
    
     
    public function index()
    {
        return view('admin.uploadrate');
    }
    public function dashboard()
    {
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $result['representatives'] = DB::table('representatives')->where('representatives.user_id', '=', $user_id)
            ->select(DB::raw('count(representatives.user_id) as total '))->first();
        $result['person_in_charge'] = DB::table('person_in_charge')->where('person_in_charge.user_id', '=', $user_id)
            ->select(DB::raw('count(person_in_charge.user_id) as total '))->first();
        $result['local_terminal_air_rates'] = DB::table('local_terminal_air_rates')->where('local_terminal_air_rates.user_id', '=', $user_id)
            ->select(DB::raw('count(local_terminal_air_rates.user_id) as total '))->first();
        $result['afr_routes'] = DB::table('afr_routes')->where('afr_routes.company_id', '=', $company_id)
            ->select(DB::raw('count(afr_routes.afr_route_id) as total '))->first();
        $result['ocean_routes'] = DB::table('ocean_routes')->where('ocean_routes.company_id', '=', $company_id)
            ->select(DB::raw('count(ocean_routes.ocean_route_id) as total '))->first();
        $result['col_routes'] = DB::table('col_routes')->where('col_routes.company_id', '=', $company_id)
            ->select(DB::raw('count(col_routes.col_route_id) as total '))->first();
        return view('admin.home')->with('data',$result);
    }

    
    public function editpersonInCharge(Request $request)
    {
        $input = Input::all();
        $file = Input::file('picture');
        $this->validate($request, [
            'full_name' => 'required',
            'position' => 'required',
            'working_email' => 'required',
            'cell_phone' => 'required',
            'picture' => 'mimes:jpeg,png,jpg|max:50000',
        ]);
        if(isset($file) && $file !=null){
            $Orname = $file->getClientOriginalName();
            $destination_path='personInCharges/';
            $filename= str_random(6).'_'.$Orname;
            $file->move($destination_path,$filename);
            $image = Image::make(sprintf('personInCharges/%s', $filename))->resize(200, 200)->save();
            //dd($filename);
            $datas = array(
                'picture' => $filename,
                'modified' => CURRENT_DATETIME
            );
            DB::table('person_in_charge')->where('person_in_charge_id', $input['person_incharge'])->update($datas);
        }

        $datas = array(
            'full_name' => $input['full_name'],
            'position' => $input['position'],
            'working_email' => $input['working_email'],
            'cell_phone' => $input['cell_phone'],
            'modified' => CURRENT_DATETIME
        );
        DB::table('person_in_charge')->where('person_in_charge_id', $input['person_incharge'])->update($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/personInCharge/View')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('/admin/personInCharge/View')->with('success',$this->freightforwarderMsg['update']);
        }
       
    }

    public function GetInfo($country,$city) {
        $countries = DB::table('countries')->where('title',$country)->first();
        $country_id = $countries->country_id;
        $cities = DB::table('cities')->where('title',$city)->where('country_id',$country_id)->first();
        print_r($cities->city_id);
        return array(
            'data' => "hello"
        );
    }

    public function uploadpostrate(Request $request)
    {
        
        $input = Input::all();
        $file = Input::file('filename');

        $destination_path='assets/files/';

        $Orname = $file->getClientOriginalName();
        $filename = str_random(6).'_'.$Orname;
        move_uploaded_file($_FILES['filename']['tmp_name'], $destination_path.$filename);
        $arrResult = array();
        $handle = fopen($destination_path.$filename, "r");
        if( $handle ) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $country = $data[2];
                $city = $data[3];
                $airport = UploadrateController::GetInfo($country,$city);
                print_r($data);
                die();
                $arrResult[] = $data;
            }
            print_r($arrResult);
            fclose($handle);
        }
   
    die();
    }
}
