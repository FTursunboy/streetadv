<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Traits\SocialAuth;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Serializer\CompactSerializer;

class AuthController extends BaseController
{
    use SocialAuth;

    public function auth(Request $request)
    {
        if ($request->isMethod('post')) {
            $email = $request->email;

            $oUser = User::where('email', $email)->first();
            if ($oUser) {
                $remember = $request->has('remember');
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
//                    if (isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != null && $_SERVER["HTTP_USER_AGENT"] != '') {
//                        $browser = !(strpos($_SERVER["HTTP_USER_AGENT"], "CFNetwork") !== false) && !(strpos($_SERVER["HTTP_USER_AGENT"], "okhttp") !== false);
//                    }
                    $browser = isset($request->web) && $request->web == 1 ? true : false;
                    if ($browser) {
                        $user = Auth::user();
                        $this->user = $user;
                        //$oUser = User::userJson($user->userID);

                        return redirect()->route('admin_dashboard');
                    } else {
                        $user = Auth::user();
                        $this->user = $user;
                        $oUser = User::userJson($user->userID);

                        return $this->json($oUser);
                    }
                } else {
                    return $this->getError('Incorrect user or password');
                }
            } else {
                $this->token = $this->generateToken();

                $oUser = new User();
                $oUser->name = '';
                $oUser->roleID = 55;
                $oUser->cityID = 1;
                $oUser->email = $request->email;
                $oUser->password = bcrypt($request->password);
                $oUser->token = $this->token;
                $oUser->save();

                $this->user = $oUser;

                return $this->json(User::userJson($oUser->userID));
            }

        }

        $user = Auth::user();
        if ($user) {
            return redirect()->route('admin_dashboard');
        }

        return view('admin.layouts.auth');
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();

            return redirect()->route('admin_auth');
        }
    }

    public function signApple(Request $request)
    {
        if (!$request->isMethod('post')) {
            return $this->getError('Ой! Что-то пошло не так. Мы уже разбираемся!');
        }

        if (!isset($request->apple_code)) {
            return $this->getError('Ой! Что-то пошло не так. Мы уже разбираемся!');
        }

//        $kid = 'JA8QUR657Z';
//        $iss = '6638F9EG93';
//        $sub = 'kidsdaily';

        $kid = 'YP738243LJ';
        $iss = '8LQ29AYVLD';
        $sub = 'com.sa.StreetAdventure';


        $jwt = $this->generateJWT($kid, $iss, $sub);

        $CODE = $request->apple_code;

        $data = [
            'client_id' => $sub,
            'client_secret' => $jwt,
            'code' => $CODE,
            'grant_type' => 'authorization_code',
            'request_uri' => 'http://streetadv.com'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://appleid.apple.com/auth/token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $serverOutput = curl_exec($ch);

        curl_close($ch);

        $json = json_decode($serverOutput);

        if (isset($json->error)) {
            return $this->getError('Apple not valid user, error:' . $json->error);
        }

        $serializerManager = new CompactSerializer();
        $decoded = $serializerManager->unserialize($json->id_token);
        $data = json_decode($decoded->getPayload(), true);

        if (!isset($data['sub'])) {
            return $this->getError('Ой! Что-то пошло не так. Мы уже разбираемся!');
        }

        $user = User::where('password', $data['sub'])->first();
        $this->token = $this->generateToken();
        if (!isset($user)) {
            $user = new User();
            //$user->site = '';
            $user->name = "";
            $user->email = "";
            $user->token = $this->token;
            $user->password = $data['sub'];
            $user->roleID = 55;
            $user->cityID = 1;
            //$user->providerID = '';
            //$user->gender = 0;
            //$user->expires_day = (isset($request->version) && $request->version > 1) ? 72 : 168; // 3 Тестовых ДНЕЙ или 27
            //$user->active = 1;
            //$user->sub_appleid = $data['sub'];
            //$user->ver = "";
            $user->save();
        } else {
            //$user->active = 1;
            $user->save();
        }

        // $this->token = $user->token;
        $this->user = $user;

//        $this->logUser('login');
//        $this->logUser('countLogin');
//        $this->logUser('tasksUnDone');
//        $this->logUser('lastMove');

        return $this->json(User::userJson($user->userID));
    }

    public function generateJWT($kid, $iss, $sub)
    {
        $body = json_encode([
            'iss' => $iss,
            'iat' => time(),
            'exp' => time() + 3600,
            'aud' => 'https://appleid.apple.com',
            'sub' => $sub,
        ]);

        $algorithmManager = new AlgorithmManager([new ES256()]);
        $jwsBuilder = new JWSBuilder($algorithmManager);
        $jws = $jwsBuilder
            ->create()
            ->withPayload($body)
            ->addSignature(JWKFactory::createFromKeyFile(base_path() . '/AuthKey_YP738243LJ.p8'), [
                'alg' => 'ES256',
                'kid' => $kid,
                'typ' => "JWT"
            ])
            ->build();

        $serializer = new CompactSerializer();
        $token = $serializer->serialize($jws, 0);
        return $token;
    }

    public function forgot(Request $request)
    {
        if (!$request->isMethod('post')) {
            return $this->getError('Ой! Что-то пошло не так. Мы уже разбираемся!');
        }

        $email = $request->get('email');
        $user = User::query()->where('email', $email)->first();

        if ($user) {
            try {
                $new_password = Str::random(6);
                Mail::send('email.forgot', ['password' => $new_password, 'email' => $user->email], function ($message) use ($user) {
                    $message->to($user->email)->subject('Street Adventure: Сброс пароля');
                });
            } catch (Exception $exception) {
                Log::error($exception);
                return $this->getError('Ой! Что-то пошло не так. Мы уже разбираемся!');
            }
            $user->update(['password' => bcrypt($new_password)]);
            return $this->getSuccess('Новый пароль для Вашего аккаунта отправлен вам на эл. почту.');
        } else {
            return $this->getError('Пользователь не найден.');
        }
    }
}
