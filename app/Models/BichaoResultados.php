<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BichaoResultados extends Model
{
    use HasFactory;
    protected $table = 'bichao_resultados';

    // Relação com o modelo Horario
    public function horario()
    {
        return $this->belongsTo(BichaoHorarios::class, 'horario_id');
    }
}
