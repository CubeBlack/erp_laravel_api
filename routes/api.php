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

//Put sozinho
//Route::put('pessoas/{id}', [PessoasController::class, 'update']);

Route::match(['put', 'patch'], 'pessoas/{id}', [PessoasController::class, 'update']);

