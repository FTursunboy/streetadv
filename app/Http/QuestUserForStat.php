<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestUserForStat extends Model
{
    protected $primaryKey = 'userStatID';

    protected $table = 'quest_users_for_stats';
}
