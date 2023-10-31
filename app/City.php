<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primaryKey = 'cityID';

    protected $table = 'cities';

    public static function citiesForJson ($city)
    {
        $arrCities = [
            'id' => $city->cityID,
            'lang_id' => $city->languageID,
            'name' => $city->name,
            'lat' => $city->lat,
            'lng' => $city->lng
        ];

        return $arrCities;
    }
}
