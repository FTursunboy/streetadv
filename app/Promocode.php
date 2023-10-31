<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $primaryKey = 'promocodeID';

    protected $table = 'promocodes';

    public static $promocodeTypes = [
        'open_quest' => 'Открыть квест',
        'one_quest_discount' => 'Скидка на один квест',
        'any_quest_discount' => 'Скидка на любую покупку',
    ];
}
