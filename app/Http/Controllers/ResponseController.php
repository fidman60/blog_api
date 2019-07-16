<?php

namespace App\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ResponseController extends Controller{

    protected $perPage = 5;
    protected $responseRepository;

    /**
     * ResponseController constructor.
     * @param $responseRepository
     */
    public function __construct(ResponseRepository $responseRepository){
        $this->middleware('auth:api')->only(['store']);
        $this->responseRepository = $responseRepository;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'response' => 'required|string|max:200|min:2',
            'comment_id' => 'required|integer|exists:comments,id'
        ]);

        if ($validator->fails()) return response()->json(['error' => $validator->errors()], 401);

        $success = $this->responseRepository->store($request->all(), Auth::id());

        if ($success)
            return response()->json(['success' => $success]);
        return response()->json(['error' => 'Sorry, something went wrong'], 401);
    }

    public function getCommentResponses($commentId){
        return response()->json($this->responseRepository->getCommentResponses($commentId, $this->perPage));
    }

}
