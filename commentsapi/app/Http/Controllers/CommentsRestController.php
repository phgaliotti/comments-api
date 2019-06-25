<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UseCases\CreateCommentsUseCase;
use App\UseCases\RetrieveCommentsUseCase;
use App\UseCases\RetrieveCommentsByUserIdUseCase;
use App\UseCases\DeleteCommentsUseCase;
use App\UseCases\DeleteAllCommentsByUserUseCase;

class CommentsRestController extends Controller
{
    protected $createCommentsUseCase;
    protected $retrieveCommentsUseCase;
    protected $retrieveCommentsByUserIdUseCase;
    protected $deleteCommentsUseCase;
    protected $deleteAllCommentsByUserUseCase;

    public function __construct(CreateCommentsUseCase $createCommentsUseCase, 
        RetrieveCommentsUseCase $retrieveCommentsUseCase, 
        RetrieveCommentsByUserIdUseCase $retrieveCommentsByUserIdUseCase, 
        DeleteCommentsUseCase $deleteCommentsUseCase,
        DeleteAllCommentsByUserUseCase $deleteAllCommentsByUserUseCase) {

        $this->createCommentsUseCase = $createCommentsUseCase;
        $this->retrieveCommentsUseCase = $retrieveCommentsUseCase;
        $this->retrieveCommentsByUserIdUseCase = $retrieveCommentsByUserIdUseCase;
        $this->deleteCommentsUseCase = $deleteCommentsUseCase;
        $this->deleteAllCommentsByUserUseCase = $deleteAllCommentsByUserUseCase;
    }

    public function create(Request $request) {
        $this->validate($request, [
            'posting_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required'
        ]);

        $comment = $request->all();
        return $this->createCommentsUseCase->execute($comment);
    }

    public function getByUserId(Request $request) {
        return response()->json(['data' => $this->retrieveCommentsByUserIdUseCase->execute($request)]);
    }

    public function list(Request $request) {
        return response()->json(['data' => $this->retrieveCommentsUseCase->execute($request)]);
    }

    public function delete (Request $request){
        $id = $request->route('id');
        $userid = $request->route('userid');
        return $this->deleteCommentsUseCase->execute($id, $userid);
    }

    public function deleteUserComments(Request $request){
        $owenerpostingid = $request->route('owenerpostingid');
        $postid = $request->route('postid');
        $userid = $request->route('userid');
        return $this->deleteAllCommentsByUserUseCase->execute($owenerpostingid, $postid, $userid);

    }
}
