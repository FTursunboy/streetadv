<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'settingID';

    protected $table = 'settings';

    public static $mainSettingID = 1;

    public static function settingsForJson ($setting)
    {
        $arrSettings = [
            'contacts_phone' => $setting->contactPhone,
            'contacts_email' => $setting->contactEmail
        ];

        return $arrSettings;
    }
}
