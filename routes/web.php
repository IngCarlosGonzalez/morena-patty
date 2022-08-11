<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource(
        'colonias',
        ColoniaController::class
    )
    ->names('colonias');

    Route::resource(
        'owners',
        OwnerController::class
    )
    ->names('owners');

    Route::resource(
        'categorias',
        CategoriaController::class
    )
    ->names('categorias');

    Route::resource(
        'contactos',
        ContactoController::class
    )
    ->names('contactos');

    Route::resource(
        'visitas',
        VisitaController::class
    )
    ->names('visitas');

    Route::resource(
        'agendas',
        AgendaController::class
    )
    ->names('agendas');
});
