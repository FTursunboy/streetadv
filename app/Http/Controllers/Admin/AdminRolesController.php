<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRolesController extends Controller
{
    public function listItems()
    {
        $oObjects = Role::all();

        return view('admin.roles.list', [
            'arrObjects' => $oObjects,
        ]);
    }

    public function editItems(Request $request, $roleID = null)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($roleID) && $roleID != null) {
            $data['edit'] = true;
            $data['obj'] = Role::where('roleID', $roleID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {

            if (isset($request['roleID'])) {
                // Обновление данных
                $object = Role::find($request['roleID']);
                $object->name = $request['name'];
                if (is_array($request['menusIDs']) && !empty($request['menusIDs'])) {
                    $object->menusIDs = implode(',', $request['menusIDs']);
                } else {
                    $object->menusIDs = null;
                }
                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Role();
                $object->name = $request['name'];
                if (is_array($request['menusIDs']) && !empty($request['menusIDs'])) {
                    $object->menusIDs = implode(',', $request['menusIDs']);
                }
                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oMenus = Menu::orderBy('sort_number','ASC')
            ->get()
            ->keyBy('menuID');

        return view('admin.roles.edit', [
            'data' => $data,
            'oMenus' => $oMenus
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Role::where('roleID', $objectID)->first();
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
