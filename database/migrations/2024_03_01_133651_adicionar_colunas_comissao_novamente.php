<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarColunasComissaoNovamente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('commission_lv_3')->default('0')->nullable()->after('commission_lv_2');
        $table->string('commission_lv_4')->default('0')->nullable()->after('commission_lv_3');
        $table->string('commission_lv_5')->default('0')->nullable()->after('commission_lv_4');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('commission_lv_3');
        $table->dropColumn('commission_lv_4');
        $table->dropColumn('commission_lv_5');
    });
}
}
