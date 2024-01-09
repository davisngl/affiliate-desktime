<?php

namespace App\Exceptions;

class StatisticsException extends \Exception
{
    public static function affiliateCodeNotSet(): static
    {
        return new static(
            'Affiliate code has not been set. In order to set it, use `setAffiliateCode` method on AffiliateStatisticsInterface instance.'
        );
    }
}
