<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'total',
        'repair',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'integer',
            'repair' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function lendingItems(): HasMany
    {
        return $this->hasMany(LendingItem::class);
    }

    public function activeLendingLines(): HasMany
    {
        return $this->hasMany(LendingItem::class)
            ->whereHas('lending', fn ($q) => $q->whereNull('returned_at'));
    }

    protected function lendingTotal(): Attribute
    {
        return Attribute::make(
            get: function () {
                $key = 'active_lending_lines_sum_quantity';
                if (array_key_exists($key, $this->attributes) && $this->attributes[$key] !== null) {
                    return (int) $this->attributes[$key];
                }

                return (int) $this->activeLendingLines()->sum('quantity');
            },
        );
    }

    protected function available(): Attribute
    {
        return Attribute::make(
            get: fn () => max(0, (int) $this->total - (int) $this->repair - $this->lending_total),
        );
    }
}
