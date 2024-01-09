<?php

namespace App\Http\Controllers;

use App\Contracts\AffiliateStatisticsInterface;
use Carbon\CarbonInterval;

class AffiliateCodeStatisticsController extends Controller
{
	public function __invoke(AffiliateStatisticsInterface $statistics, string $code)
	{
        return view('statistics', [
            'chart_data' => $statistics
                ->setAffiliateCode($code)
                ->durationInDays(CarbonInterval::days(7)->days)
                ->getGroupedData(),
        ]);
	}
}
