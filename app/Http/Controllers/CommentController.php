<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CommentController extends Controller {

    protected $perPage = 5;
    protected $commentRepository;

    /**
     * CommentController constructor.
     * @param $commentRepository
     */
    public function __construct(CommentRepository $commentRepository){
        $this->middleware('auth:api')->only('store', 'destroy');
        $this->commentRepository = $commentRepository;
    }

    public function getPostComments($postId){
        $data = $this->commentRepository->postComments($postId, $this->perPage);

        if(is_array($data))
            return response()->json(['data' => $data], 200);
        return response()->json(['error'=>'Sorry, something went wrong'], 401);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|min:10|max:100',
            'evaluation' => 'required|integer|min:1|max:5',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $success = $this->commentRepository->storeComment($request->all(), Auth::id());

        if($success)
            return response()->json(['success' => $success], 200);
        return response()->json(['error'=>'Sorry, something went wrong'], 401);
    }

    public function destroy($commentId){
        $success = $this->commentRepository->destroy($commentId, Auth::id());
        if($success)
            return response()->json(['success' => $success], 200);
        return response()->json(['error'=>'Sorry, something went wrong'], 401);
    }

    public function countResponses($commentId){
        return response()->json(['data' => $this->commentRepository->countTotalResponses($commentId)]);
    }

    public function countPositiveReactions($commentId){
        return response()->json(['data' => $this->commentRepository->countPositiveReactions($commentId)]);
    }

    public function countNegativeReactions($commentId){
        return response()->json(['data' => $this->commentRepository->countNegativeReactions($commentId)]);
    }

}
