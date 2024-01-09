<?php

namespace App\Http\Controllers;

use App\Contracts\AffiliateStatisticsInterface;
use App\Models\AffiliateCode;

class AffiliateCodeStatisticsController extends Controller
{
	public function __invoke(AffiliateStatisticsInterface $statistics, AffiliateCode $affiliate)
	{
        return view('statistics', [
            'dataset' => $statistics
                ->setAffiliateCode($affiliate->code)
                ->getGroupedData(),
        ]);
	}
}
