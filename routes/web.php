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
    
    //usuarios
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //Route::get('usuarios', [App\Http\Controllers\HomeController::class, 'getUsuarios']);
    Route::get('get-usuarios', [App\Http\Controllers\HomeController::class, 'getUsuarios']);
    Route::post('usuarios/create', [App\Http\Controllers\HomeController::class, 'create']);
    Route::post('usuarios/edit', [App\Http\Controllers\HomeController::class, 'edit']);
    Route::post('usuarios', [App\Http\Controllers\HomeController::class, 'store']);
    Route::put('usuarios', [App\Http\Controllers\HomeController::class, 'update']);
    
    Route::delete("usuarios/{id}", [App\Http\Controllers\HomeController::class, "destroy"]);
    
    //categoria campos
    // Route::get('categorias-de-campos', [App\Http\Controllers\CategoriaCampoController::class, 'index']);
    // Route::get('categoria_campos', [App\Http\Controllers\CategoriaCampoController::class, 'getCategoriaCampos']);
    // Route::get('categoria_campos/create', [App\Http\Controllers\CategoriaCampoController::class, 'create']);
    // Route::get('categoria_campos/edit', [App\Http\Controllers\CategoriaCampoController::class, 'edit']);
    // Route::post('categoria_campos', [App\Http\Controllers\CategoriaCampoController::class, 'store']);
    // Route::put('categoria_campos', [App\Http\Controllers\CategoriaCampoController::class, 'update']);
    
    // Route::delete("categoria_campos/{id}", [App\Http\Controllers\CategoriaCampoController::class, "destroy"]);

    //formularios
    Route::get('tipoformularios', [App\Http\Controllers\TipoFormularioController::class, 'index']);
    Route::get('tipoformularios/gettipoformularios', [App\Http\Controllers\TipoFormularioController::class, 'getTipoFormularios']);
    Route::get('tipoformularios/create', [App\Http\Controllers\TipoFormularioController::class, 'create']);
    Route::get('tipoformularios/edit', [App\Http\Controllers\TipoFormularioController::class, 'edit']);
    Route::post('tipoformularios', [App\Http\Controllers\TipoFormularioController::class, 'store']);
    Route::put('tipoformularios', [App\Http\Controllers\TipoFormularioController::class, 'update']);
    
    Route::delete("tipoformularios/{id}", [App\Http\Controllers\TipoFormularioController::class, "destroy"]);

    //tipo campos
    Route::get('tipos-de-campos', [App\Http\Controllers\TipoCampoController::class, 'index']);
    Route::get('tipo_campos', [App\Http\Controllers\TipoCampoController::class, 'getTipoCampos']);
    Route::get('tipo_campos/create', [App\Http\Controllers\TipoCampoController::class, 'create']);
    Route::get('tipo_campos/edit', [App\Http\Controllers\TipoCampoController::class, 'edit']);
    Route::post('tipo_campos', [App\Http\Controllers\TipoCampoController::class, 'store']);
    Route::put('tipo_campos', [App\Http\Controllers\TipoCampoController::class, 'update']);
    
    Route::delete("tipo_campos/{id}", [App\Http\Controllers\TipoCampoController::class, "destroy"]);

    //campos para formularios
    Route::get('campos-para-formularios', [App\Http\Controllers\CampoController::class, 'index']);
    Route::get('campos_formularios', [App\Http\Controllers\CampoController::class, 'getCampos']);
    Route::get('campos_formularios/create', [App\Http\Controllers\CampoController::class, 'create']);
    Route::get('campos_formularios/edit', [App\Http\Controllers\CampoController::class, 'edit']);
    Route::post('campos_formularios', [App\Http\Controllers\CampoController::class, 'store']);
    Route::put('campos_formularios', [App\Http\Controllers\CampoController::class, 'update']);
    
    Route::delete("campos_formularios/{id}", [App\Http\Controllers\CampoController::class, "destroy"]);
});

