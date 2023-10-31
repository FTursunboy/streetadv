<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\Quest;
use App\QuestAnswer;
use App\QuestQuestion;
use App\QuestQuestionComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AdminQuestsQuestionsController extends Controller
{
    protected $type = 'questions';

    public function listItems($questID)
    {
        $oQuest = Quest::find($questID);
        if (!$oQuest) {
            abort(404);
        } else {
            $oObjects = QuestQuestion::where('questID', $questID)->orderBy('sort_number', 'ASC')->get();

            return view('admin.questions.list', [
                'arrObjects' => $oObjects,
                'oQuest' => $oQuest
            ]);
        }
    }

    public function editItems(Request $request, Helpers $helpers, $questID, $typeName = null, $questionID = null)
    {
        $oQuest = Quest::find($questID);

        if (!$oQuest || ($typeName != 'question' && $typeName != null)) {
            abort(404);
        }

        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($questionID) && $questionID != null) {
            $data['edit'] = true;
            $data['obj'] = QuestQuestion::where('questionID', $questionID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['questionID'])) {

                // Обновление данных
                $object = QuestQuestion::find($request['questionID']);

                $object->questID = $oQuest->questID;
                $object->points = $request['points'];
                $object->hemisphere = $request['hemisphere'];
                $object->lat = $request['lat'];
                $object->lng = $request['lng'];
                $object->radius = $request['radius'];
                $object->geoType = isset($request['geoType']) ? $request['geoType'] : 0;
                $object->isAugmentedReality = isset($request['isAugmentedReality']) ? $request['isAugmentedReality'] : 0;

                // Work with images and files
                if ($request->hasFile('voice_over')) {
                    $helpers->deleteOldFile($object->voice_over, $this->type);
                    $newFileName = $helpers->uploadNewFile($request, 'voice_over', $this->type);
                    $object->voice_over = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->voice_over, $this->type) == false) {
                        $object->voice_over = null;
                    }
                }

                if ($request->hasFile('offline_map_image')) {
                    $helpers->deleteOldFile($object->offline_map_image, $this->type);
                    $newFileName = $helpers->uploadNewFile($request, 'offline_map_image', $this->type);
                    $object->offline_map_image = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->offline_map_image, $this->type) == false) {
                        $object->offline_map_image = null;
                    }
                }

                $object->update();

                // Work with questions components

                $this->saveComponents($helpers, $request, $questID, $request['questionID'], true);

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {

                // Сохраннение данных
                $object = new QuestQuestion();

                $object->questID = $oQuest->questID;
                $object->points = $request['points'];
                $object->hemisphere = $request['hemisphere'];
                $object->lat = $request['lat'];
                $object->lng = $request['lng'];
                $object->radius = $request['radius'];
                $object->geoType = isset($request['geoType']) ? $request['geoType'] : 0;
                $object->isAugmentedReality = isset($request['isAugmentedReality']) ? $request['isAugmentedReality'] : 0;

                // Set a last sort number
                $oQuestions = QuestQuestion::where('questID', $oQuest->questID)->orderBy('sort_number', 'DESC')->first();
                if ($oQuestions) {
                    $object->sort_number = $oQuestions->sort_number + 1;
                }

                // Work with images and files
                if ($request->hasFile('voice_over')) {
                    $newFileName = $helpers->uploadNewFile($request, 'voice_over', $this->type);
                    $object->voice_over = $newFileName;
                }

                if ($request->hasFile('offline_map_image')) {
                    $newFileName = $helpers->uploadNewFile($request, 'offline_map_image', $this->type);
                    $object->offline_map_image = $newFileName;
                }

                $object->save();

                // Work with questions components
                $this->saveComponents($helpers, $request, $questID, $object->questionID, false);

                // Create new answer for the question
                $oAnswer = new QuestAnswer();
                $oAnswer->questionID = $object->questionID;
                $oAnswer->save();

                return redirect()->route('admin_questions_edit', [$oQuest->questID, 'question', $object->questionID])->with('success', 'Новые данные сохранены.');
            }
        }

        // Весь список вопросов для быстрой пагинации внутри сущности
        $oQuestionsList = QuestQuestion::where('questID', $questID)
            ->orderBy('sort_number', 'ASC')
            ->get()
            ->keyBy('questionID');

        // Компоненты вопроса
        $oComponents = QuestQuestionComponent::where('questionID', $questionID)
            ->orderBy('sort_number', 'ASC')
            ->get();
            //->keyBy('sort_number');

        $oAnswer = QuestAnswer::where('questionID', $questionID)->first();

        return view('admin.questions.edit', [
            'data' => $data,
            'oQuest' => $oQuest,
            'oQuestionsList' => $oQuestionsList,
            'oComponents' => $oComponents,
            'oAnswer' => $oAnswer
        ]);
    }

    public function deleteItems(Request $request)
    {
        // todo сделать удаление всех сущностей вопроса
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = QuestQuestion::where('questionID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }

    public function ajaxSortQuestions(Request $request)
    {
        if ($request->ajax()) {

            $arrEntitiesIDs = $request->arrEntitiesIDs;

            $i = 1;
            foreach ($arrEntitiesIDs as $key => $entityID) {
                $oEntity = QuestQuestion::where('questionID', $entityID)->first();
                $oEntity->sort_number = $i;
                $oEntity->update();

                $i ++;
            }

            return response()->json(['success' => true]);
        }
    }

    public function ajaxAddQuestionDescription(Request $request)
    {
        if ($request->ajax()) {

            $componentsCount = $request->componentsCount;

            $html = View::make('admin.questions.components.question_description',[
                'componentsCount' => $componentsCount + 1
            ]);
            $html = $html->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function ajaxAddQuestionFile(Request $request)
    {
        if ($request->ajax()) {

            $componentsCount = $request->componentsCount;

            $html = View::make('admin.questions.components.question_file', [
                'componentsCount' => $componentsCount + 1
            ]);
            $html = $html->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function ajaxAddQuestionTimer(Request $request)
    {
        if ($request->ajax()) {

            $componentsCount = $request->componentsCount;

            $html = View::make('admin.questions.components.question_timer', [
                'componentsCount' => $componentsCount + 1
            ]);
            $html = $html->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function saveComponents(Helpers $helpers, $request, $questID, $questionID, $update = false)
    {
        // todo удалять файл при удалении компонента с фотографией
        if ($update == true) {
            QuestQuestionComponent::where('questionID', $questionID)->delete();
            if (isset($request->components['temp'])) {
                foreach ($request->components['temp'] as $sortNumber => $component) {
                    if (isset($request->files->all()['components']['file'][$sortNumber])) {
                        $helpers->deleteOldFile($component, 'questions/components');
                    } else {
                        $oNewComponent = new QuestQuestionComponent();

                        $oNewComponent->questID = $questID;
                        $oNewComponent->questionID = $questionID;
                        $oNewComponent->type = 'file';
                        $oNewComponent->file = $component;
                        $oNewComponent->sort_number = $sortNumber;

                        $oNewComponent->save();
                    }
                }
            }
        }

        if (isset($request->components)) {

            $components = $request->components;

            // Save description components
            if (isset($components['description'])) {
                foreach ($components['description'] as $sortNumber => $component) {

                    $oNewComponent = new QuestQuestionComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->type = 'description';
                    $oNewComponent->description = $component;
                    $oNewComponent->sort_number = $sortNumber;

                    $oNewComponent->save();
                }
            }

            // Save timer components
            if (isset($components['timer'])) {
                foreach ($components['timer'] as $sortNumber => $component) {

                    $oNewComponent = new QuestQuestionComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->type = 'timer';
                    $oNewComponent->timer = $component;
                    $oNewComponent->sort_number = $sortNumber;

                    $oNewComponent->save();
                }
            }

            // Save file components
            if (isset($request->files->all()['components']['file'])) {
                $componentsFiles = $request->files->all()['components']['file'];
                foreach ($componentsFiles as $sortNumber => $componentsFile) {

                    $newFileName = $helpers->generateFileName($componentsFile->getClientOriginalName());
                    $componentsFile->move(public_path() . '/uploads/questions/components', $newFileName);
                    $oNewComponent = new QuestQuestionComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->type = 'file';
                    $oNewComponent->file = $newFileName;
                    $oNewComponent->sort_number = $sortNumber;

                    $oNewComponent->save();
                }
            }
        }
    }
}
