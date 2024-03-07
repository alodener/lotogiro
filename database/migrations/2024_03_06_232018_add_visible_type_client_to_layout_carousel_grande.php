<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibleTypeClientToLayoutCarouselGrande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout_carousel_grande', function (Blueprint $table) {
            $table->string('visible_type_client')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layout_carousel_grande', function (Blueprint $table) {
            $table->dropColumn('visible_type_client');
        });
    }
}
