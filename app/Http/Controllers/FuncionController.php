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
