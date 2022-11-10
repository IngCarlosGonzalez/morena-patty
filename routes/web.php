<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SubscriberController;

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

// Route::view('/powergrid', 'powergrid-demo');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'asegun']
    )->name('dashboard');

    Route::name('catalogos')->resource(
        'usuarios',
        UsuarioController::class
    )
    ->names('usuarios');

    Route::name('catalogos')->resource(
        'colonias',
        ColoniaController::class
    )
    ->names('colonias');

    Route::name('catalogos')->resource(
        'owners',
        OwnerController::class
    )
    ->names('owners');

    Route::name('catalogos')->resource(
        'categorias',
        CategoriaController::class
    )
    ->names('categorias');

    Route::name('directorios')->resource(
        'subscribers',
        SubscriberController::class
    )
    ->names('subscribers');

    Route::name('directorios')->resource(
        'contactos',
        ContactoController::class
    )
    ->names('contactos');

    Route::get(
        '/directorios/contactos/index2',
        [ContactoController::class, 'index2']
    )->name('directorios.contactos.index2');

    Route::get(
        '/directorios/contactos/avisos',
        [ContactoController::class, 'avisos']
    )->name('directorios.contactos.avisos');

    Route::name('directorios')->resource(
        'documentos',
        DocumentoController::class
    )
    ->names('documentos');

    Route::name('oficinas')->resource(
        'visitas',
        VisitaController::class
    )
    ->names('visitas');

    Route::name('controles')->resource(
        'agendas',
        AgendaController::class
    )
    ->names('agendas');
});
