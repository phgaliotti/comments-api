<?php

namespace App\Repositories;

use App\User;

class UserRepository 
{
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
    }
    
    public function findById($id) {
		return $this->user->find($id);
	}    

	public function update($user_id, $transaction){
		User::find($user_id)->update($transaction);
	}
   
}
