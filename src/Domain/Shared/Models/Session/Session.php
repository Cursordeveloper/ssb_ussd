<?php

declare(strict_types=1);

namespace Domain\Shared\Models\Session;

use Domain\User\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'user_inputs' => 'array',
        'user_data' => 'array',
    ];

    protected $fillable = [
        'id',
        'customer_id',
        'session_id',
        'msisdn',
        'phone_number',
        'sequence',
        'user_inputs',
        'user_data',
        'state',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id'
        );
    }

    public function userInputs(): array
    {
        return json_decode($this->user_inputs, associative: true);
    }

    public function userData(): array
    {
        return json_decode($this->user_data, associative: true);
    }
}
