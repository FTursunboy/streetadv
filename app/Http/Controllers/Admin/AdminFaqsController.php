<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use App\Http\Controllers\Admin\Misc\Helpers;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFaqsController extends Controller
{
    public function listItems()
    {
        $oObjects = Faq::orderBy('sort', 'ASC')->get();

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.faqs.list', [
            'arrObjects' => $oObjects,
            'oLanguages' => $oLanguages
        ]);
    }

    public function editItems(Request $request, $faqID = null, Helpers $helpers)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($faqID) && $faqID != null) {
            $data['edit'] = true;
            $data['obj'] = Faq::where('faqID', $faqID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['faqID'])) {
                // Обновление данных
                $object = Faq::find($request['faqID']);

                $object->languageID = $request['languageID'];
                $object->title = $request['title'];
                $object->description = $request['description'];

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Faq();

                $object->languageID = $request['languageID'];
                $object->title = $request['title'];
                $object->description = $request['description'];

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.faqs.edit', [
            'data' => $data,
            'oLanguages' => $oLanguages
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Faq::where('faqID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }

    public function ajaxSortFaqs(Request $request)
    {
        if ($request->ajax()) {

            $arrEntitiesIDs = $request->arrEntitiesIDs;

            $i = 0;
            foreach ($arrEntitiesIDs as $key => $entityID) {
                $oEntity = Faq::where('faqID', $entityID)->first();
                $oEntity->sort = $i;
                $oEntity->update();

                $i ++;
            }

            return response()->json(['success' => true]);
        }
    }
}
