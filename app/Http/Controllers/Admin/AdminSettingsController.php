<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller
{
    public function editItems(Request $request)
    {
        $mainSettingID = Setting::$mainSettingID;

        // Получение данных из базы
        if (isset($mainSettingID) && $mainSettingID != null) {
            $data = Setting::where('settingID', $mainSettingID)->first();
            $data = json_decode($data->content);
        } else {
            abort(404);
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            // Обновление данных
            $object = Setting::find($mainSettingID);

            $object->content = json_encode($request->all());

            $object->update();

            return redirect()->back()->with('success', 'Изменения сохранены.');
        }

        return view('admin.settings.edit', [
            'data' => $data,
        ]);
    }
}
