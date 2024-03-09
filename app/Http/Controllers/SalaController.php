<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaController extends Controller
{
    public function index()
    {
        $salas = Sala::all();
        return response()->json($salas, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cine_id' => 'required|exists:cines,id',
            'numero_sala' => 'required|int',
            'capacidad' => 'required|int|min:1',
        ], [
            'cine_id.required' => 'El campo cine_id es obligatorio.',
            'cine_id.exists' => 'El cine_id proporcionado no existe.',
            'numero_sala.required' => 'El campo número de sala es obligatorio.',
            'numero_sala.int' => 'El campo número de sala debe ser un número entero.',
            'capacidad.required' => 'El campo capacidad es obligatorio.',
            'capacidad.int' => 'El campo capacidad debe ser un número entero.',
            'capacidad.min' => 'El campo capacidad debe ser al menos 1.',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Sala::create($request->all());

        return response()->json('Sala creada correctamente', 201);
    }

    public function show($id)
    {
        $sala = Sala::find($id);

        if (!$sala) {
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }

        return response()->json($sala, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cine_id' => 'required|exists:cines,id',
            'numero_sala' => 'required|int',
            'capacidad' => 'required|int|min:1',
        ], [
            'cine_id.required' => 'El campo cine_id es obligatorio.',
            'cine_id.exists' => 'El cine_id proporcionado no existe.',
            'numero_sala.required' => 'El campo número de sala es obligatorio.',
            'numero_sala.int' => 'El campo número de sala debe ser un número entero.',
            'capacidad.required' => 'El campo capacidad es obligatorio.',
            'capacidad.int' => 'El campo capacidad debe ser un número entero.',
            'capacidad.min' => 'El campo capacidad debe ser al menos 1.',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sala = Sala::find($id);

        if (!$sala) {
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }

        $sala->update($request->all());

        return response()->json($sala, 200);
    }

    public function destroy($id)
    {
        $sala = Sala::find($id);

        if (!$sala) {
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }

        $sala->delete();

        return response()->json(['message' => 'Sala eliminada correctamente'], 200);
    }
}
