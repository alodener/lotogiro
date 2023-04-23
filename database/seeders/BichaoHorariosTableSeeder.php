<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BichaoHorariosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bichao_horarios')->delete();

        \DB::table('bichao_horarios')->insert(array (
            0 =>
            array (
                'id' => 1,
                'estado_id' => 1,
                'horario' => '11:20:00',
                'banca' => 'PTM-RIO',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            1 =>
            array (
                'id' => 2,
                'estado_id' => 1,
                'horario' => '14:20:00',
                'banca' => 'PT-RIO',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            2 =>
            array (
                'id' => 3,
                'estado_id' => 1,
                'horario' => '16:20:00',
                'banca' => 'PTV-RIO',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            3 =>
            array (
                'id' => 4,
                'estado_id' => 1,
                'horario' => '18:20:00',
                'banca' => 'PTN-RIO',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            4 =>
            array (
                'id' => 5,
                'estado_id' => 1,
                'horario' => '21:20:00',
                'banca' => 'CORUJA-RIO',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            5 =>
            array (
                'id' => 6,
                'estado_id' => 2,
                'horario' => '13:00:00',
                'banca' => 'PT-SP',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            6 =>
            array (
                'id' => 7,
                'estado_id' => 2,
                'horario' => '16:00:00',
                'banca' => 'BANDEIRANTES',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            7 =>
            array (
                'id' => 8,
                'estado_id' => 2,
                'horario' => '20:00:00',
                'banca' => 'PTN-SP',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            8 =>
            array (
                'id' => 9,
                'estado_id' => 3,
                'horario' => '11:20:00',
                'banca' => 'LOOK',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            9 =>
            array (
                'id' => 10,
                'estado_id' => 3,
                'horario' => '14:20:00',
                'banca' => 'LOOK',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            10 =>
            array (
                'id' => 11,
                'estado_id' => 3,
                'horario' => '16:20:00',
                'banca' => 'LOOK',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            11 =>
            array (
                'id' => 12,
                'estado_id' => 3,
                'horario' => '18:20:00',
                'banca' => 'LOOK',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            12 =>
            array (
                'id' => 13,
                'estado_id' => 3,
                'horario' => '21:20:00',
                'banca' => 'LOOK',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            13 =>
            array (
                'id' => 14,
                'estado_id' => 4,
                'horario' => '12:00:00',
                'banca' => 'ALVORADA',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            14 =>
            array (
                'id' => 15,
                'estado_id' => 4,
                'horario' => '15:00:00',
                'banca' => 'MINAS-DIA',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            15 =>
            array (
                'id' => 16,
                'estado_id' => 4,
                'horario' => '19:00:00',
                'banca' => 'MINAS-NOITE',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            16 =>
            array (
                'id' => 17,
                'estado_id' => 5,
                'horario' => '12:00:00',
                'banca' => 'BA',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            17 =>
            array (
                'id' => 18,
                'estado_id' => 5,
                'horario' => '15:00:00',
                'banca' => 'BA',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            18 =>
            array (
                'id' => 19,
                'estado_id' => 5,
                'horario' => '19:00:00',
                'banca' => 'BA',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            19 =>
            array (
                'id' => 20,
                'estado_id' => 5,
                'horario' => '21:00:00',
                'banca' => 'BA',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            20 =>
            array (
                'id' => 21,
                'estado_id' => 6,
                'horario' => '10:45:00',
                'banca' => 'LOTEP',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            21 =>
            array (
                'id' => 22,
                'estado_id' => 6,
                'horario' => '12:45:00',
                'banca' => 'LOTEP',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            22 =>
            array (
                'id' => 23,
                'estado_id' => 6,
                'horario' => '15:45:00',
                'banca' => 'LOTEP',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            23 =>
            array (
                'id' => 24,
                'estado_id' => 6,
                'horario' => '18:45:00',
                'banca' => 'LOTEP',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            24 =>
            array (
                'id' => 25,
                'estado_id' => 7,
                'horario' => '12:40:00',
                'banca' => 'LBR',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            25 =>
            array (
                'id' => 26,
                'estado_id' => 7,
                'horario' => '15:00:00',
                'banca' => 'LBR',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            26 =>
            array (
                'id' => 27,
                'estado_id' => 7,
                'horario' => '17:00:00',
                'banca' => 'LBR',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            27 =>
            array (
                'id' => 28,
                'estado_id' => 7,
                'horario' => '19:00:00',
                'banca' => 'LBR',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            28 =>
            array (
                'id' => 29,
                'estado_id' => 8,
                'horario' => '11:00:00',
                'banca' => 'LOTECE',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            29 =>
            array (
                'id' => 30,
                'estado_id' => 8,
                'horario' => '14:00:00',
                'banca' => 'LOTECE',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            30 =>
            array (
                'id' => 31,
                'estado_id' => 8,
                'horario' => '19:00:00',
                'banca' => 'LOTECE',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
        ));
    }
}
