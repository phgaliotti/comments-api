<?php

namespace App\UseCases;

use App\Services\CommentsService;
use Illuminate\Support\Arr;
use App\Services\PostingService;
use App\Services\UsersService;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Log;
use App\Services\CacheService;

class CreateCommentsUseCase
{
    protected $commentsService;
    protected $postingService;
    protected $usersService;
    protected $notificationsService;
    protected $transactionService;
    protected $cacheService;

    public function __construct(CommentsService $commentsService, PostingService $postingService, 
        UsersService $usersService, NotificationsService $notificationsService, TransactionService $transactionService, CacheService $cacheService)
	{
        $this->commentsService = $commentsService;
        $this->postingService = $postingService;
        $this->usersService = $usersService;
        $this->notificationsService = $notificationsService;
        $this->transactionService = $transactionService;
        $this->cacheService = $cacheService;
    }
    
    public function execute($comment) {
        $user_id = Arr::get($comment, 'user_id');
        $commentingUser = $this->usersService->findById($user_id);

        if ($this->commentsService->userExceededCommentsNumberPerMinute($commentingUser)) {
            return response()->json(['msg' => 'Limite de comentários por minuto excedido. Por favor, tente novamente mais tarde'], 429);
        }

        $posting_id = Arr::get($comment, 'posting_id');
        $posting = $this->postingService->findById($posting_id);
        if (!$this->validateUserCanComment($commentingUser, $posting)){
            return response()->json(['msg' => 'Olá, ' . $commentingUser->name .', você precisa ser assinante para comentar nessa postagem'], 403);
        }

        $comment = $this->setCommentExpirationDate($comment);

        $coinsSent = Arr::get($comment, 'coins');
        if (!empty($coinsSent)){
            if ($coinsSent > $commentingUser->coins) {
                return response()->json(['msg' => 'Olá, ' . $commentingUser->name .', você não tem saldo suficiente. Seu saldo atual é de ' .$commentingUser->coins . ' moedas'], 403);
            } else {
                $comment = $this->enableHighlightComment($comment, $coinsSent);
            }
        }

        $newComment = $this->commentsService->create($comment);
        $this->cacheService->invalid();

        if ($newComment->enable_highlight == true){
            $this->registerTransaction($newComment, $coinsSent);
            $this->updateBalanceCoins($user_id, $coinsSent);
        }

        $this->notifyOwnerPosting($commentingUser, $posting);
        return response()->json($newComment, 201);
    }

    private function registerTransaction($newComment, $coinsSent){
        $this->transactionService->register($newComment);
        $this->transactionService->registerRetainedValue($newComment, $coinsSent);
    }

    private function updateBalanceCoins($user_id, $coinsSent) {
        $this->usersService->updateBalanceCoins($user_id, $coinsSent);
    }

    private function enableHighlightComment($comment, $coinsSent) {
        $coinsWithRetainedValue = $this->transactionService->generateValueWithRetainedValue($coinsSent);
        $comment['coins'] =  $coinsWithRetainedValue;
        $comment['enable_highlight'] = true;
        $comment['expiration_date'] = Carbon::now()->addMinute($coinsWithRetainedValue);
        
        return $comment;
    }

    private function validateUserCanComment($commentingUser, $posting){
        if ($commentingUser->subscriber == true || $this->ownerPostingIsSubscriber($posting) == true){
            return true; 
        }
        return false;
    }

    private function notifyOwnerPosting($commentingUser, $posting){
        $this->notificationsService->notifyOwnerPosting($commentingUser, $posting);
    }

    private function ownerPostingIsSubscriber($posting){
        return $posting->user->subscriber;
    }

    private function setCommentExpirationDate($comment) {
        $comment['expiration_date'] = Carbon::now();
        return $comment;
    }
}
