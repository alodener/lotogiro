<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBichaoResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bichao_resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('bichao_horarios');
            $table->string('premio_1', 5);
            $table->string('premio_2', 5);
            $table->string('premio_3', 5);
            $table->string('premio_4', 5);
            $table->string('premio_5', 5);
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
        Schema::dropIfExists('bichao_resultados');
    }
}
