<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Promocode;
use App\PromocodeUser;
use App\Quest;
use App\Http\Controllers\Controller;
use App\QuestUser;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $arrStatuses = [
            0 => 'Не определено',
            1 => 'Ввод промокода',
            2 => 'Покупка',
            3 => 'Получен бесплатно',
            4 => 'Куплен по скидке'
        ];

        $oQuests = Quest::all();
        $oCities = City::all();
        $oUsers = User::all();
        $oQuestUser = QuestUser::orderBy('created_at', 'DESC')->get();

        if ($request->isMethod('post')) {
            if (isset($request->questID) && $request->questID != 0) {
                $oQuestUser = QuestUser::where('questID', $request->questID)->orderBy('created_at', 'DESC')->get();
            }
        }

        $arrData = [];
        if (count($oQuestUser) > 0) {
            foreach ($oQuestUser as $item) {

                //*************
                $arrData[$item->questUserID]['date'] = $item->created_at->format('d.m.Y');
                $arrData[$item->questUserID]['time'] = $item->created_at->format('H:i:s');
                $arrData[$item->questUserID]['price'] = number_format($item->price, 2, '.', ' ');

                //*************
                $oUser = User::where('userID', $item->userID)->first();

                $userID = null;
                $userLogin = 'Пользователя больше не существует';
                $userRoute = null;

                if ($oUser) {
                    $userID = $oUser->userID;
                    $userLogin = $oUser->email;
                    $userRoute = 'admin_users_edit';
                }

                $arrData[$item->questUserID]['userID'] = $userID;
                $arrData[$item->questUserID]['userLogin'] = $userLogin;
                $arrData[$item->questUserID]['userRoute'] = $userRoute;

                //*************
                $boughtStatus = 'Не определено';
                $price = 'Не определено';

                $oQuest = Quest::where('questID', $item->questID)->first();
                $promoCodes = Promocode::query()->where('questID', $item->questID)->pluck('promocodeID')->toArray();
                $oUserPromocode = PromocodeUser::where('userID', $item->userID)
                    ->whereIn('promocodeID', array_values($promoCodes))
                    ->first();


		$promoCodesDisc = Promocode::query()->where('questID', $item->questID)->where('discount', '>', '0')->first();


		if ($oQuest) {
                    $discount = isset($promoCodesDisc->discount) ? $promoCodesDisc->discount : "na";
                    if ($oUserPromocode && $oQuest->access == 'promocode' && $discount != "na") {
                        $boughtStatus = 'Куплен по скидке';
                    }
		    else if ($oUserPromocode && $oQuest->access == 'all') {
                        $boughtStatus = 'Ввод промокода';
                    }
                    else if ($oUserPromocode && $oQuest->access == 'promocode') {
                        $boughtStatus = 'Ввод промокода';
                    }

                    else if (!$oUserPromocode && $oQuest->access == 'all') {
                        $boughtStatus = 'Покупка';
                    }

                    else if (!$oUserPromocode) {
                        $boughtStatus = 'Получен бесплатно';
                    }

                    $price = number_format($oQuest->price, 2, '.', ' ');
                }

                $arrData[$item->questUserID]['price'] = $price;
                $arrData[$item->questUserID]['boughtStatus'] = $boughtStatus;

                //*************
                $questID = null;
                $questName = 'Не найден';
                $questRoute = null;

                if ($oQuest) {
                    $questID = $oQuest->questID;
                    $questName = $oQuest->name;
                    $questRoute = 'admin_quests_edit';
                }

                $arrData[$item->questUserID]['questID'] = $questID;
                $arrData[$item->questUserID]['questName'] = $questName;
                $arrData[$item->questUserID]['questRoute'] = $questRoute;
            }
        }
        if (isset($request->status)) {
            foreach ($arrData as $key => $datum) {
                if ($datum['boughtStatus'] != $arrStatuses[$request->status]) {

                    unset($arrData[$key]);
                }
            }
        }

        return view('admin.dashboard', [
            'oUsers' => $oUsers,
            'oQuests' => $oQuests,
            'oCities' => $oCities,
            'oQuestUser' => $oQuestUser,
            'arrData' => $arrData,
            'data' => $request,
            'arrStatuses' => $arrStatuses
        ]);
    }
}
