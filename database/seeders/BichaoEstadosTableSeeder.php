<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BichaoEstadosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bichao_estados')->delete();

        \DB::table('bichao_estados')->insert(array (
            0 =>
            array (
                'id' => 1,
                'nome' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),         
            1 =>
            array (
                'id' => 2,
                'nome' => 'São Paulo',
                'uf' => 'SP',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            2 =>
            array (
                'id' => 3,
                'nome' => 'Goiás',
                'uf' => 'GO',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            3 =>
            array (
                'id' => 4,
                'nome' => 'Minas Gerais',
                'uf' => 'MG',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            4 =>
            array (
                'id' => 5,
                'nome' => 'Bahia',
                'uf' => 'BA',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            5 =>
            array (
                'id' => 6,
                'nome' => 'Paraíba',
                'uf' => 'PB',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            6 =>
            array (
                'id' => 7,
                'nome' => 'Brasília',
                'uf' => 'DF',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            7 =>
            array (
                'id' => 8,
                'nome' => 'Ceará',
                'uf' => 'CE',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            8 =>
            array (
                'id' => 9,
                'nome' => 'Federal',
                'uf' => 'FED',
                'active' => true,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
        ));
    }
}
