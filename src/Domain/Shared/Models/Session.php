<?php

declare(strict_types=1);

namespace Domain\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
    ];

    protected $fillable = [
        'id',
        'session_id',
        'phone_number',
        'sequence',
        'state',
    ];
}
