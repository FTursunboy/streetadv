<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\City;
use App\Http\Controllers\Admin\Misc\Helpers;
use App\Language;
use App\Quest;
use App\QuestAppearance;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminQuestsController extends Controller
{
    public function listItems()
    {
        $currentUser = Auth::user();
        if (isset($currentUser->writer_questsIDs) && $currentUser->writer_questsIDs != null) {
            $arrAccessQuestsIDs = explode(',', $currentUser->writer_questsIDs);
            $oObjects = Quest::whereIn('questID', $arrAccessQuestsIDs)->orderBy('sort_number', 'ASC')->get();
        } else {
            $oObjects = Quest::orderBy('sort_number', 'ASC')->get();
        }

        $oCities = City::all()->keyBy('cityID');
        $oLanguages = Language::all()->keyBy('languageID');

        return view('admin.quests.list', [
            'arrObjects' => $oObjects,
            'oCities' => $oCities,
            'oLanguages' => $oLanguages,
            'currentUser' => $currentUser
        ]);
    }

    public function editItems(Request $request, $questID = null, Helpers $helpers)
    {
        $type = 'quests';
        $data['obj'] = [];
        $data['edit'] = false;

        $oAppearance = [];

        // Получение данных из базы
        if (isset($questID) && $questID != null) {
            $data['edit'] = true;
            $data['obj'] = Quest::where('questID', $questID)->first();
            $oAppearance = QuestAppearance::where('questID', $questID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['questID'])) {
                // Обновление данных
                $object = Quest::find($request['questID']);

                $object->name = $request['name'];
                $object->description = $request['description'];
                $object->product_id = $request['product_id'];
                if (is_array($request['categoryIDs']) && !empty($request['categoryIDs'])) {
                    $object->categoryIDs = implode(',', $request['categoryIDs']);
                }
                $object->cityID = $request['cityID'];
                $object->languageID = $request['languageID'];

                $object->address = $request['address'];
                $object->type = $request['type'];
                $object->latitude = $request['latitude'];
                $object->longitude = $request['longitude'];
                $object->hemisphere = $request['hemisphere'];
                $object->price = $request['price'];
                $object->price_android = $request['price_android'];
                $object->currency = $request['currency'];
                $object->previous_price = $request['previous_price'];
                $object->discount = $request['discount'];
                $object->steps = $request['steps'];
                $object->distance = $request['distance'];
                $object->calories = $request['calories'];
                $object->access = $request['access'];
                $object->nextQuestionPhraseAction = $request['nextQuestionPhraseAction'];
                $object->bottomLeftLat = $request['bottomLeftLat'];
                $object->bottomLeftLng = $request['bottomLeftLng'];
                $object->topRightLat = $request['topRightLat'];
                $object->topRightLng = $request['topRightLng'];
                $object->active = isset($request['active']) ? $request['active'] : 0;
                $object->recommend = isset($request['recommend']) ? $request['recommend'] : 0;

                // Work with images and files
                if($request->hasFile('image')) {
                    $helpers->deleteOldFile($object->image, '');
                    $newFileName = $helpers->uploadNewFile($request, 'image', $type);
                    $object->image = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->image, $type) == false) {
                        $object->image = null;
                    }
                }
                if($request->hasFile('image_bg')) {
                    $helpers->deleteOldFile($object->image_bg, $type);
                    $newFileName = $helpers->uploadNewFile($request, 'image_bg', $type);
                    $object->image_bg = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->image_bg, $type) == false) {
                        $object->image_bg = null;
                    }
                }

                $object->update();

                return redirect()->back()->with('success', 'Изменения сохранены.');
            } else {
                // Сохраннение данных
                $object = new Quest();

                $object->name = $request['name'];
                $object->description = $request['description'];
                $object->product_id = $request['product_id'];
                if (is_array($request['categoryIDs']) && !empty($request['categoryIDs'])) {
                    $object->categoryIDs = implode(',', $request['categoryIDs']);
                }
                $object->cityID = $request['cityID'];
                $object->languageID = $request['languageID'];

                $object->address = $request['address'];
                $object->type = $request['type'];
                $object->latitude = $request['latitude'];
                $object->longitude = $request['longitude'];
                $object->hemisphere = $request['hemisphere'];
                $object->price = $request['price'];
                $object->price_android = $request['price_android'];
                $object->currency = $request['currency'];
                $object->previous_price = $request['previous_price'];
                $object->discount = $request['discount'];
                $object->steps = $request['steps'];
                $object->distance = $request['distance'];
                $object->calories = $request['calories'];
                $object->access = $request['access'];
                $object->nextQuestionPhraseAction = $request['nextQuestionPhraseAction'];
                $object->bottomLeftLat = $request['bottomLeftLat'];
                $object->bottomLeftLng = $request['bottomLeftLng'];
                $object->topRightLat = $request['topRightLat'];
                $object->topRightLng = $request['topRightLng'];
                $object->active = isset($request['active']) ? $request['active'] : 0;
                $object->recommend = isset($request['recommend']) ? $request['recommend'] : 0;

                // Work with images and files
                if($request->hasFile('image')) {
                    $newFileName = $helpers->uploadNewFile($request, 'image', $type);
                    $object->image = $newFileName;
                }
                if($request->hasFile('image_bg')) {
                    $newFileName = $helpers->uploadNewFile($request, 'image_bg', $type);
                    $object->image_bg = $newFileName;
                }

                $object->save();

                $questAppearance = new QuestAppearance();
                $questAppearance->questID = $object->questID;
                $questAppearance->save();

                return redirect()->route('admin_quests_edit', [$object->questID])->with('success', 'Новые данные сохранены.');
            }
        }

        $oCategories = Category::all()->keyBy('categoryID');
        $oCities = City::all()->keyBy('cityID');
        $oLanguages = Language::all()->keyBy('languageID');
        $arrAccess = Quest::$accessType;
        $arrFonts = QuestAppearance::$ARR_FONTS;

        return view('admin.quests.edit', [
            'data' => $data,
            'oCategories' => $oCategories,
            'oCities' => $oCities,
            'oLanguages' => $oLanguages,
            'arrAccess' => $arrAccess,
            'arrFonts' => $arrFonts,
            'oAppearance' => $oAppearance
        ]);
    }

    public function deleteItems(Request $request)
    {
        // todo сделать удаление всех сущностей квеста
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $object = Quest::where('questID', $objectID)->first();
            if (!is_null($object)) {
                $object->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }

    public function ajaxSortQuests(Request $request)
    {
        if ($request->ajax()) {

            $arrEntitiesIDs = $request->arrEntitiesIDs;

            $i = 0;
            foreach ($arrEntitiesIDs as $key => $entityID) {
                $oEntity = Quest::where('questID', $entityID)->first();
                $oEntity->sort_number = $i;
                $oEntity->update();

                $i ++;
            }

            return response()->json(['success' => true]);
        }
    }
}
