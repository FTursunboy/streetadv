<?php

namespace App\Http\Controllers;

use App\City;
use App\Language;
use Illuminate\Http\Request;

class CityController extends BaseController
{
    public function index(Request $request)
    {
        $this->_saveLog();

        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        if ($request->langID != '' && $request->langID != null) {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                $oLanguage = Language::where('prefix', "en")->first();
                //return $this->getError(trans('No such language in database'));
            }
            //$cities = City::orderBy('name', 'ASC')->get();
            $cities = City::where('languageID', $oLanguage->languageID)->orderBy('name', 'ASC')->get();
        } else {
            $cities = City::orderBy('name', 'ASC')->get();
        }
        $arrCities = [];

        foreach ($cities as $city) {
            $arrCities[] = City::citiesForJson($city);
        }

        return $this->json($arrCities);
    }
}
