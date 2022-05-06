<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualifications extends Model
{
    protected $fillable = [
        'description',
        'image',
        'goal',
        'personal_percentage',
        'group_percentage',
    ];
}
