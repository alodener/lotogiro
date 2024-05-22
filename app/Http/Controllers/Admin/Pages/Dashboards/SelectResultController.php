<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\TypeGame;
use App\Models\Draw;
use App\Models\Layout_imagens_resultado;
use App\Models\countgames;
use Illuminate\Http\Request;

class SelectResultController extends Controller
{
    public function index()
    {

        $banner = Layout_imagens_resultado::latest('id')->first();
        $system = System::all();

        return view('admin.pages.dashboards.selectresult.index', compact('banner','system'));
    }

    public function selected(Request $request, $id)
    {

        $game = TypeGame::find($id);
        $draws = Draw::where('type_game_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.pages.dashboards.selectresult.selected', compact('game','draws'));
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


    public function valuegames($dategame)
    {
        // Calcula a data e hora com base nas horas fornecidas
        $date = now()->subHours($dategame);
    
        // Soma os valores do campo 'value' de todos os registros do modelo CountGames que foram criados após a data calculada
        $sum = CountGames::where('created_at', '>=', $date)->sum('value');
    
        // Retorna a soma dos valores encontrados
        return $sum;
    }
    
}
