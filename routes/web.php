<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// web.php para rutas web o api.php para rutas de API
use App\Http\Controllers\AuthController;

// Ruta para registrar un nuevo usuario
Route::post('/register', [AuthController::class, 'register']);

// Ruta para iniciar sesión
Route::post('/login', [AuthController::class, 'login']);

// Ruta para cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');