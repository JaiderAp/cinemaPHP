<?php
namespace Database\Factories;

use App\Models\Pelicula;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeliculaFactory extends Factory
{
    protected $model = Pelicula::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'elenco' => $this->faker->name . ', ' . $this->faker->name,
            // Define otros campos según sea necesario
        ];
    }
}
