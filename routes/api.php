<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::controller(UsuarioController::class)->group(function() {
    Route::get('usuarios', 'all')->name('usuarios.all');
    Route::post('usuarios', 'store')->name('usuarios.store');
    Route::put('usuarios/{usuario}', 'update')->name('usuarios.update');
    Route::delete('usuarios/{usuario}', 'destroy')->name('usuarios.destroy');
});
