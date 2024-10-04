<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'policies', callback: function (Blueprint $table) {
            // Table ids
            $table->id();

            // Table main attributes
            $table->string(column: 'name')->unique();
            $table->string(column: 'url');

            // Foreign key field
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'policies');
    }
};
