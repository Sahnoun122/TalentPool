<?php 

// app/Services/AuthService.php
namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;  
use App\Models\User;
class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->register($data);
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->Connecter($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function modifierMotDePasse(User $user, string $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $user->save();
    }

    
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();
    }

    public function refreshToken()
    {
        return JWTAuth::parseToken()->refresh();
    }
}

