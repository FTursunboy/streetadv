<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\Quest;
use App\QuestHint;
use App\QuestHintComponent;
use App\QuestQuestion;
use App\QuestQuestionComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AdminQuestsHintsController extends Controller
{
    protected $type = 'hints';

    public function listItems($questionID)
    {
        $oQuestion = QuestQuestion::find($questionID);
        if (!$oQuestion) {
            abort(404);
        } else {
            $oObjects = QuestHint::where('questionID', $questionID)->orderBy('sort_number', 'ASC')->get();
            $oQuest = Quest::where('questID', $oQuestion->questID)->first();

            return view('admin.hints.list', [
                'arrObjects' => $oObjects,
                'oQuestion' => $oQuestion,
                'oQuest' => $oQuest
            ]);
        }
    }

    public function editItems(Request $request, Helpers $helpers, $questionID, $typeName = null, $hintID = null)
    {
        $oQuestion = QuestQuestion::find($questionID);

        if (!$oQuestion || ($typeName != 'hint' && $typeName != null)) {
            abort(404);
        }

        $data['obj'] = [];
        $data['edit'] = false;
        $oQuest = Quest::find($oQuestion->questID);

        // Получение данных из базы
        if (isset($hintID) && $hintID != null) {
            $data['edit'] = true;
            $data['obj'] = QuestHint::where('hintID', $hintID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['hintID'])) {

                // Обновление данных
                $object = QuestHint::find($request['hintID']);

                $object->questionID = $oQuestion->questionID;
                $object->points = $request['points'];

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

                $object->update();

                // Work with hint components
                $this->saveComponents($helpers, $request, $oQuest->questID, $questionID, $request['hintID'], true);

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {

                // Сохраннение данных
                $object = new QuestHint();

                $object->questionID = $oQuestion->questionID;
                $object->points = $request['points'];

                // Set a last sort number
                $oHints = QuestHint::where('questionID', $oQuestion->questionID)->orderBy('sort_number', 'DESC')->first();
                if ($oHints) {
                    $object->sort_number = $oHints->sort_number + 1;
                }

                // Work with images and files
                if ($request->hasFile('voice_over')) {
                    $newFileName = $helpers->uploadNewFile($request, 'voice_over', $this->type);
                    $object->voice_over = $newFileName;
                }

                $object->save();

                // Work with questions components
                $this->saveComponents($helpers, $request, $oQuest->questID, $questionID, $object->hintID, false);

                return redirect()->route('admin_hints_edit', [$oQuestion->questionID, 'hint', $object->hintID])->with('success', 'Новые данные сохранены.');
            }
        }

        // Компоненты вопроса
        $oComponents = QuestHintComponent::where('hintID', $hintID)
            ->orderBy('sort_number', 'ASC')
            ->get();
            //->keyBy('sort_number');

        return view('admin.hints.edit', [
            'data' => $data,
            'oQuest' => $oQuest,
            'oQuestion' => $oQuestion,
            'oComponents' => $oComponents,
        ]);
    }

    public function deleteItems(Request $request)
    {
        // todo сделать удаление всех сущностей вопроса
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = QuestHint::where('hintID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }

    public function ajaxSortHints(Request $request)
    {
        if ($request->ajax()) {

            $arrEntitiesIDs = $request->arrEntitiesIDs;

            $i = 1;
            foreach ($arrEntitiesIDs as $key => $entityID) {
                $oEntity = QuestHint::where('hintID', $entityID)->first();
                $oEntity->sort_number = $i;
                $oEntity->update();

                $i ++;
            }

            return response()->json(['success' => true]);
        }
    }

    public function ajaxAddHintDescription(Request $request)
    {
        if ($request->ajax()) {

            $componentsCount = $request->componentsCount;

            $html = View::make('admin.hints.components.hint_description',[
                'componentsCount' => $componentsCount + 1
            ]);
            $html = $html->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function ajaxAddHintFile(Request $request)
    {
        if ($request->ajax()) {

            $componentsCount = $request->componentsCount;

            $html = View::make('admin.hints.components.hint_file', [
                'componentsCount' => $componentsCount + 1
            ]);
            $html = $html->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function saveComponents(Helpers $helpers, $request, $questID, $questionID, $hintID, $update = false)
    {
        // todo удалять файл при удалении компонента с фотографией
        if ($update == true) {
            QuestHintComponent::where('hintID', $hintID)->delete();
            if (isset($request->components['temp'])) {
                foreach ($request->components['temp'] as $sortNumber => $component) {
                    if (isset($request->files->all()['components']['file'][$sortNumber])) {
                        $helpers->deleteOldFile($component, 'hints/components');
                    } else {
                        $oNewComponent = new QuestHintComponent();

                        $oNewComponent->questID = $questID;
                        $oNewComponent->questionID = $questionID;
                        $oNewComponent->hintID = $hintID;
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

                    $oNewComponent = new QuestHintComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->hintID = $hintID;
                    $oNewComponent->type = 'description';
                    $oNewComponent->description = $component;
                    $oNewComponent->sort_number = $sortNumber;

                    $oNewComponent->save();
                }
            }

            // Save file components
            if (isset($request->files->all()['components']['file'])) {
                $componentsFiles = $request->files->all()['components']['file'];
                foreach ($componentsFiles as $sortNumber => $componentsFile) {

                    $newFileName = $helpers->generateFileName($componentsFile->getClientOriginalName());
                    $componentsFile->move(public_path() . '/uploads/hints/components', $newFileName);
                    $oNewComponent = new QuestHintComponent();

                    $oNewComponent->questID = $questID;
                    $oNewComponent->questionID = $questionID;
                    $oNewComponent->hintID = $hintID;
                    $oNewComponent->type = 'file';
                    $oNewComponent->file = $newFileName;
                    $oNewComponent->sort_number = $sortNumber;

                    $oNewComponent->save();
                }
            }
        }
    }
}
