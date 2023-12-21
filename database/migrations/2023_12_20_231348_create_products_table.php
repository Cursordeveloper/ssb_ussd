<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'products', callback: function (Blueprint $table) {
            // Table ids
            $table->id();
            $table->uuid(column: 'resource_id')->unique()->nullable(false);

            // Table main attributes
            $table->string(column: 'category');
            $table->string(column: 'order');
            $table->string(column: 'name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
