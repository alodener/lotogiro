<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\TypeGame;
use Illuminate\Http\Request;

class SelectResultController extends Controller
{
    public function index()
    {

        $system = System::get();

        return view('admin.pages.dashboards.selectresult.index', compact('system'));
    }

    public function selected(Request $request, $id)
    {

        $game = TypeGame::find($id);
        
        return view('admin.pages.dashboards.selectresult.selected', compact('game'));
    }
}
