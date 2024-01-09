<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

readonly class AffiliateRegistered
{
	use Dispatchable;

	public function __construct(public User $referrer, public User $affiliate) {}
}
