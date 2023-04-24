<?php

namespace App\Http\Controllers\Admin\Pages;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Game;
use App\Models\Bet;
use App\Models\Qualifications;
use App\Models\UsersHasPoints;
use App\Models\UsersHasQualifications;

class HomeController extends Controller
{
    public function index()
    {
        // $user= auth()->user();
        //$user->assignRole('Administrador');
        //$user= auth()->user()->hasAllRoles(Role::all());

        $rankings = \DB::select(
            (\DB::raw("WITH RECURSIVE
                unwound AS (
                SELECT id, games
                    FROM draws
                UNION ALL
                SELECT id, regexp_replace(games, '^[^,]*,', '') games
                    FROM unwound
                    WHERE games LIKE '%,%'
                )
                
                SELECT client_id, SUM(premio) AS total, cli.name
                FROM games
                JOIN clients cli ON client_id = cli.id
                WHERE games.id IN (SELECT regexp_replace(games, ',.*', '') games
                FROM unwound
                ORDER BY id) 
                GROUP BY client_id
                ORDER BY 2 DESC;"
            )
        ));

        $User = Auth::user();
        $FiltroUser = client::where('email', $User['email'])->first();
        $this->FiltroUser = $FiltroUser;
        
        $JogosFeitos = game::where('user_id', $User['id'])->count();
        $saldo =(double) auth()->user()->balance;

        $balances = UsersHasPoints::getBalancesByUser(auth()->user());
        $points = UsersHasPoints::where('user_id', auth()->user()->id)->orderByDesc('id')->get();

        UsersHasQualifications::generateByUser(auth()->user());

        $qualificationAtived = UsersHasQualifications::getActivedByUser(auth()->user());
        $nextGoal = null;
        $goalCalculation = null;
        if ($qualificationAtived) {
            $nextGoal = Qualifications::getDiffNextGoal($qualificationAtived->getQualification(), $balances['personal_balance'], $balances['group_balance']);
            $goalCalculation = Qualifications::getGoalCalculation($qualificationAtived->getQualification(), $balances['personal_balance'], $balances['group_balance']);
        }

        // mandando valores para dashboar
        return view('admin.pages.home', compact('User', 'FiltroUser', 'JogosFeitos', 'saldo','points', 'balances', 'qualificationAtived', 'nextGoal','goalCalculation', 'rankings'));
    }

    public function riot(Request $request)
    {
        dd($request->all());
    }

    public function changeLocale(Request $request, $locale)
    {
        \DB::table('users')
        ->where('id', \Auth()->user()->id)
        ->update([
            'lang' => $locale
        ]);

        return redirect()->back();
    }
}
