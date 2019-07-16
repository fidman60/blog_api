<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/07/2019
 * Time: 23:45
 */

namespace App\Repositories;


use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use DB;

class CommentRepositoryImpl implements CommentRepository {

    protected $comment;

    /**
     * CommentRepositoryImpl constructor.
     * @param $comment
     */
    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    function postComments($postId, $n){
        return $this->comment
            ->orderBy('created_at','desc')
            ->with('user')
            ->where('post_id', $postId)
            ->paginate($n)->all();
    }

    function storeComment($data, $userId){

        $comment = new $this->comment;
        $post = Post::find($data['post_id']);
        $user = User::find($userId);
        if (!$post || !$user) return false;
        $comment->comment = $data['comment'];
        $comment->evaluation = $data['evaluation'];
        $comment->post()->associate($post);
        $comment->user()->associate($user);

        return $comment->save();
    }

    function destroy($commentId, $userId){
        $comment = $this->comment->find($commentId);

        if (!$comment || (int)$comment->user_id !== (int)$userId) return false;

        return $comment->delete();
    }

    function countTotalResponses($commentId){
        return DB::table('responses')->where('comment_id', $commentId)->count();
    }

    function countPositiveReactions($commentId){
        return DB::table('reactions')->where(['comment_id' => $commentId,'reaction' => 1])->count();
    }

    function countNegativeReactions($commentId){
        return DB::table('reactions')->where(['comment_id' => $commentId,'reaction' => 0])->count();
    }


}