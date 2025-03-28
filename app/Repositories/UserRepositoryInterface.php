<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
    public function register ( $data);
    public function Connecter( $email);
    public function modifierMotDePasse($user,$password);
}