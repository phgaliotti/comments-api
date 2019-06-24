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

    public function updateBalanceCoins($user_id, $coinsSent) {;
        $user = $this->findById($user_id);
        return $this->userRepository->update($user_id, ['coins' => $this->calcBalanceCoins($user, $coinsSent)]);
    }

    private function calcBalanceCoins($user, $coinsSent){
        return $user->coins - $coinsSent;
    }

}
