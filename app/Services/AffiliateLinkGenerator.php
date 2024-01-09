<?php

namespace App\Services;

use App\Contracts\AffiliateLinkGeneratorInterface;
use Illuminate\Support\Str;

class AffiliateLinkGenerator implements AffiliateLinkGeneratorInterface
{
	/**
	 * @inheritDoc
	 */
	public function generate(int $length = 10): string
	{
		return Str::random($length);
	}
}
