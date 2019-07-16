<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15/07/2019
 * Time: 14:40
 */

namespace App\Repositories;

use App\Model\Comment;
use App\Model\Reaction;
use App\Model\User;


class ReactionRepositoryImpl implements ReactionRepository {

    protected $reaction;

    /**
     * ReactionRepositoryImpl constructor.
     * @param $reaction
     */
    public function __construct(Reaction $reaction){
        $this->reaction = $reaction;
    }

    function store($data, $userId){
        $user = User::find($userId);
        $comment = Comment::find($data['comment_id']);
        if (!$user || !$comment) return false;

        $this->reaction->reaction = $data['reaction'];
        $this->reaction->user()->associate($user);
        $this->reaction->comment()->associate($comment);
        return $this->reaction->save();
    }

}