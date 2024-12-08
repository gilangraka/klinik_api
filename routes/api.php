<?php

use App\Http\Controllers\Master\JenisLayananController;
use App\Http\Controllers\Master\LayananController;
use App\Http\Controllers\Master\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TrxFormulirController;
use App\Http\Middleware\CheckAvailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/posts', PostController::class)->middleware('auth:sanctum');

Route::prefix('/master')->group(function () {
    Route::apiResource('/jenis_layanan', JenisLayananController::class);
    Route::apiResource('/layanan', LayananController::class);
    Route::apiResource('/post_category', PostCategoryController::class);
});

Route::apiResource('/trx_formulir', TrxFormulirController::class)->except('store');
Route::post('/trx_formulir', [TrxFormulirController::class, 'store'])->name('trx_formulir.store')->middleware(CheckAvailable::class);
Route::post('/trx_formulir/webhook', [TrxFormulirController::class, 'handleHook']);

Route::get('migrate', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return 'Migrasi dan Seeding selesai!';
});
