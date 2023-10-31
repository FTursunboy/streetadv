<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\Language;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPagesController extends Controller
{
    public function listItems()
    {
        $oObjects = Page::orderBy('pageID', 'ASC')->get();
        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.pages.list', [
            'arrObjects' => $oObjects,
            'oLanguages' => $oLanguages
        ]);
    }

    public function editItems(Request $request, $pageID = null, Helpers $helpers)
    {
        $type = 'pages';
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($pageID) && $pageID != null) {
            $data['edit'] = true;
            $data['obj'] = Page::where('pageID', $pageID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['pageID'])) {
                // Обновление данных
                $object = Page::find($request['pageID']);

                $object->name = $request['name'];
                $object->alias = $request['alias'];
                $object->languageID = $request['languageID'];
                $object->text = $request['text'];

                // Work with images and files
                if($request->hasFile('image')) {
                    $helpers->deleteOldFile($object->image, $type);
                    $newFileName = $helpers->uploadNewFile($request, 'image', $type);
                    $object->image = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->image, $type) == false) {
                        $object->image = null;
                    }
                }

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Page();

                $object->name = $request['name'];
                $object->alias = $request['alias'];
                $object->languageID = $request['languageID'];
                $object->text = $request['text'];

                // Work with images and files
                if($request->hasFile('image')) {
                    $newFileName = $helpers->uploadNewFile($request, 'image', $type);
                    $object->image = $newFileName;
                }

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.pages.edit', [
            'data' => $data,
            'oLanguages' => $oLanguages
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Page::where('pageID', $objectID)->first();
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
