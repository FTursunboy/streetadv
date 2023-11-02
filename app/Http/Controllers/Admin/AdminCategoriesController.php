<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Admin\Misc\Helpers;
use App\Language;
use App\Quest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCategoriesController extends Controller
{
    public function listItems()
    {
        $oObjects = Category::orderBy('sort_number', 'ASC')->get();
        $oLanguages = Language::all()->keyBy('languageID');
        $oQuests = Quest::all();

        return view('admin.categories.list', [
            'arrObjects' => $oObjects,
            'oLanguages' => $oLanguages,
            'oQuests' => $oQuests
        ]);
    }

    public function editItems(Request $request, $categoryID = null, Helpers $helpers)
    {
        $type = 'categories';
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($categoryID) && $categoryID != null) {
            $data['edit'] = true;
            $data['obj'] = Category::where('categoryID', $categoryID)->first();
        }


        // Запись данных в базу

        if ($request->method() == "POST") {
            if (isset($request['categoryID'])) {
                // Обновление данных
                $object = Category::find($request['categoryID']);

                $object->name = $request['name'];
                $object->color = $request['color'];
                $object->languageID = $request['languageID'];
                $object->active = isset($request['active']) ? $request['active'] : 0;

                // Work with images and files
                if($request->hasFile('bg_image')) {
                    $helpers->deleteOldFile($object->bg_image, $type);
                    $newFileName = $helpers->uploadNewFile($request, 'bg_image', $type);
                    $object->bg_image = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->bg_image, $type) == false) {
                        $object->bg_image = null;
                    }
                }

                if($request->hasFile('icon_image')) {
                    $helpers->deleteOldFile($object->icon_image, $type);
                    $newFileName = $helpers->uploadNewFile($request, 'icon_image', $type);
                    $object->icon_image = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->icon_image, $type) == false) {
                        $object->icon_image = null;
                    }
                }

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Category();

                $object->name = $request['name'];
                $object->color = $request['color'];
                $object->languageID = $request['languageID'];
                $object->active = isset($request['active']) ? $request['active'] : 0;

                // Work with images and files
                if($request->hasFile('bg_image')) {
                    $newFileName = $helpers->uploadNewFile($request, 'bg_image', $type);
                    $object->bg_image = $newFileName;
                }
                if($request->hasFile('icon_image')) {
                    $newFileName = $helpers->uploadNewFile($request, 'icon_image', $type);
                    $object->icon_image = $newFileName;
                }

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.categories.edit', [
            'data' => $data,
            'oLanguages' => $oLanguages
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Category::where('categoryID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }

    public function ajaxSortCategories(Request $request)
    {
        if ($request->ajax()) {

            $arrEntitiesIDs = $request->arrEntitiesIDs;

            $i = 0;
            foreach ($arrEntitiesIDs as $key => $entityID) {
                $oEntity = Category::where('categoryID', $entityID)->first();
                $oEntity->sort_number = $i;
                $oEntity->update();

                $i ++;
            }

            return response()->json(['success' => true]);
        }
    }
}
