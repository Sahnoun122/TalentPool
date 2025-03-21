<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface


{
    public function register(array $data)
    {
        return User::create($data);
    }

    public function Connecter(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function modifierMotDePasse($user, string $password)
    {
        $user->password = bcrypt($password);
        $user->save();
    }
}