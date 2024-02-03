<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // Registro de un nuevo usuario
    public function register(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken(config('app.name'))->accessToken;



        return response(['user'=>$user,'token' => $token], 200);
    }

    // Inicio de sesión
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response(['error' => 'Invalid credentials'], 401);
        }

        $user = $request->user();
        $token = $user->createToken(config('app.name'))->accessToken;

        return response(['token' => $token], 200);
    }

    // Cierre de sesión
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(['message' => 'Successfully logged out'], 200);
    }
}