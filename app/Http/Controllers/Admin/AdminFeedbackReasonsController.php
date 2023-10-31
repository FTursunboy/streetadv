<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use App\FeedbackReasons;
use App\Http\Controllers\Admin\Misc\Helpers;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFeedbackReasonsController extends Controller
{
    public function listItems()
    {
        $oObjects = FeedbackReasons::all();

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.reasons.list', [
            'arrObjects' => $oObjects,
            'oLanguages' => $oLanguages
        ]);
    }

    public function editItems(Request $request, $feedbackReasonID = null, Helpers $helpers)
    {
        $data['obj'] = [];
        $data['edit'] = false;

        // Получение данных из базы
        if (isset($feedbackReasonID) && $feedbackReasonID != null) {
            $data['edit'] = true;
            $data['obj'] = FeedbackReasons::where('feedbackReasonID', $feedbackReasonID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['feedbackReasonID'])) {

                // Обновление данных
                $object = FeedbackReasons::find($request['feedbackReasonID']);
                $object->languageID = $request['languageID'];
                $object->reason_type = $request['reason_type'];

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {

                // Сохраннение данных
                $object = new FeedbackReasons();
                $object->languageID = $request['languageID'];
                $object->reason_type = $request['reason_type'];

                $object->save();

                return redirect()->back()->with('success', 'Новые данные сохранены.');
            }
        }

        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.reasons.edit', [
            'data' => $data,
            'oLanguages' => $oLanguages
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = FeedbackReasons::where('feedbackReasonID', $objectID)->first();
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
