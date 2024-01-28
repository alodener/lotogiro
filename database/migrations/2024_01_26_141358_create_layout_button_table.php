<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutButtonTable extends Migration
{
    public function up()
    {
        Schema::create('layout_button', function (Blueprint $table) {
            $table->id();
            $table->string('first_text', 2000);
            $table->string('second_text', 2000);
            $table->string('second_text', 2000);
            $table->string('link', 2000);
            $table->integer('visivel')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layout_button');
    }
}