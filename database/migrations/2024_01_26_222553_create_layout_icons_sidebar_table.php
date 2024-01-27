<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutIconsSidebarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_icons_sidebar', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('url');
            $table->timestamps(); // Isso cria automaticamente os campos created_at e updated_at

            // Adicionando unicidade ao campo 'id'
            $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layout_icons_sidebar');
    }
}

