<?php

namespace Database\Factories;

use App\Models\PaymentRecord;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentRecordFactory extends Factory
{
    protected $model = PaymentRecord::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'subscription_plan_id' => SubscriptionPlan::factory(),
            'provider' => config('subscription.provider', 'pending'),
            'transaction_reference' => 'TXN-'.Str::upper(Str::random(12)),
            'amount' => '100.00',
            'currency' => config('subscription.currency', 'BDT'),
            'status' => 'pending',
        ];
    }
}
