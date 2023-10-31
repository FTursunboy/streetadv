<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestUser extends Model
{
    protected $primaryKey = 'questUserID';

    protected $table = 'quest_users';

    public function points($quest_id,  $user_id)
    {
        return $this->stats($user_id, $quest_id, 'points');
    }

    public function progress($quest_id,  $user_id)
    {
        return $this->stats($user_id, $quest_id, 'progress');
    }

    public function stats($user_id, $quest_id, $type)
    {
        $oQuestStatistic = QuestStatistic::where('user_id', $user_id)
            ->where('quest_id', $quest_id)
            ->get();

        if (count($oQuestStatistic) > 0) {
            // generate array
            $arrQuestionsBox = [];
            foreach ($oQuestStatistic as $item) {
                $arrQuestionsBox[$item->question_id][] = [
                    'type' => $item->type,
                    'hintScore' => $item->hintScore,
                    'answerState' => $item->answerState,
                    'answerScore' => $item->answerScore,
                ];
            }

            $i = 1;
            $hintScores = '';
            $answerScores = 0;
//            dd($arrQuestionsBox);
            foreach ($arrQuestionsBox as $key => $questionBox) {
                foreach ($questionBox as $box) {
                    if ($box['type'] == 'hint') {
//                        $hintScores += $box['hintScore'] != null && $box['hintScore'] != '' ? $box['hintScore'] : 0;
                        $hintScores = 0;
                    }
                    if ($box['type'] == 'answer') {

                        if ($box['answerState'] == 'right') {
//                            $answerScores += $box['answerScore'] != null ? $box['answerScore'] : 0;
                            $answerScores = 0;
                        }
                    }
                }
                $i ++;
            }

            if ($type == 'progress') {
                $oQuest = Quest::find($quest_id);
                if ($oQuest) {

                    $oQuestQuestions = QuestQuestion::where('questID', $oQuest->questID)->get();
                    $countQuestions = count($oQuestQuestions);
                    $countEndedQuestions = $i - 1;
                    $html = '<progress value="' . $countEndedQuestions . '" max="' . $countQuestions . '"></progress>';
                } else {
                    $html = '';
                }


                return $html;
            }
            if ($type == 'points') {
                return (int) $answerScores - (int) $hintScores;
            }
        } else {
            return 0;
        }
    }
}
