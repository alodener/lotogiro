<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomeBalanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $users = User::all();

        return view('admin.pages.dashboards.customer.index',[
            'users' => $users
        ]);
    }

    public function lock_account($id)
    {
        $user = User::where('id',$id)->first();

        $user['is_active'] = 0;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index',[
            'users' => $users
        ]);
    }

    public function unlock_account($id)
    {
        $user = User::where('id',$id)->first();

        $user['is_active'] = 1;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index',[
            'users' => $users
        ]);
    }

    public function save_changes(Request $request, $id)
    {
        $data = $request->all();
        $user = User::where('id',$id)->first();

        $user['commission'] = $data['commission'];
        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index',[
            'users' => $users
        ]);
    }

    public function contact_made($id)
    {
        $user = User::where('id',$id)->first();

        $user['contact_made'] = 1;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index',[
            'users' => $users
        ]);
    }

    public function contact_not_made($id)
    {
        $user = User::where('id',$id)->first();

        $user['contact_made'] = 0;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index',[
            'users' => $users
        ]);
    }
}
