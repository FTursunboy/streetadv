<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $primaryKey = 'pageID';

    protected $table = 'pages';

    public static $names = [
        'for_groups' => 'Для Групп',
        'capabilities' => 'Возможности',
        'about_company' => 'О компании',
        'contacts' => 'Контакты',
    ];

    public function subDescription ($chars_count = 10, $start = 0, $ending = '...', $encoding = 'UTF-8') {
        $string = $this->attributes['text'];

        return mb_substr($string, $start, $chars_count, $encoding) . (mb_strlen($string) > $chars_count ? $ending : '');
    }

    public static function pageForJson ($page)
    {
        $arrPages = [
            'id' => $page->pageID,
            'lang_id' => $page->languageID,
            'name' => $page->alias,
            'image' => asset('uploads/pages/' . $page->image),
            'title' => $page->name,
            'text' => $page->text
        ];

        return $arrPages;
    }
}
