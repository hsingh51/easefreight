<?php

namespace App\Http\Controllers\administrator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Image;
use Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class DashboardController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        $this->before(Auth::user()->group_id);
    }

    public function before($group_id)
    {
        if ($group_id == '2') {
            return Redirect::to('/admin/dashboard')->send();
        }
        if ($group_id == '3') {
            return Redirect::to('/home')->send();
        }
    }

    public function passwordChange(Request $request)
    {
        $post = $request->all();
        $id = Auth::user()->id;
        $redirectTo = '/administrator/profile';
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'password_confirmation'=>'required|min:6',
        ]);

        $datas = array(
            'password' => bcrypt($post['password']),
        );
        if(DB::table('users')->where('id', $id)->update($datas)){
            return Redirect::to('administrator/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
        }else{
            return Redirect::to('administrator/profile')->with('error',$this->freightforwarderMsg['profile']['error']);
        }
        
    }

    public function index()
    {
        return view('administrator.home');
    }
    public function dashboard()
    {
        $result['country'] = DB::table('countries')->select(DB::raw('count(countries.country_id) as total '))->first();
        $result['city'] = DB::table('cities')->select(DB::raw('count(cities.city_id) as total '))->first();
        $result['airport'] = DB::table('airports')->select(DB::raw('count(airports.airport_id) as total '))->first();
        $result['service'] = DB::table('services')->select(DB::raw('count(services.service_id) as total '))->first();
        $result['unit'] = DB::table('units')->select(DB::raw('count(units.unit_id) as total '))->first();
        $result['freight_forwarder'] = DB::table('users')->select(DB::raw('count(users.id) as total '))->where('group_id','=','2')->first();
        return view('administrator.home')->with('data',$result);
    }

    // UserController.php
    public function update(Request $request) {
        $post = $request->all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'company' => 'required',
            'username' => 'required|unique:users,email,' . $id,
            'phone' => 'required|numeric',
            'mobile' => 'required|numeric',
            'position' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'website' => 'required',
            'message' => 'required',
        ]);

        $datas = array(
            'name' => $post['name'],
            'email' => $post['email'],
            'company' => $post['company'],
            'username' => $post['username'],
            'phone' => $post['phone'],
            'mobile' => $post['mobile'],
            'position' => $post['position'],
            'address' => $post['address'],
            'country_id' => $post['country_id'],
            'city_id' => $post['city_id'],
            'website' => $post['website'],
            'message' => $post['message'],
        );
        
        if(DB::table('users')->where('id', $id)->update($datas)){
            return Redirect::to('administrator/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
        }else{
            return Redirect::to('administrator/profile')->with('error',$this->freightforwarderMsg['profile']['error']);
        }
        return redirect('administrator/profile');
    }

    public function getProfile()
    {
        //return view('administrator.profile', ['user' => User::findOrFail($id)]);
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')
            ->get();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        return view('administrator.profile')->with('stats',$stats);
    }
    
    public function updatePicture(Request $request)
    {
        $input = Input::all();
        $file = Input::file('picture');
        $id = Auth::user()->id;
        $imageName = $file->getClientOriginalName();
        //$path = base_path() . '/public/uploads/';
        $destination_path = 'uploads/';
        $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
        $extension = $file->getClientOriginalExtension();
        $filename= $id.'.'.$extension;
        $file->move($destination_path,$filename);
        $image = Image::make(sprintf('uploads/%s', $filename))->resize(200, 200)->save();

        if(DB::table('users')->where('id', $id)->update(['picture' => $filename])){
            return Redirect::to('administrator/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
        }else{
            return Redirect::to('administrator/profile')->with('error',$this->freightforwarderMsg['profile']['error']);
        }
    }


    public function changeStatus($id,$status,$table,$field,$decReason)
    {
        if($decReason =="null"){ $decReason ='';}
        $modified = 'modified';
        
        //dd($field);
        if($table =="users"){
            $modified = 'updated_at';
            
            $data = DB::table($table)->where($field, $id)->select('users.name','users.username','users.mobile','users.website','users.email',
                'companies.name as company')->join('companies','companies.company_id','=','users.company_id')->first();
            $data= (array) $data;
            $data['is_active_reason'] = $decReason; 
            $view = 'emails.forwarder.conformation';$data['subject'] ='Welcome To EASE FREIGHT Forwarder Account';
            if($status==2){ $view = 'emails.forwarder.decline'; $data['subject'] ='EASE FREIGHT Forwarder Account Decline';}
            Mail::send($view, $data, function ($message) use($data){
                //$message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
                $message->to($data['email'])->subject($data['subject']);
            });    
        }
        $datas = array(
            'is_active' => $status,
            'is_active_reason'=>$decReason,
            $modified => CURRENT_DATETIME
        );
        $return = DB::table($table)->where($field, $id)->update($datas);
        return Redirect::back()->with('success',$this->freightforwarderMsg['update']);
    }

    public function delete($id,$table,$field)
    {
        DB::table($table)->where($field, $id)->delete();
        return Redirect::back()->with('success',$this->freightforwarderMsg['update']);
    }

    //Countries
    public function viewCountries()
    {
        $result = DB::table('countries')->select('countries.*')->paginate(ADMINISTRATOR_PAGENATE);
        return view('administrator.Countries.view')->with('data',$result);
    }
    
    public function getCountries()
    {
        
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('countries')->where('countries.country_id', $condition, $value)->select('countries.title')->first();
        $query = DB::table('countries')->select('countries.*')->orderBy( 'title' );
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('countries.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('countries.country_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('countries.created','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('countries.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('countries.is_active','=', 2);
            }
        }

        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.countries.add')->with('states',$newresult);
    }

    public function addCountries(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'country_code' => 'required|numeric',
            'title' => 'required',
        ]);

        $datas = array(
            'country_code' => $input['country_code'],
            'title' => $input['title'],
            'created' => CURRENT_DATETIME
        );
        if(isset($input['update']) && !empty($input['update'])){
            $return = DB::table('countries')->where('country_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $return = DB::table('countries')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/countries')->with('success',$message);
        }
    }

    //Statuses
    public function viewStatus()
    {
        $result = DB::table('ff_status')->select('ff_status.*')->paginate(ADMINISTRATOR_PAGENATE);
        return view('administrator.ffStatus.view')->with('data',$result);
    }
    
    public function getStatus()
    {
        
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('ff_status')->where('ff_status.status_id', $condition, $value)->select('ff_status.title','ff_status.message')->first();
        $query = DB::table('ff_status')->select('ff_status.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('ff_status.message','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('ff_status.status_id','LIKE','%'.$_GET['search'].'%');
            //$query = $query->orwhere('countries.created','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('ff_status.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('ff_status.is_active','=', 2);
            }
        }

        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.ff_status.add')->with('states',$newresult);
    }

    public function addStatus(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
            'message' => $input['message']
        );
        if(isset($input['update']) && !empty($input['update'])){
            $return = DB::table('ff_status')->where('status_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
            $return = DB::table('ff_status')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/ffstatus')->with('success',$message);
        }
    }

    //Sevices
    public function viewServices()
    {
        $result = DB::table('services')->select('services.*')->paginate(ADMINISTRATOR_PAGENATE);
        return view('administrator.Services.view')->with('data',$result);
    }
    
    public function getServices()
    {
        
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('services')->where('services.service_id', $condition, $value)->select('services.title')->first();
        $query = DB::table('services')->select('services.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('services.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('services.service_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('services.created','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('services.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('services.is_active','=', 2);
            }
        }

        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.services.add')->with('services',$newresult);
    }

    public function addServices(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
            
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('services')->where('service_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $return = DB::table('services')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/services')->with('success',$message);
        }
    }

    //Units
    public function viewUnits()
    {
        $result = DB::table('units')->select('units.*')->paginate(ADMINISTRATOR_PAGENATE);
        return view('administrator.Units.view')->with('data',$result);
    }
    
    public function getUnits()
    {
        
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('units')->where('units.unit_id', $condition, $value)->select('units.title')->first();
        $query = DB::table('units')->select('units.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('units.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('units.unit_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('units.created','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('units.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('units.is_active','=', 2);
            }
        }

        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.units.add')->with('units',$newresult);
    }

    public function addUnits(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title']
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('units')->where('unit_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
            $return = DB::table('units')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/units')->with('success',$message);
        }
    }


    //Airports
    public function viewAirports()
    {
        $result = DB::table('airports')->select('airports.*','countries.title as country','cities.title as city')
            ->leftjoin('countries','countries.country_id','airports.country_id')
            ->leftjoin('cities','cities.city_id','airports.city_id')->paginate(ADMINISTRATOR_PAGENATE);
        return view('administrator.Airports.view')->with('data',$result);
    }
    
    public function getAirports()
    {
        $newresult['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->orderBy( 'title' )->get();
        $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->get();

        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('airports')->where('airports.airport_id', $condition, $value)->select('airports.name','airports.iata_code','airports.city_id','airports.country_id')->first();
        $query = DB::table('airports')->select('airports.*','countries.title as country','cities.title as city')
            ->leftjoin('countries','countries.country_id','=','airports.country_id')
            ->leftjoin('cities','cities.city_id','=','airports.city_id');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('airports.name','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('airports.iata_code','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('airports.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('airports.is_active','=', 2);
            }
        }

        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.airports.add')->with('airports',$newresult);
    }

    public function addAirports(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'iata_code' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        $datas = array(
            'name' => $input['name'],
            'iata_code' => $input['iata_code'],
            'country_id' => $input['country_id'],
            'city_id' => $input['city_id']
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('airports')->where('airport_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
            $return = DB::table('airports')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/airports')->with('success',$message);
        }
    }


////------------By Vaid------------------///////
    public function getAirline()
        {
           // $newresult['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->orderBy( 'title' )->get();
          //  $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->get();

            $condition = '=';
            $value = 0;
            if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
            //dd(implode(',', $condition));
            $edit = DB::table('airlines')->where('airlines.airline_id', $condition, $value)->select('airlines.*')->first();

            $query = DB::table('airlines')->join('countries','countries.country_id','=','airlines.country_id')->select('airlines.*','countries.title as country');
            if(isset($_GET['search']) && !empty($_GET['search'])){
                $query = $query->orwhere('airlines.title','LIKE','%'.$_GET['search'].'%');
                $query = $query->orwhere('airlines.iata_designator','LIKE','%'.$_GET['search'].'%');
                $query = $query->orwhere('airlines.three_digit','LIKE','%'.$_GET['search'].'%');
                $query = $query->orwhere('airlines.icao_designator','LIKE','%'.$_GET['search'].'%');

                if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                    $query = $query->orwhere('airlines.is_active','=', 1);
                }
                if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                    $query = $query->orwhere('airlines.is_active','=', 2);
                }
            }

            $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
            $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->get();
            $newresult['edit']= $edit;
            return view('administrator.airline.add')->with('airlines',$newresult);
        }

        public function addAirline(Request $request)
        {
            //dd($request);
            $input = Input::all();
            $id = Auth::user()->id;
            $this->validate($request, [
                'country_id' => 'required',
                'name' => 'required',
                'iata_code' => 'required',
                'digit_code' => 'required',
                'icao_code' => 'required',
                
            ]);

            $datas = array(
                'country_id' => $input['country_id'],
                'title' => $input['name'],
                'iata_designator' => $input['iata_code'],
                'three_digit' => $input['digit_code'],
                'icao_designator' => $input['icao_code'],
                'is_active' => 1
            );
            if(isset($input['update']) && !empty($input['update'])){
                $datas['modified'] = CURRENT_DATETIME;
                $return = DB::table('airlines')->where('airline_id', $input['update'])->update($datas);
                $message = $this->freightforwarderMsg['update'];
            }else{
                $datas['created'] = CURRENT_DATETIME;
                $return = DB::table('airlines')->insert($datas);
                $message = $this->freightforwarderMsg['success'];
            }
            if($return == 1)
            {
                return Redirect::to('administrator/airline')->with('success',$message);
            }
        }
////------------By Vaid------------------///////

    //Cities
    public function getCities(){
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('cities')->where('cities.city_id', $condition, $value)->select('cities.title','cities.country_id')->first();
        $query = DB::table('cities')->select('cities.*','countries.title as country')
                 ->leftjoin('countries','countries.country_id','=','cities.country_id');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('cities.title','LIKE',"%".$_GET['search']."%");
            $query = $query->orwhere('countries.title','LIKE',"%".$_GET['search']."%");
            $query = $query->orwhere('cities.city_id','LIKE',"%".$_GET['search']."%");
            $query = $query->orwhere('cities.created','LIKE',"%".$_GET['search']."%");
            // if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
            //     $query = $query->orwhere('cities.is_active','=', 1);
            // }
            // if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
            //     $query = $query->orwhere('cities.is_active','=', 2);
            // }
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        //dd($newresult['result']);
        $newresult['edit']= $edit;
        $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->get();
        return view('administrator.cities.add')->with('states',$newresult);
    }

    public function addCities(Request $request){
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
            'country_id'=> $input['country_id'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('cities')->where('city_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('cities')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/cities')->with('success',$message);
        }
    }

    //Departments
    public function getDepartments(){
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('col_departments')->where('col_departments.col_department_id', $condition, $value)
            ->select('col_departments.name','col_departments.city_id','col_departments.zipcode')->first();
        $query = DB::table('col_departments')->select('col_departments.*','cities.title as city')
            ->leftjoin('cities','cities.city_id','=','col_departments.city_id');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('col_departments.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('city.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_departments.id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('col_departments.created','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('col_departments.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('col_departments.is_active','=', 2);
            }
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        $newresult['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')
            ->get();
        return view('administrator.departments.add')->with('states',$newresult);
    }

    public function addDepartments(Request $request){
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'zipcode' => 'required',
        ]);

        $datas = array(
            'name' => $input['name'],
            'zipcode' => $input['zipcode'],
            'city_id'=> $input['city_id'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('col_departments')->where('col_department_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('col_departments')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/departments')->with('success',$message);
        }
    }

    //Freight forworder
    public function getFreightRegister() {  
        $query = DB::table('users')->select('users.*','companies.name as company','companies.branches',
            'companies.com_id','ff_status.title as status')->join('companies','companies.company_id','=','users.company_id')
        ->join('ff_status','ff_status.status_id','=','users.is_active');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('users.id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('companies.name','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('users.username','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('users.mobile','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('users.website','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('users.email','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('users.name','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('users.created_at','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('users.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('users.is_active','=', 2);
            }
        }
        $newresult = $query->where('users.group_id','=','2')->paginate(ADMINISTRATOR_PAGENATE);
        
        return view('administrator.freightRegister.view')->with('data',$newresult);
    }
    
    public function getAddFreightRegister(){
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')
            ->get();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        $stats['status'] = DB::table('ff_status')->select('ff_status.*')->where('is_active','=','1')
            ->get(); 
        return view('administrator.freightRegister.add')->with('stats',$stats);
    }
    public function freightRegister(Request $request)
    {
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

        $view = 'emails.forwarder.welcome'; $data['subject'] ='Welcome To EASE FREIGHT Forwarder Account';
        Mail::send($view, $data, function ($message) use($data){
            //$message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
            $message->to($data['email'])->subject($data['subject']);
        });
        return Redirect::to('administrator/freight-forwarder/View')->with('success',$this->freightforwarderMsg['success']);
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
    public function confirmation($ticket_user,$ticket)
    {
        if(!empty($ticket_user) && !empty($ticket)){
            $user_id = Crypt::decrypt($ticket_user);
            if(DB::table('tickets')->where('user_id', $user_id)->where('ticket_id', $ticket)->update(['is_active' => 1])){
                return Redirect::to('/freight/register')->with('success',$this->freightforwarderMsg['register']['success']);
            }else{
                return Redirect::to('/freight/register')->with('error',$this->freightforwarderMsg['register']['error']);
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

    public function deleteFreightRegister($id)
    {
        $result = DB::table('users')->select('users.*')->where('users.id','=',$id)->first();
        DB::table('users')->where('users.id','=',$id)->delete();
        File::delete('uploads/'.$result->picture);
        return Redirect::to('administrator/freight-forwarder/View')->with('success',$this->freightforwarderMsg['delete']);
    }
    public function geteditFreightRegister($id)
    {

        if(!isset($id) && empty($id)){
            return Redirect::to('administrator/freight-forwarder/View');
        }
        
        $stats['data'] = DB::table('users')->select('users.*','companies.name as company','companies.branches',
            'companies.com_id','appointment.appointment_date','appointment.appointment_time','ff_status.title as status')->where('users.id','=',$id)->join('companies','companies.company_id','=','users.company_id')->
        join('ff_status','ff_status.status_id','=','users.is_active')->leftjoin('appointment','appointment.user_id','=','users.id')->first();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->get();
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')
            ->get();
        $stats['status'] = DB::table('ff_status')->select('ff_status.*')->where('is_active','=','1')
            ->get();    
        return view('administrator.freightRegister.edit')->with('stats',$stats);
    }
    public function editFreightRegister(Request $request)
    {
        $data = Input::all();

        $this->validate($request, [
            'company' => 'required',
            'company_id' => 'required',
            'branches' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'website' => 'required',
            'message' => 'required',
            'appointment_time'=>'required_if:is_active,12',
            'appointment_date'=>'required_if:is_active,12',
        ]);
        $user = new \App\User;
        
        $datas = array(
            'name'=>$data['company'],
            'com_id' => $data['company_ID'],
            'branches' => $data['branches'],
            'modified' => CURRENT_DATETIME
        );
        DB::table('companies')->where('company_id', $data['company_id'])->update($datas);
        $users['name'] = $data['company'];
        $users['group_id'] = $data['group_id'];
        $users['username'] = $data['company'];
        $users['phone'] = $data['phone'];
        $users['address'] = $data['address'];
        $users['country_id'] = $data['country_id'];
        $users['city_id'] = $data['city_id'];
        $users['website'] = $data['website'];
        $users['is_active'] = $data['is_active'];
        $users['message'] = $data['message'];
        DB::table('users')->where('id',$data['id'])->update($users);
        if($data['is_active'] == "8"){
            $appointment = array(
                'user_id' => $data['id'],
                'appointment_date' => date('Y-m-d',strtotime($data['appointment_date'])),
                'appointment_time' => date('H:i:s',strtotime($data['appointment_time'])),
                'created' => CURRENT_DATETIME
            );
            DB::table('appointment')->insert($appointment);
            $view = 'emails.forwarder.appointment'; $data['subject'] ='EASE FREIGHT Appointment Schedule';
            $sent = Mail::send($view, $data, function ($message) use($data){
                //$message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
                $message->to($data['email'])->subject($data['subject']);
            });
        }
        if($data['is_active'] == "1"){
            $view = 'emails.forwarder.conformation'; 
            $data['subject'] ='EASE FREIGHT Approval';
            $sent = Mail::send($view, $data, function ($message) use($data){
                //$message->from('neha.sharma@ldh.01s', 'EASE FREIGHT');
                $message->to($data['email'])->subject($data['subject']);
            });
        }
        return Redirect::to('administrator/freight-forwarder/View')->with('success',$this->freightforwarderMsg['update']);
       
    }

    //EXCHANGE SELECTION
    public function getExchangeSelection()
    {
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('exchange_selection')->where('exchange_selection.exchange_selection_id', $condition, $value)
            ->select('exchange_selection.title','exchange_selection.exchange_selection_id')->first();

        $query = DB::table('exchange_selection')->select('exchange_selection.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('exchange_selection.exchange_selection_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('exchange_selection.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('exchange_selection.created','LIKE','%'.$_GET['search'].'%');
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.exchangeSelection.add')->with('states',$newresult);
    }

    public function addExchangeSelection(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('exchange_selection')->where('exchange_selection_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('exchange_selection')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/exchangeSelection')->with('success',$message);
        }
    }

    //MEAN OF TRANSPORTATION SELECTION
    public function getTransportationSelection()
    {
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('transportation_selection')->where('transportation_selection.transportation_selection_id', $condition, $value)
            ->select('transportation_selection.title','transportation_selection.transportation_selection_id')->first();
        
        $query = DB::table('transportation_selection')->select('transportation_selection.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('transportation_selection.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('transportation_selection.transportation_selection_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('transportation_selection.created','LIKE','%'.$_GET['search'].'%');
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.transportationSelection.add')->with('states',$newresult);
    }

    public function addTransportationSelection(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('transportation_selection')->where('transportation_selection_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('transportation_selection')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/transportationSelection')->with('success',$message);
        }
    }

    //OCEAN FREIGHT TRANSPORTATION MODE SELECTION
    public function getCFTMode()
    {
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('cft_mode')->where('cft_mode.cft_mode_id', $condition, $value)->select('cft_mode.title')->first();
        
        $query = DB::table('cft_mode')->select('cft_mode.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('cft_mode.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('cft_mode.cft_mode_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('cft_mode.created','LIKE','%'.$_GET['search'].'%');
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.CFTMode.add')->with('states',$newresult);
    }

    public function addCFTMode(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('cft_mode')->where('cft_mode_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('cft_mode')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/CFTMode')->with('success',$message);
        }
    }

    //CONTAINER TYPE AND CUANTITY
    public function getContainerType()
    {
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('container_type')->where('container_type.container_type_id', $condition, $value)->select('container_type.title')->first();
        $query = DB::table('container_type')->select('container_type.*');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('container_type.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('container_type.container_type_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('container_type.created','LIKE','%'.$_GET['search'].'%');
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        return view('administrator.containerType.add')->with('states',$newresult);
    }

    public function addContainerType(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('container_type')->where('container_type_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('container_type')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/containerType')->with('success',$message);
        }
    }

    //Ocean ports
    public function getOceanPorts()
    {
        //return view('administrator.Countries.add');
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('ocean_ports')->where('ocean_ports.ocean_port_id', $condition, $value)->select('ocean_ports.*')->first();
        $query = DB::table('ocean_ports')->select('ocean_ports.*','countries.title as country','cities.title as city')
            ->leftjoin('countries','countries.country_id','=','ocean_ports.country_id')->leftjoin('cities','cities.city_id','=','ocean_ports.city_id');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('ocean_ports.port_title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('countries.country_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('ocean_ports.ocean_port_id','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('ocean_ports.created','LIKE','%'.$_GET['search'].'%');
        }
        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        $newresult['edit']= $edit;
        $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('countries.is_active','=','1')->orderBy('countries.title')->get();
        $newresult['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('cities.is_active','=','1')->orderBy('cities.title')->get();
        return view('administrator.oceanPorts.add')->with('states',$newresult);
    }

    public function addOceanPorts(Request $request)
    {
        //dd($request);
        $input = Input::all();
        
        $id = Auth::user()->id;
        $this->validate($request, [
            'country_id' => 'required',
            'city_id' => 'required',
            'title' => 'required',
        ]);

        $datas = array(
            'country_id'=>$input['country_id'],
            'port_title' => $input['title'],
            'city_id' =>$input['city_id'],
        );
        if(isset($input['update']) && !empty($input['update'])){
            $datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('ocean_ports')->where('ocean_port_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
        
            $return = DB::table('ocean_ports')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            return Redirect::to('administrator/oceanPorts')->with('success',$message);
        }
    }
}
