<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'elenco'];
    // Asegúrate de agregar cualquier otro campo que necesites
}
