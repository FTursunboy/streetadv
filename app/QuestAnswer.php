<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestAnswer extends Model
{
    protected $table = 'quest_answers';

    protected $primaryKey = 'answerID';

    public static $ARR_TYPES = [
        'text_input' => [
            'title'  => 'Ввод текста',
            'button' => 'text'
        ],
        'text_choice' => [
            'title' => 'Выбрать текст из нескольких вариантов',
            'button' => 'text'
        ],
        'text_multi_choice' => [
            'title' => '2 или более текстовых варианта ответа',
            'button' => 'text'
        ],
        'text_button' => [
            'title' => 'Нажатие на кнопку с текстом',
            'button' => 'text'
        ],
        'image_choice' => [
            'title' => 'Выбор из нескольких картинок',
            'button' => 'file'
        ],
        'image_piece' => [
            'title' => 'Участок фотографии, отличающийся от реальности',
            'button' => 'file'
        ],
        'image_puzzle' => [
            'title' => 'Сбор пазла',
            'button' => 'file'
        ],
        'camera' => [
            'title' => 'Кнопка с камерой',
            'button' => ''
        ],
        'qr_code' => [
            'title' => 'Считывание QR-кода',
            'button' => ''
        ],
        'file_audio' => [
            'title' => 'Аудио файл пользователя',
            'button' => ''
        ],
        'file_video' => [
            'title' => 'Видео файл пользователя',
            'button' => ''
        ],
        'image_ar_find' => [
            'title' => 'AR Поиск объекта вокруг себя',
            'button' => 'file'
        ],
        'cold_hot' => [
            'title' => 'Горячо/Холодно',
            'button' => ''
        ]
    ];

    public static $ARR_TYPES_FOR_JSON = [
        'text_input' => 'Ввод текста',
        'text_choice' => 'Выбрать текст из нескольких вариантов',
        'text_multi_choice' => '2 или более текстовых варианта ответа',
        'text_button' => 'Нажатие на кнопку с текстом',
        'image_choice' => 'Выбор из нескольких картинок',
        'image_piece' => 'Участок фотографии, отличающийся от реальности',
        'image_puzzle' => 'Сбор пазла',
        'camera' => 'Кнопка с камерой',
        'qr_code' => 'Считывание QR-кода',
        'file_audio' => 'Аудио файл пользователя',
        'file_video' => 'Видео файл пользователя',
        'image_ar_map_find' => 'AR Поиск объекта на карте',
        'image_ar_find' => 'AR Поиск объекта вокруг себя',
        'cold_hot' => 'Горячо/Холодно',
        'dop_reality' => 'С доп. реальностью'
    ];

    public static function answersJson ($question)
    {
        $oQuestsAnswers = QuestAnswer::where('questionID', $question->questionID)->orderBy('sort_number', 'ASC')->get();

        $arrAnswersForReturn = [];
        foreach ($oQuestsAnswers as $questsAnswer) {

            $coords = null;

            if ($questsAnswer->type == 'image_piece' && $questsAnswer->coords != null && $questsAnswer->coords != '') {

                $coordsTemp = json_decode($questsAnswer->coords);
                $coords = [
                    'x1' => (int) $coordsTemp->x,
                    'y1' => (int) $coordsTemp->y,
                    'width' => (int) $coordsTemp->width,
                    'height' => (int) $coordsTemp->height
                ];
            }

            $oAnswerComponents = QuestAnswerComponent::where('answerID', $questsAnswer->answerID)->orderBy('sort_number', 'ASC')->get();

            $arrAnswerComponents = [];
            if (count($oAnswerComponents) > 0) {
                foreach ($oAnswerComponents as $answerComponent) {

                    if ($answerComponent->file != null && $answerComponent->file != '') {

                        $fileExt = explode('.', $answerComponent->file);

                        $fileType = 'undefined';
                        foreach (QuestQuestion::$arrExt as $type => $item) {
                            if (in_array($fileExt[1], $item)) {
                                $fileType = $type;
                            }
                        }

                        $arrAnswerComponents[] = [
                            'id' => $answerComponent->componentID,
                            'type' => $fileType,
                            'ext' => $fileExt[1],
                            'text' => $answerComponent->text,
                            'right' => $answerComponent->right,
                            'sort_number' => $answerComponent->sort_number,
                            'filename' => $answerComponent->file,
                            'file' => $answerComponent->file ? asset('uploads/answers/components/' . $answerComponent->file) : ''
                        ];

                    } else {

                        $arrAnswerComponents[] = [
                            'id' => $answerComponent->componentID,
                            'text' => $answerComponent->text,
                            'right' => $answerComponent->right,
                            'sort_number' => $answerComponent->sort_number
                        ];
                    }
                }
            }

            $arrAnswersForReturn = [
                'id' => $questsAnswer->answerID,
                'type' => $questsAnswer->type,
                'sort_number' => $questsAnswer->sort_number,
                'voice_over' => $questsAnswer->voice_over ? asset('uploads/answers/' . $questsAnswer->voice_over) : '',
                'coords' => $coords,
                'parts' => $arrAnswerComponents
            ];
        }

        return $arrAnswersForReturn;
    }

    public static function answerJson ($answerID = false , $questionID = false)
    {
        if ($questionID) {
            $questsAnswer = QuestAnswer::where('questionID', $questionID)->orderBy('sort_number', 'ASC')->first();
        } else {
            $questsAnswer = QuestAnswer::where('answerID', $answerID)->orderBy('sort_number', 'ASC')->first();
        }

        $coords = null;

        if ($questsAnswer->type == 'image_piece' && $questsAnswer->coords != null && $questsAnswer->coords != '') {

            $coordsTemp = json_decode($questsAnswer->coords);
            $coords = [
                'x1' => (int) $coordsTemp->x,
                'y1' => (int) $coordsTemp->y,
                'width' => (int) $coordsTemp->width,
                'height' => (int) $coordsTemp->height
            ];
        }

        $oAnswerComponents = QuestAnswerComponent::where('answerID', $questsAnswer->answerID)->orderBy('sort_number', 'ASC')->get();

        $arrAnswerComponents = [];
        if (count($oAnswerComponents) > 0) {
            foreach ($oAnswerComponents as $answerComponent) {

                if ($answerComponent->file != null && $answerComponent->file != '') {

                    $fileExt = explode('.', $answerComponent->file);

                    $fileType = 'undefined';
                    foreach (QuestQuestion::$arrExt as $type => $item) {
                        if (in_array($fileExt[1], $item)) {
                            $fileType = $type;
                        }
                    }

                    $arrAnswerComponents[] = [
                        'id' => $answerComponent->componentID,
                        'type' => $fileType,
                        'ext' => $fileExt[1],
                        'text' => $answerComponent->text,
                        'right' => $answerComponent->right,
                        'sort_number' => $answerComponent->sort_number,
                        'filename' => $answerComponent->file,
                        'file' => $answerComponent->file ? asset('uploads/answers/components/' . $answerComponent->file) : ''
                    ];

                } else {

                    $arrAnswerComponents[] = [
                        'id' => $answerComponent->componentID,
                        'text' => $answerComponent->text,
                        'right' => $answerComponent->right,
                        'sort_number' => $answerComponent->sort_number
                    ];
                }
            }
        }

        $arrAnswersForReturn = [
            'id' => $questsAnswer->answerID,
            'type' => $questsAnswer->type,
            'sort_number' => $questsAnswer->sort_number,
            'voice_over' => $questsAnswer->voice_over ? asset('uploads/answers/' . $questsAnswer->voice_over) : '',
            'coords' => $coords,
            'parts' => $arrAnswerComponents
        ];

        return $arrAnswersForReturn;
    }
}
