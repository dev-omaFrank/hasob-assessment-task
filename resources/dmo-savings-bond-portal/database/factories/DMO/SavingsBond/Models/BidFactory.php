<?php

namespace Database\Factories\DMO\SavingsBond\Models;

use DMO\SavingsBond\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidFactory extends Factory
{
    protected $model = Bid::class;

    public function definition()
    {
        return [
            'organization_id' => null,
            'display_ordinal' => $this->faker->numberBetween(0, 100),
            'offer_id' => null,
            'user_id' => null, // Will be set by test (uses $this->test_user->id)
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'wf_status' => $this->faker->word,
            'wf_meta_data' => $this->faker->text(200),
            'units_requested' => $this->faker->numberBetween(1, 1000),
            'price_per_unit' => $this->faker->randomFloat(2, 100, 10000),
            'total_price' => $this->faker->randomFloat(2, 100, 1000000),
        ];
    }
}
