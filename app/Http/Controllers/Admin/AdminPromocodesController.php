<?php

namespace App\Http\Controllers\Admin;

use App\Promocode;
use App\Quest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPromocodesController extends Controller
{
    public function listItems()
    {
        $oObjects = Promocode::all();
        $oQuests = Quest::all()->keyBy('questID');
        $arrPromocodeTypes = Promocode::$promocodeTypes;

        return view('admin.promocodes.list', [
            'arrObjects' => $oObjects,
            'oQuests' => $oQuests,
            'arrPromocodeTypes' => $arrPromocodeTypes
        ]);
    }

    public function editItems(Request $request, $promocodeID = null)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($promocodeID) && $promocodeID != null) {
            $data['edit'] = true;
            $data['obj'] = Promocode::where('promocodeID', $promocodeID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['promocodeID'])) {
                // Обновление данных
                $object = Promocode::find($request['promocodeID']);

                $object->code = $request['code'];
                $object->promocode_type = $request['promocode_type'];
                $object->questID = $request['questID'];
                $object->discount = $request['discount'];
                $object->quantity = $request['quantity'];
                $object->discount_product_id = $request['discount_product_id'];

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Promocode();

                $object->code = $request['code'];
                $object->promocode_type = $request['promocode_type'];
                $object->questID = $request['questID'];
                $object->discount = $request['discount'];
                $object->quantity = $request['quantity'];
                $object->discount_product_id = $request['discount_product_id'];

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oQuests = Quest::all();
        $arrPromocodeTypes = Promocode::$promocodeTypes;

        return view('admin.promocodes.edit', [
            'data' => $data,
            'oQuests' => $oQuests,
            'arrPromocodeTypes' => $arrPromocodeTypes
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Promocode::where('promocodeID', $objectID)->first();
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
