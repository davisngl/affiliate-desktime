<?php

namespace App\Events;

use App\Models\AffiliateCode;
use Illuminate\Foundation\Events\Dispatchable;

class AffiliateLinkClicked
{
	use Dispatchable;

	public function __construct(public AffiliateCode $affiliate) {}
}
