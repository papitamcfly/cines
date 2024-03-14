<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\cineController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\CombosController;
use App\Http\Controllers\GenerosController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\usuarioscontroller;
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
    Route::post('verify-code', 'AuthController@verifyCode')->name('verifyCode')->middleware('limited-access-token');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get ('/activate/{token}', [AuthController::class ,'activate'])->name('activate');
});

Route::middleware(['auth:api','role:3'])->group(function () {
    Route::post('/cines', [cineController::class, 'store'])->name('createCine');
    Route::get('/cines/{cine}', [cineController::class, 'show'])->where('cine', '[0-9]+')->name('showCine');
    Route::put('/cines/{cine}', [cineController::class, 'update'])->where('cine', '[0-9]+')->name('updateCine');
    Route::delete('/cines/{cine}', [cineController::class, 'destroy'])->where('cine', '[0-9]+')->name('deleteCine');
});

Route::middleware(['auth:api','role:3'])->group(function () {
    Route::post('/salas', [SalaController::class, 'store'])->name('createSala');
    Route::get('/salas/{sala}', [SalaController::class, 'show'])->where('sala', '[0-9]+')->name('showSala');
    Route::put('/salas/{sala}', [SalaController::class, 'update'])->where('sala', '[0-9]+')->name('updateSala');
    Route::delete('/salas/{sala}', [SalaController::class, 'destroy'])->where('sala', '[0-9]+')->name('deleteSala');
});

Route::middleware(['auth:api','role:3'])->group(function () {
    Route::post('/funciones', [FuncionController::class, 'store'])->name('createFuncion');
    Route::get('/funciones/{funcion}', [FuncionController::class, 'show'])->where('funcion', '[0-9]+')->name('showFuncion');
    Route::put('/funciones/{funcion}', [FuncionController::class, 'update'])->where('funcion', '[0-9]+')->name('updateFuncion');
    Route::delete('/funciones/{funcion}', [FuncionController::class, 'destroy'])->where('funcion', '[0-9]+')->name('deleteFuncion');
});

Route::middleware(['auth:api','role:3'])->group(function () {
    Route::post('/boletos', [BoletoController::class, 'store'])->name('createBoleto');
    Route::get('/boletos/{boleto}', [BoletoController::class, 'show'])->where('boleto', '[0-9]+')->name('showBoleto');;
    Route::put('/boletos/{boleto}', [BoletoController::class, 'update'])->where('boleto', '[0-9]+')->name('updateBoleto');;
    Route::delete('/boletos/{boleto}', [BoletoController::class, 'destroy'])->where('boleto', '[0-9]+')->name('deleteBoleto');;
});

Route::middleware(['auth:api','role:1,3'])->group(function () {
    Route::post('/peliculas', [PeliculasController::class, 'store'])->name('createpeliculas');
    Route::get('/peliculas/{pelicula}', [PeliculasController::class, 'show'])->where('pelicula', '[0-9]+')->name('showPelicula');;
    Route::put('/peliculas/{pelicula}', [PeliculasController::class, 'update'])->where('pelicula', '[0-9]+')->name('updatePelicula');;
    Route::delete('/peliculas/{pelicula}', [PeliculasController::class, 'destroy'])->where('pelicula', '[0-9]+')->name('deletePelicula');;
});
Route::middleware(['auth:api','role:2,3'])->group(function () {
    Route::post('/generos', [GenerosController::class, 'store'])->name('creategeneros');
    Route::get('/generos/{genero}', [GenerosController::class, 'show'])->where('genero', '[0-9]+')->name('showgeneros');;
    Route::put('/generos/{genero}', [GenerosController::class, 'update'])->where('genero', '[0-9]+')->name('updategeneros');;
    Route::delete('/generos/{genero}', [GenerosController::class, 'destroy'])->where('genero', '[0-9]+')->name('deletegeneros');;
});
Route::middleware(['auth:api','role:3'])->group(function () {
    Route::post('/productos', [ProductosController::class, 'store'])->name('createproductos');
    Route::get('/productos/{producto}', [ProductosController::class, 'show'])->where('producto', '[0-9]+')->name('showproductos');;
    Route::put('/productos/{producto}', [ProductosController::class, 'update'])->where('producto', '[0-9]+')->name('updateproductos');;
    Route::delete('/productos/{producto}', [ProductosController::class, 'destroy'])->where('producto', '[0-9]+')->name('deleteproductos');;
});
Route::middleware(['auth:api','role:3'])->group(function () {
    Route::post('/combos', [CombosController::class, 'store'])->name('createcombos');
    Route::get('/combos/{combo}', [CombosController::class, 'show'])->where('combo', '[0-9]+')->name('showcombos');;
    Route::put('/combos/{combo}', [CombosController::class, 'update'])->where('combo', '[0-9]+')->name('updatecombos');;
    Route::delete('/combos/{combo}', [CombosController::class, 'destroy'])->where('combo', '[0-9]+')->name('deletecombos');;
});

Route::middleware(['auth:api','role:1,2,3'])->group(function () {
    Route::get('/peliculas', [PeliculasController::class, 'index'])->name('allpeliculas');
    Route::get('/combos', [CombosController::class, 'index'])->name('allcombos');
    Route::get('/productos', [ProductosController::class, 'index'])->name('allproductos');
    Route::get('/generos', [GenerosController::class, 'index'])->name('allgeneros');
    Route::get('/boletos', [BoletoController::class, 'index'])->name('allBoletos');
    Route::get('/funciones', [FuncionController::class, 'index'])->name('allFunciones');
    Route::get('/salas', [SalaController::class, 'index'])->name('allSalas');
    Route::get('/cines', [cineController::class, 'index'])->name('allCines');
});

Route::middleware(['auth:api','role:3'])->group(function () {
    Route::get('/usuarios', [usuarioscontroller::class, 'index'])->name('allusuarios');
    Route::post('/usuarios', [usuarioscontroller::class, 'store'])->name('createusuarios');
    Route::get('/usuarios/{combo}', [usuarioscontroller::class, 'show'])->where('combo', '[0-9]+')->name('showusuarios');
    Route::put('/usuarios/{combo}', [usuarioscontroller::class, 'update'])->where('combo', '[0-9]+')->name('updateusuarios');
    Route::delete('/usuarios/{combo}', [usuarioscontroller::class, 'destroy'])->where('combo', '[0-9]+')->name('deleteusuarios');
    Route::get('/roles',[usuarioscontroller::class,'showroles']);
});