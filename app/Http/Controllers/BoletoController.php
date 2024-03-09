<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Boleto;

class BoletoController extends Controller
{
  
    public function index()
    {
        $boletos = Boleto::all();
        return response()->json($boletos, 200);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_funcion' => 'required|exists:funciones,id',
            'id_user' => 'required|exists:users,id',
            'fila' => 'required',
            'asiento' => 'required',
            'precio' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Boleto::create($request->all());

        return response()->json(['message' => 'Boleto creado correctamente'], 201);
    }

    
    public function show($id)
    {
        $boleto = Boleto::find($id);

        if (!$boleto) {
            return response()->json(['message' => 'Boleto no encontrado'], 404);
        }

        return response()->json($boleto, 200);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_funcion' => 'required|exists:funciones,id',
            'id_user' => 'required|exists:users,id',
            'fila' => 'required',
            'asiento' => 'required',
            'precio' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $boleto = Boleto::find($id);

        if (!$boleto) {
            return response()->json(['message' => 'Boleto no encontrado'], 404);
        }

        $boleto->update($request->all());

        return response()->json(['message' => 'Boleto actualizado correctamente'], 200);
    }

    
    public function destroy($id)
    {
        $boleto = Boleto::find($id);

        if (!$boleto) {
            return response()->json(['message' => 'Boleto no encontrado'], 404);
        }

        $boleto->delete();

        return response()->json(['message' => 'Boleto eliminado correctamente'], 200);
    }
}
