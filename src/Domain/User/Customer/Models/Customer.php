<?php

declare(strict_types=1);

namespace Domain\User\Customer\Models;

use Domain\Shared\Models\Session\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected string $guard = 'customer';

    protected $fillable = [
        'id',
        'resource_id',
        'first_name',
        'last_name',
        'phone_number',
        'has_pin',
        'has_kyc',
        'accepted_terms',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'resource_id';
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(
            related: Session::class,
            foreignKey: 'customer_id'
        );
    }
}
