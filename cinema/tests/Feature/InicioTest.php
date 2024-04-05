<?php
// codigo necesario para ejecutar los test: php artisan test tests/Feature/InicioTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Feature\Peliculas;
use App\Models\Pelicula;
use Database\Factories\PeliculaFactory;

class PeliculasControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testlistar()
    {
        // Insertar algunos datos de prueba en la tabla de películas
        DB::table('peliculas')->insert([
            ['nombre' => 'Pelicula 1', 'descripcion' => 'Descripción de la película 1', 'elenco' => 'Actor 1, Actor 2'],
            ['nombre' => 'Pelicula 2', 'descripcion' => 'Descripción de la película 2', 'elenco' => 'Actor 3, Actor 4'],
            // Inserta más datos según sea necesario
        ]);

        // Simular una solicitud HTTP GET a la ruta 'crud.index'
        $response = $this->get(route('crud.index'));

        // Verificar que la respuesta tenga un estado HTTP 200 (OK)
        $response->assertStatus(200);

        // Verificar que los datos de las películas están presentes en la vista
        $response->assertSee('Pelicula 1');
        $response->assertSee('Pelicula 2');
        // Agrega más verificaciones según sea necesario
    }

    public function testCreate()
    {
        // Simular una imagen cargada
        $imagen = UploadedFile::fake()->image('cartel.jpg');
    
        // Simular datos de película utilizando Faker
        $datosPelicula = [
            'txtnombre' => $this->faker->sentence,
            'txtdescripcion' => $this->faker->paragraph,
            'cartelera' => $imagen,
            'txtelenco' => $this->faker->name . ', ' . $this->faker->name,
        ];
    
        // Realizar una solicitud HTTP POST a la ruta de creación de películas
        $response = $this->post(route('crud.create'), $datosPelicula);
        
    
        // Verificar que la respuesta tenga un estado HTTP 302 (redirección después de la creación)
        $response->assertStatus(302);
    
        // Verificar que la película se ha registrado correctamente en la base de datos
        $this->assertDatabaseHas('peliculas', [
            'nombre' => $datosPelicula['txtnombre'],
            'descripcion' => $datosPelicula['txtdescripcion'],
            // Asegúrate de verificar todos los campos relevantes
        ]);
    }
    
    public function testActualizarPelicula()
    {
        // Crear una película de ejemplo en la base de datos
        $pelicula = DB::table('peliculas')->insertGetId([
            'nombre' => 'Pelicula de prueba',
            'descripcion' => 'Descripción de la película de prueba',
            'elenco' => 'Actor 1, Actor 2',
        ]);

        // Simular una imagen cargada
        $imagen = UploadedFile::fake()->image('nuevo_cartel.jpg');

        // Simular datos actualizados de la película utilizando Faker
        $datosActualizados = [
            'txtnombre' => $this->faker->sentence,
            'txtdescripcion' => $this->faker->paragraph,
            'cartelera' => $imagen,
            'txtelenco' => $this->faker->name . ', ' . $this->faker->name,
            'txtcodigo' => $pelicula,
        ];

        // Realizar una solicitud HTTP POST a la ruta de actualización de películas
        $response = $this->post(route('crud.update', $pelicula), $datosActualizados);

        // Verificar que la respuesta tenga un estado HTTP 302 (redirección después de la actualización)
        $response->assertStatus(302);

        // Verificar que la película se ha actualizado correctamente en la base de datos
        $this->assertDatabaseHas('peliculas', [
            'id' => $pelicula,
            'nombre' => $datosActualizados['txtnombre'],
            'descripcion' => $datosActualizados['txtdescripcion'],
            // Asegúrate de verificar todos los campos relevantes
        ]);
    }

    public function testEliminarPelicula()
    {
        // Crear una película de ejemplo en la base de datos
        $pelicula = DB::table('peliculas')->insertGetId([
            'nombre' => 'Pelicula de prueba',
            'descripcion' => 'Descripción de la película de prueba',
            'elenco' => 'Actor 1, Actor 2',
        ]);

        // Realizar una solicitud HTTP DELETE a la ruta de eliminación de la película
        $response = $this->get(route('crud.delete', $pelicula));

        // Verificar que la respuesta tenga un estado HTTP 302 (redirección después de la eliminación)
        $response->assertStatus(302);

        // Verificar que la película ha sido eliminada de la base de datos
        $this->assertDatabaseMissing('peliculas', ['id' => $pelicula]);
    }

    public function testBuscarPelicula()
    {
        // Insertar algunos datos de prueba en la tabla de películas
        DB::table('peliculas')->insert([
            ['nombre' => 'Pelicula 1', 'descripcion' => 'Descripción de la película 1', 'elenco' => 'Actor 1, Actor 2'],
            ['nombre' => 'Pelicula 2', 'descripcion' => 'Descripción de la película 2', 'elenco' => 'Actor 3, Actor 4'],
        ]);

        // Realizar una solicitud HTTP GET a la ruta 'buscar' con el término de búsqueda 'Pelicula 1'
        $response = $this->get(route('buscar', ['searchTerm' => 'Pelicula 1']));

        // Verificar que la respuesta tenga un estado HTTP 200 (OK)
        $response->assertStatus(200);

        // Verificar que la vista muestra los resultados de la búsqueda
        $response->assertSee('Pelicula 1');
        $response->assertDontSee('Pelicula 2'); // Asegúrate de que la otra película no esté presente
    }

    public function testBuscarPeliculaPorElenco()
    {
        // Insertar algunos datos de prueba en la tabla de películas
        DB::table('peliculas')->insert([
            ['nombre' => 'Pelicula 1', 'descripcion' => 'Descripción de la película 1', 'elenco' => 'Actor 1, Actor 2'],
            ['nombre' => 'Pelicula 2', 'descripcion' => 'Descripción de la película 2', 'elenco' => 'Actor 3, Actor 4'],
        ]);

        // Realizar una solicitud HTTP GET a la ruta 'buscar' con el término de búsqueda 'Actor 1'
        $response = $this->get(route('buscar', ['searchTerm' => 'Actor 1']));

        // Verificar que la respuesta tenga un estado HTTP 200 (OK)
        $response->assertStatus(200);

        // Verificar que la vista muestra los resultados de la búsqueda
        $response->assertSee('Pelicula 1');
        $response->assertDontSee('Pelicula 2'); // Asegúrate de que la otra película no esté presente
    }

    public function testBuscarPeliculaPorDescripcion()
    {
        // Insertar algunos datos de prueba en la tabla de películas
        DB::table('peliculas')->insert([
            ['nombre' => 'Pelicula 1', 'descripcion' => 'Descripción de la película 1', 'elenco' => 'Actor 1, Actor 2'],
            ['nombre' => 'Pelicula 2', 'descripcion' => 'Descripción de la película 2', 'elenco' => 'Actor 3, Actor 4'],
        ]);

        // Realizar una solicitud HTTP GET a la ruta 'buscar' con el término de búsqueda 'Descripción de la película 1'
        $response = $this->get(route('buscar', ['searchTerm' => 'Descripción de la película 1']));

        // Verificar que la respuesta tenga un estado HTTP 200 (OK)
        $response->assertStatus(200);

        // Verificar que la vista muestra los resultados de la búsqueda
        $response->assertSee('Pelicula 1');
        $response->assertDontSee('Pelicula 2'); // Asegúrate de que la otra película no esté presente
    }

    public function testPaginacion()
    {
        // Insertar seis películas en la base de datos
        DB::table('peliculas')->insert([
            ['nombre' => 'Pelicula 1', 'descripcion' => 'Descripción de la película 1', 'elenco' => 'Actor 1, Actor 2'],
            ['nombre' => 'Pelicula 2', 'descripcion' => 'Descripción de la película 2', 'elenco' => 'Actor 3, Actor 4'],
            ['nombre' => 'Pelicula 3', 'descripcion' => 'Descripción de la película 3', 'elenco' => 'Actor 5, Actor 6'],
            ['nombre' => 'Pelicula 4', 'descripcion' => 'Descripción de la película 4', 'elenco' => 'Actor 7, Actor 8'],
            ['nombre' => 'Pelicula 5', 'descripcion' => 'Descripción de la película 5', 'elenco' => 'Actor 9, Actor 10'],
            ['nombre' => 'Pelicula 6', 'descripcion' => 'Descripción de la película 6', 'elenco' => 'Actor 11, Actor 12'],
        ]);
    
        // Realizar una solicitud HTTP GET a la ruta 'crud.index'
        $response = $this->get(route('crud.index'));
    
        // Verificar que la respuesta tenga un estado HTTP 200 (OK)
        $response->assertStatus(200);
    
        // Verificar que se muestran cinco películas en la vista
        $response->assertSee('Pelicula 1');
        $response->assertSee('Pelicula 2');
        $response->assertSee('Pelicula 3');
        $response->assertSee('Pelicula 4');
        $response->assertSee('Pelicula 5');
    
        // Verificar que no se muestra la sexta película en la vista
        $response->assertDontSee('Pelicula 6');
    }

    public function testStressCreate()
    {
        // Repetir el proceso de creación de películas 50 veces
        for ($i = 1; $i <= 100; $i++) {
            // Simular una imagen cargada
            $imagen = UploadedFile::fake()->image('cartel' . $i . '.jpg');
        
            // Simular datos de película utilizando Faker
            $datosPelicula = [
                'txtnombre' => $this->faker->sentence,
                'txtdescripcion' => $this->faker->paragraph,
                'cartelera' => $imagen,
                'txtelenco' => $this->faker->name . ', ' . $this->faker->name,
            ];
        
            // Realizar una solicitud HTTP POST a la ruta de creación de películas
            $response = $this->post(route('crud.create'), $datosPelicula);
            
            // Verificar que la respuesta tenga un estado HTTP 302 (redirección después de la creación)
            $response->assertStatus(302);
        
            // Verificar que la película se ha registrado correctamente en la base de datos
            $this->assertDatabaseHas('peliculas', [
                'nombre' => $datosPelicula['txtnombre'],
                'descripcion' => $datosPelicula['txtdescripcion'],
                // Asegúrate de verificar todos los campos relevantes
            ]);
        }
    }

    public function testActualizacionSinCambios()
    {
        // Crear una película de ejemplo en la base de datos
        $pelicula = Pelicula::factory()->create();

        // Simular una solicitud HTTP POST a la ruta de actualización de películas sin realizar cambios
        $response = $this->post(route('crud.update', $pelicula->id), []);

        // Verificar que la respuesta tenga un estado HTTP 302 (redirección después de la actualización)
        $response->assertStatus(302);

        // Verificar que la película no se ha modificado en la base de datos
        $this->assertDatabaseHas('peliculas', [
            'id' => $pelicula->id,
            'nombre' => $pelicula->nombre,
            'descripcion' => $pelicula->descripcion,
            // Asegúrate de verificar todos los campos relevantes
        ]);
    }
       
}


