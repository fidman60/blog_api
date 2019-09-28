<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class CommentController extends Controller {

    protected $perPage = 5;
    protected $commentRepository;

    /**
     * CommentController constructor.
     * @param $commentRepository
     */
    public function __construct(CommentRepository $commentRepository){
        $this->middleware('auth:api')->only('store', 'destroy', 'getPostComments');
        $this->commentRepository = $commentRepository;
    }

    public function getPostComments($postId){
        $data = $this->commentRepository->postComments($postId, $this->perPage, Auth::id());

        if($data)
            return response()->json($data, 200);
        return response()->json(['error'=>'Sorry, something went wrong'], 401);
    }

    public function store(Request $request){
        Validator::extend('not_exists', function($attribute, $value, $parameters)
        {
            return DB::table("comments")
                ->where("user_id", '=', Auth::id())
                ->where("post_id", '=', $parameters[0])
                ->count() < 1;
        });

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|min:5|max:300',
            'evaluation' => 'required|integer|min:1|max:5',
            'post_id' => 'required|integer|exists:posts,id|not_exists:'.$request->get('post_id'),
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $comment = $this->commentRepository->storeComment($request->all(), Auth::id());

        if($comment)
            return response()->json(array_merge($comment->getAttributes(),['fname' => Auth::user()->fname, 'lname' => Auth::user()->lname]), 200);
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
