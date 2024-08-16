<?php

use App\Http\Controllers\Api\PermohonanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GrupController;
use App\Http\Controllers\Api\InstansiController;
use App\Models\Grup;
use App\Models\Instanses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/permohonan/test',[PermohonanController::class,"test"]);
Route::get('/permohonan',[PermohonanController::class,"index"]);
Route::get('/users',[UserController::class,"index"]);
Route::get('/grups',[GrupController::class,"index"]);
Route::get('/instanses',[InstansiController::class,"index"]);
