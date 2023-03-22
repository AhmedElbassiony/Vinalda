<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bill/{bill}' , [\App\Http\Controllers\Api\BillController::class , 'index']);
Route::post('/bill/update/{bill}' , [\App\Http\Controllers\Api\BillController::class , 'update']);
Route::get('/bill/destroy/{bill}' , [\App\Http\Controllers\Api\BillController::class , 'destroy']);
Route::post('/add/{billId}/item-purchase' , [\App\Http\Controllers\Api\ItemController::class , 'storePurchase'])->name('item.purchase.store');
Route::post('/add/{billId}/item-sale' , [\App\Http\Controllers\Api\ItemController::class , 'storeSale'])->name('item.sale.store');
Route::post('/add/{billId}/item-exchange' , [\App\Http\Controllers\Api\ItemController::class , 'storeExchange'])->name('item.exchange.store');
Route::get('/items-purchase' , [\App\Http\Controllers\Api\ItemController::class , 'itemPurchase']);
Route::get('/items-sale/{billId}' , [\App\Http\Controllers\Api\ItemController::class , 'itemSale']);
Route::get('/items-exchange/{billId}' , [\App\Http\Controllers\Api\ItemController::class , 'itemExchange']);
Route::get('/stocks' , [\App\Http\Controllers\Api\GeneralController::class , 'stocks']);
//Route::get('/cost-types' , 'UnitController@costType');
//Route::get('/banks' , 'UnitController@bank');
