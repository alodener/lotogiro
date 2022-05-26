<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select('users.*')
            ->leftJoin('users_has_qualifications', 'users_has_qualifications.user_id', '=', 'users.id')
            ->leftJoin('qualifications', 'qualifications.id', '=', 'users_has_qualifications.qualification_id')
            ->where('users_has_qualifications.active',1)
            ->orderByDesc('qualifications.goal')
            ->orderBy('users.name')
            ->get();
        return view('admin.pages.ranking', compact('users'));
    }
}
