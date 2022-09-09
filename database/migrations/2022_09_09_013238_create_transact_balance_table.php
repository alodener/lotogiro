<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transact_balance')) {
            Schema::create('transact_balance', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('user_id_sender')->nullable();
                $table->foreignId('user_id')->nullable();
                $table->string('value')->nullable();
                $table->string('old_value')->nullable();
                $table->string('type')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transact_balance');
    }
}
