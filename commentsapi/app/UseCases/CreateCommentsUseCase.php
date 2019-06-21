<?php

namespace App\UseCases;

use App\Services\CommentsService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CreateCommentsUseCase
{
    protected $commentsService;

    public function __construct(CommentsService $commentsService)
	{
        $this->commentsService = $commentsService;
    }
    
    public function execute($comment) {
        $user_id = Arr::get($comment, 'user_id');
        $lastCommentsByUserId = $this->commentsService->getLastMinuteCommentsByUserId($user_id);
        if ($lastCommentsByUserId > 10) {
            return response()->json(['msg' => 'Limite de comentários por minuto excedido. Por favor, tente novamente mais tarde'], 429);
        }

        $comment = $this->commentsService->create($comment);
        return response()->json($comment, 201);
    }
}
