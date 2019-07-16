<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15/07/2019
 * Time: 14:39
 */

namespace App\Repositories;


interface ReactionRepository {

    function store($data, $userId);

}