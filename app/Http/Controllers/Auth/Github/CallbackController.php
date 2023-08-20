<?php

namespace App\Http\Controllers\Auth\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::query()
                    ->updateOrCreate(
                        [
                            'email' => $githubUser->getEmail(),
                        ],
                        [
                            'nickname' => $githubUser->getNickname(),
                            'name'     => $githubUser->getName(),
                            'password' => $githubUser->getId(),
                        ]
                    );

        Auth::login($user);

        return to_route('dashboard');
    }
}
