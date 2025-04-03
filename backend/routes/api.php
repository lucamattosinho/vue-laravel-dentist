<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConsultaController;

Route::apiResource('consultas', ConsultaController::class);

Route::apiResource('pacientes', PacienteController::class);