<?php

namespace App\UseCases;

use App\Services\CommentsService;

class RetrieveCommentsByUserIdUseCase
{
    protected $commentsService;

    public function __construct(CommentsService $commentsService)
	{
        $this->commentsService = $commentsService;
    }
    
    public function execute($pageSize, $id) {
        return response()->json(['data' => $this->commentsService->findByIdPaged($pageSize, $id)]);
    }
}
