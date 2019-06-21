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
        $this->commentRepository->new($comment);
        // retornar objeto criado
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
}
