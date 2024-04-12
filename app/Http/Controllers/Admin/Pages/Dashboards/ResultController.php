<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {

        $system = System::get();

        return view('admin.pages.dashboards.result.index', compact('system'));
    }
}
