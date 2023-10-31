<?php
    $oQuestUser = $object;
    $oQuest = \App\Quest::find($oQuestUser->questID);
    if ($oQuest) {
        $oQuestPhrases = \App\QuestPhrase::all()->keyBy('phraseID');
        $oQuestStatistic = \App\QuestStatistic::where('user_id', $oQuestUser->userID)
            ->where('quest_id', $oQuestUser->questID)
            ->get();

        $html = '';
        $userInfo = '';
        if (count($oQuestStatistic) > 0) {

            // Quest questions
            $arrQuestQuestionsIDs = [];

            $oQuestQuestions = \App\QuestQuestion::where('questID', $oQuest->questID);
            foreach ($oQuestQuestions as $question) {
                $arrQuestQuestionsIDs[] = $question->questionID;
            }

            $oQuestQuestionsDesc = \App\QuestQuestionComponent::whereIn('questionID', $arrQuestQuestionsIDs)->get();

            $arrQuestQuestionsDesc = [];
            foreach ($oQuestQuestionsDesc as $item) {
                $arrQuestQuestionsDesc[$item->questionID] = [
                    'name' => $item->description
                ];
            }

            // Question hints
            $oQuestionHints = \App\QuestHint::whereIn('questionID', $arrQuestQuestionsIDs)->get();

            $arrQuestionHintsIDs = [];
            foreach ($oQuestionHints as $hint) {
                $arrQuestionHintsIDs[] = $hint->hintID;
            }

            $oQuestionHintDesc = \App\QuestHintComponent::whereIn('hintID', $arrQuestionHintsIDs)->get();

            $arrQuestionsHintsDesc = [];
            foreach ($oQuestionHintDesc as $hint) {
                $arrQuestionsHintsDesc[$hint->hintID] = [
                    'name' => $hint->description
                ];
            }

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
            $arrCoords = [];
            $downloadTime = '';

            foreach ($arrQuestionsBox as $key => $questionBox) {
                if (isset($arrQuestQuestionsDesc[$key])) {
                    $html .= '<p class="questions-box label-primary">' . $i . ' - Вопрос: ' . $arrQuestQuestionsDesc[$key]['name'] . '</p>';
                } else {
                    $html .= '<p class="questions-box label-primary">' . $i . ' - Вопрос: Гео вопрос</p>';
                }
                foreach ($questionBox as $box) {
                    $time = \Carbon\Carbon::parse($box['time'])->format('d-m-Y H:i:s');
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
                }
                $i ++;
            }

            \Carbon\Carbon::setLocale('ru');
            if ($downloadTime != '') {
                $questBought = $downloadTime;
            } else {
                $questBought = $oQuestUser->created_at;
            }
            $diffDates = \Carbon\Carbon::parse($fistQuestionTime)->diffForHumans(\Carbon\Carbon::parse($questBought));
            $diffQuestionsTimes = \Carbon\Carbon::parse($fistQuestionTime)->diffInMinutes(\Carbon\Carbon::parse($lastQuestionTime));
//            $countQuestions = count($oQuest->questions);
//            $countEndedQuestions = $i - 1;
//            $countScoresAll = $answerScores;
//            $countScoresUser = $answerScores - $hintScores;
//            $arrCoords = json_encode($arrCoords);

//            $userInfo .= '<div class="dop-info-box">';
//            $userInfo .= '<p class="dop-info"><label>Пользователь:</label> <a href="' . url('admin/users/' . $oQuestUser->user->id . '/edit') . '" target="_blank"> ' . $oQuestUser->user->email . '</a></p>';
//            $userInfo .= '<p class="dop-info"><label>Квест куплен:</label> ' . \Carbon\Carbon::parse($questBought)->format('d-m-Y H:i:s') .'</p>';
//            $userInfo .= '<p class="dop-info"><label>Квест начат:</label> Через ' . $diffDates . ' покупки. ' . \Carbon\Carbon::parse($fistQuestionTime)->format('d-m-Y H:i:s') .'</p>';
//            $userInfo .= '<p class="dop-info"><label>Прогресс:</label><progress value="' . $countEndedQuestions . '" max="' . $countQuestions . '"></progress></p>';
//            $userInfo .= '<p class="dop-info"><label>Набрано очков:</label>' . $countScoresUser . ' из ' . $countScoresAll . ' возможных</p>';
//            $userInfo .= '<p class="dop-info"><label>Время между первым и последним вопросом:</label>' . $diffQuestionsTimes . ' минут(ы)</p>';
//            $userInfo .= '<div id="map" style="height: 500px;"></div>';
//            $userInfo .= '</div>';
//
//            $userInfo .= $html;

            if ($type == 'dateStart') {
                echo \Carbon\Carbon::parse($questBought)->format('d-m-Y H:i:s');
            }
            if ($type == 'dateEnd') {
                echo \Carbon\Carbon::parse($fistQuestionTime)->format('d-m-Y H:i:s');
            }
            if ($type == 'diff') {
                echo $diffQuestionsTimes . ' минут(ы)';
            }
        } else {
            if ($type == 'dateStart') {
                echo $oQuestUser->created_at;
            }

            return 0;
        }
    } else {
        return 0;
    }
