<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/09/2019
 * Time: 21:55
 */

namespace App\Http\Controllers;

use Socialite;

class SocialAuthController extends Controller {

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')
            ->fields([
                'name',
                'first_name',
                'last_name',
                'email',
            ])->user();

        dd($user);
        // $user->token;
    }
}