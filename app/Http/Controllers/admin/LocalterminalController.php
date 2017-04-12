<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App;
use App\Models\OceanLocalTerminalRate;
class LocalterminalController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

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

    // Terminal air rates
    public function viewLocalTerminalAir()
    {
        $query =  DB::table('local_terminal_air_rates')->where('local_terminal_air_rates.user_id', '=', $this->user_id)
            ->leftjoin('airports as oair', 'local_terminal_air_rates.origin_airport_id', '=', 'oair.airport_id')
            ->leftjoin('airports as dair', 'local_terminal_air_rates.destination_airport_id', '=', 'dair.airport_id')
            ->leftjoin('cities', 'local_terminal_air_rates.city_id', '=', 'cities.city_id')
            ->leftjoin('services', 'local_terminal_air_rates.service_id', '=', 'services.service_id')
            ->leftjoin('units', 'local_terminal_air_rates.unit_id', '=', 'units.unit_id')
            ->select('services.title as service','local_terminal_air_rates.*','cities.title as city','units.title as unit','oair.name as oname',
                'oair.iata_code as oiata_code','dair.name as dname','dair.name as diata_code');
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $query = $query->Where(function ($query) {
                $query->orwhere('cities.title','LIKE','%'.$_GET['search'].'%')
                ->orwhere('services.title','LIKE','%'.$_GET['search'].'%')
                ->orwhere('units.title','LIKE','%'.$_GET['search'].'%')
                //->orwhere('local_terminal_air_rates.service_id','LIKE','%'.$_GET['search'].'%')
                ->orwhere('local_terminal_air_rates.service','LIKE','%'.$_GET['search'].'%')
                ->orwhere('local_terminal_air_rates.unit_id','LIKE','%'.$_GET['search'].'%')
                ->orwhere('local_terminal_air_rates.load_rate','LIKE','%'.$_GET['search'].'%')
                ->orwhere('local_terminal_air_rates.discharge_rate','LIKE','%'.$_GET['search'].'%')
                ->orwhere('local_terminal_air_rates.airport_fee','LIKE','%'.$_GET['search'].'%')
                ->orwhere('local_terminal_air_rates.ground_charges','LIKE','%'.$_GET['search'].'%');
            });
        }
        $result = $query->paginate(PAGENATE);
        return view('admin.LocalTerminalAir.view')->with('data',$result);
    }
    public function getLocalTerminalAir()
    {
        $col_country = DB::table('countries')->select('country_id')->where('title','=','Colombia')->first();
        $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code','city_id')
            ->where('is_active','=','1')->where('country_id','=',$col_country->country_id)->get();
        foreach ($stats['airports'] as $airport) {
            $air_array[$airport->city_id] = $airport->city_id;
        }
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title','country_id')->where('is_active','=','1')
            ->where('country_id','=',$col_country->country_id)->whereIn('city_id',$air_array)->get();
        $stats['services'] = DB::table('services')->select('services.service_id','services.title')->where('is_active','=','1')->get();
        $stats['units'] = DB::table('units')->select('units.unit_id','units.title')->where('is_active','=','1')->get();
        return view('admin.LocalTerminalAir.add')->with('stats',$stats);
    }

    // UserController.php
    public function addLocalTerminalAir(Request $request) {
        $post = $request->all();
        
        $this->validate($request, [
            'origin_airport_id'=>'required',
            //'destination_airport_id'=>'required',
            'city_id' => 'required',
            'discharge_rate' => 'required|numeric',
            'load_rate' => 'required|numeric',
            'airport_fee' => 'numeric',
            'ground_charges' => 'numeric',
            'airport_transfer' => 'numeric',
            //'airport_transfer_min' => 'numeric',
            'consolidation' => 'numeric',
            //'minimum_consolidation' => 'numeric',
            'deconsolidation' => 'numeric',
            //'minimum_deconsolidation' => 'numeric',
            'minimum_value' => 'numeric',
        ]);

        $datas = array(
            'user_id'=> $this->user_id,
            'company_id'=> $this->company_id,
            'origin_airport_id'=>$post['origin_airport_id'],
            //'destination_airport_id'=>$post['destination_airport_id'],
            'city_id' => $post['city_id'],
            //'service_id' => $post['service'],
            'service' => $post['service'],
            'load_rate' => $post['load_rate'],            
            'discharge_rate' => $post['discharge_rate'],            
            'airport_fee' => $post['airport_fee'],            
            'ground_charges' => $post['ground_charges'],            
            'load_cur' => $post['load_cur'],
            'discharge_cur' => $post['discharge_cur'],
            'airport_cur' => $post['airport_cur'],
            'ground_cur' => $post['ground_cur'],                       
            //'minimum_deconsolidation_cur' => $post['minimum_deconsolidation_cur'],
            //'minimum_deconsolidation' => $post['minimum_deconsolidation'],            
            'deconsolidation_cur' => $post['deconsolidation_cur'],
            'deconsolidation' => $post['deconsolidation'],            
            //'minimum_consolidation_cur' => $post['minimum_consolidation_cur'],
            //'minimum_consolidation' => $post['minimum_consolidation'],            
            'consolidation_cur' => $post['consolidation_cur'],
            'consolidation' => $post['consolidation'],            
            //'airport_transfer_min_cur' => $post['airport_transfer_min_cur'],
            //'airport_transfer_min' => $post['airport_transfer_min'],
            'airport_transfer' => $post['airport_transfer'],            
            'airport_transfer_cur' => $post['airport_transfer_cur'],
            'minimum_value' => $post['minimum_value'], 
            'airport_transfer_unit' => $post['airport_transfer_unit'],            
            //'airport_transfer_min_unit' => $post['airport_transfer_min_unit'],
            'consolidation_unit' => $post['consolidation_unit'],
            //'minimum_consolidation_unit' => $post['minimum_consolidation_unit'],
            'deconsolidation_unit' => $post['deconsolidation_unit'],
            //'minimum_deconsolidation_unit' => $post['minimum_deconsolidation_unit'],
            'ground_unit' => $post['ground_unit'],
            'airport_unit' => $post['airport_unit'],
            'discharge_unit' => $post['discharge_unit'],
            'load_unit' => $post['load_unit'],
            'created' => CURRENT_DATETIME,
        );
        //dd($datas);
        if(DB::table('local_terminal_air_rates')->insert($datas)){
            if($this->locale == "es"){
                return Redirect::to('/es/admin/localTerminalAir/View')->with('success',$this->freightforwarderMsg['success']);
            }else{
                return Redirect::to('/admin/localTerminalAir/View')->with('success',$this->freightforwarderMsg['success']); 
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to('/es/admin/localTerminalAir/Add')->with('error',$this->freightforwarderMsg['error']);
            }else{
                return Redirect::to('/admin/localTerminalAir/Add')->with('error',$this->freightforwarderMsg['error']); 
            }
        }
    }

    public function deleteLocalTerminalAir($id)
    {
        $result = DB::table('local_terminal_air_rates')->select('local_terminal_air_rates.*')
            ->where('local_terminal_air_rates.local_terminal_air_rates_id','=',$id)->first();
        DB::table('local_terminal_air_rates')->where('local_terminal_air_rates.local_terminal_air_rates_id','=',$id)->delete();
        if($this->locale == "es"){
            return Redirect::to('/es/admin/localTerminalAir/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/localTerminalAir/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    public function geteditLocalTerminalAir($id)
    {
        if(!isset($id) && empty($id)){
            return Redirect::to('admin/localTerminalAir/View');
        }
        $stats['data'] = DB::table('local_terminal_air_rates')->select('local_terminal_air_rates.*')
            ->where('local_terminal_air_rates.local_terminal_air_rates_id','=',$id)->first();
        
        $col_country = DB::table('countries')->select('country_id')->where('title','=','Colombia')->first();
        $stats['airports'] = DB::table('airports')->select('airports.airport_id','airports.name','airports.iata_code','city_id')
            ->where('is_active','=','1')->where('country_id','=',$col_country->country_id)->get();
        foreach ($stats['airports'] as $airport) {
            $air_array[$airport->city_id] = $airport->city_id;
        }
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title','country_id')->where('is_active','=','1')
            ->where('country_id','=',$col_country->country_id)->whereIn('city_id',$air_array)->get();
        $stats['services'] = DB::table('services')->select('services.service_id','services.title')->where('is_active','=','1')->get();
        $stats['units'] = DB::table('units')->select('units.unit_id','units.title')->where('is_active','=','1')->get();
        
        return view('admin.LocalTerminalAir.edit')->with('stats',$stats);
    }
    public function editLocalTerminalAir(Request $request)
    {
        $post = $request->all();

        $this->validate($request, [
            'origin_airport_id'=>'required',
            //'destination_airport_id'=>'required',
            'city_id' => 'required',
            'discharge_rate' => 'required|numeric',
            'load_rate' => 'required|numeric',
            'airport_fee' => 'numeric',
            'ground_charges' => 'numeric',
            'airport_transfer' => 'numeric',
            //'airport_transfer_min' => 'numeric',
            'consolidation' => 'numeric',
            //'minimum_consolidation' => 'numeric',
            'deconsolidation' => 'numeric',
            //'minimum_deconsolidation' => 'numeric',
            'minimum_value' => 'numeric',
        ]);

        $datas = array(
            'user_id'=> $this->user_id,
            'company_id'=> $this->company_id,
            'origin_airport_id'=>$post['origin_airport_id'],
            //'destination_airport_id'=>$post['destination_airport_id'],
            'city_id' => $post['city_id'],
            //'service_id' => $post['service'],
            'service' => $post['service'],
            'load_rate' => $post['load_rate'],
            'discharge_rate' => $post['discharge_rate'],
            'airport_fee' => $post['airport_fee'],
            'ground_charges' => $post['ground_charges'],
            'load_cur' => $post['load_cur'],
            'discharge_cur' => $post['discharge_cur'],
            'airport_cur' => $post['airport_cur'],
            'ground_cur' => $post['ground_cur'],
            //'minimum_deconsolidation_cur' => $post['minimum_deconsolidation_cur'],
            //'minimum_deconsolidation' => $post['minimum_deconsolidation'],
            'deconsolidation_cur' => $post['deconsolidation_cur'],
            'deconsolidation' => $post['deconsolidation'],
            //'minimum_consolidation_cur' => $post['minimum_consolidation_cur'],
            //'minimum_consolidation' => $post['minimum_consolidation'],
            'consolidation_cur' => $post['consolidation_cur'],
            'consolidation' => $post['consolidation'],
            //'airport_transfer_min_cur' => $post['airport_transfer_min_cur'],
            //'airport_transfer_min' => $post['airport_transfer_min'],
            'airport_transfer' => $post['airport_transfer'],
            'airport_transfer_cur' => $post['airport_transfer_cur'],
            'minimum_value' => $post['minimum_value'], 
            'airport_transfer_unit' => $post['airport_transfer_unit'],            
            //'airport_transfer_min_unit' => $post['airport_transfer_min_unit'],
            'consolidation_unit' => $post['consolidation_unit'],
            //'minimum_consolidation_unit' => $post['minimum_consolidation_unit'],
            'deconsolidation_unit' => $post['deconsolidation_unit'],
            //'minimum_deconsolidation_unit' => $post['minimum_deconsolidation_unit'],
            'ground_unit' => $post['ground_unit'],
            'airport_unit' => $post['airport_unit'],
            'discharge_unit' => $post['discharge_unit'],
            'load_unit' => $post['load_unit'],
            'modified' => CURRENT_DATETIME,
        );
        DB::table('local_terminal_air_rates')->where('local_terminal_air_rates_id', $post['terminal_rates'])->update($datas);
        //dd($this->freightforwarderMsg);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/localTerminalAir/View')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('/admin/localTerminalAir/View')->with('success',$this->freightforwarderMsg['update']); 
        }
    }

    //Local terminal
    public function viewLocalTerminalCOL()
    {
        
        // $ocean_local_terminal_rates = OceanLocalTerminalRate::
        //                               join('cities', 'cities.city_id', '=', 'ocean_local_terminal_rates.city_id')
        //                             ->join('col_city_ports', 'col_city_ports.col_city_port_id', '=', 'ocean_local_terminal_rates.col_city_port_id')
        //                             ->select('ocean_local_terminal_rates.*','cities.title as city','col_city_ports.title as port')
        //                             ->where('ocean_local_terminal_rates.user_id','=',$this->user_id)
        //                             ->paginate(PAGENATE);


        $ocean_local_terminal_rates = OceanLocalTerminalRate::
                                      join('ocean_ports', 'ocean_ports.ocean_port_id', '=', 'ocean_local_terminal_rates.city_id')
                                    ->join('terminals', 'terminals.terminal_id', '=', 'ocean_local_terminal_rates.col_city_port_id')
                                    ->select('ocean_local_terminal_rates.*','ocean_ports.port_title as city','terminals.title as port')
                                    ->where('ocean_local_terminal_rates.user_id','=',$this->user_id)
                                    ->paginate(PAGENATE);
        
        // echo "<pre>";
        // $ocean_terminal_load_charges = $ocean_local_terminal_rates[0]->ocean_terminal_load_charges;
        // print_r($ocean_terminal_load_charges); 
        // echo "</pre>";
        // die;
        
        $stats['data'] = $ocean_local_terminal_rates;
        return view('admin.LocalTerminalCOL.view')->with('stats',$stats);
    }
    public function getLocalTerminalCOL()
    {
        $col_country = DB::table('countries')->select('country_id')->where('title','=','Colombia')->first();
        
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('country_id','=',$col_country->country_id)->whereIn('city_id',[6,5,13,19])->where('is_active','=','1')->get();
        
        $stats['col_city_ports'] = DB::table('col_city_ports')->select('col_city_ports.col_city_port_id','col_city_ports.title')->where('country_id','=',$col_country->country_id)->orderBy('title')->where('is_active','=','1')->get();
        
        $stats['ocean_ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
            ->orderBy('port_title')->where('country_id','=','42')->where('is_active','=','1')->get();
        
        //dd($stats['ocean_ports'] );
       //$ports = DB::table('ocean_ports')->where('country_id','=',$country_id)->orderBy('ocean_ports.port_title')->get();

        return view('admin.LocalTerminalCOL.add')->with('stats',$stats);
    }

    // UserController.php
    public function addLocalTerminalCOL(Request $request) {
        $post = $request->all();
        
        $id = Auth::user()->id;
        //dd($post);
        $this->validate($request, [
            //'ocean_port_id'=>'required',
            'city_id' => 'required',
            'col_city_port_id' => 'required',
            // 'destination' => 'required',
            'load_lcl' => 'required|numeric',
            'load_lcl_min' => 'required|numeric',
            'load_20' => 'required|numeric',
            'load_40' => 'required|numeric',
            'load_40hc' => 'required|numeric',
            'wharfage_lcl' => 'required|numeric',
            'wharfage_lcl_min' => 'required|numeric',
            'wharfage_20' => 'required|numeric',
            'wharfage_40' => 'required|numeric',
            'wharfage_40hc' => 'required|numeric',
            'terminal_lcl' => 'required|numeric',
            'terminal_lcl_min' => 'required|numeric',
            'terminal_20' => 'required|numeric',
            'terminal_40' => 'required|numeric',
            'terminal_40hc' => 'required|numeric',
            'consolidation_lcl' => 'required|numeric',
            'consolidation_lcl_min' => 'required|numeric',
            'deconsolidation_lcl' => 'required|numeric',
            'deconsolidation_lcl_min' => 'required|numeric',
            'local_port_charges_lcl' => 'required|numeric',
            'local_port_charges_20' => 'required|numeric',
            'local_port_charges_40' => 'required|numeric',
            'local_port_charges_40hc' => 'required|numeric',
            'minimum_value' => 'numeric',
        ]);
        //dd($post);
        $datas = array(
            'user_id' => $id,
            //'place'=>$post['place'],
            'city_id' => $post['city_id'],
            'col_city_port_id' => $post['col_city_port_id'],
            'minimum_value' => $post['minimum_value'],
            'created' =>CURRENT_DATETIME,
        );
        $ocean_local_terminal_rate_id = DB::table('ocean_local_terminal_rates')->insertGetId($datas);
        
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>1,
            'lcl' => $post['load_lcl'],
            'lcl_min' => $post['load_lcl_min'],
            'l20' => $post['load_20'],
            'l40' => $post['load_40'],
            '40hc' => $post['load_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>2,
            'lcl' => $post['wharfage_lcl'],
            'lcl_min' => $post['wharfage_lcl_min'],
            'l20' => $post['wharfage_20'],
            'l40' => $post['wharfage_40'],
            '40hc' => $post['wharfage_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>3,
            'lcl' => $post['terminal_lcl'],
            'lcl_min' => $post['terminal_lcl_min'],
            'l20' => $post['terminal_20'],
            'l40' => $post['terminal_40'],
            '40hc' => $post['terminal_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>4,
            'lcl' => $post['consolidation_lcl'],
            'lcl_min' => $post['consolidation_lcl_min'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>5,
            'lcl' => $post['deconsolidation_lcl'],
            'lcl_min' => $post['deconsolidation_lcl_min'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>6,
            'lcl' => $post['local_port_charges_lcl'],
            'l20' => $post['local_port_charges_20'],
            'l40' => $post['local_port_charges_40'],
            '40hc' => $post['local_port_charges_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/localTerminalCOL/View')->with('success',$this->freightforwarderMsg['success']);
        }else{
            return Redirect::to('/admin/localTerminalCOL/View')->with('success',$this->freightforwarderMsg['success']); 
        }
    }

    public function deleteLocalTerminalCOL($id)
    {
        //die($id);

        //$result = DB::table('local_terminal_air_rates')->select('local_terminal_air_rates.*')->where('local_terminal_air_rates.local_terminal_air_rates_id','=',$id)->first();
        DB::table('ocean_local_terminal_rates')->where('ocean_local_terminal_rates.ocean_local_terminal_rate_id','=',$id)->delete();
        DB::table('ocean_terminal_load_charges')->where('ocean_terminal_load_charges.ocean_local_terminal_rate_id','=',$id)->delete();
        if($this->locale == "es"){
            return Redirect::to('/es/admin/localTerminalCOL/View')->with('success',$this->freightforwarderMsg['delete']);
        }else{
            return Redirect::to('/admin/localTerminalCOL/View')->with('success',$this->freightforwarderMsg['delete']); 
        }
    }
    public function geteditLocalTerminalCOL($id)
    {
        $col_country = DB::table('countries')->select('country_id')->where('title','=','Colombia')->first();
        $stats['cities'] = DB::table('cities')->select('cities.city_id','cities.title')->where('country_id','=',$col_country->country_id)->whereIn('city_id',[6,5,13,19])->where('is_active','=','1')->get();
        



       // $stats['ocean_ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')->orderBy('port_title')->where('is_active','=','1')->get();

        $stats['ocean_ports'] = DB::table('ocean_ports')->select('ocean_ports.ocean_port_id','ocean_ports.port_title')
            ->orderBy('port_title')->where('country_id','=','42')->where('is_active','=','1')->get();
            
        $stats['ocean_local_terminal_rates'] = OceanLocalTerminalRate::
                                      join('cities', 'cities.city_id', '=', 'ocean_local_terminal_rates.city_id')
                                    ->join('col_city_ports', 'col_city_ports.col_city_port_id', '=', 'ocean_local_terminal_rates.col_city_port_id')
                                    ->select('ocean_local_terminal_rates.*','cities.title as city','cities.city_id as city_id','col_city_ports.title as port')
                                    ->find($id);
       // dd($stats['ocean_local_terminal_rates']);
        //$stats['col_city_ports'] = DB::table('col_city_ports')->where('city_id','=',$stats['ocean_local_terminal_rates']->city_id)->orderBy('col_city_ports.title')->get();
        $stats['col_city_ports'] = DB::table('terminals')->where('ocean_port_id','=',$stats['ocean_local_terminal_rates']->city_id)
                                   //->orderBy('col_city_ports.title')
                                   ->get();


        //dd($stats);
        //dd($stats['ocean_local_terminal_rates']->ocean_terminal_load_charges);
        return view('admin.LocalTerminalCOL.edit')->with('stats',$stats);
    }
    public function editLocalTerminalCOL(Request $request)
    {
        $post = $request->all();
        $this->validate($request, [
            'city_id' => 'required',
            'col_city_port_id' => 'required',
            'load_lcl' => 'required|numeric',
            'load_lcl' => 'required|numeric',
            'load_lcl_min' => 'required|numeric',
            'load_20' => 'required|numeric',
            'load_40' => 'required|numeric',
            'load_40hc' => 'required|numeric',
            'wharfage_lcl' => 'required|numeric',
            'wharfage_lcl_min' => 'required|numeric',
            'wharfage_20' => 'required|numeric',
            'wharfage_40' => 'required|numeric',
            'wharfage_40hc' => 'required|numeric',
            'terminal_lcl' => 'required|numeric',
            'terminal_lcl_min' => 'required|numeric',
            'terminal_20' => 'required|numeric',
            'terminal_40' => 'required|numeric',
            'terminal_40hc' => 'required|numeric',
            'consolidation_lcl' => 'required|numeric',
            'consolidation_lcl_min' => 'required|numeric',
            'deconsolidation_lcl' => 'required|numeric',
            'deconsolidation_lcl_min' => 'required|numeric',
            'local_port_charges_lcl' => 'required|numeric',
            'local_port_charges_20' => 'required|numeric',
            'local_port_charges_40' => 'required|numeric',
            'local_port_charges_40hc' => 'required|numeric',
            'minimum_value' => 'numeric',
        ]);
        $datas = array(
            'city_id' => $post['city_id'],
            'col_city_port_id' => $post['col_city_port_id'],
            'minimum_value' => $post['minimum_value'],
            'modified' => CURRENT_DATETIME,
        );
        
        DB::table('ocean_local_terminal_rates')->where('ocean_local_terminal_rate_id', $post['ocean_local_terminal_rate_id'])->update($datas);

        // Load Charges rate
        $ocean_local_terminal_rate_id = $post['ocean_local_terminal_rate_id'];
        DB::table('ocean_terminal_load_charges')->where('ocean_terminal_load_charges.ocean_local_terminal_rate_id','=',$ocean_local_terminal_rate_id)->delete();
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type' => 1,
            'lcl'  => $post['load_lcl'],
            'lcl_min'  => $post['load_lcl_min'],
            'l20'  => $post['load_20'],
            'l40'  => $post['load_40'],
            '40hc' => $post['load_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>2,
            'lcl' => $post['wharfage_lcl'],
            'lcl_min' => $post['wharfage_lcl_min'],
            'l20' => $post['wharfage_20'],
            'l40' => $post['wharfage_40'],
            '40hc' => $post['wharfage_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>3,
            'lcl' => $post['terminal_lcl'],
            'lcl_min' => $post['terminal_lcl_min'],
            'l20' => $post['terminal_20'],
            'l40' => $post['terminal_40'],
            '40hc' => $post['terminal_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>4,
            'lcl' => $post['consolidation_lcl'],
            'lcl_min' => $post['consolidation_lcl_min'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>5,
            'lcl' => $post['deconsolidation_lcl'],
            'lcl_min' => $post['deconsolidation_lcl_min'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);
        $datas = array(
            'ocean_local_terminal_rate_id' => $ocean_local_terminal_rate_id,
            'type'=>6,
            'lcl' => $post['local_port_charges_lcl'],
            'l20' => $post['local_port_charges_20'],
            'l40' => $post['local_port_charges_40'],
            '40hc' => $post['local_port_charges_40hc'],
        );
        DB::table('ocean_terminal_load_charges')->insert($datas);

        //dd($this->freightforwarderMsg);
        if($this->locale == "es"){
            return Redirect::to('/es/admin/localTerminalCOL/View')->with('success',$this->freightforwarderMsg['update']);
        }else{
            return Redirect::to('/admin/localTerminalCOL/View')->with('success',$this->freightforwarderMsg['update']); 
        }
       
    }

}
