<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLanguagesController extends Controller
{
    public function listItems()
    {

        $oObjects = Language::all();
        return view('admin.languages.list', [
            'arrObjects' => $oObjects
        ]);
    }

    public function editItems(Request $request, $languageID = null)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($languageID) && $languageID != null) {
            $data['edit'] = true;
            $data['obj'] = Language::where('languageID', $languageID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {

            if (isset($request['languageID'])) {
                // Обновление данных
                $object = Language::find($request['languageID']);

                $object->ru_name = $request['ru_name'];
                $object->en_name = $request['en_name'];
                $object->prefix = $request['prefix'];

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Language();

                $object->ru_name = $request['ru_name'];
                $object->en_name = $request['en_name'];
                $object->prefix = $request['prefix'];

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        return view('admin.languages.edit', [
            'data' => $data,
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Language::where('languageID', $objectID)->first();
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
