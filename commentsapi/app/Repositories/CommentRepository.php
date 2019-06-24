<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class CommentRepository 
{
	private $comment;

	public function __construct(Comment $comment) {
		$this->comment = $comment;
    }
    
    public function new($comment) {
       return $this->comment->create($comment);
	}
	
	public function findByUserIdPaged($pageSize, $user_id){
		return $this->comment
			->where('user_id', $user_id)
			->paginate($pageSize);
	}

	public function findById($id){
		return $this->comment->find($id);
	}

	public function findAll($pageSize) {
		return $this->comment
			->join('users', 'comments.user_id', '=','users.id')
			->orderBy('comments.expiration_date', 'desc')
			->orderBy('comments.coins', 'desc')
			->orderBy('comments.created_at', 'desc')
			->select('comments.user_id', 'comments.id', 'users.email', 'users.subscriber', 'comments.enable_highlight', 'comments.created_at', 'comments.comment')
			->paginate($pageSize);
	} 

	public function getLastMinuteCommentsByUserId ($id) {
		$array = DB::select("select * from comments where TIMESTAMPDIFF(MINUTE, created_at, NOW()) <= 1 and user_id = '$id'");
		return $array;
	}

	public function delete($id) {
		return $this->comment->find($id)->delete();
	}

	public function deleteAllCommentsByUserId($userId, $postingId){
		return $this->comment
			->where('user_id', '=' , $userId)
			->Where('posting_id', $postingId)
			->delete();
	}
}
