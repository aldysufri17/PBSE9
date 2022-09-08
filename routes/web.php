<?php

use App\Http\Controllers\EnergyController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.home');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'indexPengguna'])->name('home');

    // User
    Route::get('/dashboard', [HomeController::class, 'indexAdmin'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::get('/status/user/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('user.status');
    Route::post('/reset/password', [UserController::class, 'reset'])->name('user.reset');

    // Energi
    Route::resource('energy', EnergyController::class);

    // Post
    Route::resource('post', PostController::class);

    // Frontend
    Route::get('input-audit', [FrontendController::class, 'inputAudit'])->name('audit.input');
    Route::post('input-audit', [FrontendController::class, 'auditStore'])->name('audit.store');
});
