<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CivitasController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\EnergyUsageController;
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
    Route::get('/dashboard', [HomeController::class, 'indexAdmin'])->name('dashboard');
    Route::get('audit-master', [FrontendController::class, 'auditMaster'])->name('master.audit');
    Route::get('audit-input', [FrontendController::class, 'auditInput'])->name('audit.input');

    // ====================================== Dashboard Admin and Auditor ==============================
    // Route::group(['middleware' => AdminMiddleware::class], function () {
    // User
    Route::resource('user', UserController::class);
    Route::get('/status/user/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('user.status');
    Route::post('/reset/password', [UserController::class, 'reset'])->name('user.reset');

    // section
    Route::resource('section', SectionController::class);

    // Energi
    Route::resource('energy', EnergyController::class);

    // Konservasi Item
    Route::resource('konservasi', KonservasiContoller::class);

    // Building
    Route::resource('building', BuildingController::class);
    Route::get('/building/detail_admin/{id}', [BuildingController::class, 'showAdmin'])->name('building.show_admin');

    // Building
    Route::resource('civitas', CivitasController::class);
    Route::get('/civitas/detail_admin/{id}/{post_by}', [CivitasController::class, 'detailAdmin'])->name('civitas.detailAdmin');

    // Infrastruktur
    Route::resource('infrastruktur', InfrastrukturController::class);
    Route::get('/infrastruktur/{post_by}/{year}', [InfrastrukturController::class, 'edit'])->name('infrastruktur.edit');
    Route::get('/room/infrastruktur/ajax', [InfrastrukturController::class, 'roomInfrastrukturAjax'])->name('roomInfrastruktur.ajax');

    // Energy Usage
    Route::resource('energy-usage', EnergyUsageController::class);
    Route::get('admin/energy-usage', [EnergyUsageController::class, 'indexAdmin'])->name('energy-usage.index_admin');
    Route::get('/energy-usage/{id}/{post_by}', [EnergyUsageController::class, 'edit'])->name('energy-usage.edit');



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
    Route::get('infrastruktur/export/{id}', [InfrastrukturController::class, 'exportbeban'])->name('iq.export');
    Route::get('infrastruktur/building/{building_id}', [InfrastrukturController::class, 'InfrastrukturQty'])->name('rekap.building');
    Route::get('infrastruktur/infrastruktur/admin/Edit', [InfrastrukturController::class, 'ajaxEdit']);
    Route::post('infrastruktur/admin/infrastruktur/update', [InfrastrukturController::class, 'ajaxUpdate']);
    Route::delete('admin/infrastruktur/delete', [InfrastrukturController::class, 'deleteInfrastruktur'])->name('delete_infrastruktur');

    // Rekap Civitas
    // Route::get('Rekap-civitas', [CivitasController::class, 'rekapCivitas'])->name('rekap.civitas');
    // Route::get('Rekap-civitas-Tahunan/{post_by}', [CivitasController::class, 'civitasYear'])->name('civitas.year');
    // Route::get('Rekap-civitas/show/{post_by}/{year}', [CivitasController::class, 'show'])->name('civitas.show');

    // Konservasi Usage
    Route::get('konservasi-usage', [KonservasiContoller::class, 'konservasiusageIndex'])->name('konservasi_usage.index');
    Route::get('admin/konservasi-usage', [KonservasiContoller::class, 'indexAdmin'])->name('konservasi_usage.index_admin');
    Route::post('konservasi-input', [KonservasiContoller::class, 'konservasiInput'])->name('konservasi.input');
    Route::get('/konservasi-edit/{id}/{post_by}', [KonservasiContoller::class, 'Konservasiedit'])->name('konservasi_usage.edit');
    Route::post('/konservasi-update/{id}', [KonservasiContoller::class, 'Konservasiupdate'])->name('konservasi_usage.update');








    Route::get('konservasi-usage-years/{id}', [KonservasiContoller::class, 'konservasiusageYears'])->name('konservasi_usage.years');
    Route::get('konservasi-usage-show-years/{id}/{year}', [KonservasiContoller::class, 'konservasiusageShowYears'])->name('konservasi_usage.show_year');
    Route::get('konservasi-usage-month/{id}/{year}', [KonservasiContoller::class, 'konservasiusageMonth'])->name('konservasi_usage.month');
    Route::get('konservasi-usage-show-month/{id}/{month}', [KonservasiContoller::class, 'konservasiusageShowMonth'])->name('konservasi_usage.show_month');
    // Route::get('konservasi-usage/show/{id}/{year}/{month}', [KonservasiContoller::class, 'konservasiusageShow'])->name('konservasi_usage.show');
    // });

    // ====================================== User Panel ==============================
    // Route::group(['middleware' => UserMiddleware::class], function () {

    // Route::post('audit-store', [FrontendController::class, 'auditStore'])->name('audit.store');
    Route::post('infrastruktur-input', [FrontendController::class, 'infrastrukturInput'])->name('infrastruktur.input');
    Route::post('pemakaian-input', [FrontendController::class, 'pemakaianInput'])->name('pemakaian.input');
    // Route::post('konservasi-input', [FrontendController::class, 'konservasiInput'])->name('konservasi.input');
    // Route::get('civitas-akademika', [FrontendController::class, 'inputCivitas'])->name('input.civitas');
    // Route::post('civitas-akademika/store', [FrontendController::class, 'civitasStore'])->name('civitas.store');
    Route::post('tahunan-store', [FrontendController::class, 'tahunanStore'])->name('tahunan.store');

    // Gedung
    Route::get('Building-Add', [FrontendController::class, 'buildingAdd'])->name('building.add');
    // Route::post('Building-Store', [FrontendController::class, 'buildingStore'])->name('building.store');
    Route::get('Building-Detail/{building_id}', [FrontendController::class, 'buildingDetail'])->name('building.detail');
    Route::get('/room/delete', [FrontendController::class, 'deleteroom']);
    Route::get('/room/ajax', [FrontendController::class, 'roomAjax'])->name('room.ajax');
    // Route::post('Building-Update/{building_id}', [FrontendController::class, 'buildingUpdate'])->name('building.update');
    Route::get('Building-Delete/{building_id}', [FrontendController::class, 'buildingDelete'])->name('building.delete');

    // Infrastruktur
    Route::post('infrastruktur-edit/update', [FrontendController::class, 'updateInfrastrukturInput'])->name('updateInfrastruktur.input');
    Route::get('/infras/delete', [FrontendController::class, 'deleteinfras']);
    // });
});
