<?php

namespace App\Http\Controllers\Traits;

use File;
use GuzzleHttp;
use App\User;
use Illuminate\Http\Request;

trait SocialAuth {

    protected $available_providers = ['facebook', 'vkontakte'];

    /**
     * @param $provider
     * @param $token
     * @return mixed
     */
    public function socialLogin($provider, $token)
    {
        if (! in_array($provider, $this->available_providers)) {
            return $this->getError(trans('auth.failed'));
        }

        $client = new GuzzleHttp\Client();

        $data = $this->getUserData(
            $provider,
            json_decode($client->get($this->{$provider . 'Url'}($token), ['http_errors' => false])->getBody()->getContents(), true)
        );

        if (isset($data['error'])) return $this->getError(trans('auth.failed'));


        if (! $user = User::where($provider . '_id', $data['id'])->first()){
            $user = User::updateOrCreate(['email' => $data['email']], $data);
        }

        if (! $user) return $this->getError(trans('auth.failed'));

//        $userInfo = [
//            'email' => $user->email,
//            'avatar' => $user->image,
//            'id'=>$user->id,
//            'name' => $user->name
//        ];

        $this->user = $user;
        $this->user_id = $user->userID;

        $oUser = User::userJson($user->userID);

        return $this->json($oUser);
    }


    /**
     * @param $token
     * @return string
     */
    public function facebookUrl($token)
    {
        return 'https://graph.facebook.com/me?fields=id,email,name,hometown,picture&access_token=' . $token;
    }


    /**
     * @param $token
     * @return string
     */
    public function vkontakteUrl($token)
    {
        return 'https://api.vk.com/method/users.get?fields=id,email,name,bdate,city,photo_200_orig&v=5.52&access_token=' . $token;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getAccessToken(Request $request)
    {
        return $request->all();
    }


    /**
     * @param $provider
     * @param $data
     * @return array
     */
    protected function getUserData($provider, $data){


        if ($provider == 'vkontakte'){

                $arrData = [
                    'id' => $data['response'][0]['id'],
                    'email' => isset($data['email']) ? $data['email'] : isset($_GET['email'])?$_GET['email']:$_POST['email'],
                    'name' => $data['response'][0]['first_name'] . ' ' . $data['response'][0]['last_name'],
                    'avatar' => isset($data['response'][0]['photo_200_orig']) ? $this->getAvatar($data['response'][0]['photo_200_orig'], $data['response'][0]['id']) : '',
                    $provider . '_id' => $data['response'][0]['id'],
                    'roleID' => 55,
                    'cityID' => 1,
                    'password' => ''
                ];
        }elseif ($provider == 'facebook'){
            $arrData = [
                'id' => $data['id'],

                'email' => isset($data['email']) ? $data['email'] : isset($_GET['email'])?$_GET['email']:$_POST['email'],
                'name' => $data['name'],
                'avatar' => $this->getAvatar($data['picture']['data']['url'], $data['id']),
                $provider . '_id' => $data['id'],
                'roleID' => 55,
                'cityID' => 1,
                'password' => ''
            ];
        }

        $arrData['token'] = $this->generateToken();

        return $arrData;
    }



    /**
     * @param $url
     * @return string
     */
    protected function getAvatar($url, $id)
    {
        $directory = public_path('/uploads/users/');
        $avatar = sha1($id) . '.jpg';
        $filename = $directory . '/' . $avatar;

        $http = new GuzzleHttp\Client();

        $image = $http->get($url, ['http_errors' => false])->getBody()->getContents();

        if( ! File::exists($directory)) File::makeDirectory($directory, 777, true);

        File::put($filename, $image);

        return $avatar;
    }

}