<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersHasQualifications extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'qualification_id',
        'active',
    ];

    public static function getActivedByUser(User $user)
    {
        $userQualification = UsersHasQualifications::where('user_id', $user->id)->where('active', 1)->first();
        if (!$userQualification) {
            return false;
        }
    }
}
