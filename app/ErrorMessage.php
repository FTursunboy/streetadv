<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorMessage extends Model
{
    protected $primaryKey = 'errorID';

    protected $table = 'error_messages';

    public static $ru = [1,2,3,4,5,6,7,8,9,10,11,12,13];

    public static $en = [17,18,19,20,21,22,23,24,25,26,27,28,29];

    public static $uk = [30,31,32,33,34,35,36,37,38,39,40,41,42];
}
