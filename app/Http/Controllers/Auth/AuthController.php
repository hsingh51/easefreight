<?php



namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\User;

use Validator;
use Session;
use Auth;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;



class AuthController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Registration & Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles the registration of new users, as well as the

    | authentication of existing users. By default, this controller uses

    | a simple trait to add these behaviors. Why don't you explore it?

    |

    */



    use AuthenticatesAndRegistersUsers, ThrottlesLogins;



    /**

     * Where to redirect users after login / registration.

     *

     * @var string

     */

    protected $redirectTo = '/controller';



    /**

     * Create a new authentication controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest', ['except' => 'logout']);

    }





    /**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */

    // protected function validator(array $data)

    // {



    //     return Validator::make($data, [

    //         'name' => 'required|max:255',

    //         'email' => 'required|email|max:255|unique:users',

    //         'password' => 'required|confirmed|min:6',

    //         'password_confirmation'=>'required|min:6',

    //         //'company_name' => 'required',

    //         'username' => 'required|unique:users',

    //         'phone' => 'required|numeric',

    //         'mobile' => 'required|numeric',

    //         //'position' => 'required',

    //         'address' => 'required',

    //         'country' => 'required',

    //         'city' => 'required',

    //         'website' => 'required',

    //         'message' => 'required',

    //     ]);

    // }



    /**

     * Create a new user instance after a valid registration.

     *

     * @param  array  $data

     * @return User

     */

    // protected function create(array $data)

    // {



    //     return User::create([

    //         'name' => $data['name'],

    //         'group_id' => $data['group_id'],

    //         'email' => $data['email'],

    //         'password' => bcrypt($data['password']),

    //         'company_name' => $data['company_name'],

    //         'username' => $data['username'],

    //         'phone' => $data['phone'],

    //         'mobile' => $data['mobile'],

    //         'position' => $data['position'],

    //         'address' => $data['address'],

    //         'country' => $data['country'],

    //         'city' => $data['city'],

    //         'website' => $data['website'],

    //         'message' => $data['message'],

    //     ]);

    // }



    public function postRegister(Request $request){

        $data = $request->all();

        dd($data);

    }

    public function logout()
    {
        //die('die;');
        Auth::Logout();
        Session::flush();
        //Session::forget('ocean_route_id');
        return redirect('/');
    }

}
