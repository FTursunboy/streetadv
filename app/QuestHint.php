<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestHint extends Model
{
    protected $table = 'quest_hints';

    protected $primaryKey = 'hintID';

    public static function hintsJson ($question)
    {
        $oQuestHints = QuestHint::where('questionID', $question->questionID)->orderBy('sort_number', 'ASC')->get();

        $arrHintsForReturn = [];
        foreach ($oQuestHints as $questHint) {

            $oHintsComponents = QuestHintComponent::where('hintID', $questHint->hintID)->orderBy('sort_number', 'ASC')->get();

            $arrHintComponents = [];
            if (count($oHintsComponents) > 0) {
                foreach ($oHintsComponents as $hintsComponent) {

                    if ($hintsComponent->type == 'file' && $hintsComponent->file != '' && $hintsComponent->file != null) {

                        $fileExt = explode('.', $hintsComponent->file);

                        $fileType = 'undefined';
                        foreach (QuestQuestion::$arrExt as $type => $item) {
                            if (in_array($fileExt[1], $item)) {
                                $fileType = $type;
                            }
                        }

                        $arrHintComponents[] = [
                            'id' => $hintsComponent->componentID,
                            'type' => $fileType,
                            'ext' => $fileExt[1],
                            'sort_number' => $hintsComponent->sort_number,
                            'filename' => $hintsComponent->file,
                            'file' => $hintsComponent->file ? asset('uploads/hints/components/' . $hintsComponent->file) : ''
                        ];

                    } else {

                        $arrHintComponents[] = [
                            'id' => $hintsComponent->componentID,
                            'text' => $hintsComponent->description,
                            'type' => $hintsComponent->type,
                            'sort_number' => $hintsComponent->sort_number
                        ];
                    }
                }
            }

            $arrHintsForReturn[] = [
                'id' => $questHint->hintID,
                'sort_number' => $questHint->sort_number,
                'voice_over' => $questHint->voice_over ? asset('uploads/hints/' . $questHint->voice_over) : '',
                'points' => $questHint->points,
                'parts' => $arrHintComponents
            ];
        }

        return $arrHintsForReturn;
    }

    public static function hintJson ($hintID)
    {
        $oQuestHints = QuestHint::where('hintID', $hintID)->orderBy('sort_number', 'ASC')->first();


        $oHintsComponents = QuestHintComponent::where('hintID', $oQuestHints->hintID)->orderBy('sort_number', 'ASC')->get();

        $arrHintComponents = [];
        if (count($oHintsComponents) > 0) {
            foreach ($oHintsComponents as $hintsComponent) {

                if ($hintsComponent->type == 'file' && $hintsComponent->file != '' && $hintsComponent->file != null) {

                    $fileExt = explode('.', $hintsComponent->file);

                    $fileType = 'undefined';
                    foreach (QuestQuestion::$arrExt as $type => $item) {
                        if (in_array($fileExt[1], $item)) {
                            $fileType = $type;
                        }
                    }

                    $arrHintComponents[] = [
                        'id' => $hintsComponent->componentID,
                        'type' => $fileType,
                        'ext' => $fileExt[1],
                        'sort_number' => $hintsComponent->sort_number,
                        'filename' => $hintsComponent->file,
                        'file' => $hintsComponent->file ? asset('uploads/hints/components/' . $hintsComponent->file) : ''
                    ];

                } else {

                    $arrHintComponents[] = [
                        'id' => $hintsComponent->componentID,
                        'text' => $hintsComponent->description,
                        'type' => $hintsComponent->type,
                        'sort_number' => $hintsComponent->sort_number
                    ];
                }
            }
        }

        $arrHintsForReturn = [
            'id' => $oQuestHints->hintID,
            'sort_number' => $oQuestHints->sort_number,
            'voice_over' => $oQuestHints->voice_over ? asset('uploads/hints/' . $oQuestHints->voice_over) : '',
            'points' => $oQuestHints->points,
            'parts' => $arrHintComponents
        ];

        return $arrHintsForReturn;
    }
}
