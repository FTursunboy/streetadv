<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\Quest;
use App\QuestPhrase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminQuestsPhrasesController extends Controller
{
    protected $type = 'phrases';

    public function listItems($questID)
    {
        $oQuest = Quest::find($questID);
        if (!$oQuest) {
            abort(404);
        } else {
            $oObjects = QuestPhrase::where('questID', $questID)->get();
            $arrPhrasesTypes = QuestPhrase::$phraseTypes;

            return view('admin.phrases.list', [
                'arrObjects' => $oObjects,
                'arrPhrasesTypes' => $arrPhrasesTypes,
                'oQuest' => $oQuest
            ]);
        }
    }

    public function editItems(Request $request, Helpers $helpers, $questID, $typeName = null, $phraseID = null)
    {
        $oQuest = Quest::find($questID);

        if (!$oQuest || ($typeName != 'phrase' && $typeName != null)) {
            abort(404);
        }

        $type = 'phrases';
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($phraseID) && $phraseID != null) {
            $data['edit'] = true;
            $data['obj'] = QuestPhrase::where('phraseID', $phraseID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['phraseID'])) {
                // Обновление данных
                $object = QuestPhrase::find($request['phraseID']);

                $object->questID = $oQuest->questID;
                $object->type = $request['type'];
                $object->description = $request['description'];

                // Work with images and files
                if($request->hasFile('voice')) {
                    $helpers->deleteOldFile($object->voice, $type);
                    $newFileName = $helpers->uploadNewFile($request, 'voice', $type);
                    $object->voice = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->voice, $type) == false) {
                        $object->voice = null;
                    }
                }

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new QuestPhrase();

                $object->questID = $oQuest->questID;
                $object->type = $request['type'];
                $object->description = $request['description'];

                // Work with images and files
                if($request->hasFile('voice')) {
                    $newFileName = $helpers->uploadNewFile($request, 'voice', $type);
                    $object->voice = $newFileName;
                }

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $arrPhrasesTypes = QuestPhrase::$phraseTypes;

        return view('admin.phrases.edit', [
            'data' => $data,
            'arrPhrasesTypes' => $arrPhrasesTypes,
            'oQuest' => $oQuest
        ]);
    }

    public function deleteItems(Request $request, Helpers $helpers)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;
            $object = QuestPhrase::where('phraseID', $objectID)->first();

            if (!is_null($object)) {

                // Remove files if exist
                if($helpers->checkFileExist($object->voice, $this->type) == true) {
                    $helpers->deleteOldFile($object->voice, $this->type);
                }

                // Remove entity
                $object->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }
}
