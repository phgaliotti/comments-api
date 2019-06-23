<?php

namespace App\UseCases;

use App\Services\CommentsService;
use App\Services\PostingService;

class DeleteAllCommentsByUserUseCase
{
    protected $commentsService;
    protected $postingService;

    public function __construct(CommentsService $commentsService, PostingService $postingService)
	{
        $this->commentsService = $commentsService;
        $this->postingService = $postingService;
    }
    
    public function execute($owenerpostingid, $postingId, $userId) {
        $posting = $this->postingService->findById($postingId);
        if (!empty($posting)) {
            if ($posting->user_id == $owenerpostingid) {
                $this->commentsService->deleteAllCommentsByUserId($userId, $postingId);
                return response()->json(['msg' => 'Os comentários do usuário de id ' . $userId . ' foram apagados com sucesso'], 200);
            }
        }

        return response()->json(['msg' => 'Postagem não encontrada ou você não tem privilégios para apagar esse comentários'], 400);
    }
}
