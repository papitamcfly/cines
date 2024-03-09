<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cine;
use Illuminate\Support\Facades\Validator;

class cineController extends Controller
{
    public function index(){
        $cines =  Cine::all();
        return response()->json($cines, 200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'nombre'  => 'required|min:5|max:20|string',
            'direccion' => 'required|min:10|max:40|string',
            'ciudad' => 'required|min:10|max:20|string',
            'capacidad_total' => 'required|integer|min:1'
        ]);

        if($validate->fails()){
        return response()->json(['errors' =>$validate->errors()],422);
        }

        Cine::create($request->all());

        return response()->json('Cine creado correctamente', 201);
    }

    public function show($id){
        $cine = Cine::find($id);

        if(!$cine){
            return response()->json(['message'=> 'Cine no encontrado'],404);
        }
        return response()->json($cine, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'dirección' => 'required',
            'ciudad' => 'required',
            'capacidad_total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cine = Cine::find($id);

        if (!$cine) {
            return response()->json(['message' => 'Cine no encontrado'], 404);
        }

        $cine->update($request->all());

        return response()->json($cine);
    }

    public function destroy($id)
    {
        $cine = Cine::find($id);

        if (!$cine) {
            return response()->json(['message' => 'Cine no encontrado'], 404);
        }

        $cine->delete();

        return response()->json(['message' => 'Cine eliminado correctamente'], 200);
    }
}
