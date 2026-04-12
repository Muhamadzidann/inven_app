<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lending extends Model
{
    protected $fillable = [
        'borrower_name',
        'user_id',
        'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'returned_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lendingItems(): HasMany
    {
        return $this->hasMany(LendingItem::class);
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }
}
