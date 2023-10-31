<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\ErrorMessage;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminErrorsController extends Controller
{
    public function listItems()
    {

        $oObjects = ErrorMessage::all();
        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.errors.list', [
            'arrObjects' => $oObjects,
            'oLanguages' => $oLanguages
        ]);
    }

    public function editItems(Request $request, $errorID = null)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($errorID) && $errorID != null) {
            $data['edit'] = true;
            $data['obj'] = ErrorMessage::where('errorID', $errorID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {

            if (isset($request['errorID'])) {
                // Обновление данных
                $object = ErrorMessage::find($request['errorID']);

                $object->title = $request['title'];
                $object->text = $request['text'];
                $object->languageID = $request['languageID'];

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new ErrorMessage();

                $object->title = $request['title'];
                $object->text = $request['text'];
                $object->languageID = $request['languageID'];

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.errors.edit', [
            'data' => $data,
            'oLanguages' => $oLanguages
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = ErrorMessage::where('errorID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }
}
