<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {

Route::post('logout', [AuthController::class, 'logout']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Rutas privadas para todos los usuarios autenticados
Route::middleware(['auth:api', 'role:admin|user'])->group(function () 
{ 
   Route::post('logout', [AuthController::class, 'logout']); 
}); 
// Rutas privadas solo para usuarios con rol admin
Route::middleware(['auth:api', 'role:admin'])->group(function () 
{ 
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::get('/users/show', [UserController::class, 'show']);
Route::get('/users', [UserController::class, 'index']);
}); 
// Rutas privadas solo para usuarios con rol usuario
// Route::middleware(['auth:api', 'role:user'])->group(function () 
// Add user-specific routes here if needed





