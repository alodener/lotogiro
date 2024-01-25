<?php

namespace App\Http\Controllers;
use App\Models\TypeGame;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function getCategories($typeGameId)
    {   
        $category = $typeGameId;
        $typeGames = TypeGame::where('category', $category)->get();
        return view('admin.layouts.categorias')->with(compact('typeGames'));

        
    }
}