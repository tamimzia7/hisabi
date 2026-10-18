<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['workspace_id', 'member_id', 'meal_date', 'breakfast', 'lunch', 'dinner', 'notes'])]
class MessMeal extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'meal_date' => 'date',
            'breakfast' => 'integer',
            'lunch' => 'integer',
            'dinner' => 'integer',
        ];
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(WorkspaceMember::class, 'member_id');
    }

    public function totalCount(): int
    {
        return (int) $this->breakfast + (int) $this->lunch + (int) $this->dinner;
    }
}
