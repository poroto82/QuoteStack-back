<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // Registro de un nuevo usuario
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('MyApp')->accessToken;

        return response(['token' => $token], 200);
    }

    // Inicio de sesión
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response(['error' => 'Invalid credentials'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('MyApp')->accessToken;

        return response(['token' => $token], 200);
    }

    // Cierre de sesión
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(['message' => 'Successfully logged out'], 200);
    }
}