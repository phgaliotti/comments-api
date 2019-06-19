<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsRestController extends Controller
{
    public function create(Request $request){
        dd($request->all());
    }

    public function index(){
        return "ok";
    }
}
