<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use DB;

use Auth;

use File;

use Image;

use Illuminate\Support\Facades\Input;

use Session;

class RatingController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        //$this->middleware('auth');
        $this->locale = App::getLocale();
    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function rating(Request $request)

    {

        return view('importexport.index');

    }



    public function getRatingDetails()

    {

        $stats['ff'] = DB::table('users')->where('group_id','=','2')->select('id','name')->get();

        //dd($stats);

        return view('rating.rating')->with('stats',$stats);

    }



    public function addRatingDetails(Request $request)

    {

        $post = $request->all();
        // $this->validate($request, [

        //     'load_type' => 'required',

        //     'item.*.title' => 'required',

        // ]);

        $fileds = array('Friendliness_and_Service'=>'friendliness','Availability_of_Care'=>'availability','Technical_OF_Knowledge'=>'technical','Response_of_Times'=>'reponse',

          'Quality_of_Information_Provided'=>'quality_info','complaince_frequency'=>'complaince_frequency','Complaince_Itineraries'=>'complaince_itineraries',

          'Quality_Document_Processes'=>'quality_document','Fast_Answers'=>'fast_anwers','Competitivity_Fare'=>'competitivity_fare');

        $total=0;

        foreach ($fileds as $key => $value) {

            $total += $post[$key];

        }

        $maintotal = 5*count($fileds);

        $avg = $total / $maintotal *100;

        $rating = 5*$avg/100;

      // dd($total);

        //dd($avg);

        //dd($rating);

        $datas = array(

            'ff_id' => $post['ff'],

            'rating'=> $rating,

            'friendliness' => $post['Friendliness_and_Service'],

            'availability' => $post['Availability_of_Care'],

            'technical' => $post['Technical_OF_Knowledge'],

            'reponse' => $post['Response_of_Times'],

            'quality_info' => $post['Quality_of_Information_Provided'],

            'comment' => $post['comment'],

            'complaince_frequency' => $post['complaince_frequency'],

            'complaince_itineraries' => $post['Complaince_Itineraries'],

            'quality_document' => $post['Quality_Document_Processes'],

            'fast_anwers' => $post['Fast_Answers'],

            'competitivity_fare'=>$post['Competitivity_Fare'],

            'service_comment'=>$post['service_comment'],
            'reaction'=> $post['reaction'],
            'created' => CURRENT_DATETIME

        );

        if(DB::table('ratings')->insert($datas)){
            if($this->locale == "es"){  
                return Redirect::to("/es/home");
            }else{
                return Redirect::to("/home");
            }  
        }else{
            if($this->locale == "es"){  
                return Redirect::to("/es/rating/add");
            }else{
                return Redirect::to("/rating/add");
            }
            
        }

    }



    public function getQuality()

    {

        return view('rating.quality');

    }



    public function addQuality(Request $request)

    {

        // $post = $request->all();

        // $this->validate($request, [

        //     'include_pickup' => 'required',

        //     'include_delivery' => 'required',

        //     'origin_postal_code' => 'required_if:include_pickup,yes',

        //     'destination_postal_code' => 'required_if:include_delivery,yes',

        //     'origin_city_id' => 'required',

        //     'destination_city_id' => 'required',

        //     'origin_port_id' => 'required',

        //     'destination_port_id' => 'required',

        // ]);

        // foreach ($post as $key => $value) {

        //     Session::put($key, $value);

        // }

        // if (Auth::check()){

        //     $service = $request->session()->get('servicetype').'/search';

        //     return Redirect::to($service);

        // }else{

        //     return Redirect::to("user/login");

        // }

    }



}

