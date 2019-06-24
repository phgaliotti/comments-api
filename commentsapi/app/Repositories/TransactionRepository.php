<?php

namespace App\Repositories;

use App\Transaction;

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
