<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TutoriaisController extends Controller
{
    public function index()
    {



        // Lógica para buscar os tutoriais e passá-los para a view
       // $tutoriais = Tutorial::all(); // Exemplo: obtendo todos os tutoriais do banco de dados

        // Retornar a view dos tutoriais com os dados
        return view('admin.pages.dashboards.tutoriais.index');
    }
}
