<?php

namespace App\Listeners;

use App\Events\AffiliateRegistered;
use Illuminate\Support\Facades\Cookie;

class ClearAffiliateCookies
{
	public function handle(AffiliateRegistered $event): void
	{
        Cookie::forget('affiliate');
	}
}
