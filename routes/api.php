<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

Route::post('/users', [AuthController::class , 'create']);
Route::post('/users/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);

Route::get('/unauthenticated', function() {

    $array['error'] = 'Usuario não logado';

    return $array;

})->name('login');

Route::get('/todos', [ApiController::class, 'index']);
Route::middleware('auth:sanctum')->post('/todo', [ApiController::class, 'store']);
Route::get('/todo/{id}',[ApiController::class, 'show']);
Route::middleware('auth:sanctum')->put('/todo/{id}', [ApiController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/todo/{id}', [ApiController::class, 'delete']);
