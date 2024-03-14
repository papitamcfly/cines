<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenerosController extends Controller
{
    public function index(){
        $cines =  Genero::all();
        return response()->json($cines, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required'
        ],[
            'nombre.required'=>'el campo nombre es obligatorio'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        Genero::create($request->all());
        return response()->json(['message'=>'genero creado correctamente'],201);
    }

    public function show($id)
    {
        $Genero = Genero::find($id);

        if (!$Genero) {
            return response()->json(['message' => 'Genero no encontrado'], 404);
        }

        return response()->json($Genero, 200);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required'
        ],[
            'nombre.required'=>'el campo nombre es obligatorio'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $Genero = Genero::find($id);

        if (!$Genero) {
            return response()->json(['message' => 'Genero no encontrado'], 404);
        }

        $Genero->update($request->all());

        return response()->json(['message' => 'Genero actualizado correctamente'], 200);
    }

    
    public function destroy($id)
    {
        $Genero = Genero::find($id);

        if (!$Genero) {
            return response()->json(['message' => 'Genero no encontrado'], 404);
        }

        $Genero->delete();

        return response()->json(['message' => 'Genero eliminado correctamente'], 200);
    }
}
