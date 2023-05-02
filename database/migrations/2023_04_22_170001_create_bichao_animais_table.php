<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBichaoAnimaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bichao_animais', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('value_1', 2);
            $table->string('value_2', 2);
            $table->string('value_3', 2);
            $table->string('value_4', 2);
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
        Schema::dropIfExists('bichao_animais');
    }
}
