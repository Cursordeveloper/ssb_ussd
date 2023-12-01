<?php

declare(strict_types=1);

namespace Domain\Customer\Models;

use Domain\Shared\Models\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];
    protected string $guard = 'customer';
    protected $fillable = ['id', 'resource_id', 'first_name', 'last_name', 'phone_number', 'email', 'has_pin', 'status'];

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

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
