<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout_Button extends Model
{
    use HasFactory;
    
    protected $table = 'layout_button';

    protected $guarded = [];

    protected $fillable = [
        'first_text',
        'second_text',
        'cor',
        'visivel',
        'link',

    ];
           
}
