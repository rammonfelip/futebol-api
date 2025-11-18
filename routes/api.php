<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/campeonato', [App\Http\Controllers\BrasileiraoController::class, 'campeonato']);
    Route::get('/tabela', [App\Http\Controllers\BrasileiraoController::class, 'tabela']);
    Route::get('/proximas/partidas/{timeId}', [App\Http\Controllers\BrasileiraoController::class, 'proximasPartidas']);
});
