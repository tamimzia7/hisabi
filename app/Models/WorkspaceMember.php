<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['workspace_id', 'user_id', 'name', 'phone', 'is_active', 'joined_at', 'left_at'])]
class WorkspaceMember extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'joined_at' => 'date',
            'left_at' => 'date',
        ];
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messMeals(): HasMany
    {
        return $this->hasMany(MessMeal::class, 'member_id');
    }

    public function messDeposits(): HasMany
    {
        return $this->hasMany(MessDeposit::class, 'member_id');
    }
}
