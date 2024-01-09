<?php

namespace App\Contracts;

interface BarChartDatasetInterface
{
    /**
     * Labels for each dataset item.
     *
     * @return array
     */
    public function labels(): array;

    /**
     * Actual aggregated data for use in displaying proper chart.
     *
     * @return array
     */
    public function dataset(): array;
}
