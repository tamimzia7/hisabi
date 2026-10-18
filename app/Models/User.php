<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

#[Fillable(['name', 'email', 'password', 'account_type', 'trial_starts_at', 'trial_ends_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'trial_starts_at' => 'datetime',
            'trial_ends_at' => 'datetime',
        ];
    }

    /**
     * Determine whether the user is currently on a free trial.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at instanceof Carbon && $this->trial_ends_at->isFuture();
    }

    /**
     * Number of days remaining in the free trial (0 if expired).
     */
    public function trialDaysRemaining(): int
    {
        if (! $this->trial_ends_at instanceof Carbon || $this->trial_ends_at->isPast()) {
            return 0;
        }

        return (int) now()->diffInDays($this->trial_ends_at, false);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function paymentRecords(): HasMany
    {
        return $this->hasMany(PaymentRecord::class);
    }

    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();
    }
}
