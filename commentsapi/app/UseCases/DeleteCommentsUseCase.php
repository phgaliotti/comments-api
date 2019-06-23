<?php

namespace App\UseCases;

use App\Services\CommentsService;
use App\Services\PostingService;

class DeleteCommentsUseCase
{
    protected $commentsService;
    protected $postingService;

    public function __construct(CommentsService $commentsService, PostingService $postingService)
	{
        $this->commentsService = $commentsService;
        $this->postingService = $postingService;
    }
    
    public function execute($id, $userid) {
        $comment = $this->commentsService->findById($id);
        if (!empty($comment)) {
            if ($comment->user_id == $userid){
                $this->commentsService->delete($id);
                return response()->json(['msg' => 'Comentário ' . $id . " deletado com sucesso"], 200);
            } else {
                $posting = $this->postingService->findById($comment->posting_id);
                if (!empty($posting)) {
                    if ($posting->user_id == $userid) {
                        $this->commentsService->delete($id);
                        return response()->json(['msg' => 'Comentário ' . $id . " deletado com sucesso"], 200);
                    }
                }
            }
        }

        return response()->json(['msg' => 'Comentário não encontrado ou você não tem privilégios para apagá-lo'], 400);
    }
}
