<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
    public function register (array $data);
    public function Connecter(string $email);
    public function modifierMotDePasse($user, string $password);
}