<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\AuthController;

Route::apiResource('consultas', ConsultaController::class);

Route::apiResource('pacientes', PacienteController::class);

Route::put('/pacientes/{id}', [PacienteController::class, 'update']);
Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy']);

Route::put('/consultas/{id}', [ConsultaController::class, 'update']);
Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy']);

Route::post('/login', [AuthController::class, 'login']);