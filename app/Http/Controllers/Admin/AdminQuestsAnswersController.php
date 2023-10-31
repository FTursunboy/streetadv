<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\Quest;
use App\QuestAnswer;
use App\QuestAnswerComponent;
use App\QuestQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AdminQuestsAnswersController extends Controller
{
    protected $type = 'answers';

    public function editItems(Request $request, Helpers $helpers, $questionID, $answerID = null)
    {
        $oQuestion = QuestQuestion::find($questionID);
        $oAnswer = QuestAnswer::find($answerID);

        if (!$oQuestion || !$oAnswer) {
            abort(404);
        }

        // Запись данных в базу
        if ($request->method() == "POST") {

            // Обновление данных
            $oAnswer->type = $request['type'];
            $oAnswer->coords = isset($request['coords']) ? $request['coords'] : '';

            // Work with images and files
            if ($request->hasFile('voice_over')) {
                $helpers->deleteOldFile($oAnswer->voice_over, $this->type);
                $newFileName = $helpers->uploadNewFile($request, 'voice_over', $this->type);
                $oAnswer->voice_over = $newFileName;
            } else {
                if($helpers->checkFileExist($oAnswer->voice_over, $this->type) == false) {
                    $oAnswer->voice_over = null;
                }
            }

            $oAnswer->update();

            // Work with answer components
            $this->saveComponents($helpers, $request, $oQuestion->questID, $oQuestion->questionID, $request['answerID'], $request['type']);

            return redirect()->back()->with('success', 'Изменения сохранены.');
        }

        $oQuest = Quest::find($oQuestion->questID);
        $arrAnswersTypes = QuestAnswer::$ARR_TYPES;
        $oComponents = QuestAnswerComponent::where('answerID', $answerID)
            ->orderBy('sort_number', 'ASC')
            ->get();
            //->keyBy('sort_number');

        // Весь список вопросов для быстрой пагинации внутри сущности
        $oQuestionsList = QuestQuestion::where('questID', $oQuest->questID)
            ->orderBy('sort_number', 'ASC')
            ->get()
            ->keyBy('questionID');

        return view('admin.answers.edit', [
            'oQuest' => $oQuest,
            'oAnswer' => $oAnswer,
            'oQuestion' => $oQuestion,
            'arrAnswersTypes' => $arrAnswersTypes,
            'oComponents' => $oComponents,
            'oQuestionsList' => $oQuestionsList
        ]);
    }

    public function ajaxChangeAnswerComponent(Request $request)
    {
        if ($request->ajax()) {

            $component = $request->component;
            $arrAnswerTypes = QuestAnswer::$ARR_TYPES;

            $html = '';
            foreach ($arrAnswerTypes as $key => $answerType) {
                if ($component == $key) {
                    $html = $answerType['button'];
                }
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'type' => $component
            ]);
        }
    }

    public function ajaxAddAnswerComponent(Request $request)
    {
        if ($request->ajax()) {

            $component = $request->component;
            $arrAnswerTypes = QuestAnswer::$ARR_TYPES;

            $html = '';
            foreach ($arrAnswerTypes as $key => $answerType) {
                if ($component == $key) {
                    if ($answerType['button'] != '') {
                        $html = View::make('admin.answers.components.' . $key);
                        $html = $html->render();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'type' => $component
            ]);
        }
    }

    public function saveComponents(Helpers $helpers, $request, $questID, $questionID, $answerID, $type)
    {
        QuestAnswerComponent::where('answerID', $answerID)->delete();

        if (isset($request->components)) {

            $components = $request->components;

            // Save description components
            if (isset($components['text'])) {
                foreach ($components['text'] as $sortNumber => $component) {

                    $oNewComponent = new QuestAnswerComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->answerID = $answerID;
                    $oNewComponent->type = $type;
                    $oNewComponent->text = $component;
                    $oNewComponent->sort_number = $sortNumber;

                    // Save right components
                    if (isset($components['right'])) {
                       $oNewComponent->right = $components['right'][$sortNumber];
                    }

                    $oNewComponent->save();
                }
            }

            // Save temp components
            if (isset($components['temp'])) {
                foreach ($components['temp'] as $sortNumber => $component) {
                    if (isset($request->files->all()['components']['file'][$sortNumber])) {
                        $helpers->deleteOldFile($component, 'answers/components');
                    } else {
                        $oNewComponent = new QuestAnswerComponent();

                        $oNewComponent->questID = $questID;
                        $oNewComponent->questionID = $questionID;
                        $oNewComponent->answerID = $answerID;
                        $oNewComponent->type = $type;
                        $oNewComponent->file = $component;
                        $oNewComponent->sort_number = $sortNumber;

                        // Save right components
                        if (isset($components['right'][$sortNumber])) {
                            $oNewComponent->right = $components['right'][$sortNumber];
                        }

                        $oNewComponent->save();
                    }
                }
            }

            // Save file components
            if (isset($request->files->all()['components']['file'])) {
                $componentsFiles = $request->files->all()['components']['file'];
                foreach ($componentsFiles as $sortNumber => $componentsFile) {

                    $newFileName = $helpers->generateFileName($componentsFile->getClientOriginalName());
                    $componentsFile->move(public_path() . '/uploads/answers/components', $newFileName);
                    $oNewComponent = new QuestAnswerComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->answerID = $answerID;
                    $oNewComponent->type = $type;
                    $oNewComponent->file = $newFileName;
                    $oNewComponent->sort_number = $sortNumber;

                    // Save right components
                    if (isset($components['right'])) {
                        $oNewComponent->right = $components['right'][$sortNumber];
                    }

                    $oNewComponent->save();
                }
            }
        }
    }
}
