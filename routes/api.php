<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('/user', [UserController::class, 'create']);
Route::put('/user', [UserController::class, 'update']);
Route::get('/user/{user_id}', [UserController::class, 'list']);
Route::delete('/user/{user_id}', [UserController::class, 'destroy']);

Route::post('/card', [CardController::class, 'create']);
Route::get('/card/{card_id}', [CardController::class, 'list']);

Route::post('/expense', [ExpenseController::class, 'create']);
Route::get('/expense/{user_id}', [ExpenseController::class, 'list']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
