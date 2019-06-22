<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UsersService
{
    
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    

    public function findById($id) {
        return $this->userRepository->findById($id);
    }

}
