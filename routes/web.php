<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    //
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('usuarios', [App\Http\Controllers\HomeController::class, 'getUsuarios']);
    Route::get('usuarios/create', [App\Http\Controllers\HomeController::class, 'create']);
    Route::get('usuarios/edit', [App\Http\Controllers\HomeController::class, 'edit']);
    Route::post('usuarios', [App\Http\Controllers\HomeController::class, 'store']);
    Route::put('usuarios', [App\Http\Controllers\HomeController::class, 'update']);

    Route::delete("usuarios/{id}", [App\Http\Controllers\HomeController::class, "destroy"]);
});

