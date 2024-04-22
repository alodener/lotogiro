<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutImagesResultado extends Migration
{
    public function up()
    {
        Schema::create('layout_images_resultado', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2000);
            $table->string('nome', 2000);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layout_images_resultado');
    }
}