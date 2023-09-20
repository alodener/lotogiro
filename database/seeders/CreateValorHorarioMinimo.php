<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateValorHorarioMinimo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system')->delete();

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Valor Mínimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Horário Máximo',
            'value'         => '22'
        ]);
    }
}
