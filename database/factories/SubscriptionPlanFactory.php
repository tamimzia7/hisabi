<?php

namespace Database\Factories;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPlanFactory extends Factory
{
    protected $model = SubscriptionPlan::class;

    public function definition(): array
    {
        return [
            'name' => 'মাসিক প্ল্যান',
            'slug' => fake()->unique()->slug(),
            'description' => 'এক মাসের সাবস্ক্রিপশন।',
            'price' => '100.00',
            'currency' => config('subscription.currency', 'BDT'),
            'duration_days' => 30,
            'is_active' => true,
        ];
    }
}
