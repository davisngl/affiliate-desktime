<?php

namespace App\Http\Controllers;

use App\Events\AffiliateLinkClicked;
use App\Models\AffiliateCode;
use Carbon\CarbonInterval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AffiliateCodeController extends Controller
{
    public function __invoke(Request $request, string $code): RedirectResponse
    {
        $affiliate = AffiliateCode::whereCode($code)->first();

        logger()->info(
            vsprintf('Using affiliate code %s', [$code]),
            ['code' => $code]
        );

        if (! $affiliate) {
            logger()->warning(
                'Affiliate code has not been found, proceeding with normal registration',
                ['code' => $code]
            );

            /**
             * Having invalid affiliate code would only send
             * us to register page and the usual registration flow ensues.
             */
            return to_route('register');
        }

        event(new AffiliateLinkClicked($affiliate));

        $affiliateCookie = Cookie::make(
            'affiliate',
            $affiliate->asCookiePayload(encoded: true),
            CarbonInterval::month()->totalMinutes,
            httpOnly: false
        );

        logger()->info('Affiliate cookie has been set properly', ['code' => $code]);

        return response()
            // Using 'via' as an indicator whether to clear cookie on front-end,
            // as there was a redirect to /register. Even if we don't use referral link to
            // get to /register page later, cookie will still be active as domain+expiration criteria is met.
            // This comparison between 'via' and cookie data can be used to check for tampering, as well.
            ->redirectToRoute('register', ['via' => $code])
            ->withCookie($affiliateCookie);
    }
}
