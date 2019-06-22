<?php

namespace App\UseCases;

use App\Services\CommentsService;

class RetrieveCommentsUseCase
{
    protected $commentsService;

    public function __construct(CommentsService $commentsService)
	{
        $this->commentsService = $commentsService;
    }
    
    public function execute($pageSize) {
        return response()->json(['data' => $this->commentsService->findAll($pageSize)]);
    }
}
