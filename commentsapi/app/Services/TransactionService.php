<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class TransactionService
{
    const RETAINED_PERCENTAGE = 0.1;

    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository) {
        $this->transactionRepository = $transactionRepository;
    }
    
    public function register($comment) {
        $transaction = $this->convertCommenttoTransactionEntity($comment, null);
        $this->transactionRepository->create($transaction);
    }

    public function registerRetainedValue($comment, $sentCoins) {
        $transaction = $this->convertCommenttoTransactionEntity($comment, $sentCoins);
        $this->transactionRepository->create($transaction);
    }

    public function generateValueWithRetainedValue($sentCoins){
        return $sentCoins - ($sentCoins * TransactionService::RETAINED_PERCENTAGE);
    }

    private function getRetainedValue($coins){
        return $coins * TransactionService::RETAINED_PERCENTAGE;
    }

    private function convertCommenttoTransactionEntity($comment, $sentCoins){
        $userId = Arr::get($comment, 'user_id');
        $postId = Arr::get($comment, 'posting_id');
        $commentId = Arr::get($comment, 'id');
        $coins = Arr::get($comment, 'coins');
        if(!empty($sentCoins)){
            $coins = $this->getRetainedValue($sentCoins);
        }

        $entity = array("user_id" => $userId, "posting_id" => $postId, "comment_id" => $commentId, "coins" => $coins);
        return $entity;
    }

}
