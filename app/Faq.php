<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $primaryKey = 'faqID';

    protected $table = 'faqs';

    public function subDescription ($chars_count = 10, $start = 0, $ending = '...', $encoding = 'UTF-8') {
        $string = $this->attributes['description'];

        return mb_substr($string, $start, $chars_count, $encoding) . (mb_strlen($string) > $chars_count ? $ending : '');
    }

    public static function faqsForJson ($faq)
    {
        $arrFaq = [
            'id' => $faq->faqID,
            'lang_id' => $faq->languageID,
            'title' => $faq->title,
            'description' => $faq->description,
            'sort' => $faq->sort,
            'created_at' => $faq->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $faq->updated_at->format('Y-m-d H:i:s')
        ];

        return $arrFaq;
    }
}
