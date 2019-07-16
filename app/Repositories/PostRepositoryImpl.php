<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/07/2019
 * Time: 00:50
 */

namespace App\Repositories;

use App\Model\Post;
use DB;

class PostRepositoryImpl implements PostRepository {

    protected $post;

    /**
     * PostRepositoryImpl constructor.
     * @param $post
     */
    public function __construct(Post $post){
        $this->post = $post;
    }

    function listPagination($n){
        return $this->post->orderBy('created_at','desc')->with('user')->paginate($n)->all();
    }

    function store($post, $userId){
        $user = \App\Model\User::find($userId);
        if (!$user) return false;

        $this->post->title = $post['title'];
        $this->post->content = $post['content'];
        $this->post->user()->associate($user);

        return $this->post->save();
    }

    function update($post, $postId, $userId){
        $foundPost = \App\Model\Post::find($postId);

        if (!$foundPost || (int)$foundPost->user_id !== (int)$userId) return false;

        $foundPost->title = $post['title'];
        $foundPost->content = $post['content'];

        return $foundPost->save();
    }

    function destroy($id, $userId){
        $post = Post::find($id);

        if (!$post || (int)$post->user_id !== (int)$userId) return false;

        return $post->delete();
    }

    function show($id){
        return Post::find($id);
    }

    function myPosts($userId, $n){
        return $this->post->orderBy('created_at','desc')
            ->where('user_id',$userId)
            ->paginate($n)->all();
    }

    function avgEvaluation($postId){
        return (float)DB::table('comments')->where('post_id', $postId)->avg('evaluation');
    }

}