<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Traits\SocialAuth;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends BaseController
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


    use AuthenticatesAndRegistersUsers, ThrottlesLogins, SocialAuth;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
//        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }


    public function auth(Request $request)
    {

        if ($request->get('type') == 'login') {
            $checkEmail = User::where('email', $request->get('email'))->first();
            if (!is_null($checkEmail)) {
                return $this->login($request);
            } else {
                return $this->getError(trans('auth.failed'));
            }
        } elseif ($request->get('type') == 'register') {
            return $this->register($request);
        }
    }

    public function register(Request $request)
    {

        $validator = $this->registerValidator($request->all());

        if ($validator->fails()) {
            return $this->getError($validator->messages()->first());
        }
        Auth::guard($this->getGuard())->login($this->create($request->all()));


        $this->user = \Auth::guard('web')->user();
        $this->user_id = \Auth::guard('web')->id();
        return $this->getSuccess(trans('auth.reg_completed'),[
            'email'=>$this->user->email,
            'avatar'=>$this->user->image,
            'name'=>$this->user->name,
            'id'=>$this->user->id
        ]);
    }

    public function login(Request $request)
    {
//        $file = 'uploads/_temp/temp.txt';
//        $current = file_get_contents($file);
//        $current .= $_SERVER["HTTP_USER_AGENT"] . "\n";
//        file_put_contents($file, $current);

        $validator = $this->loginValidator($request->all());
        if (!$validator->fails() && \Auth::guard('web')->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $this->user = \Auth::guard('web')->user();
            $this->user_id = \Auth::guard('web')->id();
            $userInfo = ['email'=>$this->user->email,'avatar'=>$this->user->image,'name'=>$this->user->name,'id'=>$this->user->id];

            // Проверка с какого устройства пришел запрос
            if (isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != null && $_SERVER["HTTP_USER_AGENT"] != '') {
                $browser = !(strpos($_SERVER["HTTP_USER_AGENT"], "CFNetwork") !== false) && !(strpos($_SERVER["HTTP_USER_AGENT"], "okhttp") !== false);
                if ($browser) {
                    return $this->getSuccess(trans('auth.success'),$userInfo);
                    //return redirect('/admin');
                } else {
                    return $this->getSuccess(trans('auth.success'),$userInfo);
                }
            } else {
                return $this->getSuccess(trans('auth.success'),$userInfo);
            }

        }else{
            return $this->getError(trans('auth.failed'));
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function registerValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6 ',
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => $this->generateToken(),
        ]);
    }



    

}
