<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['owner_id', 'type', 'name', 'settings'])]
class Workspace extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(WorkspaceMember::class);
    }

    public function activeMembers(): HasMany
    {
        return $this->hasMany(WorkspaceMember::class)->where('is_active', true);
    }

    public function messMeals(): HasMany
    {
        return $this->hasMany(MessMeal::class);
    }

    public function messExpenses(): HasMany
    {
        return $this->hasMany(MessExpense::class);
    }

    public function messDeposits(): HasMany
    {
        return $this->hasMany(MessDeposit::class);
    }
}
