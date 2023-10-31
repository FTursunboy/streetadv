<?php

namespace App\Http\Controllers\Traits;


trait Discountble
{

    public function questDiscounts($quests, $user)
    {

        foreach ($user->promocodes()->active()->type('one_quest_discount')->get() as $promocode){
            $quests->where('id',$promocode->quest_id)->transform(function ($item, $key) use($promocode) {
                $item->discountPrice = $item->price - ($item->price / 100 * $promocode->discount);
                $item->discount =  $promocode->discount;
                $item->promocode_id = $promocode->id;
                $item->discount_product_id = $promocode->discount_product_id;
                return $item;
            });
        }

        if(!is_null( $anyDiscount = $user->promocodes()->active()->type('any_quest_discount')->first())){
            $quests->each(function($item, $key) use ($anyDiscount){
                if(!isset($item->discountPrice)){
                    $item->discountPrice = $item->price - ($item->price  / 100 * $anyDiscount->discount);
                    $item->discount = $anyDiscount->discount;
                    $item->promocode_id = $anyDiscount->id;
                    $item->discount_product_id = $anyDiscount->discount_product_id;
                }
            });
        }
        return $quests;
    }

}