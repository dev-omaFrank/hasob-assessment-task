<?php

namespace DMO\SavingsBond\Database\Factories;

use DMO\SavingsBond\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'organization_id' => null,
            'display_ordinal' => $this->faker->numberBetween(0, 100),
            'offer_id' => null,
            'user_id' => null,
            'broker_id' => null,
            'broker_code' => $this->faker->word,
            'broker_name' => $this->faker->company,
            'is_broker_created' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'wf_status' => $this->faker->word,
            'wf_meta_data' => $this->faker->text(200),
            'units_requested' => $this->faker->numberBetween(1, 1000),
            'price_per_unit' => $this->faker->randomFloat(2, 100, 10000),
            'total_price' => $this->faker->randomFloat(2, 100, 1000000),
            'interest_rate_pct' => $this->faker->randomFloat(2, 1, 20),
            'offer_start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'offer_end_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'offer_settlement_date' => $this->faker->dateTimeBetween('+3 months', '+4 months'),
            'offer_maturity_date' => $this->faker->dateTimeBetween('+1 year', '+3 years'),
            'tenor_years' => $this->faker->numberBetween(1, 10),
            'investor_email' => $this->faker->email,
            'investor_telephone' => $this->faker->phoneNumber,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date('Y-m-d'),
            'origin_geo_zone' => $this->faker->word,
            'origin_lga' => $this->faker->word,
            'address_street' => $this->faker->streetAddress,
            'address_town' => $this->faker->city,
            'address_state' => $this->faker->state,
            'bank_account_name' => $this->faker->name,
            'bank_account_number' => $this->faker->bankAccountNumber,
            'bank_name' => $this->faker->company,
            'bank_verification_number' => $this->faker->numerify('###########'),
            'national_id_number' => $this->faker->numerify('##########'),
            'cscs_id_number' => $this->faker->numerify('##########'),
            'chn_id_number' => $this->faker->numerify('##########'),
        ];
    }
}
