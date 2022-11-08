<?php

use App\Http\Controllers\CivitasController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\KonservasiContoller;
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
    Route::get('/list_user', [UserController::class, 'show'])->name('list_user');
    Route::resource('user', UserController::class);
    Route::get('/status/user/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('user.status');
    Route::post('/reset/password', [UserController::class, 'reset'])->name('user.reset');

    // Energi
    Route::resource('energy', EnergyController::class);

    // Konservasi
    Route::resource('konservasi', KonservasiContoller::class);

    // Frontend
    Route::get('audit-rekap', [FrontendController::class, 'auditRekap'])->name('rekap.audit');
    Route::get('audit-input', [FrontendController::class, 'auditInput'])->name('audit.input');
    // Route::post('audit-store', [FrontendController::class, 'auditStore'])->name('audit.store');

    Route::post('infrastruktur-input', [FrontendController::class, 'infrastrukturInput'])->name('infrastruktur.input');
    Route::post('pemakaian-input', [FrontendController::class, 'pemakaianInput'])->name('pemakaian.input');
    Route::post('konservasi-input', [FrontendController::class, 'konservasiInput'])->name('konservasi.input');


    Route::post('tahunan-store', [FrontendController::class, 'tahunanStore'])->name('tahunan.store');
    Route::get('riwayat-audit', [FrontendController::class, 'auditHistory'])->name('riwayat.audit');

    Route::get('civitas-akademika', [FrontendController::class, 'inputCivitas'])->name('input.civitas');
    Route::post('civitas-akademika/store', [FrontendController::class, 'civitasStore'])->name('civitas.store');


    // energi_usage
    Route::get('energi-usage', [EnergyController::class, 'enegiusageIndex'])->name('energi_usage.index');
    Route::get('energi-usage-years/{id}', [EnergyController::class, 'enegiusageYears'])->name('energi_usage.years');
    Route::get('energi-usage-month/{id}/{year}', [EnergyController::class, 'enegiusageMonth'])->name('energi_usage.month');
    Route::get('energi-usage/show/{id}/{year}/{month}', [EnergyController::class, 'enegiusageShow'])->name('energi_usage.show');


    // Infrastruktur
    Route::resource('infrastruktur', InfrastrukturController::class);
    Route::get('Rekap-infrastruktur', [InfrastrukturController::class, 'rekapInfrastruktur'])->name('rekap.infrastruktur');
    Route::get('Rekap-infrastruktur-Tahunan/{year}/{post_by}', [InfrastrukturController::class, 'infrastrukturYear'])->name('infrastruktur.year');

    // Rekap Civitas
    Route::get('Rekap-civitas', [CivitasController::class, 'rekapCivitas'])->name('rekap.civitas');
    Route::get('Rekap-civitas-Tahunan/{post_by}', [CivitasController::class, 'civitasYear'])->name('civitas.year');
    Route::get('Rekap-civitas/show/{post_by}/{year}', [CivitasController::class, 'show'])->name('civitas.show');
});
