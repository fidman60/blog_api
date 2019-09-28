<?php

namespace App\Http\Controllers;

use App\Repositories\FavoriteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class FavoritesController extends Controller {

    protected $perPage = 8;
    protected $favoriteRepository;

    /**
     * FavoritesController constructor.
     * @param $favoriteRepository
     */
    public function __construct(FavoriteRepository $favoriteRepository){
        $this->middleware('auth:api')->only(['index', 'delete', 'add']);
        $this->favoriteRepository = $favoriteRepository;
    }

    public function index(){
        $data = $this->favoriteRepository->listPagination($this->perPage, Auth::id());
        if (is_array($data))
            return response()->json($data);
        return response()->json(['error' => 'Sorry, something went wrong'], 401);
    }

    public function delete($postId){
        $success = $this->favoriteRepository->delete($postId, Auth::id());
        if ($success) return response()->json($success);
        return response()->json(['error' => 'Sorry, something went wrong'], 401);
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $success = $this->favoriteRepository->add($request->input('post_id'), Auth::id());
        if ($success) return response()->json($success);
        return response()->json(['error' => 'Sorry, something went wrong'], 401);
    }

}
