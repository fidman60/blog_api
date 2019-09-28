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
use DB;


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

        $reaction = Reaction::firstOrNew(['user_id' => $userId, 'comment_id' => $data['comment_id']]);
        $reaction->reaction = $data['reaction'];

        return $reaction->save();
    }

    function calculateReactions($comment_id) {
        return DB::table('reactions')
            ->select(
                DB::raw('(SELECT COUNT(reactions.id) FROM reactions WHERE reactions.comment_id = '.$comment_id.' and reaction = 1) as total_likes'),
                DB::raw('(SELECT COUNT(reactions.id) FROM reactions WHERE reactions.comment_id = '.$comment_id.' and reaction = 0) as total_dislikes')
            )->first();
    }

}