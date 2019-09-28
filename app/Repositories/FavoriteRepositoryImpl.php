<?php

namespace App\Repositories;

use App\Model\Favorite;
use Illuminate\Support\Facades\DB;

class FavoriteRepositoryImpl implements FavoriteRepository {

    protected $favorite;

    /**
     * FavoriteRepositoryImpl constructor.
     * @param $favorite
     */
    public function __construct(Favorite $favorite){
        $this->favorite = $favorite;
    }

    function listPagination($n, $user_id){
        return DB::table('favorites')
            ->join('posts','posts.id','=','favorites.post_id')
            ->select('posts.*',DB::raw("(SELECT COUNT(favorites.id) FROM favorites WHERE favorites.post_id = posts.id) as in_favorite"),DB::raw('(SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id) as total_comments'))
            ->orderBy('posts.id','desc')->paginate($n)->toArray();
        /*return $this->favorite
            ->orderBy('created_at','desc')
            ->with(['user','post'])
            ->where('user_id',1)
            ->paginate($n)->all();*/
    }

    function delete($post_id, $user_id, $n = 8){
        $success = DB::table('favorites')->where(['user_id' => $user_id, 'post_id' => $post_id])->delete();
        if ($success)
            return $this->listPagination($n, $user_id);
    }

    function add($post_id, $user_id, $n = 8){
        $success = DB::table('favorites')->insert(['user_id' => $user_id, 'post_id' => $post_id]);
        if ($success)
            return $this->listPagination($n, $user_id);
    }

}