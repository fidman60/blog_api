<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/07/2019
 * Time: 00:47
 */

namespace App\Repositories;


interface PostRepository {

    function listPagination($n);

    function store($post, $userId);

    function update($post, $postPostId, $userId);

    function destroy($id, $userId);

    function show($id);

    function myPosts($userId, $n);

    function avgEvaluation($postId);

}