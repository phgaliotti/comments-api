<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CommentRepository 
{
	private $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
    }
    
    public function new($comment) {
        $this->comment->create($comment);
    }

	public function findAll($pageSize) {
		return $this->comment->paginate($pageSize);
	}    

	
	public function getLastMinuteCommentsByUserId ($id) {
		$array = DB::select("select * from comments where TIMESTAMPDIFF(MINUTE, created_at, NOW()) <= 1 and user_id = '$id'");
		Log::info("getLastMinuteCommentsByUserId -> " . count($array));

		return $array;
		/*return $this->comment->where('user_id', $id)
			->where('TIMESTAMPDIFF(MINUTE, created_at, NOW()) <= 1')
			->orderBy('created_at', 'desc')
			->first()
			->get();*/
	}
}
