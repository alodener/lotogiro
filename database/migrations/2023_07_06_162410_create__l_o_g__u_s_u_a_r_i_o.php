<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLOGUSUARIO extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOG_USUARIO', function (Blueprint $table) {
            $table->id(); //gera automaticamente
            $table->unsignedBigInteger('user_id_sender'); //usuario logado que fez alteração  
            $table->unsignedBigInteger('user_id');  //usuario que sofreu a a alteração
            $table->string('nome_funcao');  //qual é o nome da funcao se é uma edição, uma exclusão ou uma criação
            $table->string('description'); //guardar o que foi feito //500 caracteres
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LOG_USUARIO');
    }
}
