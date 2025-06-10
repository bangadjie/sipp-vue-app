<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PermohonanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GrupController;
use App\Http\Controllers\Api\InstansiController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\DashboardController;
use App\Models\Grup;
use App\Models\Instanses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, "index"]);
Route::post('/users', [UserController::class, 'store']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::get('/test', [UserController::class, 'test']);

Route::get('/permohonan/test', [PermohonanController::class, "test"]);
Route::get('/permohonan', [PermohonanController::class, "index"]);
Route::post('/permohonan', [PermohonanController::class, 'store']);
Route::put('/permohonan/{id}', [PermohonanController::class, 'update']);
Route::delete('/permohonan/{id}', [PermohonanController::class, 'destroy']);
Route::get('/permohonan/getPermohonanChartData', [PermohonanController::class, 'getPermohonanChartData']);

Route::get('/instanses', [InstansiController::class, 'index']);
Route::post('/instanses', [InstansiController::class, 'store']);
Route::delete('/instanses/{id}', [InstansiController::class, 'destroy']);
Route::put('/instanses/{id}', [InstansiController::class, 'update']);
Route::get('/test', [InstansiController::class, 'test']);

Route::get('/grups', [GrupController::class, "index"]);
Route::get('/grup', [GrupController::class, 'index']);
Route::post('/grup', [GrupController::class, 'store']);
Route::delete('/grup/{id}', [GrupController::class, 'destroy']);
Route::put('/grup/{id}', [GrupController::class, 'update']);

Route::get('/test', [GrupController::class, 'test']);

Route::get('/categories', [CategoriesController::class, "index"]);

Route::get('/statuses', [StatusController::class, "index"]);

Route::get('/dashboard', [DashboardController::class, 'index']);
// Route::get('/get-permohonan-chart-data', [DashboardController::class, 'getPermohonanChartData']);
// Route::get('/get-data', [DashboardController::class, 'get-data']);
// Route::get('/get-permohonan-chart-data', [DashboardController::class, 'getPermohonanChartData']);
