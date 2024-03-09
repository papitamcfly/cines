<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Funcion;

class FuncionController extends Controller
{
    public function index()
    {
        $funciones = Funcion::all();
        return response()->json($funciones, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sala_id' => 'required|exists:salas,id',
            'pelicula_id' => 'required|exists:peliculas,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
        ], [
            'sala_id.required' => 'El campo Sala es obligatorio.',
            'sala_id.exists' => 'La Sala seleccionada no existe.',
            'pelicula_id.required' => 'El campo Película es obligatorio.',
            'pelicula_id.exists' => 'La Película seleccionada no existe.',
            'fecha.required' => 'El campo Fecha es obligatorio.',
            'fecha.date' => 'El valor ingresado para la Fecha no es válido.',
            'hora_inicio.required' => 'El campo Hora de inicio es obligatorio.',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Funcion::create($request->all());

        return response()->json('Funcion creada correctamente', 201);
    }

    public function show($id)
    {
        $funcion = Funcion::find($id);

        if (!$funcion) {
            return response()->json(['message'=>__('Funcion no encontrada')],404);
        }

        return response()->json($funcion, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sala_id' => 'required|exists:salas,id',
            'pelicula_id' => 'required|exists:peliculas,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
        ], [
            'sala_id.required' => 'El campo sala_id es obligatorio.',
            'sala_id.exists' => 'El sala_id proporcionado no existe.',
            'pelicula_id.required' => 'El campo pelicula_id es obligatorio.',
            'pelicula_id.exists' => 'El pelicula_id proporcionado no existe.',
            'fecha.required' => 'El campo fecha es obligatorio.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'hora_inicio.required' => 'El campo hora_inicio es obligatorio.',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $funcion = Funcion::find($id);

        if (!$funcion) {
            return response()->json(['message'=>'Funcion no encontrada'],404);
        }

        $funcion->update($request->all());

        return response()->json('Funcion actualizada correctamente', 201);
    }

    public function destroy($id)
    {
        $funcion = Funcion::find($id);

        if (!$funcion) {
            return response()->json(['message'=>'Funcion no encontrada'],404);
        }

        $funcion->delete();

        return response()->json(['message' => 'Función eliminada correctamente'], 200);
    }
}
