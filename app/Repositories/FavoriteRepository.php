<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/07/2019
 * Time: 03:00
 */

namespace App\Repositories;


interface FavoriteRepository {

    function listPagination($n, $user_id);

    function delete($post_id, $user_id);

    function add($post_id, $user_id);

}