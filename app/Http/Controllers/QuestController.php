<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\ErrorMessage;
use App\File;
use App\Language;
use App\Quest;
use App\QuestAppearance;
use App\QuestHint;
use App\QuestAnswer;
use App\QuestPhrase;
use App\QuestStatic;
use App\QuestUser;
use App\Review;
use Illuminate\Http\Request;
use App\QuestQuestion;
use Illuminate\Support\Facades\Auth;

class QuestController extends BaseController
{
    public $statuses =  ['started_not_finished','started','finished'];
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

//-------------------------------------------------------------------------------------------

        $oUsersQuests = QuestUser::where('userID', $this->user->userID)->get();

        $oAllQuests = Quest::where('access', 'all')->get();

        $arrQuestsUserIDs = [];
        foreach ($oUsersQuests as $usersQuest) {
            $arrQuestsUserIDs[] = $usersQuest->questID;
        }

        foreach ($oAllQuests as $quest) {
            $arrQuestsUserIDs[] = $quest->questID;
        }

//-------------------------------------------------------------------------------------------

        if (isset($request->langID)) {
            $langID = $request->langID;
        } else {
            $langID = null;
        }

        if ($langID != null) {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                $oLanguage = Language::where('prefix', "en")->first();
    //           return $this->getError(trans('No such language in database'));
            }
	    $arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs)->where('languageID', $oLanguage->languageID);
            //$arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs);
        } else {
            $arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs);
        }

//-------------------------------------------------------------------------------------------

        if (isset($request->city)) {
            $oCity = City::where('name', $request->city)->first();
            if ($oCity) {
                $arrQuests->whereIn('cityID', [$oCity->cityID, 0]);
            }
        }

        $orderField = $request->get('orderField', 'sort_number');
        $orderDir = $request->get('orderDir', 'ASC');
        $arrQuestsGet = $arrQuests->orderBy($orderField, $orderDir)->get();

        $arrQuestsForJson = array();
        if (isset($request->category_id)) {
            foreach ($arrQuestsGet as $quest) {
                $categories = explode(',', $quest->categoryIDs);
                if (in_array($request->category_id, $categories)) {
                    $arrQuestsForJson[] = Quest::questJson($quest, $this->user_id);
                }
            }
        } else {
            foreach ($arrQuestsGet as $quest) {
                $arrQuestsForJson[] = Quest::questJson($quest, $this->user_id);
            }
        }

//-------------------------------------------------------------------------------------------

        return $this->json($arrQuestsForJson);
    }



/**
     * Display a listing of the resource by page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pages(Request $request)
    {

        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        //-------------------------------------------------------------------------------------------

        $oUsersQuests = QuestUser::where('userID', $this->user->userID)->get();
        $oAllQuests = Quest::where('access', 'all')->get();

        $arrQuestsUserIDs = [];
        foreach ($oUsersQuests as $usersQuest) {
            $arrQuestsUserIDs[] = $usersQuest->questID;
        }

        foreach ($oAllQuests as $quest) {
            $arrQuestsUserIDs[] = $quest->questID;
        }
        //-------------------------------------------------------------------------------------------

        if (isset($request->langID)) {
            $langID = $request->langID;
        } else {
            $langID = null;
        }


        //-----------------------------------------------------------------------------------------
        $quest_on_page = 5;
        $page = 0;

        $page = (int)request('page');
        if ($page < 0 || $page > 1000) $page = 0;
        $arrQuestsCount = Quest::whereIn('questID', $arrQuestsUserIDs)->count();
        $offcet = $page * $quest_on_page;

        //-----------------------------------------------------------------------------------------
        if ($langID != null) {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                $oLanguage = Language::where('prefix', "en")->first();
    //            return $this->getError(trans('No such language in database'));
            }
            //$arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs)->where('languageID', $oLanguage->languageID);
            if (isset($request->category_id)) {
                $arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs)->where('languageID', $oLanguage->languageID);
            } else {
                $arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs)->where('languageID', $oLanguage->languageID)->offset($offcet)->limit($quest_on_page);
            }
        } else {

            if (isset($request->category_id)) {
                $arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs);
            } else {
                $arrQuests = Quest::whereIn('questID', $arrQuestsUserIDs)->offset($offcet)->limit($quest_on_page);
            }
        }

        //-------------------------------------------------------------------------------------------

        if (isset($request->city)) {
            $oCity = City::where('name', $request->city)->first();
            if ($oCity) {
                $arrQuests->whereIn('cityID', [$oCity->cityID, 0]);
            }
        }

        $orderField = $request->get('orderField', 'sort_number');
        $orderDir = $request->get('orderDir', 'ASC');
        $arrQuestsGet = $arrQuests->orderBy($orderField, $orderDir)->get();

        $arrQuestsForJson = array();
        if (isset($request->category_id)) {
            foreach ($arrQuestsGet as $quest) {
                $categories = explode(',', $quest->categoryIDs);
                if (in_array($request->category_id, $categories)) {
                    $arrQuestsForJson[] = Quest::questJson($quest, $this->user_id);
                }
            }
        } else {
            foreach ($arrQuestsGet as $quest) {
                $arrQuestsForJson[] = Quest::questJson($quest, $this->user_id);
            }
        }

        //-------------------------------------------------------------------------------------------

        return $this->json($arrQuestsForJson);
    }










    /**
     * Display the specified resource.
     *
     * @param  Quest $quest
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Quest $quest)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $arrQuestInfo = Quest::questJson($quest, $this->user->userID);

        return $this->json($arrQuestInfo);
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Http\JsonResponse
     */
    public function files(Quest $quest)
    {
        return $this->json($quest->files()->orderBy('sort_number')->get());
    }


    /**
     * @param Quest $quest
     * @return \Illuminate\Http\JsonResponse
     */
    public function questions(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $oQuest = Quest::find($request->questID);

        return $this->json(QuestQuestion::questionsJson($oQuest));
    }


    /**
     * @param QuestQuestion $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function question(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $questQuestion = QuestQuestion::where('questionID', $request->questionID)->first();

        return $this->json(QuestQuestion::questionJson($questQuestion));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function answerTypes()
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(QuestAnswer::$ARR_TYPES_FOR_JSON);
    }


    /**
     * @param QuestQuestion $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function answer(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(QuestAnswer::answerJson(false, $request->questionID));
    }


    /**
     * @param QuestAnswer $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function answerById(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(QuestAnswer::answerJson($request->answerID, false));
    }


    /**
     * @param QuestQuestion $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function hints(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(QuestHint::hintsJson($request));
    }


    /**
     * @param QuestHint $hint
     * @return \Illuminate\Http\JsonResponse
     */
    public function hint(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(QuestHint::hintJson($request->hintID));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productIDS()
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(Quest::pluck('product_id'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function byProductId(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $oQuest = Quest::where('product_id', $request->product_id)->first();

        return $this->json(Quest::questMiniJson($oQuest));
    }

    /**
     * @param Quest $quest
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Quest $quest,Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        if (!empty($request->status)) {
            $oQuestUser = QuestUser::where('questID', $request->questID)->where('userID', $this->user->userID)->first();
            if (!$oQuestUser) {
                return $this->getError($this->_getTrans($request, [11,24,37]));
            }


            $oQuestUser->status = $request->status;
            $oQuestUser->update();

            return $this->getSuccess($this->_getTrans($request, [8,21,34]));
        }else{
            return $this->getError($this->_getTrans($request, [10,23,36]));
        }
    }

    public function uploadLog(Quest $quest,Request $request)
    {
        $questUser = QuestUser::where('quest_id',$quest->id)->where('user_id',$this->user->id);
        if(!$questUser->get()->isEmpty()){
            $questUser->update(['log'=>$request->log]);
            return $this->getSuccess('log updates');
        }else{
            return $this->getError('record not found');
        }
    }

    /**
     * Size of all files for one quest (return in Mb)
     *
     * @param $quest
     * @return float|int
     */
    public static function _questMemorySize ($quest)
    {
        $questQuestions = $quest->questions()->get();
        $questFiles = array();
        if (count($questQuestions) > 0) {
            $questionsIDs = array();
            foreach ($questQuestions as $question) {
                $questionsIDs[] = $question->id;
            }

            $questionsFiles = File::whereIn('filable_id', $questionsIDs)->where('filable_type', 'App\Models\QuestQuestion')->get();
            if (count($questionsFiles) > 0) {
                foreach ($questionsFiles as $questionsFile) {
                    $questFiles[] = $questionsFile;
                }
            }

            $questionsAnswers = QuestAnswer::whereIn('quest_question_id', $questionsIDs)->get();
            $answersIDs = array();
            if (count($questionsAnswers) > 0) {
                foreach ($questionsAnswers as $answer) {
                    $answersIDs[] = $answer->id;
                }
                $answersFiles = File::whereIn('filable_id', $answersIDs)->where('filable_type', 'App\Models\QuestAnswer')->get();
                if (count($answersFiles) > 0) {
                    foreach ($answersFiles as $answersFile) {
                        $questFiles[] = $answersFile;
                    }
                }
            }

            $questionsHints = QuestHint::whereIn('quest_question_id', $questionsIDs)->get();
            $hintsIDs = array();
            if (count($questionsHints) > 0) {
                foreach ($questionsHints as $hint) {
                    $hintsIDs[] = $hint->id;
                }
                $hintsFiles = File::whereIn('filable_id', $hintsIDs)->where('filable_type', 'App\Models\QuestHint')->get();
                if (count($hintsFiles) > 0) {
                    foreach ($hintsFiles as $hintsFile) {
                        $questFiles[] = $hintsFile;
                    }
                }
            }
        }

        if (count($questFiles) > 0) {
            $allFilesSize = 0;
            foreach ($questFiles as $questFile) {
	            if (file_exists($questFile->getFilePath())) {
		            $fileSize = filesize($questFile->getFilePath());
		            $allFilesSize = $allFilesSize + $fileSize;
	            }
            }
            $allFilesSize = ($allFilesSize / 1024) / 1024;

            return $allFilesSize;
        } else {
            return 0;
        }
    }

    /**
     * Save review and mark to the quest
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setMark (Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $reviewEntity = Review::where('userID', $this->user->userID)->where('questID', $request->quest_id)->get();

        if (!isset($reviewEntity) || count($reviewEntity) == 0) {
            $userReview = new Review();
            $userReview->userID = $this->user->userID;
            $userReview->questID = $request->quest_id;
            $userReview->review = $request->review;
            $userReview->points = $request->points;

            $userReview->save();

            return $this->getSuccess($this->_getTrans($request, [12,25,38]));
        } else {
            return $this->getError($this->_getTrans($request, [13,26,39]));
        }
    }
}
