<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('welcome/{locale}', function ($locale) {
//     App::setLocale($locale);
//     return view('welcome');
//     //
// });
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
        Route::get('/', 'HomeController@index');
    //**************** Registration and login routes *********************/
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('emaillayout', 'UserController@emaillayout');   
        Route::get('user/pre-sign-up', 'UserController@getPreSignUp'); 
        Route::get('user/resetpassword', 'Auth\PasswordController@getEmail');
        Route::post('user/resetpassword', 'Auth\PasswordController@postEmail'); 
        Route::get('user/changepassword', 'Auth\PasswordController@getReset');
        Route::post('user/changepassword', 'Auth\PasswordController@postReset');   
        Route::post('user/pre-sign-up', 'UserController@postPreSignUp');
        Route::get('user/login', 'UserController@getLogin');   
        Route::post('user/login', 'UserController@postLogin');
        Route::get('user/register', 'UserController@getregister');
        Route::post('user/register', 'UserController@postregister'); 
        Route::get('user/detail', ['middleware' => 'auth','uses' =>'UserController@getProfile']); 
        Route::get('user/profile', ['middleware' => 'auth','uses' =>'UserController@profile']); 
        Route::post('user/profile', ['middleware' => 'auth','uses' =>'UserController@postprofile']); 
        Route::get('freight/register', 'admin\HomeController@getFreightRegister');
        Route::post('freight/register', 'admin\HomeController@freightRegister');
        Route::get('freight/success', 'admin\HomeController@successRegister');
        Route::get('freight/confirmation/{enc}/{ticket}', 'admin\HomeController@confirmation');
        Route::get('quote/response/{status?}/{codRespuesta?}/{paymentRef?}/{token?}/{numAprobacion?}/{fechaTransaccion?}', 'QuoteController@getResponse');
        Route::post('quote/response', 'QuoteController@postResponse');
        Route::post('quote/final_response', 'QuoteController@postfinalResponse');
    //**************** Close Registration and login routes *********************/
    
    //**************** Static page routes *********************/
        Route::get('about_us', 'HomeController@about_us');
        Route::get('track_qoute', 'HomeController@track_qoute');
        Route::get('services', 'HomeController@services');
        Route::get('tools', 'HomeController@tools');
        Route::get('news', 'HomeController@news');
        Route::get('contact_us', 'HomeController@contact_us');
        Route::post('contact_us', 'HomeController@post_contact_us');
        Route::get('how_to_cude', 'HomeController@how_to_cude');
        Route::get('conversion', 'HomeController@conversion');
    //**************** Close static page routes *********************/

    //**************** Filter Drop Downs and login routes *********************/
        Route::get('citybycountry/{country_id}', 'HomeController@citybycountry');
        Route::get('portbycity/{city_id}', 'HomeController@portbycity');
        Route::get('citybyports/{country_id}', 'HomeController@citybyports');
        Route::get('terminalbyport/{port_id}', 'HomeController@terminalbyport');
        Route::get('oceanPortBycity/{city_id}', 'HomeController@oceanPortBycity');
        Route::get('getCitiesByCountries/{country_id}', 'HomeController@getCitiesByCountries');
        Route::get('countries', 'HomeController@countries');
    //**************** Close Filter Drop Downs and login routes *********************/

    Route::get('importexport', 'ImportExportController@index');
    Route::post('importexport', 'ImportExportController@index');
    Route::post('servicesMaritime', 'ImportExportController@servicesMaritime');

    //**************** Air Freight Search Routes *********************/
        Route::get('airfreight/route', 'AirFreightController@getquantity');
        Route::post('airfreight/route', 'AirFreightController@route');
        Route::get('airfreight/{selected}/{services}', 'AirFreightController@index');
        Route::post('airfreight/quantity', 'AirFreightController@postquantity');
        Route::get('airfreight/search', 'AirFreightController@getsearch');
        Route::post('airfreight/search', 'AirFreightController@postsearch');
        //Route::post('airfreight/additional_info', ['middleware' => 'auth','uses' =>'AirFreightController@postadditionalinfo']);
    //**************** Close  Air Freight Search Routes *********************/
    //**************** Maritime Search Routes *********************/
        Route::get('containers/{selected}/{services}', 'MaritimeController@getContainerDetails');
        Route::post('containers/details', 'MaritimeController@addContainerDetails');
        Route::get('containers/transportation', 'MaritimeController@getTransportation');
        Route::post('containers/transportation', 'MaritimeController@transportation');
        Route::get('Maritime/search', 'MaritimeController@getsearch');
        Route::post('Maritime/search', 'MaritimeController@postsearch');
    //**************** Close Maritime Search Routes *********************/
    //**************** Rating Routes *********************/
        Route::get('rating/add', 'RatingController@getRatingDetails');
        Route::post('rating/add', 'RatingController@addRatingDetails');
        Route::get('rating/quality', ['middleware' => 'auth','uses' =>'RatingController@getQuality']);
        Route::post('rating/quality', ['middleware' => 'auth','uses' =>'RatingController@addQuality']);
    //**************** Close Maritime Search Routes *********************/

    Route::get('quote/additional_services/{search_id}/{add_services?}', ['middleware' => 'auth','uses' =>'QuoteController@getServices']);
    Route::post('quote/additional_services', ['middleware' => 'auth','uses' =>'QuoteController@postServices']);
    Route::post('quote/selectinfo', ['middleware' => 'auth','uses' =>'QuoteController@postInfo']);
    Route::get('quote/additional_info/{search_id}/{add_services?}/{add_info?}', ['middleware' => 'auth','uses' =>'QuoteController@getadditionalinfo']);
    Route::get('quote/international_insurance/{search_id}/{add_services?}/{add_info?}', ['middleware' => 'auth','uses' =>'QuoteController@getInternationalInsurance']);
    Route::post('quote/international_insurance', ['middleware' => 'auth','uses' =>'QuoteController@internationalInsurance']);
    Route::get('quote/quote_details/{search_id}/{add_services?}/{add_info?}', ['middleware' => 'auth','uses' =>'QuoteController@getQuote']);
    Route::post('quote/quote_details', ['middleware' => 'auth','uses' =>'QuoteController@postQuote']);
    Route::get('quote/booking/{search_id}', ['middleware' => 'auth','uses' =>'QuoteController@getBooking']);
    Route::post('quote/booking', ['middleware' => 'auth','uses' =>'QuoteController@postBooking']);
    Route::get('quote/payment/{search_id}', ['middleware' => 'auth','uses' =>'QuoteController@getpayment']);
    Route::get('quote/final_payment/{search_id}', ['middleware' => 'auth','uses' =>'QuoteController@getFinalPayment']);
    
    Route::post('authentication','QuoteController@authenticate');
    Route::get('quote/my_orders', ['middleware' => 'auth','uses' =>'QuoteController@MyOrders']);
    Route::get('quote/my_orders/{order_id}', ['middleware' => 'auth','uses' =>'QuoteController@getMyOrder']);
    Route::get('quote/orders/pending', ['middleware' => 'auth','uses' =>'QuoteController@MyPendingOrders']);
    Route::get('track/{search_id}', ['middleware' => 'auth','uses' =>'QuoteController@track']);
    Route::post('quote/track', ['middleware' => 'auth','uses' =>'QuoteController@trackQuote']);
    Route::get('download/{quote_id}/{type}', ['middleware' => 'auth','uses' =>'QuoteController@download']);
    Route::get('quote/delete/{quote_id}', ['middleware' => 'auth','uses' =>'QuoteController@deleteQuote']);
    Route::get('quote/htmltopdf/{search_id}/{add_services?}/{add_info?}', ['middleware' => 'auth','uses' =>'QuoteController@htmlToPdf']);
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('home', 'HomeController@index');
    Route::get('show', 'HomeController@show');
    Route::get('pendingFee', 'CronJobController@pendingFee');
    Route::get('additionalService', 'CronJobController@additionalService');
    Route::get('discontinue', 'CronJobController@discontinue');
    //Route::get('importexport', 'ImportExportController@index');
});

// Easy freight Admin penal routers
Route::group(['middleware' => ['web'],'prefix' => 'admin', 'namespace' => 'admin'], function () {
    if(!Auth::check()){
        Route::get('', 'HomeController@getLogin');   
        Route::post('', 'HomeController@postLogin');
    }
    Route::get('citybycountry/{country_id}', ['uses' => 'HomeController@citybycountry','as'   => 'rates']);
    Route::get('login', 'HomeController@getLogin');   
    Route::post('login', 'HomeController@postLogin');
    Route::get('getCitiesByCountries/{country_id}', ['uses' => 'HomeController@getCitiesByCountries','as'   => 'rates']);
    Route::get('airportbycountry/{country_id}', ['uses' => 'HomeController@getAirportsByCountries','as'   => 'rates']);

    Route::get('get_afrdates/{itinerary_id}/{limit?}', 'ItineraryController@get_afrdates');

    //Route::get('getCodeByCountries/{country_id}', ['uses' => 'HomeController@getCodeByCountries','as'   => 'rates']); 
});

Route::group(['middleware' => ['web','auth'],'prefix' => 'admin', 'namespace' => 'admin'], function () {
    //Home Controller
    Route::get('logout', 'HomeController@getLogout');
    
    //Dashboard Controller
    Route::get('dashboard', 'DashboardController@dashboard');
    Route::get('profile', 'DashboardController@getProfile');
    Route::post('update', 'DashboardController@update');
    Route::post('updatePicture', 'DashboardController@updatePicture');
    Route::post('changePassword', 'DashboardController@passwordChange');

    //Airports list
    Route::get('airports', ['uses' => 'DashboardController@getAirports','as'   => 'dashboard']);
    Route::post('airports', ['uses' => 'DashboardController@addAirports','as'   => 'dashboard']);

    //Terminal list
    Route::get('terminals', ['uses' => 'DashboardController@getTerminals','as'   => 'dashboard']);
    Route::post('terminals', ['uses' => 'DashboardController@addTerminals','as'   => 'dashboard']);

    //Share Holders
    Route::get('shareHolders/Add', ['uses' => 'DashboardController@getShareHolders','as'   => 'clientInformation']);
    Route::post('shareHolders/Add', ['uses' => 'DashboardController@saveShareHolders','as'   => 'clientInformation']);
    Route::get('shareHolders/View', ['uses' => 'DashboardController@shareHolders','as'   => 'clientInformation']);
    Route::get('shareHolders/Edit/{id}', ['uses' => 'DashboardController@geteditShareHolders','as'   => 'clientInformation']);
    Route::post('shareHolders/Edit', ['uses' => 'DashboardController@editShareHolders','as'   => 'clientInformation']);
    //Route::get('finantialInformation/View', ['uses' => 'DashboardController@finantialInformation','as'   => 'clientInformation']);
    Route::get('finantialInformation/Edit', ['uses' => 'DashboardController@geteditFinantialInformation','as'   => 'clientInformation']);
    Route::post('finantialInformation/Edit', ['uses' => 'DashboardController@editFinantialInformation','as'   => 'clientInformation']);
    
    //Security and Quality
    Route::get('securityQuality', ['uses' => 'DashboardController@getSecurityQuality','as'   => 'clientInformation']);
    Route::post('securityQuality', ['uses' => 'DashboardController@securityQuality','as'   => 'clientInformation']);
    Route::get('securityFinantialQuality', ['uses' => 'DashboardController@getSecurityFinantialQuality','as'   => 'clientInformation']);
    Route::post('securityFinantialQuality', ['uses' => 'DashboardController@securityFinantialQuality','as'   => 'clientInformation']);
    
    //person in charge
    Route::get('personInCharge/Add', ['uses' => 'DashboardController@personInCharge','as'   => 'clientInformation']);
    Route::post('personInCharge/Add', ['uses' => 'DashboardController@addpersonInCharge','as'   => 'clientInformation']);
    Route::get('personInCharge/View', ['uses' => 'DashboardController@viewPersonInCharge','as'   => 'clientInformation']);
    Route::get('personInCharge/Edit/{id}', ['uses' => 'DashboardController@geteditpersonInCharge','as'   => 'clientInformation']);
    Route::post('personInCharge/Edit', ['uses' => 'DashboardController@editpersonInCharge','as'   => 'clientInformation']);
    
    //Local terminal Air Rates
    Route::get('localTerminalAir/View', ['uses' => 'LocalterminalController@viewLocalTerminalAir','as'   => 'air_rates']);
    Route::get('localTerminalAir/Add', ['uses' => 'LocalterminalController@getLocalTerminalAir','as'   => 'air_rates']);
    Route::post('localTerminalAir/Add', ['uses' => 'LocalterminalController@addLocalTerminalAir','as'   => 'air_rates']);
    Route::get('localTerminalAir/Edit/{id}', ['uses' => 'LocalterminalController@geteditLocalTerminalAir','as'   => 'air_rates']);
    Route::post('localTerminalAir/Edit', ['uses' => 'LocalterminalController@editLocalTerminalAir','as'   => 'air_rates']);
    Route::get('localTerminalAir/Delete/{id}', ['uses' => 'LocalterminalController@deleteLocalTerminalAir','as'   => 'air_rates']);

    //Local terminal Rates
    Route::get('localTerminalCOL/View', ['uses' => 'LocalterminalController@viewLocalTerminalCOL','as'   => 'rates']);
    Route::get('localTerminalCOL/Add', ['uses' => 'LocalterminalController@getLocalTerminalCOL','as'   => 'rates']);
    Route::post('localTerminalCOL/Add', ['uses' => 'LocalterminalController@addLocalTerminalCOL','as'   => 'rates']);
    Route::get('localTerminalCOL/Edit/{id}', ['uses' => 'LocalterminalController@geteditLocalTerminalCOL','as'   => 'rates']);
    Route::post('localTerminalCOL/Edit', ['uses' => 'LocalterminalController@editLocalTerminalCOL','as'   => 'rates']);
    Route::get('localTerminalCOL/Delete/{id}', ['uses' => 'LocalterminalController@deleteLocalTerminalCOL','as'   => 'rates']);

    //Route AFR
    Route::get('routeAFR/View', ['uses' => 'RouteController@viewAFRRoute','as'   => 'route']);
    Route::get('routeAFR/Add', ['uses' => 'RouteController@getAFRRoute','as'   => 'route']);
    Route::post('routeAFR/Add', ['uses' => 'RouteController@addAFRRoute','as'   => 'route']);
    Route::get('routeAFR/Edit/{id}', ['uses' => 'RouteController@geteditAFRRoute','as'   => 'route']);
    Route::post('routeAFR/Edit', ['uses' => 'RouteController@editAFRRoute','as'   => 'route']);
    Route::get('routeAFR/Delete/{id}', ['uses' => 'RouteController@deleteAFRRoute','as'   => 'route']);

    //Route Ocean
    Route::get('routeOcean/View', ['uses' => 'RouteController@viewOceanRoute','as'   => 'route']);
    Route::get('routeOcean/Add', ['uses' => 'RouteController@getOceanRoute','as'   => 'route']);
    Route::post('routeOcean/Add', ['uses' => 'RouteController@addOceanRoute','as'   => 'route']);
    Route::get('routeOcean/Edit/{id}', ['uses' => 'RouteController@geteditOceanRoute','as'   => 'route']);
    Route::post('routeOcean/Edit', ['uses' => 'RouteController@editOceanRoute','as'   => 'route']);
    Route::get('routeOcean/Delete/{id}', ['uses' => 'RouteController@deleteOceanRoute','as'   => 'route']);

    //Route Colombia
    Route::get('routeColombia/View', ['uses' => 'RouteController@viewColombiaRoute','as'   => 'route']);
    Route::get('routeColombia/Add', ['uses' => 'RouteController@getColombiaRoute','as'   => 'route']);
    Route::post('routeColombia/Add', ['uses' => 'RouteController@addColombiaRoute','as'   => 'route']);
    Route::get('routeColombia/Edit/{id}', ['uses' => 'RouteController@geteditColombiaRoute','as'   => 'route']);
    Route::post('routeColombia/Edit', ['uses' => 'RouteController@editColombiaRoute','as'   => 'route']);
    Route::get('routeColombia/Delete/{id}', ['uses' => 'RouteController@deleteColombiaRoute','as'   => 'route']);

    //Rates tarifasAFR
    Route::get('tarifasAFR/View', ['uses' => 'RateController@viewTarifasAFR','as'   => 'air_rates']);
    Route::get('tarifasAFR/Add/{route_id}/{id}/{route_result}', ['uses' => 'RateController@getTarifasAFR','as'   => 'air_rates']);
    Route::post('tarifasAFR/Add', ['uses' => 'RateController@addTarifasAFR','as'   => 'air_rates']);
    Route::get('tarifasAFR/Edit/{route_id}/{id}', ['uses' => 'RateController@geteditTarifasAFR','as'   => 'air_rates']);
    Route::post('tarifasAFR/Edit', ['uses' => 'RateController@editTarifasAFR','as'   => 'air_rates']);
    Route::get('tarifasAFR/Delete/{id}', ['uses' => 'RateController@deleteTarifasAFR','as'   => 'air_rates']);

    //Rates Ocean Lcl
    Route::get('oceanLCL/View', ['uses' => 'RateController@viewOceanLCL','as'   => 'rates']);
    Route::get('oceanLCL/Add/{route_id}/{id}/{route_result}', ['uses' => 'RateController@getOceanLCL','as'   => 'rates']);
    Route::post('oceanLCL/Add', ['uses' => 'RateController@addOceanLCL','as'   => 'rates']);
    Route::get('oceanLCL/Edit/{route_id}/{id}', ['uses' => 'RateController@geteditOceanLCL','as'   => 'rates']);
    Route::post('oceanLCL/Edit', ['uses' => 'RateController@editOceanLCL','as'   => 'rates']);
    Route::get('oceanLCL/Delete/{ocean_id}/{dest_id}/{org_id}/{for_id}/{other_id}', ['uses' => 'RateController@deleteOceanLCL','as'   => 'rates']);

    //Rates Ocean FCL
    Route::get('oceanFCL/View', ['uses' => 'RateController@viewOceanFCL','as'   => 'rates']);
    Route::get('oceanFCL/Add/{route_id}/{id}/{route_result}', ['uses' => 'RateController@getOceanFCL','as'   => 'rates']);
    Route::post('oceanFCL/Add', ['uses' => 'RateController@addOceanFCL','as'   => 'rates']);
    Route::get('oceanFCL/Edit/{route_id}/{id}', ['uses' => 'RateController@geteditOceanFCL','as'   => 'rates']);
    Route::post('oceanFCL/Edit', ['uses' => 'RateController@editOceanFCL','as'   => 'rates']);
    Route::get('oceanFCL/Delete/{ocean_id}/{dest_id}/{org_id}/{for_id}/{other_id}', ['uses' => 'RateController@deleteOceanFCL','as'   => 'rates']);


    //Route Itinerary 
    Route::get('routeItinerary/View', ['uses' => 'ItineraryController@viewRouteItinerary','as'   => 'itinerary']);
    Route::get('routeItinerary/Add/{rates_id}/{id}/{route_result}', ['uses' => 'ItineraryController@getRouteItinerary','as'   => 'itinerary']);
    Route::post('routeItinerary/Add', ['uses' => 'ItineraryController@addRouteItinerary','as'   => 'itinerary']);
    Route::get('routeItinerary/Select', ['uses' => 'ItineraryController@selectRouteItinerary','as'   => 'itinerary']);
    //Route::get('routeItinerary/getAirRoute', ['uses' => 'ItineraryController@getAirRoute','as'   => 'itinerary']);
    Route::post('routeItinerary/getAirRoute', ['uses' => 'ItineraryController@getAirRoute','as'   => 'itinerary']);
    Route::get('routeItinerary/Edit/{rates_id}/{id}', ['uses' => 'ItineraryController@geteditRouteItinerary','as'   => 'itinerary']);
    Route::post('routeItinerary/Edit', ['uses' => 'ItineraryController@editRouteItinerary','as'   => 'itinerary']);
    Route::get('routeItinerary/Delete/{route_id}/{id}', ['uses' => 'ItineraryController@deleteRouteItinerary','as'   => 'itinerary']);

     //OFR Itinerary
    Route::get('ofrItinerary/View', ['uses' => 'ItineraryController@viewOFRItinerary','as'   => 'itinerary']);
    Route::get('ofrItinerary/Add/{route_id}/{id}/{route_result}', ['uses' => 'ItineraryController@getOFRItinerary','as'   => 'itinerary']);
    Route::post('ofrItinerary/Add', ['uses' => 'ItineraryController@addOFRItinerary','as'   => 'itinerary']);
    Route::get('ofrItinerary/Edit/{route_id}/{id}', ['uses' => 'ItineraryController@geteditOFRItinerary','as'   => 'itinerary']);
    Route::post('ofrItinerary/Edit', ['uses' => 'ItineraryController@editOFRItinerary','as'   => 'itinerary']);
    Route::get('ofrItinerary/Delete/{route_id}/{id}', ['uses' => 'ItineraryController@deleteOFRtinerary','as'   => 'itinerary']);



    //Rates Colombia
    Route::get('colombiaRates/View', ['uses' => 'RateController@viewColombiaRates','as'   => 'colombiaRates']);
    Route::get('colombiaRates/Add/{route_id}/{id}/{route_result}', ['uses' => 'RateController@getColombiaRates','as'   => 'colombiaRates']);
    Route::post('colombiaRates/Add', ['uses' => 'RateController@addColombiaRates','as'   => 'colombiaRates']);
    Route::get('colombiaRates/Edit/{route_id}/{id}', ['uses' => 'RateController@geteditColombiaRates','as'   => 'colombiaRates']);
    Route::post('colombiaRates/Edit', ['uses' => 'RateController@editColombiaRates','as'   => 'colombiaRates']);
    Route::get('colombiaRates/Delete/{ocean_id}', ['uses' => 'RateController@deleteColombiaRates','as'   => 'colombiaRates']);

    //Get air route
    Route::post('getAirRoute', ['uses' => 'RouteController@getAirRoutes','as'   => 'rates']);
    //Get ocean route
    Route::post('getOceanRoute', ['uses' => 'RouteController@getOceanRoutes','as'   => 'rates']);
    //Get colombia route
    Route::post('getColombiaRoute', ['uses' => 'RouteController@getColombiaRoutes','as'   => 'rates']);

    Route::get('additionalRates/{search_id?}/{type?}', 'AdditionalController@getAdditionalRate');
    Route::post('additionalRates', 'AdditionalController@postAdditionalRate');
    Route::post('editadditionalRates', 'AdditionalController@editAdditionalRate');
    Route::post('saveAdditionalRate', 'AdditionalController@saveAdditionalRate');

    Route::get('moreweek', 'ItineraryController@moreweek');
    Route::get('moredate/{key}', 'ItineraryController@moredate');


    // Truck Assignments
    Route::get('truckAssignments/view', 'QuoteController@viewtruckAssignments');
    Route::get('truckAssignments/{quote_id?}/{booked_id?}/{assignment_id?}', 'QuoteController@truckAssignments');
    Route::post('truckAssignments', 'QuoteController@gettruckAssignments');
    Route::get('truckAssignments/Delete/{assignment_id}',  'QuoteController@deletetruckAssignments');

        // Additional Info
    Route::get('quote/additional_info/{quote_id?}/{booked_id?}', 'QuoteController@additional_info');
    Route::post('quote/getadditional_info', 'QuoteController@getadditional_info');
    Route::post('quote/addadditional_info', 'QuoteController@addadditional_info');

    // Upload Reports
    Route::get('search/additional_services', 'SearchController@additional_services');
    //Route::post('uploadpostrate', 'UploadrateController@uploadpostrate');

    Route::get('quote/info/{quote_id?}', ['uses' => 'QuoteController@getQuoteInfo','as'   => 'quote']);
    Route::post('quote/info', ['uses' => 'QuoteController@postQuoteInfo','as'   => 'quote']);

    Route::get('quote/details/{quote_id?}', ['uses' => 'QuoteController@getQuote','as'   => 'quote']);
    Route::post('quote/details', ['uses' => 'QuoteController@postQuote','as'   => 'quote']);
    Route::post('quote/paymentDocument', ['uses' => 'QuoteController@postPaymentDocument','as'   => 'quote']);


    // Reports
    Route::get('reports/{reports_id?}', ['uses' => 'ReportsController@index','as'   => 'reports']);
    Route::post('getreports', ['uses' => 'ReportsController@getreports','as'   => 'reports']);
    Route::post('reports/add', ['uses' => 'ReportsController@addreports','as'   => 'reports']);
    
});

//administrator
Route::group(['middleware' => ['web'],'prefix' => 'administrator', 'namespace' => 'administrator'], function () {
    if(!Auth::check()){
        Route::get('', 'HomeController@getLogin');   
        Route::post('', 'HomeController@postLogin');
    }
    Route::get('login', 'HomeController@getLogin');   
    Route::post('login', 'HomeController@postLogin');
    
});

Route::group(['middleware' => ['web','auth'],'prefix' => 'administrator', 'namespace' => 'administrator'], function () {
    //Home Controller
    Route::get('logout', 'HomeController@getLogout');
    
    //Dashboard Controller
    Route::get('dashboard', 'DashboardController@dashboard');
    Route::get('profile', 'DashboardController@getProfile');
    Route::post('update', 'DashboardController@update');
    Route::post('updatePicture', 'DashboardController@updatePicture');
    Route::post('changePassword', 'DashboardController@passwordChange');

    //common function
    Route::get('status/{id}/{status}/{table}/{field}/{decReason}', 'DashboardController@changeStatus');
    Route::get('delete/{id}/{table}/{field}', 'DashboardController@delete');

    //Airports list
    Route::get('airports', ['uses' => 'DashboardController@getAirports','as'   => 'dashboard']);
    Route::post('airports', ['uses' => 'DashboardController@addAirports','as'   => 'dashboard']);

    //Airline list
    Route::get('airline', ['uses' => 'DashboardController@getAirline','as'   => 'dashboard']);
    Route::post('airline', ['uses' => 'DashboardController@addAirline','as'   => 'dashboard']);


    //Services list
    Route::get('services', ['uses' => 'DashboardController@getServices','as'   => 'dashboard']);
    Route::post('services', ['uses' => 'DashboardController@addServices','as'   => 'dashboard']);

    //Units list
    Route::get('units', ['uses' => 'DashboardController@getUnits','as'   => 'dashboard']);
    Route::post('units', ['uses' => 'DashboardController@addUnits','as'   => 'dashboard']);

    //Countries list
    Route::get('countries', ['uses' => 'DashboardController@getCountries','as'   => 'dashboard']);
    Route::post('countries', ['uses' => 'DashboardController@addCountries','as'   => 'dashboard']);

    //ffstatus list
    Route::get('ffstatus', ['uses' => 'DashboardController@getStatus','as'   => 'dashboard']);
    Route::post('ffstatus', ['uses' => 'DashboardController@addStatus','as'   => 'dashboard']);

    //City list
    Route::get('cities', ['uses' => 'DashboardController@getCities','as'   => 'dashboard']);
    Route::post('cities', ['uses' => 'DashboardController@addCities','as'   => 'dashboard']);

    //Deapartment list
    Route::get('departments', ['uses' => 'DashboardController@getDepartments','as'   => 'dashboard']);
    Route::post('departments', ['uses' => 'DashboardController@addDepartments','as'   => 'dashboard']);

    //EXCHANGE SELECTION
    Route::get('exchangeSelection', ['uses' => 'DashboardController@getExchangeSelection','as'   => 'dashboard']);
    Route::post('exchangeSelection', ['uses' => 'DashboardController@addExchangeSelection','as'   => 'dashboard']);

    //MEAN OF TRANSPORTATION SELECTION
    Route::get('transportationSelection', ['uses' => 'DashboardController@getTransportationSelection','as'   => 'dashboard']);
    Route::post('transportationSelection', ['uses' => 'DashboardController@addTransportationSelection','as'   => 'dashboard']);
    
    //OCEAN FREIGHT TRANSPORTATION MODE SELECTION
    Route::get('CFTMode', ['uses' => 'DashboardController@getCFTMode','as'   => 'dashboard']);
    Route::post('CFTMode', ['uses' => 'DashboardController@addCFTMode','as'   => 'dashboard']);

    //CONTAINER TYPE AND CUANTITY
    Route::get('containerType', ['uses' => 'DashboardController@getContainerType','as'   => 'dashboard']);
    Route::post('containerType', ['uses' => 'DashboardController@addContainerType','as'   => 'dashboard']);

    //Ocean ports
    Route::get('oceanPorts', ['uses' => 'DashboardController@getOceanPorts','as'   => 'dashboard']);
    Route::post('oceanPorts', ['uses' => 'DashboardController@addOceanPorts','as'   => 'dashboard']);

    //Countries list
    Route::get('freight-forwarder/View', ['uses' => 'DashboardController@getFreightRegister','as'   => 'ff']);
    Route::get('freight-forwarder/Add', ['uses' => 'DashboardController@getAddFreightRegister','as'   => 'ff']);
    Route::post('freight-forwarder/Add', ['uses' => 'DashboardController@freightRegister','as'   => 'ff']);
    Route::get('freight-forwarder/Edit/{id}', ['uses' => 'DashboardController@geteditFreightRegister','as'   => 'ff']);
    Route::post('freight-forwarder/Edit', ['uses' => 'DashboardController@editFreightRegister','as'   => 'ff']);
    Route::get('freight-forwarder/Delete/{id}', ['uses' => 'DashboardController@deleteFreightRegister','as'   => 'ff']);

});

define('CURRENT_DATETIME', date('Y-m-d H:i:s'));
define('PAGENATE', 10);
define('ADMINISTRATOR_PAGENATE', 25);
define('BASE_URL',URL::to('/'));
define('BASE',"http://easefreight.com");
define('MINIMUM',5);
define('PERCENTAGE',15);
define('AdminEmail',"info@easefreight.com");