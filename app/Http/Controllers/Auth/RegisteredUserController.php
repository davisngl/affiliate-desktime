<?php

namespace App\Http\Controllers\Auth;

use App\Events\AffiliateRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->handleAffiliation($request, $user);

        return redirect(RouteServiceProvider::HOME);
    }

    private function handleAffiliation(Request $request, User $user)
    {
        if (! $request->hasCookie('affiliate')) {
            logger()->info(
                'Affiliate cookie has not been found. No affiliation has been processed',
                ['user_id' => $user->id]
            );

            return;
        }

        $referrer = User::find(
            Arr::get(
                $cookie = $request->decodeCookie('affiliate'),
                'referrer_id'
            )
        );

        logger()->info(
            'Affiliate has been registered!',
            ['user_id' => $user->id, 'referrer_id' => $referrer->id, 'code' => Arr::get($cookie, 'code')]
        );

        session()->flash(
            'successful_affiliate_registration',
            vsprintf('You have been successfully registered as one of %s affiliates!', [$referrer->name])
        );

        event(
            new AffiliateRegistered(referrer: $referrer, affiliate: $user)
        );
    }
}
