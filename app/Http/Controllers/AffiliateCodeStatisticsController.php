<?php

namespace App\Http\Controllers;

use App\Contracts\AffiliateStatisticsInterface;
use App\Models\AffiliateCode;

class AffiliateCodeStatisticsController extends Controller
{
    public function __invoke(AffiliateStatisticsInterface $statistics, AffiliateCode $affiliate)
    {
        return view('statistics', [
            // Well, this should be paginated, but as there not much, only the list of clicks,
            // there's no real need for it here to browse through such records.
            'affiliateUrl' => $affiliate->url(),
            'clickEvents'  => $affiliate->clickEvents()
                ->select('clicked_at')
                ->latest('clicked_at')
                ->limit(15)
                ->get(),
            'totalClicks' => $affiliate->clickEvents()->count(),
            'dataset'      => $statistics
                ->setAffiliateCode($affiliate->code)
                ->getGroupedData(),
        ]);
    }
}
