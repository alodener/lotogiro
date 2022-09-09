<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class CreateRolesSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create(['name' => 'Suporte N1']);
        Role::create(['name' => 'Suporte N2']);
        Role::create(['name' => 'Financeiro']);
        Role::create(['name' => 'Sistema Master']);
        Role::create(['name' => 'Usuário']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
