<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BichaoModalidadesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bichao_modalidades')->delete();

        \DB::table('bichao_modalidades')->insert(array (
            0 =>
            array (
                'id' => 1,
                'nome' => 'Milhar',
                'multiplicador' => 5000,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            1 =>
            array (
                'id' => 2,
                'nome' => 'Centena',
                'multiplicador' => 600,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            2 =>
            array (
                'id' => 3,
                'nome' => 'Dezena',
                'multiplicador' => 60,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            3 =>
            array (
                'id' => 4,
                'nome' => 'Grupo',
                'multiplicador' => 18,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            4 =>
            array (
                'id' => 5,
                'nome' => 'Milhar/Centena',
                'multiplicador' => 2800,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            5 =>
            array (
                'id' => 6,
                'nome' => 'Terno de Dezena',
                'multiplicador' => 5000,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            6 =>
            array (
                'id' => 7,
                'nome' => 'Terno de Grupos',
                'multiplicador' => 1300,
                'multiplicador_2' => 150,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            7 =>
            array (
                'id' => 8,
                'nome' => 'Duque de Dezena',
                'multiplicador' => 300,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            8 =>
            array (
                'id' => 9,
                'nome' => 'Duque de Grupo',
                'multiplicador' => 16,
                'multiplicador_2' => null,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
        ));
    }
}
