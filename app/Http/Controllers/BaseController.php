<?php

namespace App\Http\Controllers;

use App\ErrorMessage;
use App\Exceptions\ExistUserException;

use App\Log;
use App\Promocode;
use App\User;
use App\Language;
use Illuminate\Database\Eloquent\Collection;

class BaseController extends Controller
{

    public $data = [];
    public $json = [];

    public $user = [];
    public $user_id = 0;

    public $lang_id = '';
    public $city_id = '';

    public $token;

    public function __construct()
    {
//        $lang = request('lang') ? request('lang') : 'ru';
//        $this->lang_id = Language::findByPrefix($lang)->id;
//
//        $city = request('city') ? request('city') : 'Москва';
//        $this->city_id = City::findByName($city)->id;
//
//        $token = request('token', \Route::current()->parameter('token', ''));
//
//        if(! $user = request()->user()){
//            $user = User::where('token', $token)->first();
//        }
//
//        if (!is_null($user)) {
//            $this->user = $user;
//            $this->user_id = $user->id;
//        }elseif(\Route::currentRouteName() != 'auth' && \Route::currentRouteName() != 'social_auth'){
//            throw new ExistUserException($this->getError(trans('app.user_not_found')));
//        }
    }

    public function _checkUser($log = null)
    {
        if (!$log) {
            $this->_saveLog();
        }

        $response = null;

        $token = request('token');
        if ($token) {
            $oUser = User::where('token', $token)->first();
            if ($oUser) {
                $this->token = $token;
                $this->user = $oUser;
                $this->user_id = $oUser->userID;

                $response = null;
            } else {

                $response = $this->getError('No user with such token');
            }
        } else {
            $response = $this->getError('Token is empty');
        }

        return $response;
    }

    /**
     * return json api
     * @param array|Collection $data
     * @param int $status
     * @param int $code
     * @param bool $collapse
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json($data = [], $status = 200, $code = 0, $collapse = null)
    {
        $this->json['status'] = $status;
        if($this->user){
            $this->json['token'] = $this->user->token;
        }
        
        if ($collapse) {
            $this->json['data'] = array_collapse($this->filterData($data));
        } else {
            $this->json['data'] = $this->filterData($data);
        }

        return response()->json($this->json);
    }

    /**
     * Get error json response
     *
     * @param $text
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getError($text, $statusCode = 400)
    {
        return $this->json(['message' => $text], $statusCode);
    }

    /**
     * Get success json response
     *
     * @param $text
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuccess($text, $data = [])
    {
        if(is_array($data)){
            return $this->json(array_merge(['message' => $text], $data));
        }

        return $this->json(['message' => $text, $data]);
    }

    /**
     * Generate unique user token
     *
     * @return string
     */
    public function generateToken()
    {
        try {
            $token = str_random(60);
            return $token;
        } catch (\Exception $e) {
            return $this->generateToken();
        }
    }


    /**
     * @param $data
     * @return array
     */
    public function filterData($data)
    {
        $data = collect($data)->filter()->toArray();
        foreach ($data as $k => $v){
            if ($k == 'coords') {
                if (!is_array($v)) {
                    $data[$k] = $this->filterData(json_decode($v));
                }
            }
            if (is_array($v)) {
                $data[$k] = $this->filterData($v);
            }
        }

        return $data;
    }

    public function showIosFile()
    {
        $file = [
            'applinks' => [
                'apps' => [],
                'details' => [
                    [
                        'appID' => '8LQ29AYVLD.com.sa.StreetAdventure',
                        'paths' => ['*', '/']
                    ]
                ]
            ]
        ];

        return response()->json($file);
    }

    public function addPromo ()
    {
        $array = [
            0 => "ROBOT68393",
            1 => "ROBOT07504",
            2 => "ROBOT71729",
            3 => "ROBOT72085",
            4 => "ROBOT83893",
            5 => "ROBOT60943",
            6 => "ROBOT01402",
            7 => "ROBOT08634",
            8 => "ROBOT41934",
            9 => "ROBOT07187",
            10 => "ROBOT94891",
            11 => "ROBOT25320",
            12 => "ROBOT22562",
            13 => "ROBOT80047",
            14 => "ROBOT55623",
            15 => "ROBOT88849",
            16 => "ROBOT19537",
            17 => "ROBOT88607",
            18 => "ROBOT37006",
            19 => "ROBOT53073",
            20 => "ROBOT16994",
            21 => "ROBOT63402",
            22 => "ROBOT72281",
            23 => "ROBOT87446",
            24 => "ROBOT62470",
            25 => "ROBOT52073",
            26 => "ROBOT98213",
            27 => "ROBOT56177",
            28 => "ROBOT50578",
            29 => "ROBOT46893",
            30 => "ROBOT66063",
            31 => "ROBOT85750",
            32 => "ROBOT33721",
            33 => "ROBOT76642",
            34 => "ROBOT78329",
            35 => "ROBOT74790",
            36 => "ROBOT30971",
            37 => "ROBOT24155",
            38 => "ROBOT44980",
            39 => "ROBOT45192",
            40 => "ROBOT96548",
            41 => "ROBOT52570",
            42 => "ROBOT97868",
            43 => "ROBOT38966",
            44 => "ROBOT24920",
            45 => "ROBOT25244",
            46 => "ROBOT91127",
            47 => "ROBOT44150",
            48 => "ROBOT88539",
            49 => "ROBOT56879",
            50 => "ROBOT07942",
            51 => "ROBOT16827",
            52 => "ROBOT08530",
            53 => "ROBOT10433",
            54 => "ROBOT40880",
            55 => "ROBOT32554",
            56 => "ROBOT42655",
            57 => "ROBOT11818",
            58 => "ROBOT18475",
            59 => "ROBOT78389",
            60 => "ROBOT73930",
            61 => "ROBOT85321",
            62 => "ROBOT56580",
            63 => "ROBOT46375",
            64 => "ROBOT07062",
            65 => "ROBOT44460",
            66 => "ROBOT83447",
            67 => "ROBOT10455",
            68 => "ROBOT34933",
            69 => "ROBOT99172",
            70 => "ROBOT67408",
            71 => "ROBOT53967",
            72 => "ROBOT19404",
            73 => "ROBOT69766",
            74 => "ROBOT40175",
            75 => "ROBOT93169",
            76 => "ROBOT82416",
            77 => "ROBOT12836",
            78 => "ROBOT84106",
            79 => "ROBOT20432",
            80 => "ROBOT86163",
            81 => "ROBOT30416",
            82 => "ROBOT75444",
            83 => "ROBOT53551",
            84 => "ROBOT05845",
            85 => "ROBOT15845",
            86 => "ROBOT98402",
            87 => "ROBOT04224",
            88 => "ROBOT24202",
            89 => "ROBOT92037",
            90 => "ROBOT15335",
            91 => "ROBOT54103",
            92 => "ROBOT38858",
            93 => "ROBOT04180",
            94 => "ROBOT49063",
            95 => "ROBOT49187",
            96 => "ROBOT05076",
            97 => "ROBOT41619"
        ];

        foreach ($array as $item) {
            $promo = new Promocode();
            $promo->code = $item;
            $promo->promocode_type = 'open_quest';
            $promo->discount_product_id = 'com.sa.roboti';
            $promo->questID = 61;
            $promo->discount = 0.00;
            $promo->quantity = 999;
            $promo->save();
        }
    }

    public function __generateFileName($originalFileName)
    {
        $arrFileNameData = explode('.', $originalFileName);
        $arrFileNameData = array_reverse($arrFileNameData);
        $fileExtension = $arrFileNameData[0];

        $newFileName = md5(microtime() . rand(0, 9999));
        $newFileName = $newFileName . '.' . $fileExtension;

        return $newFileName;
    }

    public function __uploadNewFile ($fieldName, $type)
    {
        $uploadDir = public_path() . '/uploads/' . $type . '/';
        $file = basename($_FILES[$fieldName]['name']);
        $newFileName = $this->__generateFileName($file);
        $uploadFile = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadFile)) {
            return $newFileName;
        }

        return ['error' => 'error'];
    }

    public function _saveLog ()
    {
        $oLog = new Log();

        $oLog->method = url()->current();
        $oLog->fullUrl = url()->full();
        $oLog->get = json_encode($_GET);
        $oLog->post = json_encode($_POST);
        $oLog->device = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $oLog->server = json_encode($_SERVER);

        $oLog->save();
    }

    public function _getTrans ($data, $arrErrorsIDs)
    {
        $errorText = 'Error';
        if (isset($data->langID)) {
            $oLanguage = Language::where('prefix', $data->langID)->first();
            if ($oLanguage) {

                $prefix = $oLanguage->prefix;
                $arrIDs = ErrorMessage::$$prefix;

                foreach ($arrErrorsIDs as $errorID) {
                    if (in_array($errorID, $arrIDs)) {
                        $oError = ErrorMessage::where('errorID', $errorID)->first();
                        if ($oError) {
                            $errorText = $oError->text;
                        }
                    }
                }
            }
        }

        return $errorText;
    }
}
