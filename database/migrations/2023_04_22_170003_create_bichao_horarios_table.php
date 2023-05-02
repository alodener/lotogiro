<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBichaoHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bichao_horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('bichao_estados');
            $table->time('horario');
            $table->string('banca', 100);
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
        Schema::dropIfExists('bichao_horarios');
    }
}
