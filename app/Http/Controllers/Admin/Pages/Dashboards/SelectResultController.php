<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\TypeGame;
use App\Models\Layout_imagens_resultado;
use Illuminate\Http\Request;

class SelectResultController extends Controller
{
    public function index()
    {

        $banner = Layout_imagens_resultado::latest('id')->first();

        return view('admin.pages.dashboards.selectresult.index', compact('banner'));
    }

    public function selected(Request $request, $id)
    {

        $game = TypeGame::find($id);
        
        return view('admin.pages.dashboards.selectresult.selected', compact('game'));
    }
}
