<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15/07/2019
 * Time: 13:26
 */

namespace App\Repositories;


interface ResponseRepository {

    function store($data, $userId);

    function getCommentResponses($commentId, $n);

}