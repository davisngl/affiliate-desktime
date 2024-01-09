<?php

namespace App\DTO;

use App\Contracts\BarChartDatasetInterface;

readonly class ChartJsBarChartDataset implements BarChartDatasetInterface
{
    public function __construct(
        private array $labels,
        private array $dataset
    ) {}

    public function labels(): array
    {
        return $this->labels;
    }

    public function dataset(): array
    {
        return $this->dataset;
    }
}
