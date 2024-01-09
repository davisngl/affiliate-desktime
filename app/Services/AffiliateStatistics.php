<?php

namespace App\Services;

use App\Contracts\AffiliateStatisticsInterface;
use App\Contracts\BarChartDatasetInterface;
use App\Exceptions\StatisticsException;
use App\Models\AffiliateCode;
use Illuminate\Support\Carbon;

class AffiliateStatistics implements AffiliateStatisticsInterface
{
    protected string $affiliateCode;

    protected int $duration = 7;

    /**
     * @inheritDoc
     */
    public function setAffiliateCode(string $code): static
    {
        $this->affiliateCode = $code;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function durationInDays(int $amount): static
    {
        $this->duration = $amount;

        return $this;
    }

    /**
     * @inheritDoc
     * @throws StatisticsException
     */
    public function getGroupedData(): BarChartDatasetInterface
    {
        if (! $this->affiliateCode) {
            throw StatisticsException::affiliateCodeNotSet();
        }

        $data = AffiliateCode::firstWhere('code', $this->affiliateCode)
            ->clicks()
            ->whereBetween('clicked_at', [now(), now()->addDays($this->duration)])
            ->orderBy('clicked_at')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->clicked_at)->format('d');
            });

        dd($data);
    }
}
