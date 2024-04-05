<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peliculas; // Importa el modelo Peliculas

class PeliculasController extends Controller
{
    public function index()
    {
        $datos = DB::table('peliculas')->paginate(5);
        return view('welcome', ['datos' => $datos]);
    } 

    public function create(Request $request){
            $request->validate([
                'txtnombre' => 'required|string|max:255',
                'txtdescripcion' => 'required|string',
                'cartelera' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
                'txtelenco' => 'string|max:255',
            ]);

        try {
                // Verificar si hay una imagen cargada
                if($request->hasFile('cartelera') && $request->file('cartelera')->isValid()) {
                    // Obtener la instancia del archivo de imagen
                    $imagen = $request->file('cartelera');
                    // Guardar la imagen con un nombre único en la carpeta 'public/carteles'
                    $nombre_imagen = time().'_'.$imagen->getClientOriginalName();
                    $imagen->move(public_path('carteles'), $nombre_imagen);
                } else {
                    // Si no se proporciona una imagen o la imagen no es válida, asignar un valor predeterminado
                    $nombre_imagen = 'default.jpg'; // Cambia 'default.jpg' al nombre de tu imagen predeterminada
                }
    
            // Insertar los datos en la base de datos incluyendo el nombre de la imagen
            $sql = DB::insert('insert into peliculas (nombre, descripcion, cartelera, elenco) values (?, ?, ?, ?)', [
                $request->txtnombre,
                $request->txtdescripcion,
                $nombre_imagen, // Insertamos el nombre de la imagen
                $request->txtelenco,
            ]);
            
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto","Película Registrada exitosamente");
        } else {
            return back()->with("incorrecto","Error al registrar Película");
        }
    }
    

    public function update(Request $request)
    {
            // Validar los datos recibidos del formulario
            $request->validate([
                'txtnombre' => 'required|string|max:255',
                'txtdescripcion' => 'required|string',
                'cartelera' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
                'txtelenco' => 'string|max:255',
            ]);
        try {
            // Verificar si hay una imagen cargada
            if($request->hasFile('cartelera') && $request->file('cartelera')->isValid()) {
                // Obtener la instancia del archivo de imagen
                $imagen = $request->file('cartelera');
                // Guardar la imagen con un nombre único en la carpeta 'public/carteles'
                $nombre_imagen = time().'_'.$imagen->getClientOriginalName();
                $imagen->move(public_path('carteles'), $nombre_imagen);
            } else {
                // Si no se proporciona una imagen, mantener la imagen existente
                $nombre_imagen = $request->txtcartelera; // Mantenemos el nombre de la imagen existente
            }
    
            $sql = DB::update('update peliculas set nombre=?, descripcion=?, cartelera=?, elenco=? where id=?',
                [
                    $request->txtnombre,
                    $request->txtdescripcion,
                    $nombre_imagen, // Insertamos el nombre de la imagen
                    $request->txtelenco,
                    $request->txtcodigo,
                ]);
                
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto","Película modificada exitosamente");
        } else {
            return back()->with("incorrecto","Error al modificar Película");
        }
    }
    
    public function delete($id)
    {
        try {
            $sql = DB::delete("delete from peliculas where id=?", [$id]);
            
            if ($sql > 0) {
                return back()->with("correcto","La Pelicula se eliminó exitosamente");
            } else {
                return back()->with("incorrecto","No se pudo eliminar la Pelicula");
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with("incorrecto","Error al eliminar la Pelicula: " . $ex->getMessage());
        }
    }
    
    public function buscar(Request $request)
    {
        // Obtén el término de búsqueda del formulario
        $searchTerm = $request->input('searchTerm');
    
        // Realiza la consulta a la base de datos utilizando Eloquent y aplica paginación
        $resultados = Peliculas::where('nombre', 'like', '%' . $searchTerm . '%')
                               ->orWhere('elenco', 'like', '%' . $searchTerm . '%')
                               ->orWhere('descripcion', 'like', '%' . $searchTerm . '%') // Agrega la búsqueda por descripción
                               ->paginate(5);
    
        // Verifica si se encontraron resultados
        if ($resultados->isEmpty()) {
            return back()->with("correcto", "No se encontraron resultados para '$searchTerm'")->withInput();
        } else {
            return view('welcome')->with("datos", $resultados);
        }
    }
    
    
}
