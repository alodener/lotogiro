<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertValuesIntoLayoutButtonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Inserindo os valores
        DB::table('layout_button')->insert([
            'id' => '3',
            'first_text' => 'first_text1',
            'second_text' => '💥',
            'link' => '#ff0000',
            'visivel' => '0',
            'created_at' => now(),
            'updated_at' => now(),
            'cor' => '#a14545',
            'novapagina' => '0'
        ]);

        // Inserir o segundo valor
        DB::table('layout_button')->insert([
            'id' => '4',
            'first_text' => 'first_text2',
            'second_text' => '⚡️',
            'link' => '#00ff00',
            'visivel' => '0',
            'created_at' => now(),
            'updated_at' => now(),
            'cor' => '#45a145',
            'novapagina' => '1'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Você pode adicionar a lógica de remoção dos registros aqui, se necessário
    }
}
