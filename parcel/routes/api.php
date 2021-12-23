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

Route::post('/auth/register', [\App\Http\Controllers\LoginController::class, 'register']);
Route::post('/auth/login', [\App\Http\Controllers\LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/bikers/parcels', [\App\Http\Controllers\ParcelController::class, 'showBikerParcels']);
    Route::get('/senders/parcels/', [\App\Http\Controllers\ParcelController::class, 'showSenderParcels']);
    Route::get('/parcels/{id}', [\App\Http\Controllers\ParcelController::class, 'show']);
    Route::get('/parcels/{id}/cancel', [\App\Http\Controllers\ParcelController::class, 'cancel']);
    Route::post('/parcels/{id}/pickup', [\App\Http\Controllers\ParcelController::class, 'pickup']);
    Route::post('/parcels/{id}/deliver', [\App\Http\Controllers\ParcelController::class, 'deliver']);
    Route::post('/parcels', [\App\Http\Controllers\ParcelController::class, 'store']);

    Route::get('/auth/logout', [\App\Http\Controllers\LoginController::class, 'logout']);
});


