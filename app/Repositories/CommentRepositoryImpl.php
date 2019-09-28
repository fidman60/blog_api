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

    function postComments($postId, $n, $user_id){
        /*return $this->comment
            ->orderBy('created_at','desc')
            ->with('user')
            ->where('post_id', $postId)
            ->paginate($n)->all();*/

        return DB::table('comments')
            ->join('users','users.id','=','comments.user_id')
            ->select(
                'users.fname','users.lname', 'users.image as user_image','comments.*',
                DB::raw('(SELECT COUNT(responses.id) FROM responses WHERE responses.comment_id = comments.id) as total_responses'),
                DB::raw('(SELECT COUNT(reactions.id) FROM reactions WHERE reactions.comment_id = comments.id and reaction = 1) as total_likes'),
                DB::raw('(SELECT COUNT(reactions.id) FROM reactions WHERE reactions.comment_id = comments.id and reaction = 0) as total_dislikes'),
                DB::raw('(SELECT COUNT(reactions.id) FROM reactions WHERE reactions.comment_id = comments.id and reactions.user_id = '.$user_id.') as was_reacted'),
                DB::raw('(SELECT reaction FROM reactions WHERE reactions.comment_id = comments.id and reactions.user_id = '.$user_id.') as reaction')
            )
            ->where('comments.post_id',$postId)
            ->orderBy('comments.created_at','desc')->paginate($n);
    }

    function hasCommented($postId, $userId){
        return DB::table('comments')
            ->select(DB::raw('count(*) as hasCommented'))
            ->where('user_id',$userId)->where('post_id',$postId)
            ->first();
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

        if($comment->save()) return $comment;
        return false;
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