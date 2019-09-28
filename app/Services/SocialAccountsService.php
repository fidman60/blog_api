<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/09/2019
 * Time: 22:45
 */

namespace App\Services;

use App\Model\User;
use App\Model\LinkedSocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountsService {

    public function findOrCreate(ProviderUser $providerUser, string $provider): User{
        $linkedSocialAccount = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();
        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }
            if (!$user) {
                $user = User::create([
                    'fname' => $providerUser->getName(),
                    'lname' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                ]);
            }
            $user->linkedSocialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);
            return $user;
        }
    }

}