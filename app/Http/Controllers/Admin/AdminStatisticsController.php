<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\Language;
use App\Page;
use App\Quest;
use App\QuestHint;
use App\QuestHintComponent;
use App\QuestPhrase;
use App\QuestQuestion;
use App\QuestQuestionComponent;
use App\QuestStatistic;
use App\QuestUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminStatisticsController extends Controller
{
    public function listItems(Request $request)
    {
        $oObjects = QuestUser::orderBy('created_at', 'DESC')->paginate(20);

        if ($request->isMethod('post')) {
            if (isset($request->questID) && $request->questID != 0) {
                $oObjects = QuestUser::where('questID', $request->questID)->orderBy('created_at', 'DESC')->paginate(20);
            }
        }

        $arrObjects = [];
//        if (count($oObjects) > 0) {
//            foreach ($oObjects as $object) {
//                $oStat = QuestStatistic::where('userID', $object->userID)
//                    ->where('questID', $object->questID);
//            }
//        }


        $oQuests = Quest::all();

        return view('admin.statistics.list', [
            'arrObjects' => $oObjects,
            'oQuests' => $oQuests,
            'data' => $request
        ]);
    }
    public function showItem(Request $request)
    {
        $statisticID = $request->id;
        $oObject = $this->generateData($statisticID);

        return view('admin.statistics.edit', [
            'data' => $oObject,
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Page::where('pageID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }

    public function generateData($id)
    {
        $oQuestUser = QuestUser::find($id);
        $oUser = User::find($oQuestUser->userID);
        $oQuest = Quest::find($oQuestUser->questID);
        $oQuestPhrases = QuestPhrase::all()->keyBy('phraseID');
        $oQuestStatistic = QuestStatistic::where('user_id', $oQuestUser->userID)
            ->where('quest_id', $oQuestUser->questID)
            ->get();

        $html = '';
        $userInfo = '';
        $arrCoords = [];
        if (count($oQuestStatistic) > 0) {

            // Quest questions
            $oQuestQuestions = QuestQuestion::where('questID', $oQuest->questID)->get();
            $arrQuestQuestionsIDs = [];
            foreach ($oQuestQuestions as $question) {
                $arrQuestQuestionsIDs[] = $question->questionID;
            }

            $oQuestQuestionsDesc = QuestQuestionComponent::whereIn('questionID', $arrQuestQuestionsIDs)->get();

            $arrQuestQuestionsDesc = [];
            foreach ($oQuestQuestionsDesc as $item) {
                $arrQuestQuestionsDesc[$item->questionID] = [
                    'name' => $item->description
                ];
            }

            // Question hints
            $oQuestionHints = QuestHint::whereIn('questionID', $arrQuestQuestionsIDs)->get();

            $arrQuestionHintsIDs = [];
            foreach ($oQuestionHints as $hint) {
                $arrQuestionHintsIDs[] = $hint->hintID;
            }

            $oQuestionHintDesc = QuestHintComponent::whereIn('hintID', $arrQuestionHintsIDs)->get();

            $arrQuestionsHintsDesc = [];
            foreach ($oQuestionHintDesc as $hint) {
                $arrQuestionsHintsDesc[$hint->hintID] = [
                    'name' => $hint->description
                ];
            }
//            dd($oQuestionHints);
            // generate array
            $arrQuestionsBox = [];
            foreach ($oQuestStatistic as $item) {
                $arrQuestionsBox[$item->question_id][] = [
                    'type' => $item->type,
                    'lat' => $item->loc_lat,
                    'lon' => $item->loc_lon,
                    'time' => $item->time,
                    'downloadTime' => $item->downloadTime,
                    'hint_id' => $item->hint_id,
                    'hintScore' => $item->hintScore,
                    'phrase_id' => $item->phrase_id,
                    'phraseType' => $item->phraseType,
                    'answerState' => $item->answerState,
                    'answerType' => $item->answerType,
                    'answerScore' => $item->answerScore,
                    'answerText' => $item->answerText,
                    'data' => $item->data,
                ];
            }

            // edit html for view
            $i = 1;
            $fistQuestionTime = '';
            $lastQuestionTime = '';
            $answerScores = 0;
            $hintScores = 0;
            $downloadTime = '';
//dd($arrQuestionsHintsDesc);
            foreach ($arrQuestionsBox as $key => $questionBox) {
                if (isset($arrQuestQuestionsDesc[$key])) {
                    $html .= '<p class="questions-box label-primary">' . $i . ' - Вопрос: ' . $arrQuestQuestionsDesc[$key]['name'] . '</p>';
                } else {
                    $html .= '<p class="questions-box label-primary">' . $i . ' - Вопрос: Гео вопрос</p>';
                }
                foreach ($questionBox as $box) {
                    $time = Carbon::parse($box['time'])->format('d-m-Y H:i:s');
                    if ($box['type'] == 'question') {
                        $html .= '<div class="question-box">';
                        $html .= '<span class="question-label"></span><label>Задан вопрос к пользователю. (' . $time . ')</label>';
                        $html .= '</div>';
                        if ($i == 1) {
                            $fistQuestionTime = $box['time'];
                            $downloadTime = $box['downloadTime'];
                        } else {
                            $lastQuestionTime = $box['time'];
                        }
                        $arrCoords[] = [
                            'lon' => $box['lon'],
                            'lat' => $box['lat'],
                        ];
                    }
                    // -------Phrases-------
                    if ($box['type'] == 'phrase') {
                        $html .= '<div class="question-box">';
                        if ($box['phraseType'] == 'need_help_phrases') {
                            $html .= '<span class="question-label label-warning"></span><label>Пользователь просит помощи. (' . $time . ')</label>';
                            if (isset($oQuestPhrases[$box['phrase_id']])) {
                                $html .= '<p>' . $oQuestPhrases[$box['phrase_id']]->description .'</p>';
                            }
                        }
                        if ($box['phraseType'] == 'correct_answer_phrases') {
                            $html .= '<span class="question-label label-primary"></span><label>Сообщение от приложения. (' . $time . ')</label>';
                            if (isset($oQuestPhrases[$box['phrase_id']])) {
                                $html .= '<p>' . $oQuestPhrases[$box['phrase_id']]->description .'</p>';
                            }
                        }
                        if ($box['phraseType'] == 'correct_geoanswer_phrases') {
                            $html .= '<span class="question-label label-primary"></span><label>Сообщение от приложения. (' . $time . ')</label>';
                            if (isset($oQuestPhrases[$box['phrase_id']])) {
                                $html .= '<p>' . $oQuestPhrases[$box['phrase_id']]->description .'</p>';
                            }
                        }
                        if ($box['phraseType'] == 'wrong_answer_phrases') {
                            $html .= '<span class="question-label label-default"></span><label>Сообщение от приложения. (' . $time . ')</label>';
                            if (isset($oQuestPhrases[$box['phrase_id']])) {
                                $html .= '<p>' . $oQuestPhrases[$box['phrase_id']]->description .'</p>';
                            }
                        }
                        $html .= '</div>';
                    }
                    // -------Hints-------
                    if ($box['type'] == 'hint') {
                        $html .= '<div class="question-box">';
                        $html .= '<span class="question-label label-danger"></span><label>Пользователю дана подсказка: (' . $time . ')</label>';
                        if (isset($arrQuestionsHintsDesc[$box['hint_id']])) {
                            $html .= '<p>' . $arrQuestionsHintsDesc[$box['hint_id']]['name'] .'</p>';
                        } else {
                            $html .= '<p>Нет</p>';
                        }
                        $html .= '</div>';
                        $hintScores += $box['hintScore'];
                    }
                    // -------Answers-------
                    if ($box['type'] == 'answer') {
                        if ($box['answerState'] == 'hintEnded') {
                            $html .= '<div class="question-box">';
                            if ($box['answerType'] == 'text') {
                                $html .= '<span class="question-label label-default"></span><label>Ответ пользователя не верный. (' . $time . ')</label>';
                                $html .= '<p>Ответ: ' . $box['answerText'] . '</p>';
                                $html .= '<p>Подсказок больше нет. Переходим к следующему вопросу.</p>';
                            }
                            if ($box['answerType'] == 'video') {
                                $html .= '<span class="question-label label-default"></span><label>Ответ пользователя не верный. (' . $time . ')</label>';
                                $html .= '<p>Видео ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p> ';
                                $html .= '<video src="' . asset($box['data']) . '" controls width="320" height="240"></video>';
                                $html .= '<p>Подсказок больше нет. Переходим к следующему вопросу.</p>';
                            }
                            if ($box['answerType'] == 'audio') {
                                $html .= '<span class="question-label label-default"></span><label>Ответ пользователя не верный. (' . $time . ')</label>';
                                $html .= '<p>Аудио ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p>';
                                $html .= '<audio src="' . asset($box['data']) . '" controls></audio>';
                                $html .= '<p>Подсказок больше нет. Переходим к следующему вопросу.</p>';
                            }
                            if ($box['answerType'] == 'image') {
                                $html .= '<span class="question-label label-default"></span><label>Ответ пользователя не верный. (' . $time . ')</label>';
                                $html .= '<p>Изображение: <a href="' . asset($box['data']) . '" data-toggle="lightbox"><img class="thumbnail" src="' . asset($box['data']) . '" width="80"></a></p>';
                                $html .= '<p>Подсказок больше нет. Переходим к следующему вопросу.</p>';
                            }
                            $html .= '</div>';
                        }
                        if ($box['answerState'] == 'right') {
                            $html .= '<div class="question-box">';
                            if ($box['answerType'] == 'text') {
                                $html .= '<span class="question-label label-success"></span><label>Пользователь дал верный ответ. (' . $time . ')</label>';
                                $html .= '<p>Ответ: ' . $box['answerText'] . '</p>';
                            }
                            if ($box['answerType'] == 'video') {
                                $html .= '<span class="question-label label-success"></span><label>Пользователь дал верный ответ. (' . $time . ')</label>';
                                $html .= '<p>Видео ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p> ';
                                $html .= '<video src="' . asset($box['data']) . '" controls width="320" height="240"></video>';
                            }
                            if ($box['answerType'] == 'audio') {
                                $html .= '<span class="question-label label-success"></span><label>Пользователь дал верный ответ. (' . $time . ')</label>';
                                $html .= '<p>Аудио ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p>';
                                $html .= '<audio src="' . asset($box['data']) . '" controls></audio>';
                            }
                            if ($box['answerType'] == 'image') {
                                $html .= '<span class="question-label label-success"></span><label>Пользователь дал верный ответ. (' . $time . ')</label>';
                                $html .= '<p>Изображение: <a href="' . asset($box['data']) . '" data-toggle="lightbox"><img class="thumbnail" src="' . asset($box['data']) . '" width="80"></a></p>';
                            }
                            $html .= '</div>';
                            $answerScores += $box['answerScore'];
                        }
                        if ($box['answerState'] == 'wrong') {
                            $html .= '<div class="question-box">';
                            if ($box['answerType'] == 'text') {
                                $html .= '<span class="question-label label-danger"></span><label>Пользователь ответил не верно. (' . $time . ')</label>';
                                $html .= '<p>Ответ: ' . $box['answerText'] . '</p>';
                            }
                            if ($box['answerType'] == 'video') {
                                $html .= '<span class="question-label label-danger"></span><label>Пользователь ответил не верно. (' . $time . ')</label>';
                                $html .= '<p>Видео ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p> ';
                                $html .= '<video src="' . asset($box['data']) . '" controls width="320" height="240"></video>';
                            }
                            if ($box['answerType'] == 'audio') {
                                $html .= '<span class="question-label label-danger"></span><label>Пользователь ответил не верно. (' . $time . ')</label>';
                                $html .= '<p>Аудио ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p>';
                                $html .= '<audio src="' . asset($box['data']) . '" controls></audio>';
                            }
                            if ($box['answerType'] == 'image') {
                                $html .= '<span class="question-label label-danger"></span><label>Пользователь ответил не верно. (' . $time . ')</label>';
                                $html .= '<p>Изображение: <a href="' . asset($box['data']) . '" data-toggle="lightbox"><img class="thumbnail" src="' . asset($box['data']) . '" width="80"></a></p>';
                            }
                            $html .= '</div>';
                        }
                        if ($box['answerState'] == 'timerPassed') {
                            $html .= '<div class="question-box">';
                            if ($box['answerType'] == 'text') {
                                $html .= '<span class="question-label label-danger"></span><label>Время таймера закончилось. (' . $time . ')</label>';
                                $html .= '<p>Ответ: ' . $box['answerText'] . '</p>';
                            }
                            if ($box['answerType'] == 'video') {
                                $html .= '<span class="question-label label-danger"></span><label>Время таймера закончилось. (' . $time . ')</label>';
                                $html .= '<p>Видео ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p> ';
                                $html .= '<video src="' . asset($box['data']) . '" controls width="320" height="240"></video>';
                            }
                            if ($box['answerType'] == 'audio') {
                                $html .= '<span class="question-label label-danger"></span><label>Время таймера закончилось. (' . $time . ')</label>';
                                $html .= '<p>Аудио ответ: <a href="' . asset($box['data']) . '">Скачать файл</a></p>';
                                $html .= '<audio src="' . asset($box['data']) . '" controls></audio>';
                            }
                            if ($box['answerType'] == 'image') {
                                $html .= '<span class="question-label label-danger"></span><label>Время таймера закончилось. (' . $time . ')</label>';
                                $html .= '<p>Изображение: <a href="' . asset($box['data']) . '" data-toggle="lightbox"><img class="thumbnail" src="' . asset($box['data']) . '" width="80"></a></p>';
                            }
                            $html .= '</div>';
                        }
                    }
                }
                $i ++;
            }

            Carbon::setLocale('ru');
            if ($downloadTime != '') {
                $questBought = $downloadTime;
            } else {
                $questBought = $oQuestUser->created_at;
            }

            $diffDates = Carbon::parse($fistQuestionTime)->diffForHumans(Carbon::parse($questBought));
            $diffQuestionsTimes = Carbon::parse($fistQuestionTime)->diffInMinutes(Carbon::parse($lastQuestionTime));
            if(is_array($oQuest->questions))
                $countQuestions = count($oQuest->questions);
            else
                $countQuestions = 1;
            $countEndedQuestions = $i - 1;
            $countScoresAll = $answerScores;
            $countScoresUser = $answerScores - $hintScores;
            $arrCoords = json_encode($arrCoords);

            $userInfo .= '<div class="dop-info-box">';
            $userInfo .= '<p class="dop-info"><label>Пользователь:</label> <a href="' . url('admin/users/' . $oUser->userID . '/edit') . '" target="_blank"> ' . $oUser->email . '</a></p>';
            $userInfo .= '<p class="dop-info"><label>Квест куплен:</label> ' . Carbon::parse($questBought)->format('d-m-Y H:i:s') .'</p>';
            $userInfo .= '<p class="dop-info"><label>Квест начат:</label> Через ' . $diffDates . ' покупки. ' . Carbon::parse($fistQuestionTime)->format('d-m-Y H:i:s') .'</p>';
            $userInfo .= '<p class="dop-info"><label>Прогресс:</label><progress value="' . $countEndedQuestions . '" max="' . $countQuestions . '"></progress></p>';
            $userInfo .= '<p class="dop-info"><label>Набрано очков:</label>' . $countScoresUser . ' из ' . $countScoresAll . ' возможных</p>';
            $userInfo .= '<p class="dop-info"><label>Время между первым и последним вопросом:</label>' . $diffQuestionsTimes . ' минут(ы)</p>';
            $userInfo .= '<div id="map" style="height: 500px;"></div>';
            $userInfo .= '</div>';

            $userInfo .= $html;
        }
        if (is_array($arrCoords) && empty($arrCoords)) {
            $arrCoords = json_encode($arrCoords);
        }
//        $arrCoords = str_replace('"', "'", $arrCoords);
//        dd($arrCoords);
        $arrData = [
            'coords' => $arrCoords,
            'data' => $userInfo
        ];

        return $arrData;
    }

    public function usersData(Request $request)
    {
        $oStats = collect();
        if ($request->isMethod('post')) {

            $oStats = QuestStatistic::orderBy('created_at', 'DESC');

            if ($request->questID != 0) {
                $oStats = $oStats->where('quest_id', $request->questID);
            }
            if ($request->userID != 0) {
                $oStats = $oStats->where('user_id', $request->userID);
            }

            $oStats = $oStats->whereNotNull('data');
            $oStats = $oStats->get();
        }

        $oUsers = User::orderBy('email', 'ASC')->get()->keyBy('userID');
        $oQuests = Quest::orderBy('questID', 'ASC')->get()->keyBy('questID');

        return view('admin.statistics.userData', [
            'arrObjects' => $oStats,
            'oUsers' => $oUsers,
            'oQuests' => $oQuests,
            'data' => $request
        ]);
    }
}
