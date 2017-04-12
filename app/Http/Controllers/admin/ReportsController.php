<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Mail;
use App;
class ReportsController extends Controller
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
        $this->incoterm = \Config::get('constants.incoterm');
        $this->before(Auth::user()->group_id);
        $this->locale = App::getLocale();
        $this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
        //$this->freightforwarderMsg = \Config::get('constants.freight-forwarder');
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

    public function index($search_id=NULL){
        //dd('sd');
        if(@$search_id){
            $data = DB::table('searches')
                    ->join('quotes', 'quotes.search_id', '=', 'searches.search_id')
                    ->join('payment', 'payment.quote_id', '=', 'quotes.quote_id')
                    ->leftjoin('reports', 'reports.search_id', '=', 'searches.search_id')
                    ->where('searches.search_id','=',$search_id)
                    ->select('reports.*','payment.*','quotes.*','searches.*')
                    ->first();
            if(@$data){
                return view('admin.reports.index')->with('data1',$data);   
            }
        } 

        $data = DB::table('quotes')
                    ->join('searches', 'quotes.search_id', '=', 'searches.search_id')
                    ->join('payment', 'payment.quote_id', '=', 'quotes.quote_id')
                    // ->leftjoin('reports', 'reports.search_id', '=', 'searches.search_id')
                    ->where('quotes.final_payment','=','1')
                    ->where('payment.mode','=','FINAL')
                    ->where('searches.ff_id','=',$this->user_id)
                    ->select('quotes.*','searches.*','payment.booking_number')
                 ->get();  
        //dd($data);    
       return view('admin.reports.index')->with('data',$data); 
    }

    public function getreports(Request $request){
        $post = $request->all();
        //dd($post);
        $data = DB::table('payment')
                    ->join('quotes', 'quotes.quote_id', '=', 'payment.quote_id')
                    ->join('searches', 'quotes.search_id', '=', 'searches.search_id')
                    ->where('payment.booking_number','=',$post['booking_number'])
                    ->select('payment.*','quotes.*','searches.*')
                    ->first();
        //dd($data);            
        if(@$data){
            if($this->locale == "es"){
                return Redirect::to("/es/admin/reports/".$data->search_id);
            }else{
                return Redirect::to("/admin/reports/".$data->search_id);
            }
        }else{
            if($this->locale == "es"){
                return Redirect::to("/es/admin/reports/index")->with('error',$this->freightforwarderMsg['not_found']);
            }else{
                return Redirect::to("/admin/reports/index")->with('error',$this->freightforwarderMsg['not_found']);
            }
        }
        //dd($data);
    }

    public function addreports(Request $request){
        $post = $request->all();
        //dd($post);

        if(isset($post['cargo_pickup_eta_date']) && (@$post['cargo_pickup_eta_date'])){
            $data['cargo_pickup_eta_date'] = date("Y-m-d",strtotime($post['cargo_pickup_eta_date']));
        }else{
            $data['cargo_pickup_eta_date'] = "";
        }

        if(isset($post['cargo_pickup_eta_time'])){
            $data['cargo_pickup_eta_time'] = $post['cargo_pickup_eta_time'];
        }
        if(isset($post['pickup_trucking_company'])){
            $data['pickup_trucking_company'] = $post['pickup_trucking_company'];
        }
        if(isset($post['pickup_license_plate'])){
            $data['pickup_license_plate'] = $post['pickup_license_plate'];
        }
        if(isset($post['pickup_driver_name'])){
            $data['pickup_driver_name'] = $post['pickup_driver_name'];
        }
        if(isset($post['pickup_drivers_id'])){
            $data['pickup_drivers_id'] = $post['pickup_drivers_id'];
        }
        
        if(isset($post['cargo_pickup_ata_date']) && (@$post['cargo_pickup_ata_date'])){
            $data['cargo_pickup_ata_date'] = date("Y-m-d",strtotime($post['cargo_pickup_ata_date']));
        }else{
            $data['cargo_pickup_ata_date'] = "";
        }

        if(isset($post['cargo_pickup_ata_time'])){
            $data['cargo_pickup_ata_time'] = $post['cargo_pickup_ata_time'];
        }
        if(isset($post['port_eta_date']) && (@$post['port_eta_date'])){
            $data['port_eta_date'] = date("Y-m-d",strtotime($post['port_eta_date']));
        }else{
            $data['port_eta_date'] = "";
        }
        if(isset($post['port_eta_time'])){
            $data['port_eta_time'] = $post['port_eta_time'];
        }

        if(isset($post['pickup_port_ata_date']) && (@$post['pickup_port_ata_date'])){
            $data['pickup_port_ata_date'] = date("Y-m-d",strtotime($post['pickup_port_ata_date']));
            
        }else{
            $data['pickup_port_ata_date'] = "";
        }

        if(isset($post['pickup_port_ata_time'])){
            $data['pickup_port_ata_time'] = $post['pickup_port_ata_time'];
        }
        if(isset($post['destination_port_ata_date']) && (@$post['destination_port_ata_date'])){
            $data['destination_port_ata_date'] = date("Y-m-d",strtotime($post['destination_port_ata_date']));
            
        }else{
            $data['destination_port_ata_date'] = "";
        }

        if(isset($post['destination_port_ata_time'])){
            $data['destination_port_ata_time'] = $post['destination_port_ata_time'];
        }
        if(isset($post['port_etd_date']) && (@$post['port_etd_date'])){
            $data['port_etd_date'] = date("Y-m-d",strtotime($post['port_etd_date']));
        }else{
            $data['port_etd_date'] = "";
        }
        if(isset($post['port_etd_time'])){
            $data['port_etd_time'] = $post['port_etd_time'];
        }
        
        if(isset($post['port_atd_date']) && (@$post['port_atd_date'])){
            $data['port_atd_date'] = date("Y-m-d",strtotime($post['port_atd_date']));
        }else{
            $data['port_atd_date'] = "";
        }

        if(isset($post['port_atd_time'])){
            $data['port_atd_time'] = $post['port_atd_time'];
        }
        if(isset($post['bl_awb'])){
            $data['bl_awb'] = $post['bl_awb'];
        }
        if(isset($post['voyage'])){
            $data['voyage'] = $post['voyage'];
        }
        if(isset($post['container_id'])){
            $data['container_id'] = $post['container_id'];
        }

        if(isset($post['destination_port_eta_date']) && (@$post['destination_port_eta_date'])){
            $data['destination_port_eta_date'] = date("Y-m-d",strtotime($post['destination_port_eta_date']));
        }else{
            $data['destination_port_eta_date'] = "";
        }

        if(isset($post['destination_port_eta_time'])){
            $data['destination_port_eta_time'] = $post['destination_port_eta_time'];
        }

        if(isset($post['eta_delivery_date']) && (@$post['eta_delivery_date'])){
            $data['eta_delivery_date'] = date("Y-m-d",strtotime($post['eta_delivery_date']));
        }else{
            $data['eta_delivery_date'] = "";
        }

        if(isset($post['eta_delivery_time'])){
            $data['eta_delivery_time'] = $post['eta_delivery_time'];
        }
        if(isset($post['delivery_trucking_company'])){
            $data['delivery_trucking_company'] = $post['delivery_trucking_company'];
        }
        if(isset($post['delivery_license_plate'])){
            $data['delivery_license_plate'] = $post['delivery_license_plate'];
        }
        if(isset($post['delivery_driver_name'])){
            $data['delivery_driver_name'] = $post['delivery_driver_name'];
        }
        if(isset($post['delivery_drivers_id'])){
            $data['delivery_drivers_id'] = $post['delivery_drivers_id'];
        }

        if(isset($post['cargo_pickup_delivery_ata_date']) && (@$post['cargo_pickup_delivery_ata_date'])){
            $data['cargo_pickup_delivery_ata_date'] = date("Y-m-d",strtotime($post['cargo_pickup_delivery_ata_date']));
        }else{
            $data['cargo_pickup_delivery_ata_date'] = "";
        }

        if(isset($post['cargo_pickup_delivery_ata_time'])){
            $data['cargo_pickup_delivery_ata_time'] = $post['cargo_pickup_delivery_ata_time'];
        }

        if(isset($post['cargo_delivery_eta_date']) && (@$post['cargo_delivery_eta_date'])){
            $data['cargo_delivery_eta_date'] = date("Y-m-d",strtotime($post['cargo_delivery_eta_date']));
        }else{
            $data['cargo_delivery_eta_date'] = "";
        }

        if(isset($post['cargo_delivery_eta_time'])){
            $data['cargo_delivery_eta_time'] = $post['cargo_delivery_eta_time'];
        }
        if(isset($post['cargo_delivery_ata_date']) && (@$post['cargo_delivery_ata_date'])){
            $data['cargo_delivery_ata_date'] = date("Y-m-d",strtotime($post['cargo_delivery_ata_date']));
        }else{
            $data['cargo_delivery_ata_date'] = "";
        }

        if(isset($post['cargo_delivery_ata_time'])){
            $data['cargo_delivery_ata_time'] = $post['cargo_delivery_ata_time'];
        }
        if(isset($post['status1'])){
            $data['status1'] = $post['status1'];
        }
        if(isset($post['status2'])){
            $data['status2'] = $post['status2'];
        }
        if(isset($post['status3'])){
            $data['status3'] = $post['status3'];
        }
        if(isset($post['status4'])){
            $data['status4'] = $post['status4'];
        }
        if(isset($post['status5'])){
            $data['status5'] = $post['status5'];
        }
        if(isset($post['status6'])){
            $data['status6'] = $post['status6'];
        }
        if(isset($post['status7'])){
            $data['status7'] = $post['status7'];
        }
        if(isset($post['document_flow_document'])){
            $data['document_flow_document'] = $post['document_flow_document'];
        }
        if(isset($post['origin_impo_expo_custom'])){
            $data['origin_impo_expo_custom'] = $post['origin_impo_expo_custom'];
        }
        if(isset($post['destination_impo_expo_custom'])){
            $data['destination_impo_expo_custom'] = $post['destination_impo_expo_custom'];
        }

        //dd($data);
        $user =  DB::table('searches')
                ->join('users','users.id','=','searches.user_id')
                ->where('searches.search_id','=',$post['search_id'])
                ->select('users.*')
                ->first();
        //dd($post);
        if(@$post['submit_status1']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : ORIGIN PICK UP';
            $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>CARGO PICK-UP ETA: </b>".date('F d, Y H:i A',strtotime($post['cargo_pickup_eta_date']." ".$post['cargo_pickup_eta_time']))."</p>";
            $emaildata['html'] .= "<p><b>TRUCKING COMPANY: </b>".$post['pickup_trucking_company']."</p>";
            $emaildata['html'] .= "<p><b>LICENSE PLATE: </b>".$post['pickup_license_plate']."</p>";
            $emaildata['html'] .= "<p><b>DRIVER'S NAME: </b>".$post['pickup_driver_name']."</p>";
            $emaildata['html'] .= "<p><b>DRIVERS ID: </b>".$post['pickup_drivers_id']."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status1']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d');
        }

        if(@$post['submit_status2']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : PRE-CARRIAGE';
            $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>CARGO PICK-UP ATA: </b>".date('F d, Y H:i A',strtotime($post['cargo_pickup_ata_date']." ".$post['cargo_pickup_ata_time']))."</p>";
            $emaildata['html'] .= "<p><b>AIRPORT/PORT ETA: </b>".date('F d, Y H:i A',strtotime($post['port_eta_date']." ".$post['port_eta_time']))."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status2']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d');
        }
        if(@$post['submit_status3']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : DEPARTURE';
            $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>AIRPORT/PORT ATA: </b>".date('F d, Y H:i A',strtotime($post['pickup_port_ata_date']." ".$post['pickup_port_ata_time']))."</p>";
            $emaildata['html'] .= "<p><b>DAYS SINCE ARRIVAL: </b>".$post['days_arrival']."</p>";
            $emaildata['html'] .= "<p><b>AIRPORT/PORT ETD: </b>".date('F d, Y H:i A',strtotime($post['port_etd_date']." ".$post['port_etd_time']))."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status3']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d');
        }

        if(@$post['submit_status4']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : DESTINATION ARRIVAL';
           $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>AIRPORT/PORT ATD: </b>".date('F d, Y H:i A',strtotime($post['port_atd_date']." ".$post['port_atd_time']))."</p>";
            $emaildata['html'] .= "<p><b>BL / AWB #: </b>".$post['bl_awb']."</p>";
            $emaildata['html'] .= "<p><b>VOYAGE: </b>".$post['voyage']."</p>";
            $emaildata['html'] .= "<p><b>CONTAINER ID: </b>".$post['container_id']."</p>";
            $emaildata['html'] .= "<p><b>DESTINATION PORT ETA: </b>".date('F d, Y H:i A',strtotime($post['destination_port_eta_date']." ".$post['destination_port_eta_time']))."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status4']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d'); 
        }

        if(@$post['submit_status5']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : TERMINAL PICK UP';
            $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>AIRPORT/PORT ATA: </b>".date('F d, Y H:i A',strtotime($post['destination_port_ata_date']." ".$post['destination_port_ata_time']))."</p>";
            $emaildata['html'] .= "<p><b>DAYS SINCE ARRIVAL: </b>".$post['date_a']."</p>";
            $emaildata['html'] .= "<p><b>ETA DELIVERY CHARGE: </b>".date('F d, Y H:i A',strtotime($post['eta_delivery_date']." ".$post['eta_delivery_time']))."</p>";
            $emaildata['html'] .= "<p><b>TRUCKING COMPANY: </b>".$post['delivery_trucking_company']."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status5']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d'); 
        }
        if(@$post['submit_status6']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : ON-CARRIAGE';
            $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>CARGO PICK-UP FOR DELIVERY ATA: </b>".date('F d, Y H:i A',strtotime($post['cargo_pickup_delivery_ata_date']." ".$post['cargo_pickup_delivery_ata_time']))."</p>";
            $emaildata['html'] .= "<p><b>CARGO DELIVERY ETA: </b>".date('F d, Y H:i A',strtotime($post['cargo_delivery_eta_date']." ".$post['cargo_delivery_eta_time']))."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status6']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d'); 
        }
        if(@$post['submit_status7']){

            $view = 'emails.forwarder.additional_services'; 
            $emaildata['name'] = $user->name;
            $emaildata['user_email'] = $user->email;
            $emaildata['subject'] ='Status : DESTINATION DELIVERY';
            $emaildata['html']  = "<p><b>Booking Number: </b>".$post['booking_number']."</p>";
            $emaildata['html'] .= "<p><b>CARGO DELIVERY ATA: </b>".date('F d, Y H:i A',strtotime($post['cargo_delivery_ata_date']." ".$post['cargo_delivery_ata_time']))."</p>";
            $emaildata['html'] .= "<p><b>STATUS: </b>".$post['status7']."</p>";
            //}
            Mail::send($view, $emaildata, function ($message) use($emaildata){
               //$pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                $message->to($emaildata['user_email'])->subject($emaildata['subject']);
               //$message->attach($pathToFile);
            });
           //die('d'); 
        }

         
        //dd($post);
        //dd($data);
        // If file
        $file = Input::file('proof_user_approval');
        //dd($file); 
        $full_filename="";
        if(@$file){
           $Orname = $file->getClientOriginalName();
           $filename= str_random(6).'_'.$Orname;
           $imageName = $file->getClientOriginalName();
           $destination_path = base_path() . '/public/proof/';
           $originalNameWithoutExt = substr($imageName, 0, strlen($imageName) - 4);
           $extension = $file->getClientOriginalExtension();
           $full_filename= $filename;
           
           if($file->move($destination_path,$full_filename)){
                $user =  DB::table('searches')
                    ->join('users','users.id','=','searches.user_id')
                    ->where('searches.search_id','=',$post['search_id'])
                    ->select('users.*')
                    ->first();
                //dd($full_filename);


                $data['proof_user_approval'] = $full_filename; 


               
               $view = 'emails.forwarder.additional_services'; 
               $emaildata['name'] = $user->name;
                $emaildata['user_email'] = $user->email;
                $emaildata['filename']  = $filename;
                if($this->locale == "es"){ 
                    $emaildata['subject'] ='PRUEBA AWB / BL PARA LA APROBACIÓN';
                    $emaildata['html'] = "<p>Encontrará el documento de 'PROOF AWB / BL FOR APPROVAL' adjunto</p>";
                    $emaildata['html'] .= "<p>Por favor, revise y envíeme el documento revisado final sobre <a href='".Auth::user()->email."'>".Auth::user()->email."</a></p>";
                }else{
                    $emaildata['subject'] ='PROOF AWB/BL FOR APPROVAL';
                    $emaildata['html'] = "<p>Please find the document for 'PROOF AWB/BL FOR APPROVAL' attached</p>";
                    $emaildata['html'] .= "<p>Kindly review and send me the final reviewed document on <a href='".Auth::user()->email."'>".Auth::user()->email."</a></p>";
                }
               Mail::send($view, $emaildata, function ($message) use($emaildata){
                   $pathToFile = BASE_URL.'/'.'proof/'.$emaildata['filename'];
                   $message->to($emaildata['user_email'])->subject($emaildata['subject']);
                   $message->attach($pathToFile);
               });



                  
           }

        }

        
        if(@$post['report_id']){

            if(DB::table('reports')->where('report_id',  $post['report_id'])->where('user_id', $this->user_id)->update($data)){
                return Redirect::to("/admin/reports/".$post['search_id'])->with('success',$this->freightforwarderMsg['update']);
                if($this->locale == "es"){
                    return Redirect::to("/es/admin/reports/".$post['search_id'])->with('success',$this->freightforwarderMsg['update']);
                }else{
                    return Redirect::to("/admin/reports/".$post['search_id'])->with('success',$this->freightforwarderMsg['update']);
                }
            }

        }else{
            $ff_id =  DB::table('searches')
                    ->where('searches.search_id','=',$post['search_id'])
                    ->where('searches.ff_id','=',$this->user_id)
                    ->select('searches.ff_id')
                    ->first();
            if(@$ff_id){
                $data['search_id'] = $post['search_id'];
                $data['booking_number'] = $post['booking_number'];
                $data['user_id'] = $this->user_id;
            
                $report_id = DB::table('reports')->insertGetId($data);
                if($this->locale == "es"){
                    return Redirect::to("/es/admin/reports/".$post['search_id'])->with('success',$this->freightforwarderMsg['success']);
                }else{
                    return Redirect::to("/admin/reports/".$post['search_id'])->with('success',$this->freightforwarderMsg['success']);
                }
            } 
        }
        //dd("gfhfgh");
        if($this->locale == "es"){
            return Redirect::to("/es/admin/reports")->with('error',$this->freightforwarderMsg['not_found']);
        }else{
            return Redirect::to("/admin/reports")->with('error',$this->freightforwarderMsg['not_found']);
        }
        //dd($data);
    }


}