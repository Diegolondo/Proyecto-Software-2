<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

});


// Rutas privadas para todos los usuarios autenticados
Route::middleware(['auth:api', 'role:admin|user'])->group(function () 
{ 
   Route::post('logout', [AuthController::class, 'logout']); 
   Route::get('/products', [ProductController::class, 'index']);       // Listar productos
}); 
// Rutas privadas solo para usuarios con rol admin
Route::middleware(['auth:api', 'role:admin'])->group(function () 
{ 
    //Rutas Gestion Usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    //Rutas Gestion Productos
    Route::get('/products', [ProductController::class, 'index']); 
    Route::post('/products', [ProductController::class, 'store']);      // Crear producto
    Route::get('/products/{id}', [ProductController::class, 'show']);   // Ver producto por ID
    Route::put('/products/{id}', [ProductController::class, 'update']); // Actualizar producto
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Eliminar producto

    //Ruta Reporte
    Route::get('/reports', [ReportController::class, 'reporte']); // Obtener reporte de productos
}); 
// Rutas privadas solo para usuarios con rol usuario
// Route::middleware(['auth:api', 'role:user'])->group(function () 
// Add user-specific routes here if needed








