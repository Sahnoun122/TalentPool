<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;  

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:candidat,recruteur,admin',
        ]);

        $user = $this->authService->register($request->all());
       
        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        
        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        $user = $this->authService->login($request->email);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $this->authService->modifierMotDePasse($user, $request->password);

        return response()->json(['message' => 'Password reset successfully']);
    }

    public function me(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate(); 

        return response()->json(['user' => $user]);
    }
}
