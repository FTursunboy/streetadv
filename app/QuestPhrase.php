<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestPhrase extends Model
{
    protected $table = 'quest_phrases';

    protected $primaryKey = 'phraseID';

    public static $phraseTypes = [
        'correct_answer_phrases' => 'Правильные фразы ответов',
        'correct_geoanswer_phrases' => 'Правильные фразы гео ответов',
        'need_help_phrases' => 'Фразы помощи',
        'wrong_answer_phrases' => 'Неправильные фразы ответов',
        'wrong-answer-ask-for-hint' => 'Неправельные ответы на вопросы к подсказкам',
        'timer-finished' => 'Фраза при истечении времени таймера вопроса'
    ];

    public static $DEFAULT_DATA = [
        'correct_answer_phrases' => 'ура )',
        'correct_geoanswer_phrases' => 'Ура. Вы нашли это место!',
        'need_help_phrases' => 'Сломал голову, мне нужна подсказка.',
        'wrong_answer_phrases' => 'Это не правильный ответ.',
        'wrong-answer-ask-for-hint' => 'Неверный ответ, попробуй еще.',
        'timer-finished' => 'ну вооот) время - то вышло!'
    ];

    public function subDescription ($chars_count = 10, $start = 0, $ending = '...', $encoding = 'UTF-8') {
        $string = $this->attributes['description'];

        return mb_substr($string, $start, $chars_count, $encoding) . (mb_strlen($string) > $chars_count ? $ending : '');
    }

    public static function phrasesJson ($quest)
    {
        $oQuestPhrases = QuestPhrase::where('questID', $quest->questID)->get();

        $arrPhrases = [];
        foreach ($oQuestPhrases as $phrase) {
            $arrPhrases[$phrase['type']][] = [
                'id' => $phrase->phraseID,
                'type' => $phrase->type,
                'description' => $phrase->description,
                'voice' => $phrase->voice ? asset('uploads/phrases/' . $phrase->voice) : ''
            ];
        }

        return $arrPhrases;
    }
}
