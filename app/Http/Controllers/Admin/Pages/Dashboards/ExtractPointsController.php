<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\UsersHasPoints;
use Illuminate\Http\Request;

class ExtractPointsController extends Controller
{
    public function index(Request $request)
    {
        $balances = UsersHasPoints::getBalancesByUser(auth()->user());
        $points = UsersHasPoints::where('user_id',auth()->user()->id)->get();
        return view('admin.pages.dashboards.points.index',compact('points','balances'));
    }
}
