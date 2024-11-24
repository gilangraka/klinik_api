<?php

use App\Http\Controllers\Master\JenisLayananController;
use App\Http\Controllers\Master\LayananController;
use App\Http\Controllers\Master\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TrxFormulirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/master/jenis_layanan', JenisLayananController::class);
Route::apiResource('/master/layanan', LayananController::class);
Route::apiResource('/master/post_category', PostCategoryController::class);

Route::apiResource('/posts', PostController::class);
Route::apiResource('/trx_formulir', TrxFormulirController::class);
