<?php

declare(strict_types=1);

namespace Domain\Shared\Models\Policy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PolicyContent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [];

    protected $fillable = [
        'id',
        'policy_id',
        'text',
    ];

    public function policy(): BelongsTo
    {
        return $this->belongsTo(
            related: Policy::class,
            foreignKey: 'policy_id'
        );
    }
}
