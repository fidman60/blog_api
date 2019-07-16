<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15/07/2019
 * Time: 13:26
 */

namespace App\Repositories;


use App\Model\Comment;
use App\Model\Response;
use App\Model\User;

class ResponseRepositoryImpl implements ResponseRepository {

    protected $response;

    /**
     * ResponseRepositoryImpl constructor.
     * @param $response
     */
    public function __construct(Response $response){
        $this->response = $response;
    }

    function store($data, $userId){
        $user = User::find($userId);
        $comment = Comment::find($data['comment_id']);
        if (!$user || !$comment) return false;
        $this->response->response = $data['response'];
        $this->response->user()->associate($user);
        $this->response->comment()->associate($comment);
        return $this->response->save();
    }

    function getCommentResponses($commentId, $n){
        return $this->response->where('comment_id',$commentId)->with('user')->paginate($n)->all();
    }

}