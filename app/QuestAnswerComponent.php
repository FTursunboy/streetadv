<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestAnswerComponent extends Model
{
    protected $table = 'quest_answers_components';

    protected $primaryKey = 'componentID';
}
