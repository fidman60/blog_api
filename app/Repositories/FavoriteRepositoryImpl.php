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
        return $this->favorite
            ->orderBy('created_at','desc')
            ->with(['user','post'])
            ->where('user_id',1)
            ->paginate($n)->all();
    }

    function delete($post_id, $user_id){
        return DB::table('favorites')->where(['user_id' => $user_id, 'post_id' => $post_id])->delete();
    }

    function add($post_id, $user_id){
        return DB::table('favorites')->insert(['user_id' => $user_id, 'post_id' => $post_id]);
    }

}