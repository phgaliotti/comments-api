<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UseCases\CreateCommentsUseCase;
use App\UseCases\RetrieveCommentsUseCase;

class CommentsRestController extends Controller
{
    protected $createCommentsUseCase;
    protected $retrieveCommentsUseCase;

    public function __construct(CreateCommentsUseCase $createCommentsUseCase, RetrieveCommentsUseCase $retrieveCommentsUseCase)
	{
        $this->createCommentsUseCase = $createCommentsUseCase;
        $this->retrieveCommentsUseCase = $retrieveCommentsUseCase;
    }

    public function create(Request $request) {
        $commentData = $request->all();
        $this->createCommentsUseCase->execute($commentData);
        return response()->json(['msg' => 'Comentário registrado com sucesso'], 201);
    }

    public function list(Request $request) {
        $pageSize = $request->input('pageSize');
    	return $this->retrieveCommentsUseCase->execute($pageSize);
    }
}
