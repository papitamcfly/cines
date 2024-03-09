<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\cineController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\BoletoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
});


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('mandarcorreo', [AuthController::class, 'mandarcorreo']);
    Route::post('verifyCode', [AuthController::class, 'verifyCode']);
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get ('/activate/{token}', [AuthController::class ,'activate'])->name('activate');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/cines', [cineController::class, 'index'])->name('allCines');
    Route::post('/cines', [cineController::class, 'store'])->name('createCine');
    Route::get('/cines/{cine}', [cineController::class, 'show'])->where('cine', '[0-9]+')->name('showCine');
    Route::put('/cines/{cine}', [cineController::class, 'update'])->where('cine', '[0-9]+')->name('updateCine');
    Route::delete('/cines/{cine}', [cineController::class, 'destroy'])->where('cine', '[0-9]+')->name('deleteCine');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/salas', [SalaController::class, 'index'])->name('allSalas');
    Route::post('/salas', [SalaController::class, 'store'])->name('createSala');
    Route::get('/salas/{sala}', [SalaController::class, 'show'])->where('sala', '[0-9]+')->name('showSala');
    Route::put('/salas/{sala}', [SalaController::class, 'update'])->where('sala', '[0-9]+')->name('updateSala');
    Route::delete('/salas/{sala}', [SalaController::class, 'destroy'])->where('sala', '[0-9]+')->name('deleteCine');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/funciones', [FuncionController::class, 'index'])->name('allFunciones');
    Route::post('/funciones', [FuncionController::class, 'store'])->name('createFuncion');
    Route::get('/funciones/{funcion}', [FuncionController::class, 'show'])->where('funcion', '[0-9]+')->name('showFuncion');
    Route::put('/funciones/{funcion}', [FuncionController::class, 'update'])->where('funcion', '[0-9]+')->name('updateFuncion');
    Route::delete('/funciones/{funcion}', [FuncionController::class, 'destroy'])->where('funcion', '[0-9]+')->name('deleteFuncion');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/boletos', [BoletoController::class, 'index'])->name('allBoletos');
    Route::post('/boletos', [BoletoController::class, 'store'])->name('createBoleto');
    Route::get('/boletos/{boleto}', [BoletoController::class, 'show'])->where('boleto', '[0-9]+')->name('showBoleto');;
    Route::put('/boletos/{boleto}', [BoletoController::class, 'update'])->where('boleto', '[0-9]+')->name('updateBoleto');;
    Route::delete('/boletos/{boleto}', [BoletoController::class, 'destroy'])->where('boleto', '[0-9]+')->name('deleteBoleto');;
});