<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestAppearance extends Model
{

    protected $table = 'quest_appearances';

    protected $primaryKey = 'appearanceID';

    public static $ARR_FONTS = [
        "Upheaval Pro" => "Upheaval Pro",
        "Enchanted Land cyr-lat" => "Enchanted Land cyr-lat",
        "FreeSans" => "FreeSans",
        "VEGeorgianBrushCyrillicGreek" => "VEGeorgianBrushCyrillicGreek",
        "Elizabeth_tt-Uni-Italic" => "Elizabeth_tt-Uni-Italic",
        "Elizabeth_tt-Uni" => "Elizabeth_tt-Uni"
    ];

    public static $DEFAULT_DATA = [
        'question_bg_color' => '#EE355E',
        'question_text_color' => '#FFFFFF',
        'question_font_size' => '17',
        'question_font' => 'Roboto-Condensed',
        'answer_bg_color' => '#00ABEE',
        'answer_text_color' => '#FFFFFF',
        'answer_font_size' => '17',
        'answer_font' => 'Roboto-Condensed',
        'hint_bg_color' => '#EE355E',
        'hint_text_color' => '#FFFFFF',
        'hint_font_size' => '17',
        'hint_font' => 'Roboto-Condensed',
        'quest_background_color' => '#FFFFFF',
        'chat_background_color' => '#FFFFFF',
        'cell_description_font' => 'Roboto-Condensed',
        'cell_description_color' => '#797979',
    ];

    public static function appearanceJson ($quest)
    {
        $appearance = QuestAppearance::where('questID', $quest->questID)->first();

        $arrAppearance = [];
        $arrAppearance[] = [
            'question_bg_color' => $appearance->question_bg_color,
            'question_text_color' => $appearance->question_text_color,
            'question_font_size' => $appearance->question_font_size,
            'question_font' => $appearance->question_font,
            'answer_bg_color' => $appearance->answer_bg_color,
            'answer_text_color' => $appearance->answer_text_color,
            'answer_font_size' => $appearance->answer_font_size,
            'answer_font' => $appearance->answer_font,
            'hint_bg_color' => $appearance->hint_bg_color,
            'hint_text_color' => $appearance->hint_text_color,
            'hint_font_size' => $appearance->hint_font_size,
            'hint_font' => $appearance->hint_font,
            'quest_background_color' => $appearance->quest_background_color,
            'chat_background_color' => $appearance->chat_background_color,
            'cell_description_font' => $appearance->cell_description_font,
            'cell_description_color' => $appearance->cell_description_color,
            'chat_background_image' => $appearance->chat_background_image ? asset('uploads/appearances/' . $appearance->chat_background_image) : '',
        ];

        return $arrAppearance;
    }
}
