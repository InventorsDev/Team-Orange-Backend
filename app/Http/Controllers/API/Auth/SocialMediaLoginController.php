<?php

namespace App\Http\Controllers\API\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SocialMediaAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialMediaLoginController extends Controller
{
    /**
     * redirects to social login provider
     *
     * @param string $provider
     * @return redirect
     **/
    public function redirectToProvider($provider)
    {

        if (strpos(implode(',', SocialMediaAccount::PROVIDERS), strtolower($provider)) === false) {

            return $this->badRequestAlert('Unable to use social login provider');
        }

        $redirectLink = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return $this->successResponse('Social Link retrieved', ['link' => $redirectLink]);
    }

    /**
     * Handles Callback for social media provider
     *
     * Authenticates user based on social account provider
     *
     * @param string $provider
     * @return
     *
     **/
    public function handleProviderCallback()
    {
        $provider = SocialMediaAccount::PROVIDERS['GOOGLE'];

        try {

            $user = null;
            $linkedUserSocial = Socialite::driver(SocialMediaAccount::PROVIDERS['GOOGLE'])->stateless()->user();

            $providerUser = SocialMediaAccount::where('provider_id', $linkedUserSocial->getId())
                ->where('provider_name', $provider)
                ->first();

            if ($providerUser) {
                $user = $providerUser->user;

                $redirectUrl = $this->generateRedirectUrl($user);

                return Redirect::to($redirectUrl);
            }

            if ($email = $linkedUserSocial->getEmail()) {
                $user = User::where('email', $email)->first();
            }

            if (!$user) {

                $user = User::create([
                    'full_name' => $linkedUserSocial->getName(),
                    'email' => $linkedUserSocial->getEmail(),
                    'password' => null,
                    'email_verified_at' => Carbon::now(),
                    'profile_image_url' => $linkedUserSocial->getAvatar(),
                ]);
            }

            $user->socialAccounts()->create([
                'provider_id' => $linkedUserSocial->getId(),
                'provider_name' => $provider
            ]);

            $redirectUrl = $this->generateRedirectUrl($user);

            return Redirect::to($redirectUrl);
        } catch (\Exception $e) {
            return $this->serverErrorAlert("server error ", $e);
        }
    }

    private function generateRedirectUrl($user)
    {
        $redirectUrl = Config::get('custom.redirect_url');

        $authData = $this->generateAuthData($user);

        $token = $authData['token'];

        $redirectUrl .= '/' . $token;

        return $redirectUrl;
    }
}
