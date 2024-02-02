<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuoteController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/quotes', [QuoteController::class,'getRandomQuotes'])->name('api.quote.random');


Route::middleware(['auth:api'])->group(function () {
    Route::get('/secure-quotes', [QuoteController::class, 'getSecuredQuotes'])->name('api.quote.secure');

    Route::post('/logout', [AuthController::class, 'logout']);
});