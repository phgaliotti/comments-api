<?php

namespace App\UseCases;

use App\Services\CommentsService;
use Illuminate\Support\Arr;
use App\Services\PostingService;
use App\Services\UsersService;
use App\Services\NotificationsService;

class CreateCommentsUseCase
{
    protected $commentsService;
    protected $postingService;
    protected $usersService;
    protected $notificationsService;

    public function __construct(CommentsService $commentsService, PostingService $postingService, UsersService $usersService, NotificationsService $notificationsService)
	{
        $this->commentsService = $commentsService;
        $this->postingService = $postingService;
        $this->usersService = $usersService;
        $this->notificationsService = $notificationsService;
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

        $newComment = $this->commentsService->create($comment);

        $this->notifyOwnerPosting($commentingUser, $posting);

        return response()->json($newComment, 201);
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
}
