<?php

namespace Database\Factories;

use App\Models\AffiliateCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClickEvent>
 */
class ClickEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'affiliate_code_id' => AffiliateCode::factory(),
            'clicked_at'        => now(),
        ];
    }
}
