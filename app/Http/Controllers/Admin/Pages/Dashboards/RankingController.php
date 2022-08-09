<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $pagination = User::listRankingPagination(route('admin.dashboards.ranking.index'),$request->input('pg'));

        return view('admin.pages.ranking', compact('pagination'));
    }
}
