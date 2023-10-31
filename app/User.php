<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'userID';

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password','avatar','roleID', 'cityID','token','push_token','os_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function userJson($userID)
    {
        $user = User::find($userID);

        $arrUser = [
            'id' => $user->userID,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->token,
            'push_token' => $user->push_token,
            'os_type' => $user->os_type,
            'avatar' => asset('uploads/users/' . $user->avatar),
            'role' => 'user',
            'city_id' => $user->cityID,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            'steps' => 0,
            'distance' => 0,
            'points' => 0,
            'calories' => 0
        ];

        return $arrUser;
    }
}
