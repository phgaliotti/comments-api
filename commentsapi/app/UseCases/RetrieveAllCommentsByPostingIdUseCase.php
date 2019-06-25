<?php

namespace App\UseCases;

use App\Services\CommentsService;
use App\Services\CacheService;
use App\Services\PostingService;
use Illuminate\Support\Facades\Log;

class RetrieveAllCommentsByPostingIdUseCase
{
    protected $commentsService;
    protected $cacheService;
    protected $postingService;

    const DEFAULT_PAGE_SIZE = 10;
    const DEFAULT_CURRENT_PAGE = 0;

    public function __construct(CommentsService $commentsService, CacheService $cacheService, PostingService $postingService)
	{
        $this->commentsService = $commentsService;
        $this->cacheService = $cacheService;
        $this->postingService = $postingService;
    }
    
    public function execute($request) {
        $pageSize = empty($request->input('pageSize')) ? RetrieveCommentsUseCase::DEFAULT_PAGE_SIZE : $request->input('pageSize');
        $currentPage = empty($request->input('page')) ? RetrieveCommentsUseCase::DEFAULT_CURRENT_PAGE : $request->input('page');
        $postingid = $request->route('postingid');

        if (empty($this->hasPostingWithId($postingid))) {
            return response()->json(['msg' => 'A postagem que procura não existe'], 400);
        }
       
        $key = $postingid . "_" . $currentPage . '_' .$pageSize;
        return response()->json(['data' => $this->getCommentsByPostingId($key, $postingid, $pageSize)]);
    }

    private function getCommentsByPostingId($key, $postingid, $pageSize){
        if ($this->cacheService->hasKey($key)) {
            Log::info("tem cache");
            return $this->cacheService->get($key);
        } else {
            Log::info("buscou no BD");
            $comments = $this->commentsService->findAllCommentsByPostingId($postingid, $pageSize);
            $cacheExpireTimeInMinutes = 120;
            $this->cacheService->add($key, $comments, $cacheExpireTimeInMinutes);
            
            return $comments;
        }
    }

    private function hasPostingWithId($id) {
        return $this->postingService->findById($id);
    }
}
