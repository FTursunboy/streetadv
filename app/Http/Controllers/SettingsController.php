<?php

namespace App\Http\Controllers;

use App\Setting;

class SettingsController extends BaseController
{
    public function index()
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $data = Setting::all();

        $arrSettings = [];
        foreach ($data as $item) {
            $content = json_decode($item->content);
            $arrSettings[] = Setting::settingsForJson($content);
        }

        return $this->json($arrSettings, 200, 0, true);
    }
}
