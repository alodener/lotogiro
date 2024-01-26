<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutCarouselGrandeTable extends Migration
{
    public function up()
    {
        Schema::create('layout_carousel_grande', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2000);
            $table->string('nome', 2000);
            $table->string('config', 2000);
            $table->integer('visivel')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layout_carousel_grande');
    }
}