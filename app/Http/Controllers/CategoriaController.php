<?php

namespace App\Http\Controllers;
use App\Models\TypeGame;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bet;


class CategoriaController extends Controller
{
    public function getCategories($typeGameId)
    {   
        $category = $typeGameId;
        $typeGames = TypeGame::where('category', $category)->get();
        return view('admin.layouts.categorias')->with(compact('typeGames'));

        
    }
    public function getCategoriesavulso($typeGameId, User $user, Bet $bet = null)
    {    
        
    
        $allCategories = TypeGame::all();

    $TypeGamesRoll = TypeGame::all()
        ->groupBy('category')
        ->map(function ($group) {
            return $group->first();
        });   
        $category = $typeGameId;
        $typeGames = TypeGame::where('category', $category)->get();
        return view('admin.layouts.categoriasavulso')->with(compact('typeGames','user', 'bet', ));

        
    }
}