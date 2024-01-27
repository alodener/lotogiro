<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutSeeder extends Seeder   
{
    public function run()
    {
        // Insira os dados na tabela
        DB::table('layout')->insert([
            'nome_config' => 'Botões',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('layout')->insert([
            'nome_config' => 'Carousel Grande',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('layout')->insert([
            'nome_config' => 'Icons Sidebar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
