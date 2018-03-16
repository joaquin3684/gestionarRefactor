<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 13/03/18
 * Time: 18:55
 */
class UserFromToken
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new \App\Repositories\UserRepo();
    }

    public function getUser()
    {
        $token = JWTAuth::getToken();
        $userId = JWTAuth::decode($token)['user_id'];
        $usuario = $this->userRepo->findWithAllRelationships($userId);
        return $usuario;
    }
}