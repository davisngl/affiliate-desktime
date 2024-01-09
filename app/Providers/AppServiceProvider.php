<?php

namespace App\Providers;

use App\Contracts\AffiliateStatisticsInterface;
use App\Contracts\BarChartDatasetInterface;
use App\DTO\ChartJsBarChartDataset;
use App\Services\AffiliateStatistics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AffiliateStatisticsInterface::class, AffiliateStatistics::class);
        $this->app->bind(BarChartDatasetInterface::class, ChartJsBarChartDataset::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(
            app()->environment(['local', 'development', 'staging'])
        );
    }
}
