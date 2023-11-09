<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('asd', function () {//ESTO AGREGUE
    return view('asd');
});

// Route::get('/api/auth', [AuthController::class, 'redirectToAuth']);
// Route::get('/api/auth/callback', [AuthController::class, 'handleAuthCallback']);



