<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

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
            'password' => 'required|string',
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
            'password' => 'required|string', 
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $this->authService->modifierMotDePasse($user, $request->password);

        return response()->json(['message' => 'Password reset successfully']);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token refresh failed'], 401);
        }
    }
}
