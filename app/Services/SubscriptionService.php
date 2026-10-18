<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionService
{
    public function status(User $user): string
    {
        if ($user->onTrial()) {
            return 'trial';
        }

        $subscription = $user->activeSubscription();

        if ($subscription) {
            return 'active';
        }

        // Expired paid subscription?
        if ($user->subscriptions()->where('status', 'active')->exists()) {
            return 'expired';
        }

        return $user->trial_ends_at ? 'expired' : 'none';
    }

    public function isActive(User $user): bool
    {
        return $user->onTrial() || $user->activeSubscription() !== null;
    }

    public function canPerformPaidActions(User $user): bool
    {
        return $this->isActive($user);
    }

    public function currentSubscription(User $user): ?Subscription
    {
        return $user->activeSubscription();
    }

    public function endsAt(User $user): ?\Illuminate\Support\Carbon
    {
        if ($user->onTrial()) {
            return $user->trial_ends_at;
        }

        return $user->activeSubscription()?->ends_at;
    }

    public function daysRemaining(User $user): int
    {
        $endsAt = $this->endsAt($user);

        if (! $endsAt || $endsAt->isPast()) {
            return 0;
        }

        return (int) now()->diffInDays($endsAt, false);
    }
}
