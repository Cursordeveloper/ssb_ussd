<?php

declare(strict_types=1);

namespace Domain\Customer\Models;

use Domain\Customer\DTO\TokenData;
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

    public function toData(): TokenData
    {
        return new TokenData(
            id: $this->id,
            customer_id: $this->customer_id,
            token: $this->token,
            token_expiration_date: $this->token_expiration_date,
            is_verified: $this->is_verified
        );
    }
}
