<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    use HasFactory;

    protected $table = 'LOG_USUARIO';

    protected $fillable = [
        'user_id_sender',
        'user_id',
        'nome_funcao',
        'description',
        'created_at',
        'updated_at',
    ];
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id_sender', 'id'); 
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
