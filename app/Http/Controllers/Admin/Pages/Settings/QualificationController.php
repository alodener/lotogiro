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
        if ($request->ajax()) {
            $qualification = Qualifications::orderBy('goal')->get();
            return DataTables::of($qualification)
                ->addIndexColumn()
                ->addColumn('action', function ($qualification) {
                    $data = '';
                    $data .= '<a href="' . route('admin.settings.qualifications.edit', ['qualification' => $qualification->id]) . '"><button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button></a>&nbsp;&nbsp;';
                    $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_qualification" qualification="' . $qualification->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_qualification"> <i class="far fa-trash-alt"></i></button>';
                    return $data;
                })
                ->rawColumns(['action'])
                ->editColumn('goal', function ($qualification) {
                    return intval($qualification->goal);
                })
                ->editColumn('personal_percentage', function ($qualification) {
                    return intval($qualification->personal_percentage);
                })
                ->editColumn('group_percentage', function ($qualification) {
                    return intval($qualification->group_percentage);
                })
                ->make(true);
        }

        return view('admin.pages.settings.qualification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.settings.qualification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // parte de tratamento de erro
        $validatedData = $request->validate([
            'description' => 'required|max:150',
            'goal' => 'required|integer',
            'personal_percentage' => 'required|integer',
            'group_percentage' => 'required|integer',
        ]);


        try {

            $qualification = new Qualifications([
                'description' => $request->description,
                'goal' => $request->goal,
                'personal_percentage' => $request->personal_percentage,
                'group_percentage' => $request->group_percentage,
            ]);
            $qualification->save();

            return redirect()->route('admin.settings.qualifications.index')->withErrors([
                'success' => 'Qualificação cadastrada com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.qualifications.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar a qualificação, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Qualifications $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Qualifications $qualification)
    {
        return view('admin.pages.settings.qualification.edit', compact('qualification'));
    }

    /**
     * Update the specified resource in storage..
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qualifications $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qualifications $qualification)
    {

        $validatedData = $request->validate([
            'description' => 'required|max:150',
            'goal' => 'required|integer',
            'personal_percentage' => 'required|integer',
            'group_percentage' => 'required|integer',
        ]);

        try {
            $qualification->description = $request->description;
            $qualification->goal = $request->goal;
            $qualification->personal_percentage = $request->personal_percentage;
            $qualification->group_percentage = $request->group_percentage;
            $qualification->save();

            return redirect()->route('admin.settings.qualifications.index')->withErrors([
                'success' => 'Qualificação alterada com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.qualifications.edit', ['qualification' => $qualification->id])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar a qualificação, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Qualifications $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualifications $qualification)
    {
        try {
            $qualification->delete();

            return redirect()->route('admin.settings.qualifications.index')->withErrors([
                'success' => 'Qualificação deletada com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.qualifications.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar a qualificação, tente novamente'
            ]);

        }
    }
}
