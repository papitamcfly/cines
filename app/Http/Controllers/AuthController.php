<?php

namespace App\Http\Controllers;
use App\Mail\AccountActivationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','verifyCode']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validar las credenciales
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Si la validación falla, devolver los errores
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Extraer las credenciales de la solicitud
        $credentials = $request->only('email', 'password');
    
        // Intentar autenticar al usuario con las credenciales
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales no válidas'], 401);
        }
        $user = auth()->user();
        if (!$user->is_active) {
            $this->mandarcorreo($user);
            return response()->json([
                'message' => 'Verifica tu correo para activar tu cuenta.'
            ],201);
        }
        $code = mt_rand(100000, 999999);
            // Almacenar el código en la base de datos
        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
    ]);

    // Enviar el código por correo electrónico
    Mail::to($user->email)->send(new VerificationCodeMail($code));
        // Si la autenticación es exitosa, responder con el token
        return response()->json(['message' => 'Verifica tu correo electrónico para obtener el código de verificación.','token'=>$token], 200);
    }

    public function verifyCode(Request $request)
    {
        $user = auth()->user();
        log::info($user);
        $code = $request->input('code');
       
        log::info($code);

        $verificationCode = VerificationCode::where('user_id', $user->id)
                                            ->where('code', $code)
                                            ->first();

        log::info($verificationCode);
    
        if ($verificationCode) {
            // Código correcto, generar el token JWT
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token,'codigo'=>$verificationCode], 200);
        } else {
            // Código incorrecto
            return response()->json(['error' => 'El código de verificación es incorrecto.'], 401);
        }
    }
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
    if($validator->fails()){
        return response()->json($validator->errors()->toJson(),400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        $token = JWTAuth::fromUser($user);

        $url = URL::temporarySignedRoute(
            'activate', now()->addMinutes(30), ['token' => $token]
        );

        Mail::to($user->email)->send(new AccountActivationMail($url));
        return response()->json([
            'message' => 'usuario registrado correctamente. verifica tu correo para activar tu cuenta ', 'user'=>$user
        ],201);
    }

    public function mandarcorreo($user)
    {
        $token = JWTAuth::fromUser($user);
        $url = URL::temporarySignedRoute(
            'activate', now()->addMinutes(30), ['token' => $token]
        );

        Mail::to($user->email)->send(new AccountActivationMail($url));
                return response()->json([
            'message' => 'Verifica tu correo para activar tu cuenta.'
        ],201);
    }
    public function activate($token)
    {
        $user = JWTAuth::parseToken()->authenticate();
 
        if ($user->is_active  == 0) {
            $user->is_active = 1;
            $user->save();
 
            return response()->json([
                'success' => true,
                'message' => 'Account activated successfully.',
            ]);
        }
 
        return response()->json([
            'success' => false,
            'message' => 'Account is already activated.',
        ]);
    }

    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}