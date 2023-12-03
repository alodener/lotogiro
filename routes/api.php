<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhook\ZoopController;
use App\Http\Controllers\Webhook\MercadoPagoController;
use App\Http\Controllers\Admin\Pages\Bets\BichaoController;
use App\Http\Controllers\Api\v2\WebhookController;

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

Route::post('v2/webhook/', WebhookController::class);
Route::get('bichao/get-results', [BichaoController::class, 'get_resultados'])->name('bichao.get_resultados');
