<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository 
{
	private $transaction;

	public function __construct(Transaction $transaction) {
		$this->transaction = $transaction;
    }
    

	public function create($transaction) {
		return $this->transaction->create($transaction);
	}    

}
