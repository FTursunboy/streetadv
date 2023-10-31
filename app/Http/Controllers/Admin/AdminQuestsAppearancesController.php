<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Misc\Helpers;
use App\QuestAppearance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminQuestsAppearancesController extends Controller
{
    public function editItems(Request $request, $appearanceID = null, Helpers $helpers)
    {
        $type = 'appearances';

        // Получение данных из базы
        if (isset($appearanceID) && $appearanceID != null) {
            $data['edit'] = true;
            $data['obj'] = QuestAppearance::where('appearanceID', $appearanceID)->first();
        }

        // Запись данных в базу
        if ($request->method() == "POST") {
            if (isset($request['appearanceID'])) {
                // Обновление данных
                $object = QuestAppearance::find($request['appearanceID']);

                $object->question_bg_color = $request['question_bg_color'];
                $object->question_text_color = $request['question_text_color'];
                $object->question_font_size = $request['question_font_size'];
                $object->question_font = $request['question_font'];
                $object->answer_bg_color = $request['answer_bg_color'];
                $object->answer_text_color = $request['answer_text_color'];
                $object->answer_font_size = $request['answer_font_size'];
                $object->answer_font = $request['answer_font'];
                $object->hint_bg_color = $request['hint_bg_color'];
                $object->hint_text_color = $request['hint_text_color'];
                $object->hint_font_size = $request['hint_font_size'];
                $object->hint_font = $request['hint_font'];
                $object->quest_background_color = $request['quest_background_color'];
                $object->chat_background_color = $request['chat_background_color'];
                $object->cell_description_font = $request['cell_description_font'];
                $object->cell_description_color = $request['cell_description_color'];


                // Work with images and files
                if($request->hasFile('chat_background_image')) {
                    $helpers->deleteOldFile($object->chat_background_image, '');
                    $newFileName = $helpers->uploadNewFile($request, 'chat_background_image', $type);
                    $object->chat_background_image = $newFileName;
                } else {
                    if($helpers->checkFileExist($object->chat_background_image, $type) == false) {
                        $object->chat_background_image = null;
                    }
                }

                $object->update();

                $arrMessages = [
                    'success' => 'Изменения сохранены.',
                    'appearance' => true
                ];

                return redirect()->back()->with($arrMessages);
            }
        }
    }
}
