<?php

namespace App\Http\Controllers\Site\Pages\Bets;

use App\Helper\Balance;
use App\Helper\Commision;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Game;
use App\Models\Draw;
use App\Models\HashGame;
use App\Models\TypeGame;
use App\Models\TypeGameValue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use App\Helper\GameHelper;
use App\Models\Competition;
use App\Models\Commission;
use App\Models\Layout_Button;
use App\Models\Layout_carousel_grande;
use App\Models\Layout_icons_sidebar;

class GameController extends Controller
{
    public function betIndex(User $user, Bet $bet = null)
    {
        $layout_button = Layout_Button::all();
            $layout_carousel_grande = Layout_carousel_grande::all();
            $layout_icons_sidebar = Layout_icons_sidebar::all();
        
            $allCategories = TypeGame::all();

        $TypeGamesRoll = TypeGame::all()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->first();
            });

        $typeGames = TypeGame::get();
        return view('site.bets.games.bets.index', compact('user', 'bet', 'typeGames','layout_button','layout_carousel_grande','layout_icons_sidebar','allCategories','TypeGamesRoll'));
    }

    public function betStore(User $user)
    {

        try {

            
            
            $bet = new Bet();
            $bet->user_id = $user->id;
            $bet->save();

            //session()->flash('success', 'Aposta criada com sucesso!');
            return redirect()->route('games.bet', ['user' => $user->id, 'bet' => $bet->id,]);
        } catch (Exception $exception) {
            session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
            return redirect()->route('games.bet', ['user' => $user->id, 'bet' => $bet->id]);
        }
    }

    public function gameCreate($user, Bet $bet, TypeGame $typeGame)
    {

        return view('site.bets.games.bets.create', compact('bet', 'typeGame'));
    }

    public function store(Bet $bet, $typeGame, $selectedNumbers, $valor, $premio,$valueid)
    {
             
        if ($bet->status == false) {
            throw new \Exception('Aposta Já finalizada');
        }
        
        $typeGame = TypeGame::find($typeGame->id); 
    
        if ($typeGame) {
            $competition = Competition::where('type_game_id', $typeGame->id)->latest('sort_date')->first();

            if ($competition) {
                $now = Carbon::now();
                $sortDateTime = Carbon::parse($competition->sort_date);
                if ($now->gt($sortDateTime)) {
                  
                    throw new \Exception('Apostas encerradas para o sorteio atual.');
                }
            }
        }
        sort($selectedNumbers, SORT_NUMERIC);
        $balance = Balance::calculationByHash($valor, $bet->user);
        //    if (!$balance) {
      //      throw new \Exception('Saldo Insufuciente!');
       // }

        $competition = TypeGame::find($typeGame->id)->competitions->last();

        if (empty($competition)) {
            throw new \Exception('Não existe concurso cadastrado!');
        }

        $hasDraws = Draw::where('competition_id', $competition->id)->count();

        if($hasDraws > 0) {
            throw new \Exception('Esse sorteio já foi finalizado!');
        }

        $validGame = Game::where([
            ['client_id', $bet->client->id],
            ['user_id', $bet->user->id],
            ['type_game_id', $typeGame->id],
            ['numbers', implode(',', $selectedNumbers)],
            ['bet_id', $bet->id],
        ])->first();

        if (!empty($validGame)) {
            throw new \Exception('Não é possivel cadastrar o mesmo jogo para está aposta!');
        }

        $typeGameValue = TypeGameValue::find($valueid);

        if(!empty($typeGameValue->max_repeated_games)) {
            $foundGames = Game::where('numbers', implode(',', $selectedNumbers))
            ->where('competition_id', $competition->id)
            ->where('type_game_value_id', $valueid)
            ->get();

            if ($foundGames->count() >= $typeGameValue->max_repeated_games) {
                throw new \Exception('Essa dezena já atingiu o número máximo de apostas com esses números!');
            }
        }
       
        $selectedNumbersC = implode(',', $selectedNumbers);

        $game = new Game();
        $game->client_id = $bet->client->id;
        $game->user_id = $bet->user->id;
        $game->type_game_id = $typeGame->id;
        $game->type_game_value_id = $valueid;
        $game->value = $valor;
        $game->premio = $premio;
        $game->numbers = $selectedNumbersC;
        $game->competition_id = $competition->id;
        $game->commission_percentage = $bet->user->commission;
        $game->bet_id = $bet->id;
        $game->status = false;
        $game->save();
       

      
        $typeGameCategory = TypeGame::where('id',$typeGame->id)->value('category');       
          
        
        if ($typeGameCategory == 'dupla_sena') {
            $competitionA = Competition::where('number', 'like', '%' . $competition->number . 'A')->first();
            
            $OpcaoJogo = 3;
            $numbers = $selectedNumbers;
            GameHelper::duplicateGame($game, $competitionA, $bet, $typeGame, $numbers, $OpcaoJogo, $valor, $premio);
            
            $commissionCalculation = Commision::calculation($game->commission_percentage, $valor);
            
            $game->commission_value = $commissionCalculation;
            $game->save();

            $commissionCalculation = Commision::calculation($game->commission_percentage, $game->value);

            $game->commission_value = $commissionCalculation;
            $game->save();
        }
        
        if ($typeGameCategory == 'mega_kino') {
            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            $OpcaoJogo = 3;

            foreach ($letters as $letter) {
                $competitionLetter = Competition::where('number', $competition->number . $letter)->first();
                    
                if($competitionLetter){
                $numbers = $selectedNumbers;
                GameHelper::duplicateGame($game, $competitionLetter, $bet, $typeGame, $numbers, $OpcaoJogo, $valor, $premio);
                    
                $commissionCalculation = Commision::calculation($game->commission_percentage, $valor);
                $game->commission_value = $commissionCalculation;
                $game->save();
            

                $commissionCalculation = Commision::calculation($game->commission_percentage, $game->value);
                }
            }
        }

        $bet->botao_finalizar = 0;
        $bet->save();

        return $game;

    

    }

    public function betUpdate(User $user, Bet $bet)
    {


        try {
            if($bet->botao_finalizar == 3){
                return view('site.bets.games.bets.bet-create', compact('bet'));
            }else{


            $bet->botao_finalizar = 3;
            $bet->status = false;
            $bet->save();
            return view('site.bets.games.bets.bet-create', compact('bet'));
             }
        } catch (Exception $exception) {
            session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
            return redirect()->route('games.bet', ['user' => $user->id, 'bet' => $bet->id]);
        }

    }

    public function setClient(Bet $bet, $clientId)
    {

        $bet->client_id = $clientId;
        $bet->save();

        return $bet;
    }

    public function validGame($game)
    {

    }
}
