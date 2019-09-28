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
        return DB::table('posts')->select('posts.*',DB::raw('(SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id) as total_comments'))->orderBy('posts.id','desc')->paginate($n)->toArray();
        //return $this->post->orderBy('created_at','desc')->with('user','comments')->paginate($n)->all();
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

    function getPost($postId){
        return DB::table('posts')
            ->join('users','users.id','=','posts.user_id')
            ->select('users.fname','users.lname','users.image as user_image','posts.*', DB::raw("(SELECT COUNT(favorites.id) FROM favorites WHERE favorites.post_id = posts.id) as in_favorite"), DB::raw('(SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id) as total_comments'), DB::raw('(SELECT AVG(comments.evaluation) FROM comments WHERE comments.post_id = posts.id) as rating'))
            ->where('posts.id',$postId)->first();
    }

    function myPosts($userId, $n){
        return $this->post->orderBy('created_at','desc')
            ->where('user_id',$userId)
            ->paginate($n)->all();
    }

    function avgEvaluation($postId){
        return (float)DB::table('comments')->where('post_id', $postId)->avg('evaluation');
    }

    function incrementViews($postId){
        return DB::table('posts')->where('id',$postId)->increment('total_views');
    }

    function totalCommentsPost($postId){
        return DB::table('comments')->where('post_id',1)->count();
    }

    function getPostsById(array $idList){
        return DB::table('posts')->select('posts.*',DB::raw("(SELECT COUNT(favorites.id) FROM favorites WHERE favorites.post_id = posts.id) as in_favorite"),DB::raw('(SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id) as total_comments'))
            ->orderBy('posts.id','desc')->whereIn('id',$idList)->get();
    }

    function searchPosts($text){
        return DB::table('posts')
            ->select('posts.*',DB::raw('(SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id) as total_comments'))
            ->orderBy('posts.id','desc')->where('title','LIKE','%'.$text.'%')->get();
    }


}