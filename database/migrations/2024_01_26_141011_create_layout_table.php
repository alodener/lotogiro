<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutTable extends Migration
{
    public function up()
    {
        Schema::create('layout', function (Blueprint $table) {
            $table->id();
            $table->string('nome_config', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layout');
    }
}
