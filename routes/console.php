<?php

use App\Models\BichaoHorarios;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Artisan::command('ajusteHorarios', function () {
    $this->comment('Horarios sendo gerados');

    $horarios =[ 
    [
        'id' => 33,
        'estado_id' => 1,
        'horario' => '09:20:00',
        'banca' => 'PTM-RIO'
    ],
    [
        'id' => 34,
        'estado_id' => 2,
        'horario' => '08:00:00',
        'banca' => 'PTM-SP'
    ],
    [
        'id' => 35,
        'estado_id' => 2,
        'horario' => '10:00:00',
        'banca' => 'PTM-SP'
    ],
    [
        'id' => 36,
        'estado_id' => 2,
        'horario' => '17:00:00',
        'banca' => 'PT-SP'
    ],
    [
        'id' => 37,
        'estado_id' => 2,
        'horario' => '19:00:00',
        'banca' => 'PT-SP'
    ],
    [
        'id' => 38,
        'estado_id' => 3,
        'horario' => '07:20:00',
        'banca' => 'LOOK'
    ],
    [
        'id' => 39,
        'estado_id' => 3,
        'horario' => '23:20:00',
        'banca' => 'LOOK'
    ],
    [
        'id' => 40,
        'estado_id' => 3,
        'horario' => '09:20:00',
        'banca' => 'LOOK'
    ],
    [
        'id' => 41,
        'estado_id' => 4,
        'horario' => '21:20:00',
        'banca' => 'PREFERIDA'
    ],
    [
        'id' => 42,
        'estado_id' => 5,
        'horario' => '10:00:00',
        'banca' => 'BA'
    ],
    [
        'id' => 43,
        'estado_id' => 6,
        'horario' => '09:40:00',
        'banca' => 'CAPITAL LOTERIAS'
    ],
    [
        'id' => 44,
        'estado_id' => 6,
        'horario' => '20:30:00',
        'banca' => 'PARATODOS'
    ],
    [
        'id' => 45,
        'estado_id' => 7,
        'horario' => '08:40:00',
        'banca' => 'LBR'
    ],
    [
        'id' => 46,
        'estado_id' => 7,
        'horario' => '10:30:00',
        'banca' => 'LBR'
    ],
    [
        'id' => 47,
        'estado_id' => 7,
        'horario' => '20:40:00',
        'banca' => 'LBR'
    ],
    [
        'id' => 48,
        'estado_id' => 7,
        'horario' => '22:30:00',
        'banca' => 'LBR'
    ],
    [
        'id' => 50,
        'estado_id' => 7,
        'horario' => '23:40:00',
        'banca' => 'LBR'
    ],

];

    $create = Carbon::now();
    $this->output->progressStart(count($horarios));
    $delete = false;
    foreach ($horarios as $key => $hora) {
        if($delete){
            DB::table('bichao_resultados')->where('horario_id', $hora['id'])->delete();
            DB::table('bichao_horarios')->where('id', $hora['id'])->delete();
        }else{
            $hora['created_at'] =  $create;
            $hora['updated_at'] =  $create;
            DB::table('bichao_horarios')->insert($hora);
        }
        $this->output->progressAdvance();
    }
})->purpose('Display an inspiring quote');
