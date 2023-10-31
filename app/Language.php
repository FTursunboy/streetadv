<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $primaryKey = 'languageID';

    protected $table = 'languages';

    public static function languageForJson ($language)
    {
        $arrLanguages = [
            'id' => $language->languageID,
            'ru_name' => $language->ru_name,
            'en_name' => $language->en_name,
            'prefix' => $language->prefix,
            'created_at' => $language->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $language->updated_at->format('Y-m-d H:i:s'),
        ];

        return$arrLanguages;
    }
}
