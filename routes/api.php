<?php

use App\Http\Controllers\Master\JenisLayananController;
use App\Http\Controllers\Master\LayananController;
use App\Http\Controllers\Master\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TrxFormulirController;
use App\Http\Middleware\CheckAvailable;
use App\Models\TrxFormulir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('migrate', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return 'Migrasi dan Seeding selesai!';
});

// Auth Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('master')->group(function () {
        Route::apiResource('jenis_layanan', JenisLayananController::class)->except(['index', 'show']);
        Route::apiResource('layanan', LayananController::class)->except(['index', 'show']);
        Route::apiResource('post_category', PostCategoryController::class)->except(['index', 'show']);
    });

    Route::apiResource('post', PostController::class)->except('index');

    Route::prefix('trx_formulir')->group(function () {
        Route::apiResource('', TrxFormulirController::class)->only(['index', 'show']);
        Route::get('set_done/{id_formulir}', [TrxFormulirController::class, 'setDone']);
    });
});

// Auth Guest
Route::middleware('guest')->group(function () {
    Route::prefix('master')->group(function () {
        Route::apiResource('jenis_layanan', JenisLayananController::class)->only(['index', 'show']);
        Route::apiResource('layanan', LayananController::class)->only(['index', 'show']);
        Route::apiResource('post_category', PostCategoryController::class)->only(['index', 'show']);
    });

    Route::apiResource('post', PostController::class)->only('index');

    Route::prefix('trx_formulir')->group(function () {
        Route::post('webhook', [TrxFormulirController::class, 'handleHook']);
        Route::post('check_available', [TrxFormulir::class, 'checkAvailable'])->middleware(CheckAvailable::class);
        Route::post('', [TrxFormulirController::class, 'store'])->name('trx_formulir.store')->middleware(CheckAvailable::class);
    });
});
