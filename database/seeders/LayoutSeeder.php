<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutSeeder extends Seeder   
{
    public function run()
    {
        // Limpar todos os registros da tabela
        DB::table('layout')->truncate();

        // Inserir novos registros na tabela
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
        DB::table('layout')->insert([
            'nome_config' => 'Imagens Resultados',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('layout')->insert([
            'nome_config' => 'Imagens Publicidade',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
