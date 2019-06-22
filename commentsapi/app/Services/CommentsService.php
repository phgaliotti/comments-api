<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

    public function findAll($pageSize) {
        if (empty($pageSize)){
            $pageSize = 10;
        }
        
        return $this->commentRepository->findAll($pageSize);
    }

    public function getLastMinuteCommentsByUserId($id) {
        return $this->commentRepository->getLastMinuteCommentsByUserId($id);
    }

    public function notifyOwnerPosting($commentingUser, $posting){
        $data = $this->buildDataMail($commentingUser, $posting);
        /*Mail::send($data->body, function($message, $data){
            $message->to($data->mailOwonerPosting)
                ->subject('You just received a comment! See now');
            $message->from('do-notreply@gmail.com');
        });*/
    }

    private function buildDataMail($commentingUser, $posting){
        $nameCommentingUser = $commentingUser->name;
        $nameOwnerPosting = $posting->user->name;
        $mailOwonerPosting = $posting->user->email;
        $body = "Hi," . $nameOwnerPosting . " the user ". $nameCommentingUser ." commented on your post " . $posting->title;
        
        Log::info("Notify :::: " . $body);
        return array("mailOwonerPosting" => $mailOwonerPosting, "body" => $body);
    }
}