<?php

namespace App\Http\Controllers;

use App\ErrorMessage;
use App\Language;
use App\Page;
use Illuminate\Http\Request;

class PagesController extends BaseController
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        if (isset($request->langID)) {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                return $this->getError(trans('No such language in database'));
            }
            $data = Page::where('languageID', $oLanguage->languageID)->get();
        } else {
            $data = Page::all();
        }

        $arrPages = [];
        foreach ($data as $page) {
            $arrPages[] = Page::pageForJson($page);
        }

        return $this->json($arrPages);
    }


    /**
     * @param Page $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Page $page)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $oPage = Page::pageForJson($page);

        return $this->json($oPage);
    }


    /**
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function byName(Request $request, $name)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        if (isset($request->langID)) {
            $oLanguage = Language::where('prefix', $request->langID)->first();
            if (!$oLanguage) {
                return $this->getError(trans('No such language in database'));
            }
            $data = Page::where('alias', $name)->where('languageID', $oLanguage->languageID)->get();
        } else {
            $data = Page::where('alias', $name)->where('languageID', 1)->get();
        }

        $arrPages = [];
        foreach ($data as $page) {
            $arrPages[] = Page::pageForJson($page);
        }

        return $this->json($arrPages, 200, 0, true);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function names()
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        return $this->json(Page::$names);
    }

    public function test (Request $request)
    {
//        $ids = [3,29];
//
//        return $this->getError($this->_getError($request, $ids));


        return view('index');
    }
}
