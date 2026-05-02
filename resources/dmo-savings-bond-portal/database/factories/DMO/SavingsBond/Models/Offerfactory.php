<?php

namespace Database\Factories\DMO\SavingsBond\Models;

use DMO\SavingsBond\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition()
    {
        return [
            'organization_id' => null,
            'display_ordinal' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'wf_status' => $this->faker->word,
            'wf_meta_data' => $this->faker->text(200),
            'offer_title' => $this->faker->sentence(3),
            'price_per_unit' => $this->faker->randomFloat(2, 100, 10000),
            'max_units_per_investor' => $this->faker->numberBetween(1, 1000),
            'interest_rate_pct' => $this->faker->randomFloat(2, 1, 20),
            'offer_start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'offer_end_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'offer_settlement_date' => $this->faker->dateTimeBetween('+3 months', '+4 months'),
            'offer_maturity_date' => $this->faker->dateTimeBetween('+1 year', '+3 years'),
            'tenor_years' => $this->faker->numberBetween(1, 10),
        ];
    }
}
