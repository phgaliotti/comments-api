<?php

namespace App\UseCases;

use App\Services\CommentsService;

class RetrieveCommentsByUserIdUseCase
{
    protected $commentsService;

    const DEFAULT_PAGE_SIZE = 10;
    const DEFAULT_CURRENT_PAGE = 0;

    public function __construct(CommentsService $commentsService)
	{
        $this->commentsService = $commentsService;
    }
    
    public function execute($request) {
        $user_id = $request->route('userid');
        $pageSize = empty($request->input('pageSize')) ? RetrieveCommentsUseCase::DEFAULT_PAGE_SIZE : $request->input('pageSize');
        return  $this->commentsService->findByUserIdPaged($pageSize, $user_id);
    }
}
