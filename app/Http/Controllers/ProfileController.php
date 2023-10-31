<?php

namespace App\Http\Controllers;

use App\City;
use App\ErrorMessage;
use App\Http\Controllers\Traits\Discountble;
use App\Language;
use App\Promocode;
use App\PromocodeUser;
use App\Quest;
use App\QuestQuestion;
use App\QuestStatistic;
use App\QuestUser;
use App\QuestUserForStat;
use App\Statistic;
use App\User;
use App\UserFile;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Validator;

class ProfileController extends BaseController
{
    use Discountble;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $userID = null)
    {

        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        if (isset($userID)) {
            $getUser = User::find($userID);
        }

        $arrQuests = [];
        if (isset($getUser)) {
            $userQuests = QuestUser::where('userID', $userID)->get();
            foreach ($userQuests as $quest) {
                $oQuest = Quest::find($quest->questID);
                if ($oQuest) {
                    $arrQuests[] = Quest::questJson($oQuest, $userID);
                }
            }
            $user = User::userJson($userID);

        } else {
            $userQuests = QuestUser::where('userID', $this->user->userID)->get();
            foreach ($userQuests as $quest) {
                $oQuest = Quest::find($quest->questID);
                if ($oQuest) {
                    $arrQuests[] = Quest::questJson($oQuest, $this->user->userID);
                }
            }
            $user = User::userJson($this->user->userID);
        }

        $arrRecomendedQuests = [];
        $oRecommended = Quest::where('recommend', 1)->where('access', 'all');
        if ($request->langID != '' && $request->langID != null) {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                $oLanguage = Language::where('prefix', "en")->first();
                //return $this->getError(trans('No such language in database'));
            }
            $oRecommended = $oRecommended->where('languageID', $oLanguage->languageID);
        }

        $oRecommended = $oRecommended->get();

        if (isset($oRecommended) && count($oRecommended) > 0) {
            foreach ($oRecommended as $item) {
                //$arrRecomendedQuests[] = Quest::questSmallJson($item);
                $arrRecomendedQuests[] = Quest::questJson($item, $this->user->userID);
            }
        }
//        $typeQuest = ['process','not_start','finished'];
//        $result = collect();
//        foreach ($typeQuest as $type) {
//            if($type == 'process'){
//                $result->push($quests->whereInLoose('pivot.passing_percent',range(1,99)));
//            }
//            if($type == 'not_start'){
//                $result->push($quests->whereLoose('pivot.passing_percent',0));
//            }
//            if($type == 'finished'){
//                $result->push($quests->whereLoose('pivot.passing_percent',100));
//            }
//        }

        $user['quests'] = $arrQuests;
        $user['boughtQuests'] = !empty($arrQuests) ? $arrQuests : [''];
        $user['recommendQuests'] = !empty($arrRecomendedQuests) ? $arrRecomendedQuests : [''];

        return $this->json($user);
    }

    public function recommendQuests($userFor = null, $questsFor = null)
    {
	    $requestUser = $userFor != null ? $userFor : $this->user;
	    $requestQuests = $questsFor != null ? $questsFor : $this->user->quests;

        $quests = Quest::forUser($requestUser, $this->city_id);
        $userStartQuest = $requestQuests;

        $questsForUser = $quests->filter(function($value,$key) use ($userStartQuest){
            return $userStartQuest->where('id',$value->id)->isEmpty();
        });

        $recommendForUser = $questsForUser->whereLoose('recommend',1);
        if($recommendForUser->count() >= Quest::$recommendCount){


            $recommendQuests = collect([$recommendForUser->random(Quest::$recommendCount)])->collapse();

        }else {

            $leftCount = Quest::$recommendCount - $recommendForUser->count();

            $notRecommend = $questsForUser->whereLoose('recommend', 0);

            if (!$notRecommend->isEmpty() && $notRecommend->count() > $leftCount) {
                $recommendQuests = collect([$recommendForUser, $notRecommend->random($leftCount)])->collapse();
            } else {
                $recommendQuests = collect([$recommendForUser, $notRecommend])->collapse();
            }
        }

        return $recommendQuests;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

//        $validator = $this->updateValidator($request->all());
//
//        if ($validator->fails()) {
//            return $this->getError($validator->errors()->all());
//        }

        $oUser = User::where('token', $this->token)->first();
        $oUser->cityID = isset($request->cityID) ? $request->cityID : 1;
        $oUser->name = isset($request->name) ? $request->name : $this->user->name;

        if (isset($request->email) && $request->email != '') {
            $eUser = User::where('email', $request->email)->get();
            if ($eUser) {
                $oUser->email = $request->email;
            }
        }

        if(!empty($request->password)){
            $oUser->password = bcrypt($request->password);
        }

        if(isset($_FILES['image']['tmp_name'])) {
            $fileName = $this->__uploadNewFile('image', 'users');
            $oUser->avatar = $fileName;
        }

        $oUser->update();
//        if($request->image){
//            $file = $request->image;
//            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
//            $file->move(public_path('/uploads/profile/'), $filename);
//            $request->merge(['avatar' => $filename]);
//
//        }
//        $this->user->update($request->all());
        return $this->getSuccess($this->_getTrans($request, [4,17,30]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rating(Request $request)
    {
        if (!$this->user) {
            return false;
        }

        $sort = $request->sort ?: 'month';
        $users = $this->user->topRating($sort, $this->user, $request->limit, $request->offset);
        return $this->json($users);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function promocode(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $user = $this->user;
        $promocode = Promocode::where('code',$request->promocode)->first();
        if (!is_null($promocode)) {
            $oPromocodeUser = PromocodeUser::where('promocodeID', $promocode->promocodeID)->where('userID', $user->userID)->first();
        } else {
            return $this->getError($this->_getTrans($request, [3,29,42]));
        }
        if(!is_null($promocode) && !$oPromocodeUser && $promocode->quantity > 0 ){

            $newPromocodeUser = new PromocodeUser();
            $newPromocodeUser->promocodeID = $promocode->promocodeID;
            $newPromocodeUser->userID = $user->userID;
            $newPromocodeUser->save();

            $promocode->decrement('quantity');


            $newQuestUser = new QuestUser();
            $newQuestUser->userID = $user->userID;
            $newQuestUser->questID = $promocode->questID;
            $newQuestUser->save();

            $quest = Quest::where('questID', $promocode->questID)->first();

            return $this->json(Quest::questJson($quest, $user->userID));
        } else {
            if (!is_null($promocode) && $oPromocodeUser) {
                return $this->getError($this->_getTrans($request, [1,27,40]));
            }
            if (!is_null($promocode) && $promocode->quantity == 0) {
                return $this->getError($this->_getTrans($request, [2,28,41]));
            }
        }
    }


    /**
     * Copy of promocode
     * 
     * return - discount price
     * is_discount - flag 
     * discount - percent discount
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function promocodeDiscount(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }
        $user = $this->user;

        $promocode = Promocode::where('code', $request->promocode)->first();
/*
        if (!is_null($promocode)) {
            $oPromocodeUser = PromocodeUser::where('promocodeID', $promocode->promocodeID)->where('userID', $user->userID)->first();
        } else {
            return $this->getError($this->_getTrans($request, [3, 29, 42]));
        }
*/
//        if (!is_null($promocode) && !$oPromocodeUser && $promocode->quantity > 0) {
        if (!is_null($promocode) && $promocode->quantity > 0) {

/*
            $newPromocodeUser = new PromocodeUser();
            $newPromocodeUser->promocodeID = $promocode->promocodeID; 
            $newPromocodeUser->userID = $user->userID;
            $newPromocodeUser->save();
*/
            $promocode->decrement('quantity');
/*
            $newQuestUser = new QuestUser();
            $newQuestUser->userID = $user->userID;
            $newQuestUser->questID = $promocode->questID;
            $newQuestUser->save();
*/

            $quest = Quest::where('questID', $promocode->questID)->first();

            $quest_json = (Quest::questJson($quest, $user->userID));
            if($promocode->discount > 0)
            {
                $quest_json['price'] =  $quest_json['price'] / 100 * $promocode->discount;
                $quest_json['price_android'] = $quest_json['price_android'] / 100 * $promocode->discount;
                $quest_json['is_discount'] = TRUE;
                $quest_json['discount'] = $promocode->discount;
                $quest_json['discount_product_id'] = $promocode->discount_product_id;
            }
            else
            {
                $newQuestUser = new QuestUser();
                $newQuestUser->userID = $user->userID;
                $newQuestUser->questID = $promocode->questID;
                $newQuestUser->save();
            }
            return $this->json($quest_json);
        } else {
            if (!is_null($promocode) && $oPromocodeUser) {
                return $this->getError($this->_getTrans($request, [1, 27, 40]));
            }
            if (!is_null($promocode) && $promocode->quantity == 0) {
                return $this->getError($this->_getTrans($request, [2, 28, 41]));
            }
        }
    }

    public function buyQuest(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $questID = $request->quest_id;
        if($questID){
            $user = $this->user;
            $quest =  Quest::where('questID', $questID)->first();
            if ($quest) {
                $oQuestUser = QuestUser::where('userID', $user->userID)->where('questID', $quest->questID)->first();
                if (!$oQuestUser) {
                    $newQuestUser = new QuestUser();
                    $newQuestUser->userID = $user->userID;
                    $newQuestUser->questID = $quest->questID;
                    $newQuestUser->save();
                    //$quest = $this->questDiscounts($quest, $user)->first();
                    //$quest->users()->attach($this->user->id);
                    //$this->user->promocodes()->updateExistingPivot($quest->promocode_id,['active'=>0]);
                    return $this->getSuccess($this->_getTrans($request, [5,18,31]));
                } else {
                    return $this->getError($this->_getTrans($request, [6,19,32]));
                }
            } else {
                return $this->getError($this->_getTrans($request, [7,20,33]));
            }
        }else{
            return $this->getError(trans('No questID'));
        }
    }

    public function updateQuestProcessStatus(Request $request)
    {
        if ($request->quest_id) {
            $oQuestUser = QuestUser::where('quest_id', $request->quest_id)->where('user_id', $this->user->id)->first();
            if (isset($oQuestUser) && count($oQuestUser) > 0) {
                $oQuestUser->isFinished = $request->status;

                $oQuestUser->save();
                return $this->getSuccess(trans('app.quest_process_good'));
            } else {
                return $this->getError(trans('app.quest_process_error'));
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerPushToken(Request $request)
    {

        if($this->user && $request->has('push_token')){
            $data = $request->all();
            $data['os_type'] = !empty($request->os_type) ? $request->os_type : $this->user->os_type;
            $this->user->update($data);
            return $this->getSuccess('Success register push token');
        }else{
            return $this->getError(trans('app.error_register_push_token'));
        }
    }

    /**
     * @param array $data
     * @param $user
     * @return \Illuminate\Validation\Validator
     */
    protected function updateValidator(array $data)
    {

        $rules =  [
            'password' => 'sometimes|confirmed',
            'image' => 'max:2048|mimes:png,jpeg,jpg,gif,bmp',
            'city_id' =>'exists:cities,id|integer',
            'name' =>'min:1'
        ];

        if(!empty($data['email']) && $data['email'] != $this->user->email){
           $rules['email'] = 'email|max:255|unique:users';
        }
        return Validator::make($data,$rules);

    }

	public function sendStatistic (Request $request)
	{

        $response = $this->_checkUser('noLog');
        if ($response) {
            return $response;
        }

        $userID = $request['userID'];
        $questID = $request['questID'];
        $questionID = $request['questionID'];
        $time = Carbon::parse($request['time']);
        $type = $request['type'];

        // Save quest in quest_users table
        $oQuestUsers = QuestUser::where('userID', $userID)->where('questID', $questID)->first();
        if (!isset($oQuestUsers)) {
            if (count($oQuestUsers) == 0) {

                $oQuestUserEntity = new QuestUser();
                $oQuestUserEntity->userID = $userID;
                $oQuestUserEntity->questID = $questID;

                $oQuestUserEntity->save();
            }
        }

//        $questForStat = QuestUserForStat::where('userID', $userID)->where('questID', $questID)->orderBy('number', 'DESC')->first();


        $oQuestQuestions = QuestQuestion::where('questID', $questID)->orderBy('sort_number', 'ASC')->first();

        if (isset($oQuestQuestions) && $questionID == $oQuestQuestions->questionID) {

            $oStat = QuestStatistic::where('user_id', $userID)
                ->where('quest_id', $questID)
                ->where('question_id', $questionID)
                ->where('type', $type)
                ->orderBy('number', 'DESC')
                ->first();

            if (isset($oStat)) {
                $number = $oStat->number;
                $number = $number + 1;
            } else {
                $number = 1;
            }

            return $this->_saveStatistic($request, $number);

//            if ($type == 'question') {
//
//                $oStat = QuestStatistic::where('user_id', $userID)
//                    ->where('quest_id', $questID)
//                    ->where('question_id', $questionID)
//                    ->where('type', 'question')
//                    ->first();
//
//
////                if (isset($oStat) && count($oStat) > 0) {
////                    $oldTime = Carbon::parse($oStat->time);
////                    if ($time != $oldTime) {
////                        QuestStatistic::where('user_id', $userID)
////                            ->where('quest_id', $questID)
////                            ->delete();
////                        return $this->_saveStatistic($request);
////                    }
////                } else {
////                    return $this->_saveStatistic($request);
////                }
//            } else {
//                return $this->_saveStatistic($request);
//            }
        }
        else {
            return $this->_saveStatistic($request, 1);
        }
	}

    protected function _saveStatistic($request, $number)
    {
        $oStat = new QuestStatistic();
        $oStat->user_id = $request['userID'];
        $oStat->quest_id = $request['questID'];
        $oStat->question_id = $request['questionID'];
        $oStat->type = $request['type'];
        $oStat->time = $request['time'];
        $oStat->downloadTime = $request['downloadTime'];
        $oStat->token = $request['token'];
        $oStat->loc_lat = $request['location']['lat'];
        $oStat->loc_lon = $request['location']['lon'];
        $oStat->token = $request['token'];

        $oStat->hint_id = isset($request['hintID']) ? $request['hintID'] : null;
        $oStat->hintScore = isset($request['hintScore']) ? $request['hintScore'] : null;

        $oStat->phrase_id = isset($request['phraseID']) ? $request['phraseID'] : null;
        $oStat->phraseType = isset($request['phraseType']) ? $request['phraseType'] : null;

        $oStat->answerState = isset($request['answerState']) ? $request['answerState'] : null;
	    if (isset($request['answerType'])) {
			if ($request['answerType'] == 'video' || $request['answerType'] == 'audio' || $request['answerType'] == 'image') {
				if (!empty($_FILES['data']['tmp_name'])) {
					$tmpFileName = explode('.', $_FILES['data']['name']);
					$tmpFileName = array_reverse($tmpFileName);

					$fileHash = md5(microtime().$request['userID']);
					$file_name = $fileHash . '.' .$tmpFileName[0];

					$tmpUploadDir = 'uploads/statistics/' . $request['questID'] . '/' . $request['userID'] . '/' . $request['answerType'] . '/';

					if (!is_dir($tmpUploadDir)) {
						mkdir($tmpUploadDir, 0777, true);
					}

					$tmpUploadDir .= $file_name;
					move_uploaded_file($_FILES['data']['tmp_name'], $tmpUploadDir);

					$oStat->data = $tmpUploadDir;
					unset($_FILES['data']);
				}
			}
		    $oStat->answerType = $request['answerType'];
	    } else {
		    $oStat->answerType = null;
		    $oStat->data = null;
	    }
        $oStat->answerScore = isset($request['score']) ? $request['score'] : null;
        $oStat->answerText = isset($request['text']) ? $request['text'] : null;

        $oStat->number = $number;
        $oStat->save();

        return $this->getSuccess('Статистика была успешно загружена');
    }

    public function saveUserFile(Request $request)
    {
        if (isset($request['user_id'])) {
            if (!empty($_FILES['data']['tmp_name'])) {
                $tmpFileName = explode('.', $_FILES['data']['name']);
                $tmpFileName = array_reverse($tmpFileName);

                $fileHash = md5(microtime() . $request['user_id']);
                $file_name = $fileHash . '.' . strtolower($tmpFileName[0]);

                $tmpUploadDir = 'uploads/usersfiles/' . $request['user_id'] . '/';

                if (!is_dir($tmpUploadDir)) {
                    mkdir($tmpUploadDir, 0777, true);
                }

                $tmpUploadDir .= $file_name;
                move_uploaded_file($_FILES['data']['tmp_name'], $tmpUploadDir);

                $oUserFile = new UserFile();
                $oUserFile->user_id = $request['user_id'];
                $oUserFile->file_name = $fileHash;
                $oUserFile->file_ext = strtolower($tmpFileName[0]);
                $oUserFile->save();
                
                unset($_FILES['data']);

                $fileUrl = url('/' . $tmpUploadDir);
                $arrData = [
                    'fileUrl' => $fileUrl,
                    'pageUrl' => url('/' . $request['user_id'] . '/showuserfile/' . $fileHash),
                ];

                return $this->json($arrData);
            }
        }
    }
}
