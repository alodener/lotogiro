<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countgames extends Model
{
    use HasFactory;
    
    protected $table = 'games';

    protected $guarded = [];

    protected $fillable = [
        'id',
        'user_id',
        'value',
        'premio',
        'created_at',
     
    ];
           
}
