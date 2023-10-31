<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromocodeUser extends Model
{
    protected $primaryKey = 'promocodeUserID';

    protected $table = 'promocode_users';


    public static function getQuestId ($promocodeId)
    {
        $questID = Promocode::where('promocodeID', $promocodeId)->first()->questID;
        return $questID;
    }
}
