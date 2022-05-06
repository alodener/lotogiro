<?php

namespace App\Http\Controllers\Admin\Pages\Settings;

use App\Http\Controllers\Controller;
use App\Models\Qualifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QualificationController extends Controller
{
    protected $qualification;

    public function __construct(Qualifications $qualification)
    {
        $this->qualification = $qualification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('read_qualification')){
            abort(403);
        }

        if ($request->ajax()) {
            $qualification = $this->qualification->get();
            return DataTables::of($qualification)
                ->addIndexColumn()
                ->addColumn('action', function ($qualification) {
                    $data = '';
                    if(auth()->user()->hasPermissionTo('update_qualification')){
                        $data .= '<a href="' . route('admin.settings.qualifications.edit', ['user' => $qualification->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if(auth()->user()->hasPermissionTo('delete_qualification')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_qualification" user="' . $qualification->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_qualification"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->editColumn('name', function ($qualification) {
                    return $qualification->name. ' '. $qualification->last_name;
                })
                ->editColumn('created_at', function ($qualification) {
                    return Carbon::parse($qualification->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.settings.qualification.index');
    }
}
