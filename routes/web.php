<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Producto_CDAG_Controller;

// Ruta principal: redirige al listado de productos
Route::get('/', function () {
    return redirect()->route('productos.index');
});

// Rutas de productos con nombres descriptivos
// Estas rutas conectan las URLs con los métodos del controlador

// Ruta para mostrar el listado completo de productos
Route::get('/productos', [Producto_CDAG_Controller::class, 'index'])
    ->name('productos.index');

// Ruta para mostrar el detalle de un producto específico
Route::get('/productos/{id}', [Producto_CDAG_Controller::class, 'show'])
    ->name('productos.show')
    ->where('id', '[0-9]+'); // Validación: solo acepta números
