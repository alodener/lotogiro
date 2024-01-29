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
       

        $User = Auth::user();
        if ($User) {
            $FiltroUser = client::where('email', $User['email'])->first();
            $this->FiltroUser = $FiltroUser;
            $JogosFeitos = game::where('user_id', $User['id'])->count();
            $saldo = (double) auth()->user()->balance;
        }

        $layout_carousel_grande = Layout_carousel_grande::all();
        $allCategories = TypeGame::all();

        $TypeGamesRoll = TypeGame::all()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->first();
            });


        $qualificationAtived = null; //UsersHasQualifications::getActivedByUser(auth()->user());
        $nextGoal = null;
        $goalCalculation = null;

        if ($User) {
            return view('admin.pages.home', compact('User', 'FiltroUser', 'JogosFeitos', 'saldo', 'qualificationAtived', 'nextGoal', 'goalCalculation', 'layout_carousel_grande', 'TypeGamesRoll', 'allCategories'));
        } else {
            return view('admin.pages.home', compact('qualificationAtived', 'nextGoal', 'goalCalculation', 'layout_carousel_grande', 'TypeGamesRoll', 'allCategories'));

        }
    }


    public function FindCategoria($typeGameId)
    {
        $category = $typeGameId;
        $findcategory = TypeGame::where('category', $category)->get();

        $User = Auth::user();
        if ($User) {
            $FiltroUser = client::where('email', $User['email'])->first();
            $this->FiltroUser = $FiltroUser;
            $JogosFeitos = game::where('user_id', $User['id'])->count();
            $saldo = (double) auth()->user()->balance;
        }

        $layout_carousel_grande = Layout_carousel_grande::all();
        $allCategories = TypeGame::all();

        $TypeGamesRoll = TypeGame::all()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->first();
            });


        $qualificationAtived = null; //UsersHasQualifications::getActivedByUser(auth()->user());
        $nextGoal = null;
        $goalCalculation = null;

        if ($User) {
            return view('admin.pages.findcategoria', compact('User', 'FiltroUser', 'JogosFeitos', 'saldo', 'qualificationAtived', 'nextGoal', 'goalCalculation', 'layout_carousel_grande', 'TypeGamesRoll', 'allCategories','findcategory'));
        } else {
            return view('admin.pages.findcategoria', compact('qualificationAtived', 'nextGoal', 'goalCalculation', 'layout_carousel_grande', 'TypeGamesRoll', 'allCategories','findcategory'));

        }
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
