<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhook\ZoopController;
use App\Http\Controllers\Webhook\MercadoPagoController;
use App\Http\Controllers\Webhook\DoBankController;
use App\Http\Controllers\Admin\Pages\Bets\BichaoController;
use App\Http\Controllers\ScrapingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('zoop/webhook/process/transaction/success', [ZoopController::class, 'processTransactionSuccess'])->name('zoop.webhook.process.success');
Route::post('mp/webhook/process/transaction', [MercadoPagoController::class, 'processTransaction'])->name('zoop.webhook.process');
Route::post('db/webhook/process/transaction', [DoBankController::class, 'processTransaction'])->name('zoop.webhook.process');


Route::get('bichao/get-results', [BichaoController::class, 'get_resultados'])->name('bichao.get_resultados');
Route::get('/scrape0', [ScrapingController::class, 'scrape0']);
Route::get('/scrape', [ScrapingController::class, 'scrape']);
Route::get('/scrape2', [ScrapingController::class, 'scrape2']);
Route::get('/scrapeAllStates', [ScrapingController::class, 'scrapeAllStates']);
Route::get('/hoje', [ScrapingController::class, 'get_games_today']);
Route::get('/ganhadores', [ScrapingController::class, 'getWinners']);

