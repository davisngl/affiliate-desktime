<?php

namespace App\Listeners;

use App\Events\AffiliateRegistered;

class MarkUserAsAffiliate
{
	public function handle(AffiliateRegistered $event): void
	{
        $event->affiliate->update([
            'affiliate_code_id' => $event->referrer->id,
        ]);
	}
}
