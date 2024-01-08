<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AffiliateCodeController extends Controller
{
    public function __invoke(Request $request, string $code): RedirectResponse
    {
        $affiliate = AffiliateCode::whereCode($code)->first();

        if (! $affiliate) {
            /**
             * Having invalid affiliate code would only send
             * us to register page and the usual registration flow ensues.
             */
            return to_route('register');
        }

        $affiliateCookie = cookie(
            name: 'affiliate',
            value: $affiliate->asCookiePayload(encoded: true),
//            minutes: CarbonInterval::month()->totalMinutes,
            minutes: 1, // TODO revert back to month later on
            path: config('session.path'),
            domain: config('session.domain'),
            secure: true,
            httpOnly: false
        );

        return response()
            // Using 'via' as an indicator whether to clear cookie on front-end,
            // as there was a redirect to /register. Even if we don't use referral link to
            // get to /register page later, cookie will still be active as domain+expiration criteria is met.
            // This comparison between 'via' and cookie data can be used to check for tampering, as well.
            ->redirectToRoute('register', ['via' => $affiliate->code])
            ->withCookie($affiliateCookie);
    }
}
