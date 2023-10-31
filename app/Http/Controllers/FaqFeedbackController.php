<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Feedback;
use App\FeedbackReasons;
use App\Language;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class FaqFeedbackController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq(Request $request)
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
            $data = Faq::where('languageID', $oLanguage->languageID)->orderBy('sort','asc')->get();
        } else {
            $data = Faq::orderBy('sort','asc')->get();
        }

        $arrFaqs = [];
        foreach ($data as $item) {
            $arrFaqs[] = Faq::faqsForJson($item);
        }

        return $this->json($arrFaqs);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reason(Request $request)
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
            $data = FeedbackReasons::where('languageID', $oLanguage->languageID)->get();
        } else {
            $data = FeedbackReasons::all();
        }

        $arrReasons = [];
        foreach ($data as $item) {
            $arrReasons[] = FeedbackReasons::reasonsForJson($item);
        }

        return $this->json($arrReasons);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->_checkUser();
        if ($response) {
            return $response;
        }

        $html = "";
        $html .= "<p>Заголовок - " . $request['contact_us'] . "</p>";
        $html .= "<p>Причина - " . $request['reason'] . "</p>";
        $html .= "<p>Форма - " . $request['type'] . "</p>";
        $html .= "<p>Текст - " . $request['text'] . "</p>";

//        Mail::send('email.feedback', ['html' => $html], function ($message) {
//            //$message->from('admin@admin.loc');
////            $message->to('info@streetadventure.ru')->subject('Новое сообщение из приложения');
//            $message->to('fallton.vm@gmail.com')->subject('Новое сообщение из приложения');
//        });

        $oFeedback = new Feedback();
        $oFeedback->userID = $this->user->userID;
        $oFeedback->contact_us = $request['contact_us'];
        $oFeedback->text = $request['text'];
        $oFeedback->type = $request['type'];
        $oFeedback->reason = $request['reason'];

        $oFeedback->save();
//        Feedback::create(array_merge($request->all(), ['user_id' => $this->user_id]));

        return $this->getSuccess('Feedback stored.');
    }

}
