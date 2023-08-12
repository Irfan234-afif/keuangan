<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Balance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transactions(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}