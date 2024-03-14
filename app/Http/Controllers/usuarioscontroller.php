<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class usuarioscontroller extends Controller
{
    public function index()
    {
        $boletos = User::all();
        return response()->json($boletos, 200);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'required|exists:roles,id',
        ],[
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.string' => 'El email debe ser una cadena de texto.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'El email ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'rol.required' => 'El campo rol es obligatorio.',
            'rol.exists' => 'El rol seleccionado no existe.', 
        ]);
    if($validator->fails()){
        return response()->json($validator->errors()->toJson(),400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password),
            'is_active' => 1,
            ]
        ));
        return response()->json([
            'message' => 'usuario registrado correctamente. verifica tu correo para activar tu cuenta ', 'user'=>$user
        ],201);
    }

    
    public function show($id)
    {
        $boleto = User::find($id);

        if (!$boleto) {
            return response()->json(['message' => 'usuario no encontrado'], 404);
        }

        return response()->json($boleto, 200);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'rol' => 'required|exists:roles,id',
        ],[
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.string' => 'El email debe ser una cadena de texto.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'El email ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.confirmed' => 'La contraseña y la confirmación de contraseña no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'rol.required' => 'El campo rol es obligatorio.',
            'rol.exists' => 'El rol seleccionado no existe.', 
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'usuario no encontrado'], 404);
        }

        $usuario->update($request->all());

        return response()->json(['message' => 'usuario actualizado correctamente'], 200);
    }

    
    public function destroy($id)
    {
        $boleto = User::find($id);

        if (!$boleto) {
            return response()->json(['message' => 'usuario no encontrado'], 404);
        }

        $boleto->delete();

        return response()->json(['message' => 'usuario eliminado correctamente'], 200);
    }

    public function showroles()
    {
        $boletos = roles::all();
        return response()->json($boletos, 200);
    }
}
