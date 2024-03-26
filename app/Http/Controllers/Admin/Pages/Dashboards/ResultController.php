<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {

        return view('admin.pages.dashboards.result.index');
    }
}
