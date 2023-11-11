<?php

declare(strict_types=1);

namespace Domain\Customer\Models;

use Domain\Customer\DTO\CustomerData;
use Domain\Shared\Models\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use HasUuid;

    protected string $guard = 'customer';

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'resource_id',
        'first_name',
        'last_name',
        'phone_number',
        'has_pin',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'resource_id';
    }

    public function token(): HasOne
    {
        return $this->hasOne(
            related: Token::class,
            foreignKey: 'customer_id'
        );
    }

    public function toData(): CustomerData
    {
        return new CustomerData(
            id: $this->id,
            resource_id: $this->resource_id,
            first_name: $this->first_name,
            phone_number: $this->phone_number,
            email: $this->email,
            status: $this->status,
            created_at: $this->created_at,
            updated_at: $this->updated_at
        );
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
