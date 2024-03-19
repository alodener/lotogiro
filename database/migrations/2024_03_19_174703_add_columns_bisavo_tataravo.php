<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsBisavoTataravo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('commission_value_bisavo')->nullable()->after('commision_value_avo');
            $table->string('commission_value_tataravo')->nullable()->after('commission_value_bisavo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('commission_value_bisavo');
            $table->dropColumn('commission_value_tataravo');
        });
    }
}
