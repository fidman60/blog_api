<?php

namespace App\Http\Controllers;

use App\Repositories\ReactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ReactionController extends Controller {

    protected $reactionRepository;

    /**
     * ReactionController constructor.
     * @param $reactionRepository
     */
    public function __construct(ReactionRepository $reactionRepository){
        $this->middleware('auth:api')->only(['store']);
        $this->reactionRepository = $reactionRepository;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'reaction' => 'required|boolean',
            'comment_id' => 'required|integer|exists:comments,id'
        ]);

        if ($validator->fails()) return response()->json(['error' => $validator->errors()], 401);

        $success = $this->reactionRepository->store($request->all(), Auth::id());

        if ($success)
            return response()->json(['success' => $success]);
        return response()->json(['error' => 'Sorry, something went wrong'], 401);
    }

}
