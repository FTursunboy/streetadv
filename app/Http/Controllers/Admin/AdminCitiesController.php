<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCitiesController extends Controller
{
    public function listItems()
    {

        $oObjects = City::all();
        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.cities.list', [
            'arrObjects' => $oObjects,
            'oLanguages' => $oLanguages
        ]);
    }

    public function editItems(Request $request, $cityID = null)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($cityID) && $cityID != null) {
            $data['edit'] = true;
            $data['obj'] = City::where('cityID', $cityID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {

            if (isset($request['cityID'])) {
                // Обновление данных
                $object = City::find($request['cityID']);

                $object->name = $request['name'];
                $object->lat = $request['lat'];
                $object->lng = $request['lng'];
                $object->languageID = $request['languageID'];

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new City();

                $object->name = $request['name'];
                $object->lat = $request['lat'];
                $object->lng = $request['lng'];
                $object->languageID = $request['languageID'];

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.cities.edit', [
            'data' => $data,
            'oLanguages' => $oLanguages
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = City::where('cityID', $objectID)->first();
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
