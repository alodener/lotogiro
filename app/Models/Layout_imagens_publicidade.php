<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout_imagens_publicidade extends Model
{
    use HasFactory;
    
    protected $table = 'layout_images_publicidade';

    protected $guarded = [];

    protected $fillable = [
        'id',
        'nome',
        'url',
     
    ];
           
}