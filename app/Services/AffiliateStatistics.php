<?php

namespace App\Services;

use App\Contracts\AffiliateStatisticsInterface;
use App\Contracts\BarChartDatasetInterface;
use App\DTO\ChartJsBarChartDataset;
use App\Exceptions\StatisticsException;
use App\Models\AffiliateCode;
use App\Models\ClickEvent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AffiliateStatistics implements AffiliateStatisticsInterface
{
    protected string $affiliateCode;

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
     * @throws StatisticsException
     */
    public function getGroupedData(): BarChartDatasetInterface
    {
        if (! $this->affiliateCode) {
            throw StatisticsException::affiliateCodeNotSet();
        }

        $data = auth()->user()
            ->affiliateCodes()
            ->firstWhere('code', $this->affiliateCode)
            ->clickEvents()
            ->whereBetween('clicked_at', [now()->subDays(7)->startOfDay(), now()->endOfDay()])
            ->orderBy('clicked_at')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->clicked_at)->format('d-m-Y');
            })
            ->map
            ->count()
            ->toArray();

        return new ChartJsBarChartDataset(
            array_keys($data),
            array_values($data)
        );
    }
}
