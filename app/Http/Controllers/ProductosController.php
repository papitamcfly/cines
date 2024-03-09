<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function index()
    {
        $producto = Producto::all();
        return response()->json($producto, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:255',
            'descripcion'=>'required',
            'precio'=>'required|numeric'
        ],[
            'nombre.required'=>'el campo nombre es obligatorio',
            'nombre.max'=>'solo puedes poner 255 caracteres en este campo',
            'descripcion.required'=>'el campo descripcion es obligatorio',
            'precio.required'=>'el campo precio es obligatorio',
            'precio.numeric'=>'el campo precio debe ser numerico'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        Producto::create($request->all());
        return response()->json(['message'=>'producto creado correctamente'],201);
    }

    public function show($id)
    {
        $Producto = Producto::find($id);

        if (!$Producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($Producto, 200);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:255',
            'descripcion'=>'required',
            'precio'=>'required|numeric'
        ],[
            'nombre.required'=>'el campo nombre es obligatorio',
            'nombre.max'=>'solo puedes poner 255 caracteres en este campo',
            'descripcion.required'=>'el campo descripcion es obligatorio',
            'precio.required'=>'el campo precio es obligatorio',
            'precio.numeric'=>'el campo precio debe ser numerico'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $Producto = Producto::find($id);

        if (!$Producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $Producto->update($request->all());

        return response()->json(['message' => 'Producto actualizado correctamente'], 200);
    }

    
    public function destroy($id)
    {
        $Producto = Producto::find($id);

        if (!$Producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $Producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }

}
