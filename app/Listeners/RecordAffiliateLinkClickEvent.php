<?php

namespace App\Listeners;

use App\Events\AffiliateLinkClicked;
use Illuminate\Support\Facades\DB;

class RecordAffiliateLinkClickEvent
{
	public function handle(AffiliateLinkClicked $event): void
	{
        DB::transaction(static function () use ($event) {
            $event->affiliate->clickEvents()->create();
            $event->affiliate->increment('clicks');
        });
	}
}
