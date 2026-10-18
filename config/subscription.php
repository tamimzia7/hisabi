<?php

return [
    'currency' => env('SUBSCRIPTION_CURRENCY', 'BDT'),
    'trial_days' => (int) env('SUBSCRIPTION_TRIAL_DAYS', 30),
    'webhook_secret' => env('SUBSCRIPTION_WEBHOOK_SECRET'),
    'grace_days' => (int) env('SUBSCRIPTION_GRACE_DAYS', 0),
    'provider' => env('SUBSCRIPTION_PAYMENT_PROVIDER', 'pending'),
];
