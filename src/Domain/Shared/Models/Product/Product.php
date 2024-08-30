<?php

declare(strict_types=1);

namespace Domain\Shared\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'resource_id',
        'category',
        'order',
        'name',
    ];

    public function getRouteKeyName(): string
    {
        return 'resource_id';
    }
}
