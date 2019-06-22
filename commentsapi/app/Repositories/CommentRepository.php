<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentRepository 
{
	private $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
    }
    
    public function new($comment) {
       return $this->comment->create($comment);
    }

	public function findAll($pageSize) {
		return $this->comment
			->orderBy('created_at', 'desc')
			->paginate($pageSize);
	}    

	
	public function getLastMinuteCommentsByUserId ($id) {
		$array = DB::select("select * from comments where TIMESTAMPDIFF(MINUTE, created_at, NOW()) <= 1 and user_id = '$id'");
		return $array;
	}
}
