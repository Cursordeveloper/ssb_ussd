<?php

declare(strict_types=1);

namespace Domain\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Token extends Model
{
    protected $fillable = [
        'customer_id',
        'token',
        'token_expiration_date',
        'is_verified',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id'
        );
    }
}
