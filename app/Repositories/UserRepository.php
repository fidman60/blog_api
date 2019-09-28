<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 30/07/2019
 * Time: 18:01
 */

namespace App\Repositories;


interface UserRepository{

    function saveImage($image, $userId);

}