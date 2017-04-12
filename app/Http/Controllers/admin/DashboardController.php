<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use URL;
use File;
use Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App;
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
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        if($this->locale == "es"){
            $this->freightforwarderMsg = \Config::get('constants.es_freight-forwarder');
        }
        $this->user_id = Auth::user()->id;
        $this->company_id = Auth::user()->company_id;
        $this->before(Auth::user()->group_id);
        
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

    public function passwordChange(Request $request)
    {
        $post = $request->all();
        $redirectTo = '/admin/profile';
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'password_confirmation'=>'required|min:6',
        ]);

        $datas = array(
            'password' => bcrypt($post['password']),
        );
        if(DB::table('users')->where('id', $this->user_id)->update($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
            }else{
                return Redirect::to('admin/profile')->with('success',$this->freightforwarderMsg['profile']['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/profile')->with('error',$this->freightforwarderMsg['profile']['error']);
            }else{
                return Redirect::to('admin/profile')->with('success',$this->freightforwarderMsg['profile']['error']); 
            }
        }
        
    }
     
    public function index()
    {
        return view('admin.home');
    }
    public function dashboard()
    {
        //$this->authenticate(Auth::user());
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
        $result['afr_route_rates'] = DB::table('afr_route_rates')
                                     ->join('afr_routes', 'afr_route_rates.afr_route_id', '=', 'afr_routes.afr_route_id')
                                     ->where('afr_route_rates.user_id', '=', $user_id)
                                     ->select(DB::raw('count(afr_route_rates.afr_route_rates_id) as total '))
                                     ->first(); 
        $result['ocean_lcl_rates'] = DB::table('ocean_lcl_rates')
                                     ->join('ocean_routes', 'ocean_lcl_rates.ocean_route_id', '=', 'ocean_routes.ocean_route_id')
                                     ->where('ocean_lcl_rates.company_id', '=', $company_id)
                                     ->select(DB::raw('count(ocean_lcl_rates.ocean_lcl_rate_id) as total'))
                                     ->first(); 
        $result['ocean_fcl_rates'] = DB::table('ocean_fcl_rates')
                                     ->join('ocean_routes', 'ocean_fcl_rates.ocean_route_id', '=', 'ocean_routes.ocean_route_id')
                                     ->where('ocean_fcl_rates.company_id', '=', $company_id)
                                     ->select(DB::raw('count(ocean_fcl_rates.ocean_fcl_rate_id) as total'))
                                     ->first(); 
        $result['col_port_rates'] = DB::table('ocean_local_terminal_rates')
                                     ->join('col_city_ports', 'col_city_ports.col_city_port_id', '=', 'ocean_local_terminal_rates.col_city_port_id')
                                     ->where('ocean_local_terminal_rates.user_id', '=', $user_id)
                                     ->select(DB::raw('count(ocean_local_terminal_rates.ocean_local_terminal_rate_id) as total'))
                                     ->first();    
        return view('admin.home')->with('data',$result);
    }

    // UserController.php
    public function update(Request $request) {
        $post = $request->all();
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'company' => 'required',
            'company_ID' => 'required',
            'branches' => 'required',
            'username' => 'required|unique:users,email,' . $this->user_id,
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
            'name'=>$post['company'],
            'com_id' => $post['company_ID'],
            'branches' => $post['branches'],
            'modified' => CURRENT_DATETIME
        );
        $com_id = DB::table('companies')->where('company_id', $this->company_id)->update($datas);
        $user = new \App\User;
        $dangerous_good = (isset($post['dangerous_good']))? 1 : 0;
        $datas = array(
            'name' => $post['name'],
            'email' => $post['email'],
            'username' => $post['username'],
            'phone' => $post['phone'],
            'mobile' => $post['mobile'],
            'position' => $post['position'],
            'address' => $post['address'],
            'country_id' => $post['country_id'],
            'city_id' => $post['city_id'],
            'website' => $post['website'],
            'message' => $post['message'],
            'dangerous_good' => $dangerous_good,
            'updated_at' => CURRENT_DATETIME
        );
        
        if(DB::table('users')->where('id', $this->user_id)->update($datas)){

            if($this->locale == "es"){
                return Redirect::to('/es/admin/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
            }else{
                return Redirect::to('admin/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/profile')->with('error',$this->freightforwarderMsg['profile']['error']);
            }else{
                return Redirect::to('admin/profile')->with('error',$this->freightforwarderMsg['profile']['error']);
            }
        }
        return redirect('admin/profile');
    }

    public function getProfile()
    {
        $com_id = $this->company_id;
        $stats = DB::table('companies')->select('companies.name as company','companies.branches',
            'companies.com_id')->where('company_id','=',$com_id)->first();
        $stats = (array) $stats; 
        $stats['countries'] = DB::table('countries')->select('countries.country_id','countries.title')
            ->where('is_active','=','1')->orderBy('title')->get();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->orderBy('title')->where('is_active','=','1')->get();
        $stats['financial_information']= DB::table('finantial_informations')->where('finantial_informations.user_id','=',$this->user_id)->select('finantial_informations.*')->first();
        return view('admin.profile')->with('stats',$stats);
        
    }
    
    public function updatePicture(Request $request)
    {
        $input = Input::all();
        $file = Input::file('picture');
        $imageName = $file->getClientOriginalName();
        //$path = base_path() . '/public/uploads/';
        $destination_path = 'uploads/';
        $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
        $extension = $file->getClientOriginalExtension();
        $filename= $this->user_id.'.'.$extension;
        $file->move($destination_path,$filename);
        $image = Image::make(sprintf('uploads/%s', $filename))->resize(200, 200)->save();

        DB::table('users')->where('id', $this->user_id)->update(['picture' => $filename]);

        if($this->locale == "es"){
            return Redirect::to('/es/admin/profile')->with('success',$this->freightforwarderMsg['profile']['success']);
        }else{
           return Redirect::to('admin/profile')->with('success',$this->freightforwarderMsg['profile']['success']); 
        }
    }
    
    //Person in charge
    public function personInCharge()
    {
        return view('admin.personInCharge.add');
    }
    public function addpersonInCharge(Request $request)
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
        }

        $datas = array(
            'user_id'=>$this->user_id,
            'full_name' => $input['full_name'],
            'position' => $input['position'],
            'working_email' => $input['working_email'],
            'cell_phone' => $input['cell_phone'],
            'picture' => $filename,
            'modified' => CURRENT_DATETIME
        );
        DB::table('person_in_charge')->insert($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/personInCharge/View')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('admin/personInCharge/View')->with('success',$this->freightforwarderMsg['update']);   
        }
    }

    public function geteditpersonInCharge($id)
    {
        if(isset($id) && !empty($id)){
            $edit = $id;
        }else{ return Redirect::to('admin/personInCharge/View');
        }
        
        $result = DB::table('person_in_charge')->join('users', 'person_in_charge.user_id', '=', 'users.id')
            ->select('person_in_charge.*')->where('person_in_charge.person_in_charge_id','=',$edit)->first();
        return view('admin.personInCharge.edit')->with('data',$result);
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
            return Redirect::to('admin/personInCharge/View')->with('success',$this->freightforwarderMsg['update']);
        }
    }
    public function viewPersonInCharge()
    {
        $query = DB::table('person_in_charge')->where('person_in_charge.user_id', '=', $this->user_id);
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->Where(function ($query) {
                $query->orwhere('person_in_charge.full_name', 'LIKE','%'.$_GET['search'].'%')
                  ->orwhere('person_in_charge.position','LIKE','%'.$_GET['search'].'%')
                  ->orwhere('person_in_charge.working_email','LIKE','%'.$_GET['search'].'%')
                  ->orwhere('person_in_charge.cell_phone','LIKE','%'.$_GET['search'].'%');
            });
        }
        $result = $query->select('person_in_charge.*')->paginate(PAGENATE);
        return view('admin.personInCharge.view')->with('data',$result);
    }
   

    // security Quality
    public function getSecurityFinantialQuality()
    {
        $stats['data'] = DB::table('security_qualities')->select('security_qualities.*')->join('users', 'security_qualities.user_id', '=', 'users.id')->first();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->orderBy('title')->get();
        return view('admin.securityQuality.finantialEntity.securityQuality')->with('stats',$stats);
    }
    public function securityFinantialQuality(Request $request)
    {
        $post = $request->all();
        
        $id = Auth::user()->id;
        $this->validate($request, [
            //'payment_instrument' => 'required',
            'account_type' => 'required',
            'account_number' => 'required',
            'finacial_entity' => 'required',
            //'branch_office' => 'required',
            //'city_id' => 'required',
        ]);
        $datas = array(
            'user_id' => $id,
            //'payment_instrument' => $post['payment_instrument'],
            'account_type' => $post['account_type'],
            'account_number' => $post['account_number'],
            'financial_entity' => $post['finacial_entity'],
            //'branch_office' => $post['branch_office'],
            //'city_id' => $post['city_id'],
        );
        $datas['modified'] = CURRENT_DATETIME;
        $return = DB::table('security_qualities')->where('user_id', $id)->update($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/securityFinantialQuality')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('admin/securityFinantialQuality')->with('success',$this->freightforwarderMsg['  update']);
        }
        
    }

    public function getSecurityQuality()
    {
        $stats['data'] = DB::table('security_qualities')->select('security_qualities.*')->join('users', 'security_qualities.user_id', '=', 'users.id')->first();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->orderBy('title')->where('is_active','=','1')->get();
        return view('admin.securityQuality.securityQuality')->with('stats',$stats);
    }
    public function securityQuality(Request $request)
    {
        $post = $request->all();
        //dd($post);
        //dd($file);
        $id = Auth::user()->id;
        $this->validate($request, [
            'quality_management_system' => 'mimes:jpeg,png,jpg|max:50000',
            'no_answer' => 'mimes:jpeg,png,jpg|max:50000',
            'BASC' => 'mimes:jpeg,png,jpg|max:50000',
            'aci' => 'mimes:jpeg,png,jpg|max:50000',
            'iata' => 'mimes:jpeg,png,jpg|max:50000',
            'belong_network'=>'required',
            'basc_check'=>'required',
            'is_aci'=>'required',
            'is_iata'=>'required',
            'quality_check'=>'required'
        ]);
        $filename = array('quality_management_system'=>'','no_answer'=>'','BASC'=>'','aci'=>'','iata'=>'');
        foreach (Input::file() as $key => $value) {
            if($key == "quality_management_system" || $key == "no_answer" || $key == "BASC" || $key == "iata"
                || $key == "aci"){
                $file = $value;

                $imageName = $value->getClientOriginalName();
                $destination_path = base_path() . '/public/securityQuality/';
                $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
                $extension = $file->getClientOriginalExtension();
                $filename[$key]= $id.'_'.$key.'.'.$extension;
                $file->move($destination_path,$filename[$key]);
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
        //dd($post);
        $datas = array(
            'user_id' => $id,
            'basc_check'=>$post['basc_check'],
            'quality_check'=>$post['quality_check'],
            'answer_check'=>$post['answer_check'],
            'who' => $post['who_certifies'],
            'is_aci' => $post['is_aci'],
            'is_iata' => $post['is_iata'],
            'belong_network' => $post['belong_network'],
            'belong_network_text' => $post['belong_network_text'],
            'modified' => CURRENT_DATETIME
        );
        $datas['modified'] = CURRENT_DATETIME;
        foreach ($filename as $key => $value) {
            if($value){
                if($key == "quality_management_system"){
                    $datas["management_system"] = $value;
                }elseif($key == "BASC"){
                    $datas["basc"] = $value;
                }else{
                    $datas[$key] = $value;
                }
            }
        }
        // if(!$filename['quality_management_system'])
        //     $datas['management_system'] = $filename['quality_management_system'];
        // if(!$filename['no_answer'])
        //     $datas['no_answer'] = $filename['no_answer'];
        // if(!$filename['BASC'])
        //     $datas['basc'] = $filename['BASC'];
        // if(!$filename['aci'])
        //     $datas['aci'] = $filename['aci'];
        // if(!$filename['iata'])
        //     $datas['iata'] = $filename['iata'];
        //dd($datas);
        $return = DB::table('security_qualities')->where('user_id', $id)->update($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/securityQuality')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('admin/securityQuality')->with('success',$this->freightforwarderMsg['update']); 
        }
    }

    public function addSecurityQuality($add)
    {
        $id = Auth::user()->id;
        $filename = array('quality_management_system'=>'','no_answer'=>'','BASC'=>'');
        foreach (Input::file() as $key => $value) {
            $file = $value;
            $imageName = $value->getClientOriginalName();
            $destination_path = base_path() . '/public/securityQuality/';
            $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
            $extension = $file->getClientOriginalExtension();
            $filename[$key]= $id.'_'.$key.'.'.$extension;
            $file->move($destination_path,$filename[$key]);
        }
        $datas = array(
            'user_id' => $id,
            'management_system' => $filename['quality_management_system'],
            'no_answer' => $filename['no_answer'],
            'who' => $post['who_certifies'],
            'basc' => $filename['BASC'],
            'payment_instrument' => $post['payment_instrument'],
            'account_type' => $post['account_type'],
            'account_number' => $post['account_number'],
            'financial_entity' => $post['finacial_entity'],
            'branch_office' => $post['branch_office'],
            'city_id' => $post['city_id'],
            'created'=>CURRENT_DATETIME,
        );
        DB::table('security_qualities')->insert($datas);
    }

    //share holders
    public function getShareHolders()
    {
        return view('admin.shareHolder.add');
    }
    public function saveShareHolders(Request $request)
    {
        $post = $request->all();
        //dd($post);
        $this->validate($request, [
            'name' => 'required',
            //'type' => 'required',
            'identification' => 'required',
        ]);
        $input = Input::all();
        $file = Input::file('identification_copy');
        if(isset($file) && $file !=null){
            //dd($_FILES);
            $Orname = $file->getClientOriginalName();
            $destination_path='identification_copy/';
            $filename= str_random(6).'_'.$Orname;
            $file->move($destination_path,$filename);
            if(@$_FILES['identification_copy']){
                if($_FILES['identification_copy']['type']=="image/png" || $_FILES['identification_copy']['type']=="image/jpg" || $_FILES['identification_copy']['type']=="image/jpeg"){
                    $image = Image::make(sprintf('identification_copy/%s', $filename))->resize(500, 500)->save();
                }
            }
        }
        $datas = array(
            'name' => $post['name'],
            //'type' => $post['type'],
            'identification' => $post['identification'],
            'identification_copy' => $filename,
            'user_id' => $this->user_id,
            'created' => CURRENT_DATETIME
        );
        
        if(DB::table('representatives')->insert($datas) == 1)
        {
            if($this->locale == "es"){
                return Redirect::to('/es/admin/shareHolders/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('admin/shareHolders/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }
    }

    public function shareHolders(Request $request)
    {
        $query = DB::table('representatives')->where('representatives.user_id', '=', $this->user_id);
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->Where(function ($query) {
                $query->orwhere('representatives.name', 'LIKE','%'.$_GET['search'].'%')
                      ->orwhere('representatives.type','LIKE','%'.$_GET['search'].'%')
                      ->orwhere('representatives.identification','LIKE','%'.$_GET['search'].'%');
            });
        }
        $result = $query->select('representatives.*')->paginate(PAGENATE);
        return view('admin.shareHolder.view')->with('data',$result);
    }

    public function geteditShareHolders($id)
    {
        if(!isset($id) && empty($id)){

            return Redirect::to('admin/shareHolders/View');
        }
        
        $result = DB::table('representatives')->select('representatives.*')->where('representatives.representative_id','=',$id)
            ->first();
        return view('admin.shareHolder.edit')->with('data',$result);
    }
    public function editShareHolders(Request $request)
    {
        $input = Input::all();
        $file = Input::file('identification_copy');
        $post = $request->all();
        $this->validate($request, [
            'name' => 'required',
           // 'type' => 'required',
            'identification' => 'required'
        ]);
        if(isset($file) && $file !=null){
            $Orname = $file->getClientOriginalName();
            $destination_path='identification_copy/';
            $filename= str_random(6).'_'.$Orname;
            $file->move($destination_path,$filename);
            //$image = Image::make(sprintf('identification_copy/%s', $filename))->resize(500, 500)->save();

            if(@$_FILES['identification_copy']){
                if($_FILES['identification_copy']['type']=="image/png" || $_FILES['identification_copy']['type']=="image/jpg" || $_FILES['identification_copy']['type']=="image/jpeg"){
                    $image = Image::make(sprintf('identification_copy/%s', $filename))->resize(500, 500)->save();
                }
            }


            $datas = array(
                'identification_copy' => $filename,
                'modified' => CURRENT_DATETIME
            );
            DB::table('representatives')->where('representative_id', $post['representative'])->update($datas);
        }
        $datas = array(
            'name' => $post['name'],
            //'type' => $post['type'],
            'identification' => $post['identification'],
            'modified' => CURRENT_DATETIME
        );
        DB::table('representatives')->where('representative_id', $post['representative'])->update($datas);
        if($this->locale=="es"){
            return Redirect::to('/es/admin/shareHolders/View')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('admin/shareHolders/View')->with('success',$this->freightforwarderMsg['update']);
        }
    }
    // Finantial Information
    // public function finantialInformation(Request $request)
    // {
    //     $result = DB::table('representatives')->join('users', 'representatives.user_id', '=', 'users.id')
    //         ->select('representatives.*')->first();
    //     return view('admin.shareHolder.finantialInformation.view')->with('data',$result);
    // }

    public function geteditFinantialInformation()
    {
        $result = DB::table('finantial_informations')->select('finantial_informations.*')->where('finantial_informations.user_id','=',$this->user_id)
            ->first();
        return view('admin.shareHolder.finantialInformation.edit')->with('data',$result);
    }
    public function editFinantialInformation(Request $request)
    {
        $post = $request->all();
        $this->validate($request, [
            'economic' => 'required',
            'capital' => 'required',
            'source_fund' => 'required',
            'way_pay' => 'required',
            'financial' => 'required',
        ]);

        $datas = array(
            'economic_activity' => $post['economic'],
            'registered_capital' => $post['capital'],
            'funds_source' => $post['source_fund'],
            'pay_way' => $post['way_pay'],
            'financial_institution' => $post['financial'],
            'modified' => CURRENT_DATETIME
        );
        DB::table('finantial_informations')->where('user_id','=', $this->user_id)->update($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/finantialInformation/Edit')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('admin/finantialInformation/Edit')->with('success',$this->freightforwarderMsg['update']); 
        }
    }

    //Airports
    public function viewAirports()
    {
        $col_country_id = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->where('title','=','Colombia')->first();
        $result = DB::table('airports')->select('airports.*')->where('airports.country_id','=',$col_country_id->country_id)->paginate(ADMIN_PAGENATE);
        return view('admin.Airports.view')->with('data',$result);
    }
    
    public function getAirports()
    {

        $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->where('title','=','Colombia')->get();
        $newresult['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->where('country_id','=',$newresult['countries']['0']->country_id)->orderBy( 'title' )->get();
        $condition = '=';
        $value = 0;
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ $condition = "="; $value = $_GET['edit'];}
        //dd(implode(',', $condition));
        $edit = DB::table('airports')->where('airports.airport_id', $condition, $value)->
        select('airports.*')->first();
        $query = DB::table('airports')->select('airports.*')->where('country_id','=',$newresult['countries']['0']->country_id);
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
        return view('admin.airports.add')->with('airports',$newresult);
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
            'city_id' => $input['city_id'],
            'company_id'=>$this->company_id,
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
            return Redirect::to('admin/airports')->with('success',$message);
        }
    }
    public function getTerminals()
    {

        $newresult['countries'] = DB::table('countries')->select('countries.country_id','countries.title')->where('is_active','=','1')->orderBy( 'title' )->get();
        //$newresult['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('is_active','=','1')->where('country_id','=',$newresult['countries']['0']->country_id)->orderBy( 'title' )->get();
        $condition = '=';
        $value = 0;
        $edit = array();
        if(isset($_GET['edit']) && !empty($_GET['edit'])){ 
            $condition = "="; $value = $_GET['edit'];
            $edit = DB::table('terminals')->where('terminals.terminal_id', $condition, $value)->select('terminals.*')->first();
            $newresult['ports'] = DB::table('ocean_ports')->where('ocean_ports.country_id', '=', $edit->country_id)->select('ocean_ports.*')->get();
            //dd($newresult['ports']);
        }
        //dd(implode(',', $condition));
        
        //dd($edit);
        $query = DB::table('terminals')
                 ->select('terminals.*','countries.title as tcountry','ocean_ports.port_title as tport')
                 ->join('countries', 'countries.country_id', '=', 'terminals.country_id')
                 ->join('ocean_ports', 'ocean_ports.ocean_port_id', '=', 'terminals.ocean_port_id')
                 ->orderBy('countries.title')
                 ->orderBy('ocean_ports.port_title')
                 ->orderBy('terminals.title');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->orwhere('countries.title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('ocean_ports.port_title','LIKE','%'.$_GET['search'].'%');
            $query = $query->orwhere('terminals.title','LIKE','%'.$_GET['search'].'%');
            if (strpos('Approved', $_GET['search']) !== false || strpos('approved', $_GET['search']) !== false) {
                $query = $query->orwhere('terminals.is_active','=', 1);
            }
            if (strpos('Decline', $_GET['search']) !== false || strpos('decline', $_GET['search']) !== false) {
                $query = $query->orwhere('terminals.is_active','=', 2);
            }
        }

        $newresult['result'] = $query->paginate(ADMINISTRATOR_PAGENATE);
        //dd($newresult);
        $newresult['edit']= $edit;
        return view('admin.terminals.add')->with('terminals',$newresult);
    }

    public function addTerminals(Request $request)
    {
        //dd($request);
        $input = Input::all();
        $id = Auth::user()->id;
        $this->validate($request, [
            'title' => 'required',
            'country_id' => 'required',
            'ocean_port_id' => 'required',
        ]);

        $datas = array(
            'title' => $input['title'],
            'country_id' => $input['country_id'],
            'ocean_port_id' => $input['ocean_port_id'],
            'company_id'=>$this->company_id,
        );
        //dd($datas);
        if(isset($input['update']) && !empty($input['update'])){
            //$datas['modified'] = CURRENT_DATETIME;
            $return = DB::table('terminals')->where('terminal_id', $input['update'])->update($datas);
            $message = $this->freightforwarderMsg['update'];
        }else{
            $datas['created'] = CURRENT_DATETIME;
            $return = DB::table('terminals')->insert($datas);
            $message = $this->freightforwarderMsg['success'];
        }
        if($return == 1)
        {
            if($this->locale == "es"){
                return Redirect::to('/es/admin/terminals')->with('success',$message);
            }else{
                return Redirect::to('admin/terminals')->with('success',$message); 
            }
        }
    }
}
