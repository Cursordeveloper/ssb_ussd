<?php

declare(strict_types=1);

namespace Domain\Shared\Models\Policy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Policy extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [];

    protected $fillable = [
        'id',
        'name',
        'url',
    ];

    public function sessions(): HasMany
    {
        return $this->hasMany(
            related: PolicyContent::class,
            foreignKey: 'policy_id'
        );
    }
}
