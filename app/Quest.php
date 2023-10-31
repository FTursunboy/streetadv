<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\QuestUser;

class Quest extends Model
{
    protected $primaryKey = 'questID';

    protected $table = 'quests';

    public static $accessType = [
        'all' => 'Для всех',
        //'users' => 'Для указаных пользователей',
        'promocode' => 'По промокоду',
    ];

    public static $arrHemisphere = [
        1 => 'Восточное полушарие',
        2 => 'Западное полушарие'
    ];

    public static $currencies = [
      'RUB' => 'Рубли',
      'USD' => 'Доллары',
      'GBP' => 'Фунты',
    ];

    public static function questJson ($quest, $userID)
    {
        //------------- Check user -----------------------------
//        $token = request('token');
//        if ($token) {
//            $user = User::where('token', $token)->first();
//            if (!$user) {
//                return response()->json([
//                    'status' => 400,
//                    'token'  => null,
//                    'data'   => 'No such user'
//                ]);
//            }
//        }
        //------------- Check user END-----------------------------

        $userQ = QuestUser::where('userID', $userID)->where('questID', $quest->questID)->first();
        $userQ ? $status = $userQ->status : $status = '';
        $userQ ? $isFinished = $userQ->isFinished : $isFinished = '';
        $quest->hemisphere != null ? $hemisphere = $quest->hemisphere : $hemisphere = 1;

        $arrQuest = [
            'id' => $quest->questID,
            'categories' => Category::categoriesJson($quest),
            'name' => $quest->name,
            'description' => $quest->description,
            'city_id' => $quest->cityID,
            'product_id' => $quest->product_id,
            'type' => $quest->type,
            'address' => $quest->address,
            'longitude' => (float) $quest->longitude,
            'latitude' => (float) $quest->latitude,
            'hemisphere' => $hemisphere,
            'price' => $quest->price,
            'price_android' => $quest->price_android,
            'currency' => $quest->currency,
            'previous_price' => $quest->previous_price,
            'discount' => $quest->discount,
            'points' => self::questScoresCount($quest),
            'steps' => $quest->steps,
            'distance' => (int) $quest->distance,
            'calories' => $quest->calories,
            'nextQuestionPraseAction' => $quest->nextQuestionPhraseAction,
            'image' => asset('uploads/quests/' . $quest->image),
            'image_bg' => asset('uploads/quests/' . $quest->image_bg),
            'access' => $quest->access,
            'sort' => $quest->sort,
            'active' => $quest->active,
            'sticker' => $quest->sticker,
            'recommend' => $quest->recommend,
            'status' => $status,
            'isFinished' => (int) $isFinished,
            'bottomLeftLat' => (float) $quest->bottomLeftLat,
            'bottomLeftLng' => (float) $quest->bottomLeftLng,
            'topRightLat' => (float) $quest->topRightLat,
            'topRightLng' => (float) $quest->topRightLng,
            'questMemorySize' => 100, //$this->_questMemorySize($quest),
            'created_at' => $quest->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $quest->updated_at->format('Y-m-d H:i:s'),
            'questions' => QuestQuestion::questionsJson($quest),
            'appearance' => QuestAppearance::appearanceJson($quest),
            'phrases' => QuestPhrase::phrasesJson($quest)
        ];

        return $arrQuest;
    }

    public static function questSmallJson ($quest)
    {
        $quest->hemisphere != null ? $hemisphere = $quest->hemisphere : $hemisphere = 1;

        $arrQuest = [
            'id' => $quest->questID,
            'categories' => Category::categoriesJson($quest),
            'name' => $quest->name,
            'description' => $quest->description,
            'city_id' => $quest->cityID,
            'product_id' => $quest->product_id,
            'type' => $quest->type,
            'address' => $quest->address,
            'longitude' => $quest->longitude,
            'latitude' => $quest->latitude,
            'hemisphere' => $hemisphere,
            'price' => $quest->price,
            'price_android' => $quest->price_android,
            'currency' => $quest->currency,
            'previous_price' => $quest->previous_price,
            'discount' => $quest->discount,
            'points' => self::questScoresCount($quest),
            'steps' => $quest->steps,
            'distance' => (int) $quest->distance,
            'calories' => $quest->calories,
            'image' => asset('uploads/quests/' . $quest->image),
            'image_bg' => asset('uploads/quests/' . $quest->image_bg),
            'access' => $quest->access,
            'sort' => $quest->sort,
            'active' => $quest->active,
            'sticker' => $quest->sticker,
            'recommend' => $quest->recommend,
            'bottomLeftLat' => $quest->bottomLeftLat,
            'bottomLeftLng' => $quest->bottomLeftLng,
            'topRightLat' => $quest->topRightLat,
            'topRightLng' => $quest->topRightLng,
            'questMemorySize' => 100, //$this->_questMemorySize($quest),
            'created_at' => $quest->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $quest->updated_at->format('Y-m-d H:i:s'),
            'appearance' => QuestAppearance::appearanceJson($quest),
            'phrases' => QuestPhrase::phrasesJson($quest)
        ];

        return $arrQuest;
    }

    public static function questMiniJson ($quest)
    {
        $quest->hemisphere != null ? $hemisphere = $quest->hemisphere : $hemisphere = 1;

        $arrQuest = [
            'id' => $quest->questID,
            'categories' => Category::categoriesJson($quest),
            'name' => $quest->name,
            'description' => $quest->description,
            'city_id' => $quest->cityID,
            'product_id' => $quest->product_id,
            'type' => $quest->type,
            'address' => $quest->address,
            'longitude' => $quest->longitude,
            'latitude' => $quest->latitude,
            'hemisphere' => $hemisphere,
            'price' => $quest->price,
            'price_android' => $quest->price_android,
            'currency' => $quest->currency,
            'previous_price' => $quest->previous_price,
            'discount' => $quest->discount,
            'points' => self::questScoresCount($quest),
            'steps' => $quest->steps,
            'distance' => (int) $quest->distance,
            'calories' => $quest->calories,
            'nextQuestionPraseAction' => $quest->nextQuestionPhraseAction,
            'image' => asset('uploads/quests/' . $quest->image),
            'image_bg' => asset('uploads/quests/' . $quest->image_bg),
            'access' => $quest->access,
            'sort' => $quest->sort,
            'active' => $quest->active,
            'sticker' => $quest->sticker,
            'recommend' => $quest->recommend,
            'bottomLeftLat' => $quest->bottomLeftLat,
            'bottomLeftLng' => $quest->bottomLeftLng,
            'topRightLat' => $quest->topRightLat,
            'topRightLng' => $quest->topRightLng,
            'created_at' => $quest->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $quest->updated_at->format('Y-m-d H:i:s'),
        ];

        return $arrQuest;
    }

    public static function questScoresCount ($questEntity)
    {
        if ($questEntity instanceof Quest){

            $questScoresCount = 0;
            $questQuestions = QuestQuestion::where('questID', $questEntity->questID)->get();
            if (count($questQuestions) > 0) {
                foreach ($questQuestions as $question) {
                    $questScoresCount += $question->points;
                }
            }

            return $questScoresCount;
        } else {
            return false;
        }
    }
}
