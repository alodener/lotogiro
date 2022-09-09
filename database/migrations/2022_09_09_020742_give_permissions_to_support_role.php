<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\Permission;


class GivePermissionsToSupportRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $suporte_n1 = Role::where('name', 'Suporte N1')->first();        
        $suporte_n2 = Role::where('name', 'Suporte N2')->first();        
        $perms = Permission::all();

        foreach ($perms as $key => $permission) {
            $suporte_n1->attach($permission);
        }
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
