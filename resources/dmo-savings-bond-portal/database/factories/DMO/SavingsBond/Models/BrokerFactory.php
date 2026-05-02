<?php

namespace Database\Factories\DMO\SavingsBond\Models;

use DMO\SavingsBond\Models\Broker;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrokerFactory extends Factory
{
    protected $model = Broker::class;

    public function definition()
    {
        return [
            'organization_id' => null,
            'display_ordinal' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'wf_status' => $this->faker->word,
            'wf_meta_data' => $this->faker->text(200),
            'broker_code' => $this->faker->word,
            'full_name' => $this->faker->name,
            'short_name' => $this->faker->lastName,
        ];
    }
}
