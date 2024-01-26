<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout_carousel_grande extends Model
{
    use HasFactory;
    
    protected $table = 'layout_carousel_grande';

    protected $guarded = [];

    protected $fillable = [
        'url',
        'config',
        'visivel',
        'nome',

    ];
           
}
