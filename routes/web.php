<?php

use App\Http\Controllers\CivitasController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\KonservasiContoller;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('frontend.home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // ====================================== Load all role ==============================
    Route::get('/home', [HomeController::class, 'indexPengguna'])->name('home');
    Route::get('audit-rekap', [FrontendController::class, 'auditRekap'])->name('rekap.audit');
    Route::get('audit-input', [FrontendController::class, 'auditInput'])->name('audit.input');

    // ====================================== Dashboard Admin and Auditor ==============================
    Route::group(['middleware' => AdminMiddleware::class], function () {
        // User
        Route::get('/dashboard', [HomeController::class, 'indexAdmin'])->name('dashboard');
        Route::resource('user', UserController::class);
        Route::get('/status/user/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('user.status');
        Route::post('/reset/password', [UserController::class, 'reset'])->name('user.reset');

        // section
        Route::resource('section', SectionController::class);

        // Energi
        Route::resource('energy', EnergyController::class);

        // Konservasi Item
        Route::resource('konservasi', KonservasiContoller::class);

        // energi_usage
        Route::get('energi-usage', [EnergyController::class, 'enegiusageIndex'])->name('energi_usage.index');
        Route::get('energi-usage-years/{id}', [EnergyController::class, 'enegiusageYears'])->name('energi_usage.years');
        Route::get('energi-usage-month/{id}/{year}', [EnergyController::class, 'enegiusageMonth'])->name('energi_usage.month');
        Route::get('energi-usage/show/{id}/{year}/{month}', [EnergyController::class, 'enegiusageShow'])->name('energi_usage.show');
        Route::get('energi-usage/export-csv/{id}/{year}', [EnergyController::class, 'export'])->name('energy.exportall');
        Route::get('energi-usage/export-csv/{id}/{year}/{month}', [EnergyController::class, 'export'])->name('energy.export');

        // Infrastruktur
        Route::resource('infrastruktur', InfrastrukturController::class);
        Route::get('Rekap-infrastruktur', [InfrastrukturController::class, 'rekapInfrastruktur'])->name('rekap.infrastruktur');
        Route::get('Rekap-infrastruktur-Tahunan/{year}/{post_by}', [InfrastrukturController::class, 'infrastrukturYear'])->name('infrastruktur.year');
        //Route::get('infrastruktur/export-csv/{id}/{year}', [InfrastrukturController::class, 'export'])->name('infrastructure.exportall');
        Route::get('infrastruktur/export-csv/{id}/{year}', [InfrastrukturController::class, 'export'])->name('infrastructure.export');

        // Rekap Civitas
        Route::get('Rekap-civitas', [CivitasController::class, 'rekapCivitas'])->name('rekap.civitas');
        Route::get('Rekap-civitas-Tahunan/{post_by}', [CivitasController::class, 'civitasYear'])->name('civitas.year');
        Route::get('Rekap-civitas/show/{post_by}/{year}', [CivitasController::class, 'show'])->name('civitas.show');

        // Konservasi Usage
        Route::get('konservasi-usage', [KonservasiContoller::class, 'konservasiusageIndex'])->name('konservasi_usage.index');
        Route::get('konservasi-usage-years/{id}', [KonservasiContoller::class, 'konservasiusageYears'])->name('konservasi_usage.years');
        Route::get('konservasi-usage-month/{id}/{year}', [KonservasiContoller::class, 'konservasiusageMonth'])->name('konservasi_usage.month');
        Route::get('konservasi-usage/show/{id}/{year}/{month}', [KonservasiContoller::class, 'konservasiusageShow'])->name('konservasi_usage.show');
    });

    // ====================================== User Panel ==============================
    Route::group(['middleware' => UserMiddleware::class], function () {

        // Route::post('audit-store', [FrontendController::class, 'auditStore'])->name('audit.store');
        Route::post('infrastruktur-input', [FrontendController::class, 'infrastrukturInput'])->name('infrastruktur.input');
        Route::post('pemakaian-input', [FrontendController::class, 'pemakaianInput'])->name('pemakaian.input');
        Route::post('konservasi-input', [FrontendController::class, 'konservasiInput'])->name('konservasi.input');
        Route::get('civitas-akademika', [FrontendController::class, 'inputCivitas'])->name('input.civitas');
        Route::post('civitas-akademika/store', [FrontendController::class, 'civitasStore'])->name('civitas.store');
    });
});
