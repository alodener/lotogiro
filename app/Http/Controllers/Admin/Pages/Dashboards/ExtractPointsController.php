<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Helper\UserValidate;
use App\Http\Controllers\Controller;
use App\Models\Qualifications;
use App\Models\UsersHasPoints;
use App\Models\UsersHasQualifications;
use Illuminate\Http\Request;

class ExtractPointsController extends Controller
{
    public function index(Request $request)
    {
        $balances = UsersHasPoints::getBalancesByUser(auth()->user());
        // $points = UsersHasPoints::where('user_id', auth()->user()->id)->orderByDesc('id')->get();
        $pagination = UsersHasPoints::filterPagination('', $request->input('pg'), 12, ['userId' => auth()->user()->id]);

        UsersHasQualifications::generateByUser(auth()->user());

        $qualificationAtived = UsersHasQualifications::getActivedByUser(auth()->user());
        $nextGoal = null;
        $goalCalculation = null;
        if ($qualificationAtived) {
            $nextGoal = Qualifications::getDiffNextGoal($qualificationAtived->getQualification(), $balances['personal_balance'], $balances['group_balance']);
            $goalCalculation = Qualifications::getGoalCalculation($qualificationAtived->getQualification(), $balances['personal_balance'], $balances['group_balance']);
        }

        return view('admin.pages.dashboards.points.index', compact('pagination', 'balances', 'qualificationAtived', 'nextGoal', 'goalCalculation'));
    }
}
