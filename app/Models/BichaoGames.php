<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BichaoGames extends Model
{
    use HasFactory;
    protected $table = 'bichao_games';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modalidade()
    {
        return $this->belongsTo(BichaoModalidades::class, 'modalidade_id');
    }

    public function horario()
    {
        return $this->belongsTo(BichaoHorarios::class, 'horario_id');
    }
}
