<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestQuestion extends Model
{
    protected $table = 'quest_questions';

    protected $primaryKey = 'questionID';

    public static $partTypes = ['description', 'image', 'audio', 'video', 'timer'];

    public static $arrExt = [
        'image' => [
            'jpg', 'png', 'gif', 'bmp'
        ],
        'video' => [
            'mp4', 'avi'
        ],
        'audio' => [
            'mp3'
        ]
    ];
    public static function questionsJson ($questEntity)
    {
        if ($questEntity instanceof Quest){

            $arrQuestions = QuestQuestion::where('questID', $questEntity->questID)->orderBy('sort_number', 'ASC')->get();

            $arrQuestionForReturn = [];
            foreach ($arrQuestions as $question) {

                /***********************
                /** Questions parts
                /**********************/

                $oQuestionComponents = QuestQuestionComponent::where('questionID', $question->questionID)->orderBy('sort_number', 'ASC')->get();

                $arrQuestionComponentsForReturn = [];
                if (count($oQuestionComponents) > 0) {
                    foreach ($oQuestionComponents as $questionComponent) {

                        if ($questionComponent->type == 'file') {

                            $fileExt = explode('.', $questionComponent->file);

                            $fileType = 'undefined';
                            foreach (self::$arrExt as $type => $item) {
                                if (in_array($fileExt[1], $item)) {
                                    $fileType = $type;
                                }
                            }

                            $arrQuestionComponentsForReturn[] = [
                                'id' => $questionComponent->componentID,
                                'type' => $fileType,
                                'sort_number' => $questionComponent->sort_number,
                                'ext' => $fileExt[1],
                                'filename' => $questionComponent->file,
                                'file' => $questionComponent->file ? asset('uploads/questions/components/' . $questionComponent->file) : ''
                            ];

                        } elseif ($questionComponent->type == 'description') {

                            $arrQuestionComponentsForReturn[] = [
                                'id' => $questionComponent->componentID,
                                'type' => $questionComponent->type,
                                'sort_number' => $questionComponent->sort_number,
                                'text' => $questionComponent->description
                            ];

                        } elseif ($questionComponent->type == 'timer') {

                            $arrQuestionComponentsForReturn[] = [
                                'id' => $questionComponent->componentID,
                                'type' => $questionComponent->type,
                                'sort_number' => $questionComponent->sort_number,
                                'time' => $questionComponent->timer
                            ];

                        }
                    }
                }

                /***********************
                /** Answers parts
                /**********************/

                $arrAnswers = QuestAnswer::answersJson($question);

                /***********************
                /** Hints parts
                /**********************/

                $arrHints = QuestHint::hintsJson($question);

                $question->hemisphere != null ? $hemisphere = $question->hemisphere : $hemisphere = 1;
                $arrQuestionForReturn[] = [
                    'id' => $question->questionID,
                    'points' => $question->points,
                    'hemisphere' => $hemisphere,
                    'lat' => (float) $question->lat,
                    'lng' => (float) $question->lng,
                    'radius' => $question->radius,
                    'geoType' => $question->geoType,
                    'isAugmentedReality' => $question->isAugmentedReality,
                    'sort_number' => $question->sort_number,
                    'voice_over' => $question->voice_over ? asset('uploads/questions/' . $question->voice_over) : '',
                    'offline_map_image' => $question->offline_map_image ? asset('uploads/questions/' . $question->offline_map_image) : '',
                    'parts' => $arrQuestionComponentsForReturn,
                    'answer' => $arrAnswers,
                    'hints' => $arrHints
                ];
            }

            return $arrQuestionForReturn;
        } else {
            return false;
        }
    }

    public static function questionJson ($questionEntity)
    {
        if ($questionEntity instanceof QuestQuestion) {

            $arrQuestions = QuestQuestion::where('questionID', $questionEntity->questionID)->orderBy('sort_number', 'ASC')->first();

            /***********************
            /** Questions parts
            /**********************/

            $oQuestionComponents = QuestQuestionComponent::where('questionID', $arrQuestions->questionID)->orderBy('sort_number', 'ASC')->get();

            $arrQuestionComponentsForReturn = [];
            if (count($oQuestionComponents) > 0) {
                foreach ($oQuestionComponents as $questionComponent) {

                    if ($questionComponent->type == 'file') {

                        $fileExt = explode('.', $questionComponent->file);

                        $fileType = 'undefined';
                        foreach (self::$arrExt as $type => $item) {
                            if (in_array($fileExt[1], $item)) {
                                $fileType = $type;
                            }
                        }

                        $arrQuestionComponentsForReturn[] = [
                            'id' => $questionComponent->componentID,
                            'type' => $fileType,
                            'sort_number' => $questionComponent->sort_number,
                            'ext' => $fileExt[1],
                            'filename' => $questionComponent->file,
                            'file' => $questionComponent->file ? asset('uploads/questions/components/' . $questionComponent->file) : ''
                        ];

                    } elseif ($questionComponent->type == 'description') {

                        $arrQuestionComponentsForReturn[] = [
                            'id' => $questionComponent->componentID,
                            'type' => $questionComponent->type,
                            'sort_number' => $questionComponent->sort_number,
                            'text' => $questionComponent->description
                        ];

                    } elseif ($questionComponent->type == 'timer') {

                        $arrQuestionComponentsForReturn[] = [
                            'id' => $questionComponent->componentID,
                            'type' => $questionComponent->type,
                            'sort_number' => $questionComponent->sort_number,
                            'time' => $questionComponent->timer
                        ];

                    }
                }
            }

            $arrQuestions->hemisphere != null ? $hemisphere = $arrQuestions->hemisphere : $hemisphere = 1;
            $arrQuestionForReturn = [
                'id' => $arrQuestions->questionID,
                'points' => $arrQuestions->points,
                'hemisphere' => $hemisphere,
                'lat' => (float) $arrQuestions->lat,
                'lng' => (float) $arrQuestions->lng,
                'radius' => $arrQuestions->radius,
                'geoType' => $arrQuestions->geoType,
                'isAugmentedReality' => $arrQuestions->isAugmentedReality,
                'sort_number' => $arrQuestions->sort_number,
                'voice_over' => $arrQuestions->voice_over ? asset('uploads/questions/' . $arrQuestions->voice_over) : '',
                'offline_map_image' => $arrQuestions->offline_map_image ? asset('uploads/questions/' . $arrQuestions->offline_map_image) : '',
                'parts' => $arrQuestionComponentsForReturn,
            ];

            return $arrQuestionForReturn;
        }
    }
}
