<?php

    use App\Http\Controllers\Admin\Pages\Auth\RegisterController;
    use App\Http\Controllers\Admin\Pages\Dashboards\WalletController;
    use App\Http\Controllers\Admin\Pages\Dashboards\CustomeBalanceController;
    use App\Http\Controllers\Admin\Pages\Dashboards\WinningTicketController;
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
use App\Http\Controllers\Admin\Pages\Dashboards\ReportDayController;
use App\Http\Controllers\Admin\Pages\Dashboards\GainController;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Admin\Pages\Bets\PaymentController;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractPointsController;
use App\Http\Controllers\Admin\Pages\Dashboards\RankingController;
use App\Http\Controllers\Admin\Pages\Settings\QualificationController;
use App\Http\Controllers\Admin\Pages\Reports\ReportController;
use App\Http\Controllers\Admin\Pages\Settings\SystemController;
use App\Http\Controllers\Admin\Pages\Settings\LayoutController;
use App\Http\Controllers\Admin\Pages\Settings\LogosController;
use App\Http\Controllers\Admin\Pages\Bets\BichaoController;
use App\Http\Controllers\Admin\Pages\Dashboards\TutoriaisController;
use App\Http\Controllers\CategoriaController;

// recuperar senha controller
use App\Http\Controllers\ForgotPasswordController;


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

// rotas para recuperar senha
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/admin/indicate/{indicate?}', [RegisterController::class, 'registerIndicate'])->name('indicateRegister');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/updateStatusPaymentCron/2de1ce3ddcb20dda6e6ea9fba8031de4/', [WalletController::class, 'updateStatusPayment'])->name('updateStatusPaymentCron');

Route::get('/', [HomeController::class, 'index'])->middleware('guest:admin');
Route::get('admin/categoria/{typeGame}', [CategoriaController::class, 'getCategories']);
Route::get('admin/categoriaavulso/{typeGame}', [CategoriaController::class, 'getCategoriesavulso']);

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
        //Route::get('/login', [LoginController::class, 'showLoginForm'])->name('get.login');
        Route::post('/login', [LoginController::class, 'login'])->name('post.login')->middleware('is.active');;
    });
    Route::middleware(['auth:admin', 'check.openModal'])->group(function () {
        Route::get('change-locale/{locale}', [HomeController::class, 'changeLocale'])->name('changeLocale');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('dashboards')->name('dashboards.')->group(function () {
            Route::prefix('sales')->name('sales.')->group(function () {
                Route::get('/', [SaleController::class, 'index'])->name('index');
                Route::get('/bichao', [SaleController::class, 'bichaoSales'])->name('bichao');
            });
            Route::prefix('Reportday')->name('Reportday.')->group(function () {
                Route::get('/', [ReportDayController::class, 'index'])->name('index');
                Route::get('/FiltroEspecifico/{slug}', [ReportDayController::class, 'getFiltro'])->name('getFiltro');
                Route::post('/filtro-especifico', [ReportDayController::class, 'FiltroEspecifico'])->name('filtro-especifico');
            });
            Route::prefix('gains')->name('gains.')->group(function () {
                Route::get('/', [GainController::class, 'index'])->name('index');
            });
            Route::prefix('extracts')->name('extracts.')->group(function () {
                Route::get('/', [ExtractController::class, 'index'])->name('index');
                Route::get('/sales', [ExtractController::class, 'sales'])->name('sales');
                Route::get('/winning-ticket', [ExtractController::class, 'winningTicket'])->name('winning-ticket');
                Route::get('/add-winning-ticket', [ExtractController::class, 'addWinningTicket'])->name('add-winning-ticket');
                Route::get('/manual-recharge', [ExtractController::class, 'manualRecharge'])->name('manualRecharge');
                Route::get('/extracts-all', [ExtractController::class, 'extractsAll'])->name('extractsAll');
                Route::resource('points', ExtractPointsController::class);
            });

            Route::prefix('ranking')->name('ranking.')->group(function () {
                Route::get('/', [RankingController::class, 'index'])->name('index');
            });
            Route::prefix('help')->name('help.')->group(function () {
                Route::get('/tutoriais', [TutoriaisController::class, 'index'])->name('index');
            });

            Route::prefix('wallet')->name('wallet.')->group(function () {
                Route::get('/', [WalletController::class, 'index'])->name('index');
                Route::get('/convert', [WalletController::class, 'convert'])->name('convert');
                Route::get('/recharge', [WalletController::class, 'recharge'])->name('recharge');
                Route::get('/transfer', [WalletController::class, 'transfer'])->name('transfer');
                Route::get('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
                Route::get('/withdraw-visualizacao', [WalletController::class, 'withdrawVisualizacao'])->name('withdraw-visualizacao');
                Route::get('/extract', [WalletController::class, 'extract'])->name('extract');
                Route::get('/withdraw-list', [WalletController::class, 'withdrawList'])->name('withdraw-list');
                Route::get('/recharge-order', [WalletController::class, 'rechargeOrder'])->name('recharge-order');
                Route::get('/order-detail/{id}', [WalletController::class, 'orderDetail'])->name('order-detail');
                Route::get('/updateStatusPayment/2de1ce3ddcb20dda6e6ea9fba8031de4/', [WalletController::class, 'updateStatusPayment'])->name('updateStatusPayment');
                Route::get('/thanks/', [WalletController::class, 'thanks'])->name('thanks');
            });
            Route::prefix('customer')->name('customer.')->group(function (){
                Route::get('/', [CustomeBalanceController::class, 'index'])->name('balance');
                Route::get('/dashboard/winners', [CustomeBalanceController::class, 'dashboard_winners'])->name('dashboard.winners');
                Route::post('/detailed/view/user', [CustomeBalanceController::class, 'filter'])->name('detailed.view.user');
                Route::get('/lock/{id}', [CustomeBalanceController::class, 'lock_account'])->name('lock');
                Route::get('/unlock/{id}', [CustomeBalanceController::class, 'unlock_account'])->name('unlock');
                Route::get('/contact/made{id}', [CustomeBalanceController::class, 'contact_made'])->name('contact.made');
                Route::get('/contact/not/made{id}', [CustomeBalanceController::class, 'contact_not_made'])->name('contact.not.made');
                Route::put('/save/{id}', [CustomeBalanceController::class, 'save_changes'])->name('save');
                Route::get('/pdf/{id}/{date_initial}/{date_final}', [CustomeBalanceController::class, 'get_pdf'])->name('get.pdf');
            });
        });
        Route::prefix('/bets')->name('bets.')->group(function () {
            Route::prefix('/draws')->name('draws.')->group(function() {
                Route::get('bichao', [BichaoController::class, 'draws'])->name('bichao');
            });

            Route::prefix('/comissions')->name('comissions.')->group(function() {
                Route::get('bichao', [BichaoController::class, 'comissions'])->name('bichao');
            });
            Route::prefix('/bichao')->name('bichao.')->group(function (){
                Route::get('/', [BichaoController::class, 'index'])->name('index');
                Route::get('unidade', [BichaoController::class, 'unidade'])->name('unidade');
                Route::get('centena', [BichaoController::class, 'centena'])->name('centena');
                Route::get('cotacao', [BichaoController::class, 'cotacao'])->name('cotacao');
                Route::get('group', [BichaoController::class, 'group'])->name('group');
                Route::get('dezena', [BichaoController::class, 'dezena'])->name('dezena');
                Route::get('milhar/centena', [BichaoController::class, 'milhar_centena'])->name('milhar.centena');
                Route::get('milhar/invertida', [BichaoController::class, 'milhar_invertida'])->name('milhar.invertida');
                Route::get('centena/invertida', [BichaoController::class, 'centena_invertida'])->name('centena.invertida');
                Route::get('minhas/apostas', [BichaoController::class, 'my_bets'])->name('minhas.apostas');
                Route::get('terno/dezena', [BichaoController::class, 'terno_dezena'])->name('terno.dezena');
                Route::get('duque/dezena', [BichaoController::class, 'duque_dezena'])->name('duque.dezena');
                Route::get('quina/grupo', [BichaoController::class, 'quina_grupo'])->name('quina.grupo');
                Route::get('quadra/grupo', [BichaoController::class, 'quadra_grupo'])->name('quadra.grupo');
                Route::get('terno/grupo', [BichaoController::class, 'terno_grupo'])->name('terno.grupo');
                Route::get('duque/grupo', [BichaoController::class, 'duque_grupo'])->name('duque.grupo');
                Route::get('resultados', [BichaoController::class, 'results'])->name('resultados');
                Route::get('draws', [BichaoController::class, 'draws'])->name('draws');
                Route::post('draws/reports', [BichaoController::class, 'draws_reports'])->name('draws.reports');
                Route::post('bets/reports', [BichaoController::class, 'bets_reports'])->name('bets.reports');
                Route::post('add/chart', [BichaoController::class, 'add_in_chart'])->name('bichao.add.chart');
                Route::post('marcar-premio-pago', [BichaoController::class, 'pay_prize'])->name('bichao.payprize');
                Route::get('remove/chart/{index}', [BichaoController::class, 'remove_chart'])->name('bichao.remove.chart');
                Route::get('remove-all/chart', [BichaoController::class, 'remove_all_chart'])->name('bichao.remove_all.chart');
                Route::post('horarios', [BichaoController::class, 'get_horarios'])->name('bichao.horarios');
                Route::post('premio-maximo-json', [BichaoController::class, 'get_premio_maximo_json'])->name('bichao.premio_maximo');
                Route::post('checkout', [BichaoController::class, 'checkout'])->name('bichao.checkout');
                Route::post('get-results-json', [BichaoController::class, 'get_results_json'])->name('bichao.get_results_json');
                Route::get('receipt/{id}/{tipo}', [BichaoController::class, 'getReceipt'])->name('receipt');
                Route::post('save/settings', [BichaoController::class, 'save_settings'])->name('bichao.save.settings');
            });

            
            Route::resource('clients', ClientController::class)->except([
                'show']);
            Route::resource('competitions', CompetitionController::class);
            Route::resource('type_games', TypeGameController::class);
            Route::resource('type_games.values', TypeGameValueController::class);
            Route::get('/games/create-link', [GameController::class, 'createLink'])->name('games.link');
            Route::get('/games/receipt/{game}/{format}/{prize?}', [GameController::class, 'getReceipt'])->name('games.receipt');
            Route::get('/games/receiptTudo/{idcliente}', [GameController::class, 'getReceiptTudo'])->name('games.receiptTudo');
            Route::get('/games/receiptTudoTxt/{idcliente}', [GameController::class, 'getReceiptTudoTxt'])->name('games.getReceiptTudoTxt');
            Route::get('/games/{type_game}', [GameController::class, 'index'])->name('games.index');
            Route::get('games/carregarjogo/{type_game}', [GameController::class, 'carregarJogo'])->name('games.carregarjogo');
            Route::get('/games/create/{type_game}', [GameController::class, 'create'])->name('games.create');
            Route::post('/clients/vincular/{id_client}', [ClientController::class, 'vincularCliente'])->name('clients.vincular');

            Route::get('/clients/consultor', [ClientController::class, 'clientConsultor'])->name('consultor');

            Route::post('/games/mass-delete', [GameController::class, 'massDelete'])->name('games.massDelete');
            Route::resource('games', GameController::class)->except([
                'index', 'create'
            ]);
            Route::resource('draws', DrawController::class);
            Route::get('report-draws-index', [DrawController::class, 'reportDrawsIndex'])->name('report-draws-index');
            Route::get('report-draws', [DrawController::class, 'reportDraws'])->name('report-draws');
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
            Route::resource('qualifications', QualificationController::class);
            Route::get('bichao', [BichaoController::class, 'settings'])->name('bichao.index');

            Route::get('user/{user}/login-as', [UserController::class, 'logInAs'])->name('users.login-as');
            Route::get('user/loggout-as', [UserController::class, 'logoutAs'])->name('users.logout-as');

            Route::get('users/list/select', [UserController::class, 'listSelect'])->name('users.list.select');
            Route::get('clients/list/select', [ClientController::class, 'listSelect'])->name('clients.list.select');

            Route::resource('systems', SystemController::class);
            Route::resource('layout', LayoutController::class);

            Route::resource('logos', LogosController::class);
            

            Route::resource('users', UserController::class);
            Route::get('indicated', [UserController::class, 'indicated'])->name('users.indicated');
            Route::get('indicated/{userId}', [UserController::class, 'indicatedByLevel'])->name('users.indicatedByLevel');
            Route::get('users/{userId}/stateBalanceFiltrado', [UserController::class, 'statementBalancea'])->name('users.statementBalanceFiltrado');
            Route::get('users/{userId}/statementBalance', [UserController::class, 'Balance'])->name('users.statementBalance');
            Route::resource('permissions', PermissionController::class);
            Route::resource('roles', RoleController::class);
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('used-dozens/competitions', [ReportController::class, 'usedDozensListCompetitions'])->name('used.dozens');
            Route::get('{competition}/used-dozens', [ReportController::class, 'usedDozensByCompetition'])->name('used.dozens.by-competition');
            Route::get('points-by-user', [ReportController::class, 'pointsByUser'])->name('points-by-user');
            Route::get('bichao/bilhetes', [ReportController::class, 'bichaoReceipt'])->name('bichao.bilhetes');
            Route::post('bichao/bilhetes/remove/{game}', [ReportController::class, 'bichaoReceiptDestroy'])->name('bichao.bilhetes.destroy');
        });

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/readAll', [UserController::class, 'readAllNotifications']);
            Route::get('/', [UserController::class, 'getAllNotifications']);
        });
    });
});

Route::get('/users/winners', [CustomeBalanceController::class, 'userswinnersAPI']);
Route::get('/users/winners-clients', [CustomeBalanceController::class, 'userswinnersClientesAPI']);
