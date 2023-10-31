<?php

namespace App\Http\Controllers;

use App\Category;
use App\Language;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Request $request)
    {
        $this->_saveLog();

        if (isset($request->langID) && $request->langID != null && $request != '') {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                $oLanguage = Language::where('prefix', "en")->first();
                //return $this->getError(trans('No such language in database'));
            }
            $categories = Category::where('languageID', $oLanguage->languageID)->orderBy('sort_number', 'ASC')->get();
        } else {
            $categories = Category::orderBy('sort_number', 'ASC')->get();
        }

        $arrCategories = [];
        foreach ($categories as $category) {
            $arrCategories[] = Category::categoriesForJson($category);
        }

        return $this->json($arrCategories);
    }

}
