<?php

namespace App\Contracts;

interface AffiliateStatisticsInterface
{
    /**
     * Affiliate code to use for getting click events.
     *
     * @return $this
     */
    public function setAffiliateCode(string $code): static;

    /**
     * Get resulting statistics that are grouped by and aggregated.
     * @see https://www.chartjs.org/docs/latest/charts/bar.html for examples on how the data should be returned.
     *
     * @return BarChartDatasetInterface
     */
    public function getGroupedData(): BarChartDatasetInterface;
}
