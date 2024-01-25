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
use App\Models\Layout_carousel_grande;

use App\Models\TypeGame;

class HomeController extends Controller
{
    public function index()
    {
        // $user= auth()->user();
        //$user->assignRole('Administrador');
        //$user= auth()->user()->hasAllRoles(Role::all());

       /* $rankings = \DB::select(
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
                GROUP BY client_id,cli.name
                ORDER BY 2 DESC;"
            )
        ));
*/
        $User = Auth::user();
        $FiltroUser = client::where('email', $User['email'])->first();
        $this->FiltroUser = $FiltroUser;
        
        $JogosFeitos = game::where('user_id', $User['id'])->count();
        $saldo =(double) auth()->user()->balance;

        $layout_carousel_grande = Layout_carousel_grande::all();
        $allCategories = TypeGame::all();

        $TypeGamesRoll = TypeGame::all()
    ->groupBy('category')
    ->map(function ($group) {
        return $group->first();
    });


        //$balances = UsersHasPoints::getBalancesByUser(auth()->user());
        //$points = UsersHasPoints::where('user_id', auth()->user()->id)->orderByDesc('id')->get();

        //UsersHasQualifications::generateByUser(auth()->user());

        $qualificationAtived = null;//UsersHasQualifications::getActivedByUser(auth()->user());
        $nextGoal = null;
        $goalCalculation = null;
        
        // mandando valores para dashboar
        return view('admin.pages.home', compact('User', 'FiltroUser', 'JogosFeitos', 'saldo', 'qualificationAtived', 'nextGoal','goalCalculation','layout_carousel_grande','TypeGamesRoll','allCategories'));
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
