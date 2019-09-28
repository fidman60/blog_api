<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 30/07/2019
 * Time: 18:01
 */

namespace App\Repositories;

use App\Model\User;

use File;


class UserRepositoryImpl implements UserRepository {

    private $user;

    /**
     * UserRepositoryImpl constructor.
     * @param $user
     */
    public function __construct(User $user){
        $this->user = $user;
    }


    function saveImage($image, $userID){
        $user = $this->user->find($userID);

        $imageName = time().'.'.$image->getClientOriginalExtension();

        if ($user->image)
            File::delete(public_path('images/users/'.$user->image));

        $move = $image->move(public_path('images/users'), $imageName);

        if (!$move) return false;

        $user->image = $imageName;

        if ($user->save())
            return $imageName;
        return false;
    }

}