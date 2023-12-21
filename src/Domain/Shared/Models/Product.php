<?php

declare(strict_types=1);

namespace Domain\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
    ];

    protected $fillable = ['resource_id', 'category', 'order', 'name'];

    public function getRouteKeyName(): string
    {
        return 'resource_id';
    }
}
