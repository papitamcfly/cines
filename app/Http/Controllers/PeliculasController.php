<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeliculasController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|max:255',
            'sinopsis' => 'required',
            'duracion' => 'required|numeric',
            'clasificacion' => 'required',
            'generos' => 'required|array|min:1',
            'generos.*' => 'exists:generos,id'
        ],[
            'titulo.required' => 'El título de la película es obligatorio.',
            'titulo.string' => 'El título de la película debe ser una cadena de texto.',
            'titulo.max' => 'El título de la película no debe exceder los 255 caracteres.',
            'sinopsis.required' => 'La sinopsis de la película es obligatoria.',
            'duracion.required' => 'La duración de la película es obligatoria.',
            'duracion.numeric' => 'La duración de la película debe ser un valor numérico.',
            'clasificacion.required' => 'La clasificación de la película es obligatoria.',
            'generos.required' => 'Debe seleccionar al menos un género para la película.',
            'generos.array' => 'Los géneros de la película deben ser un array.',
            'generos.min' => 'Debe seleccionar al menos un género para la película.',
            'generos.*.exists' => 'Uno o más de los géneros seleccionados no existen en la base de datos.'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Crea una nueva película
        $pelicula = new Pelicula();
        $pelicula->titulo = $request->titulo;
        $pelicula->sinopsis = $request->sinopsis;
        $pelicula->duracion = $request->duracion;
        $pelicula->clasificacion = $request->clasificacion;
        $pelicula->save();
    
        // Adjunta los géneros seleccionados a la película
        $pelicula->generos()->attach($request->generos);
    
        return response()->json([
            'message' => 'Película creada correctamente',
            'pelicula' => $pelicula
        ], 201);
    }
    public function destroy($id){
        $peli = Pelicula::find($id);
        if (!$peli) return response()->json(['message'=>'combo no encontrado'],404);
        $peli->delete();

        return response()->json(['message'=>'Pelicula eliminada'],200);

    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|max:255',
            'sinopsis' => 'required',
            'duracion' => 'required|numeric',
            'clasificacion' => 'required',
            'generos' => 'required|array|min:1',
            'generos.*' => 'exists:generos,id'
        ],[
            'titulo.required' => 'El título de la película es obligatorio.',
            'titulo.string' => 'El título de la película debe ser una cadena de texto.',
            'titulo.max' => 'El título de la película no debe exceder los 255 caracteres.',
            'sinopsis.required' => 'La sinopsis de la película es obligatoria.',
            'duracion.required' => 'La duración de la película es obligatoria.',
            'duracion.numeric' => 'La duración de la película debe ser un valor numérico.',
            'clasificacion.required' => 'La clasificación de la película es obligatoria.',
            'generos.required' => 'Debe seleccionar al menos un género para la película.',
            'generos.array' => 'Los géneros de la película deben ser un array.',
            'generos.min' => 'Debe seleccionar al menos un género para la película.',
            'generos.*.exists' => 'Uno o más de los géneros seleccionados no existen en la base de datos.'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Buscar el maestro por su ID
        $maestro = Pelicula::findOrFail($id);

        // Actualizar los datos del maestro
        $maestro->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'clasificacion'=>$request->clasificacion
        ]);

        // Sincronizar las materias asociadas al maestro
        $maestro->generos()->sync($request->generos);

        // Redireccionar con un mensaje de éxito
        return response()->json(['message'=>'Pelicula actualizada','Pelicula'=>$maestro]);
    }


    public function index(){
        $maestros = Pelicula::with('generos')->get();
        return response()->json($maestros);
    }

    public function show($id)
    {
        $Pelicula = Pelicula::with('generos')->get()->find($id);

        if (!$Pelicula) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($Pelicula, 200);
    }
}
