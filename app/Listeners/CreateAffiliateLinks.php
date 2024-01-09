<?php

namespace App\Listeners;

use App\Events\AffiliateRegistered;

class CreateAffiliateLinks
{
	public function __construct() {}

	public function handle(AffiliateRegistered $event): void
	{
        $event->affiliate->createAffiliateUrl();
        $event->affiliate->createAffiliateUrl();
        $event->affiliate->createAffiliateUrl();
	}
}
