<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentsService
{
    
    protected $commentRepository;
    public function __construct(CommentRepository $commentRepository)
	{
        $this->commentRepository = $commentRepository;
    }
    
    public function create($comment) {
        return $this->commentRepository->new($comment); 
    }

    public function findByUserIdPaged($pageSize, $user_id) {
        if (empty($pageSize)){
            $pageSize = 10;
        }
        return $this->commentRepository->findByUserIdPaged($pageSize, $user_id);
    }

    public function findById($id) {
        return $this->commentRepository->findById($id);
    }

    public function findAll($pageSize) {
        if (empty($pageSize)){
            $pageSize = 10;
        }
        return $this->commentRepository->findAll($pageSize);
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
}