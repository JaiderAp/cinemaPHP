<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculasController;
use Illuminate\Support\Facades\DB;

Route::get("/", [PeliculasController::class, "index"])->name("crud.index");

//Ruta para registrar una pelicula
Route::post("/registrar-pelicula", [PeliculasController::class, "create"])->name("crud.create");
//Ruta para actualizar una pelicula
Route::post("/modificar-pelicula", [PeliculasController::class, "update"])->name("crud.update");
//Ruta para eliminar una pelicula
Route::get("/eliminar-pelicula-{id}", [PeliculasController::class, "delete"])->name("crud.delete");

Route::get('/buscar', [PeliculasController::class, 'buscar'])->name('buscar');