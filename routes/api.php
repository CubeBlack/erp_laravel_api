<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\API\PessoasController;
Route::get('pessoas', [PessoasController::class, 'index']);
Route::post('pessoas', [PessoasController::class, 'store']);
Route::get('pessoas/{id}', [PessoasController::class, 'show']);
Route::match(['put', 'patch'], 'pessoas/{id}', [PessoasController::class, 'update']);

use App\Http\Controllers\API\LogsController;
Route::get('logs/', [LogsController::class, 'index']);

use App\Http\Controllers\API\ClientePlanosController;
Route::get('clienteplanos', [ClientePlanosController::class, 'index']);
Route::post('clienteplanos', [ClientePlanosController::class, 'store']);
Route::get('clienteplanos/{id}', [ClientePlanosController::class, 'show']);
Route::match(['put', 'patch'], 'clienteplanos/{id}', [ClientePlanosController::class, 'update']);

