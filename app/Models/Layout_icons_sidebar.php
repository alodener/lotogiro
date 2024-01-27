<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout_icons_sidebar extends Model
{
    use HasFactory;
    
    protected $table = 'layout_icons_sidebar';

    protected $guarded = [];

    protected $fillable = [
        'nome',
        'url',
    
    ];
           
}
