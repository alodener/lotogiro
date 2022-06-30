<?php

namespace App\Http\Controllers\Admin\Pages\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Competition;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function usedDozensListCompetitions(Request $request)
    {   
        if (!auth()->user()->hasPermissionTo('read_competition')) {
            abort(403);
        }

        if ($request->ajax()) {
            $competition = Competition::get();
            return DataTables::of($competition)
                ->addIndexColumn()
                ->addColumn('action', function ($competition) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_competition')) {
                        $data .= '<a href="' . route('admin.reports.used.dozens.by-competition', ['competition' => $competition->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Ver Dezenas"><i class="far fa-eye"></i></button>
                    </a>';
                    }

                    return $data;
                })
                ->editColumn('type_game', function ($competition) {
                    return $competition->typeGame->name;
                })
                ->editColumn('sort_date', function ($competition) {
                    return Carbon::parse($competition->sort_date)->format('d/m/Y H:i:s');
                })
                ->editColumn('created_at', function ($competition) {
                    return Carbon::parse($competition->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.pages.reports.used-dozens');        
    }

    public function usedDozensByCompetition(Request $request, Competition $competition)
    {
        $competitionGames = $competition->games;
        $usedDozens = [];

        if($competitionGames->count() > 0) {
            foreach($competitionGames->all() as $competitionGame) {
                $competitionGameNumbers = explode(',', $competitionGame->numbers);

                if(is_array($competitionGameNumbers) && ! empty($competitionGameNumbers)) {
                    foreach($competitionGameNumbers as $competitionGameNumber) {
                        if(array_key_exists($competitionGameNumber, $usedDozens)) {
                            $usedDozens[$competitionGameNumber] = $usedDozens[$competitionGameNumber] + 1;
                        } else {
                            $usedDozens[$competitionGameNumber] = 1;
                        }
                    }
                }
            }
        }

        return view('admin.pages.reports.used-dozens-by-competition', compact('usedDozens'));
    }
}
