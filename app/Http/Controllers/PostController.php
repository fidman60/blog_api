<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PostController extends Controller
{

    protected $postRepository;
    protected $perPage = 5;

    /**
     * PostController constructor.
     * @param $postRepository
     */
    public function __construct(PostRepository $postRepository){
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = $this->postRepository->listPagination($this->perPage);
        if(is_array($data))
            return response()->json(['data'=>$data], 200);
        return response()->json(['error'=>'Sorry, something went wrong'], 401);
    }

    public function myPosts(){
        $data = $this->postRepository->myPosts(Auth::id(), $this->perPage);

        if (is_array($data)) return response()->json(['data' => $data], 200);
        return response()->json(['error'=>'Sorry, something went wrong'], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:10',
            'content' => 'required|min:5',
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $success = (boolean)$this->postRepository->store($request->all(), Auth::id());
        if ($success)
            return response()->json(['success' => $success]);
        return response()->json(['error' => 'Sorry, the post was not inserted'], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $post = $this->postRepository->show($id);
        if ($post)
            return response()->json(['data' => $post]);
        return response()->json(['error', 'Sorry, post has not been found'], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:10',
            'content' => 'required|min:5',
            'post_id' => 'required|integer|exists:posts,id'
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $success = (boolean)$this->postRepository->update($request->all(), $id, Auth::id());
        if ($success)
            return response()->json(['success' => $success]);
        return response()->json(['error' => 'Sorry, the post has not been updated'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $success = (boolean)$this->postRepository->destroy($id, Auth::id());
        if ($success)
            return response()->json(['success' => $success]);
        return response()->json([ 'error' => 'Sorry, the post has not been deleted'], 401);
    }

    public function avgEvaluation($postId){
        $validator = Validator::make(['post_id' => $postId], [
            'post_id' => 'required|exists:posts,id',
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);
        return response()->json(['data' => $this->postRepository->avgEvaluation($postId)]);
    }
}
