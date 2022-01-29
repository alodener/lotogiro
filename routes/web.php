<?php

    use App\Http\Controllers\Admin\Pages\Dashboards\WalletController;
    use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Pages\Auth\LoginController;
use App\Http\Controllers\Admin\Pages\HomeController;
use App\Http\Controllers\Admin\Pages\Settings\UserController;
use App\Http\Controllers\Admin\Pages\Settings\PermissionController;
use App\Http\Controllers\Admin\Pages\Settings\RoleController;
use App\Http\Controllers\Admin\Pages\Bets\ClientController;
use App\Http\Controllers\Admin\Pages\Bets\CompetitionController;
use App\Http\Controllers\Admin\Pages\Bets\TypeGameController;
use App\Http\Controllers\Admin\Pages\Bets\TypeGameValueController;
use App\Http\Controllers\Admin\Pages\Bets\GameController;
use App\Http\Controllers\Admin\Pages\Bets\ValidateGamesController;
use App\Http\Controllers\Admin\Pages\Bets\DrawController;
use App\Http\Controllers\Admin\Pages\Dashboards\SaleController;
use App\Http\Controllers\Admin\Pages\Dashboards\GainController;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Admin\Pages\Bets\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [LoginController::class, 'showLoginForm']);

Route::get('/', [LoginController::class, 'showLoginForm'])->middleware('guest:admin');

Route::middleware('guest:web')->group(function () {
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/{user}/{bet?}', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'betIndex'])->name('bet');
        Route::post('/{user}/store', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'betStore'])->name('bet.store');
        Route::post('/{user}/{bet?}/update', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'betUpdate'])->name('bet.update');
        Route::get('/{user}/{bet}/{typeGame}/game-create', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'gameCreate'])->name('bet.game.create');
    });
});

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('get.login');
        Route::post('/login', [LoginController::class, 'login'])->name('post.login');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('dashboards')->name('dashboards.')->group(function () {
            Route::prefix('sales')->name('sales.')->group(function () {
                Route::get('/', [SaleController::class, 'index'])->name('index');
            });
            Route::prefix('gains')->name('gains.')->group(function () {
                Route::get('/', [GainController::class, 'index'])->name('index');
            });
            Route::prefix('extracts')->name('extracts.')->group(function () {
                Route::get('/', [ExtractController::class, 'index'])->name('index');
            });


            Route::prefix('wallet')->name('wallet.')->group(function () {
                Route::get('/', [WalletController::class, 'index'])->name('index');
                Route::get('/recharge', [WalletController::class, 'recharge'])->name('recharge');
                Route::get('/transfer', [WalletController::class, 'transfer'])->name('transfer');
                Route::get('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
                Route::get('/extract', [WalletController::class, 'extract'])->name('extract');
                Route::get('/withdraw-list', [WalletController::class, 'withdrawList'])->name('withdraw-list');
            });
        });
        Route::prefix('/bets')->name('bets.')->group(function () {
            Route::resource('clients', ClientController::class);
            Route::resource('competitions', CompetitionController::class);
            Route::resource('type_games', TypeGameController::class);
            Route::resource('type_games.values', TypeGameValueController::class);
            Route::get('/games/create-link', [GameController::class, 'createLink'])->name('games.link');
            Route::get('/games/receipt/{game}/{format}/{prize?}', [GameController::class, 'getReceipt'])->name('games.receipt');
            Route::get('/games/receiptTudo/{idcliente}', [GameController::class, 'getReceiptTudo'])->name('games.receiptTudo');
            Route::get('/games/{type_game}', [GameController::class, 'index'])->name('games.index');
            Route::get('games/carregarjogo/{type_game}', [GameController::class, 'carregarJogo'])->name('games.carregarjogo');
            Route::get('/games/create/{type_game}', [GameController::class, 'create'])->name('games.create');
            Route::resource('games', GameController::class)->except([
                'index', 'create'
            ]);
            Route::resource('draws', DrawController::class);
            Route::resource('validate-games', ValidateGamesController::class)->except([
                'store'
            ]);;
            Route::prefix('payments')->name('payments.')->group(function () {
                Route::prefix('commissions')->name('commissions.')->group(function () {
                    Route::get('/', [PaymentController::class, 'commissionIndex'])->name('index');
                });
                Route::prefix('draws')->name('draws.')->group(function () {
                    Route::get('/', [PaymentController::class, 'drawIndex'])->name('index');
                });
            });
        });
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::resource('users', UserController::class);
            Route::get('users/{userId}/statementBalance', [UserController::class, 'statementBalance'])->name('users.statementBalance');
            Route::resource('permissions', PermissionController::class);
            Route::resource('roles', RoleController::class);
        });
    });
});

