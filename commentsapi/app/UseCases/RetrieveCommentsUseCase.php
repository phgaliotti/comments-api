<?php

namespace App\UseCases;

use App\Services\CommentsService;
use Illuminate\Support\Facades\Log;
use App\Services\CacheService;

class RetrieveCommentsUseCase
{
    protected $commentsService;
    protected $cacheService;

    const DEFAULT_PAGE_SIZE = 10;
    const DEFAULT_CURRENT_PAGE = 0;

    public function __construct(CommentsService $commentsService, CacheService $cacheService)
	{
        $this->commentsService = $commentsService;
        $this->cacheService = $cacheService;
    }
    
    public function execute($request) {
        $pageSize = empty($request->input('pageSize')) ? RetrieveCommentsUseCase::DEFAULT_PAGE_SIZE : $request->input('pageSize');
        $currentPage = empty($request->input('page')) ? RetrieveCommentsUseCase::DEFAULT_CURRENT_PAGE : $request->input('page');
        $key = $currentPage . '_' .$pageSize;

        if ($this->cacheService->hasKey($key)) {
            Log::info("Recuperando comentários do Cache");
            return $this->cacheService->get($key);
        } else {
            Log::info("Recuperando comentários do BD");
            $comments = $this->commentsService->findAll($pageSize);
            $cacheExpireTimeInMinutes = 120;
            $this->cacheService->add($key, $comments, $cacheExpireTimeInMinutes);
            return $comments;
        }
    }
}
