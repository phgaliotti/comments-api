<?php

namespace App\UseCases;

use App\Services\CommentsService;
use Illuminate\Support\Arr;
use App\Services\PostingService;
use Illuminate\Support\Facades\Log;
use App\Services\UsersService;

class CreateCommentsUseCase
{
    protected $commentsService;
    protected $postingService;
    protected $usersService;

    public function __construct(CommentsService $commentsService, PostingService $postingService, UsersService $usersService)
	{
        $this->commentsService = $commentsService;
        $this->postingService = $postingService;
        $this->usersService = $usersService;
    }
    
    public function execute($comment) {
        $user_id = Arr::get($comment, 'user_id');
        $commentingUser = $this->usersService->findById($user_id);

        if ($this->userExceededCommentsNumberPerMinute($commentingUser)) {
            return response()->json(['msg' => 'Limite de comentários por minuto excedido. Por favor, tente novamente mais tarde'], 429);
        }

        $posting_id = Arr::get($comment, 'posting_id');
        $posting = $this->postingService->findById($posting_id);
        // se o dono da postagem não for assinante e o dono do comentário tbm não for assinante erro
        if (!$this->validateUserCanComment($commentingUser, $posting)){
            return response()->json(['msg' => 'Olá, ' . $commentingUser->name .', você precisa ser assinante para comentar nessa postagem'], 403);
        }

        $newComment = $this->commentsService->create($comment);
        Log::info("vai notificar");
        $this->commentsService->notifyOwnerPosting($commentingUser, $posting);
        return response()->json($newComment, 201);
    }

    private function userExceededCommentsNumberPerMinute($commentingUser){
        $lastCommentsByUserId = $this->commentsService->getLastMinuteCommentsByUserId($commentingUser->id);
        if (count($lastCommentsByUserId) > 10) {
            return true;
        }
        return false;
    }

    private function validateUserCanComment($commentingUser, $posting){
        if ($commentingUser->subscriber == true || $this->ownerPostingIsSubscriber($posting) == true){
            return true; 
        }
        return false;
    }

    private function ownerPostingIsSubscriber($posting){
        return $posting->user->subscriber;
    }
}
