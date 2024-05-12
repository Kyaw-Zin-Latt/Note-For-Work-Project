<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
        $userOAuth = Socialite::driver("github")->user();

        $checkLoginedUser = User::where("email", $userOAuth->getEmail())->orWhere("provider_id", $userOAuth->getId())->first();

        if (!$checkLoginedUser){
            $user = new User();
            $user->name = $userOAuth->getName();
            $user->email = !$userOAuth->getEmail() ? "default.gmail.com" : '';
            $user->password = Hash::make($userOAuth->getId());
            $user->provider_id = $userOAuth->getId();
            $user->profile_photo_path = $userOAuth->getAvatar();
            $user->save();

            Auth::login($user);
        } else {
            Auth::login($checkLoginedUser);
        }

        return redirect()->route("dashboard");
    }
}
