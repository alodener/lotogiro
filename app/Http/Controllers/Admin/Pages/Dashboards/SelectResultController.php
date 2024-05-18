<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\TypeGame;
use App\Models\Layout_imagens_resultado;
use App\Models\countgames;
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


    public function countgames($dategame)
    {
        // Calcula a data e hora com base nas horas fornecidas
        $date = now()->subHours($dategame);

        // Conta os registros do modelo CountGames que foram criados após a data calculada
        $count = CountGames::where('created_at', '>=', $date)->count();

        // Retorna a quantidade de registros encontrados
        return $count;
    }
}
