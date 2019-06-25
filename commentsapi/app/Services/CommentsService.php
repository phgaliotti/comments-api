<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentsService
{
    const DEFAULT_PAGE_SIZE = 10;
    const DEFAULT_CURRENT_PAGE = 0;

    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
	{
        $this->commentRepository = $commentRepository;
    }
    
    public function create($comment) {
        return $this->commentRepository->new($comment); 
    }

    public function findByUserIdPaged($pageSize, $user_id) {
        return $this->commentRepository->findByUserIdPaged($this->getPageSize($pageSize), $user_id);
    }

    public function findById($id) {
        return $this->commentRepository->findById($id);
    }

    public function findAllCommentsByPostingId($postingid, $pageSize){
        return $this->commentRepository->findAllCommentsByPostingId($postingid, $this->getPageSize($pageSize));
    }

    public function findAll($pageSize) {
        return $this->commentRepository->findAll($this->getPageSize($pageSize));
    }

    public function getLastMinuteCommentsByUserId($id) {
        return $this->commentRepository->getLastMinuteCommentsByUserId($id);
    }

    public function userExceededCommentsNumberPerMinute($commentingUser) {
        $lastCommentsByUserId = $this->getLastMinuteCommentsByUserId($commentingUser->id);
        if (count($lastCommentsByUserId) > 10) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        return $this->commentRepository->delete($id);
    }

    public function deleteAllCommentsByUserId($userId, $postingId) {
        return $this->commentRepository->deleteAllCommentsByUserId($userId, $postingId);
    }

    private function getPageSize($pageSize){
        return empty($pageSize) ? CommentsService::DEFAULT_PAGE_SIZE : $pageSize;
    }
}