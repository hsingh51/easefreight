<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
class CronJobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendingFee(Request $request){
        $quotes = DB::table('quotes')->select('quotes.quote_id','quotes.search_id','quotes.additional_service_id','quotes.additional_info_id',
            'quotes.cargo_detail_id')->leftjoin('payment','payment.quote_id','=','quotes.quote_id')->whereNull('payment_id')->get();
    }

    public function additionalService(Request $request){
        $additional_services = DB::table('additional_services')->select('additional_services.search_id','additional_services.user_id')
            ->leftjoin('quotes','quotes.search_id','=','additional_services.search_id')->whereNull('quote_id')->get();
        dd($additional_services);
    }

    public function finalPayment(Request $request){
        // $additional_services = DB::table('additional_info')->select('additional_info.search_id','additional_info.user_id')
        //     ->join('quotes','quotes.search_id','=','additional_services.search_id')
        //     ->join('payment','payment.quote_id','=','quotes.quote_id')->whereNull('quote_id')
        //     ->where('')->get();
        $quotes = DB::table('quotes')->select('quotes.quote_id','quotes.search_id','quotes.additional_service_id','quotes.additional_info_id',
            'quotes.cargo_detail_id')->leftjoin('payment','payment.quote_id','=','quotes.quote_id')->whereNotNull('payment_id')->get();
        dd($additional_services);
    }

    public function discontinue(Request $request){
        $date = Carbon::now()->addDays('2')->format('Y-m-d');
        $itinerary = DB::table('itinerary')->join('users','users.id','=','itinerary.user_id')
            ->select('itinerary.discontinue_date','users.name','users.email','users.mobile','users.mobile')
            ->where('itinerary.discontinue_date','=',"$date")->get();
        $subject = "Itinerary Discontinue Date";
        $html = '<p>Your Itinerary Validation date going to expire in 2 Days. Please update discontinue date</p>';
        $view = 'emails.forwarder.discontinue';
        if(@$itinerary){
            $this->email($itinerary, $view, $html, $subject);
        }
        $itinerary_ofr = DB::table('itinerary_ofr')->join('users','users.id','=','itinerary.user_id')
            ->select('itinerary.discontinue_date','users.name','users.email','users.mobile','users.mobile')
            ->where('itinerary.discontinue_date','=',"$date")->get();
        if(@$itinerary_ofr){
            $this->email($itinerary, $view, $html, $subject);
        }
    }

    public function email($datas, $view, $html, $subject){
        foreach ($datas as $data) {
            $data['html'] = $html;
            $data['subject'] = $subject;
            Mail::send($view, $data, function ($message) use($data){
                $message->to($data['email'])->subject($data['subject']);
            });
        }
    }

}
