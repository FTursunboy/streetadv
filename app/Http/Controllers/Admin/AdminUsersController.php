<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Admin\Misc\Helpers;
use App\Quest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUsersController extends Controller
{
    public function listItems()
    {
        $oObjects = User::all();
        $oCities = City::all()->keyBy('cityID');
        $oRoles = Role::all()->keyBy('roleID');

        return view('admin.users.list', [
            'arrObjects' => $oObjects,
            'oCities' => $oCities,
            'oRoles' => $oRoles
        ]);
    }

    public function editItems(Request $request, $userID = null, Helpers $helpers)
    {
        $type = 'users';
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($userID) && $userID != null) {
            $data['edit'] = true;
            $data['obj'] = User::where('userID', $userID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['userID'])) {

//---------------------------------------- Обновление данных -----------------------------------------------------------

                $object = User::find($request['userID']);
                if ($object->email != $request['email']) {
                    $oUsers = User::where('email', $request['email'])->get();
                    if (count($oUsers) > 0) {
                        return redirect()->back()->with('error', 'Такой адрес эл. почты уже существует!.')->withInput();
                    }
                }

                $object->name = $request['name'];
                $object->email = $request['email'];
                $object->cityID = $request['cityID'];
                $object->roleID = $request['roleID'];
                if (is_array($request['writer_questsIDs']) && !empty($request['writer_questsIDs'])) {
                    $object->writer_questsIDs = implode(',', $request['writer_questsIDs']);
                } else {
                    $object->writer_questsIDs = null;
                }

                // Work with images and files
                if($request->hasFile('avatar')) {
                    if ($object->avatar != 'avatar.png') {
                        $helpers->deleteOldFile($object->avatar, $type);
                    }

                    $newFileName = $helpers->uploadNewFile($request, 'avatar', $type);
                    $object->avatar = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->avatar, $type) == false) {
                        $object->avatar = null;
                    }
                }

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {

//------------------------------------ Сохраннение данных --------------------------------------------------------------

                $oUsers = User::where('email', $request['email'])->get();
                if (count($oUsers) > 0) {
                    return redirect()->back()->with('error', 'Такой адрес эл. почты уже существует!.')->withInput();
                }

                $object = new User();

                $object->name = $request['name'];
                $object->email = $request['email'];
                $object->cityID = $request['cityID'];
                $object->roleID = $request['roleID'];
                if (is_array($request['writer_questsIDs']) && !empty($request['writer_questsIDs'])) {
                    $object->writer_questsIDs = implode(',', $request['writer_questsIDs']);
                }
                $object->password = bcrypt($request['password']);

                // Work with images and files
                if($request->hasFile('avatar')) {
                    $newFileName = $helpers->uploadNewFile($request, 'avatar', $type);
                    $object->avatar = $newFileName;
                }

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oCities = City::all()->keyBy('cityID');
        $oRoles = Role::all()->keyBy('roleID');
        $oQuests = Quest::where('active', 1)->get();

        return view('admin.users.edit', [
            'data' => $data,
            'oCities' => $oCities,
            'oRoles' => $oRoles,
            'oQuests' => $oQuests
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = User::where('userID', $objectID)->first();
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
