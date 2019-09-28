<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/09/2019
 * Time: 23:09
 */

namespace App\Services;

use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialUserResolver implements SocialUserResolverInterface {

    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable {
        $providerUser = null;

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (Exception $exception) {}

        if ($providerUser) {
            return (new SocialAccountsService())->findOrCreate($providerUser, $provider);
        }
        return null;
    }

}