<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/07/2019
 * Time: 23:45
 */

namespace App\Repositories;


interface CommentRepository {

    function postComments($postId, $n);

    function storeComment($data, $userId);

    function destroy($commentId, $userId);

    function countTotalResponses($commentId);

    function countPositiveReactions($commentId);

    function countNegativeReactions($commentId);

}