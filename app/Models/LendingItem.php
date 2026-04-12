<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LendingItem extends Model
{
    protected $fillable = [
        'lending_id',
        'item_id',
        'quantity',
    ];

    public function lending(): BelongsTo
    {
        return $this->belongsTo(Lending::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
