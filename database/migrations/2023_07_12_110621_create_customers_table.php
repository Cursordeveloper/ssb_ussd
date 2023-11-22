<?php

declare(strict_types=1);

use Domain\Customer\Enums\CustomerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'customers', callback: function (Blueprint $table) {
            // Table ids
            $table->id();
            $table->uuid(column: 'resource_id')->unique()->index();

            // Table main attributes
            $table->string(column: 'first_name')->nullable();
            $table->string(column: 'last_name')->nullable();

            $table->string(column: 'email')->unique()->nullable()->index();
            $table->string(column: 'phone_number')->unique()->index();

            $table->string(column: 'password')->nullable();

            $table->boolean(column: 'has_pin')->default(value: false);
            $table->string(column: 'status')->default(CustomerStatus::Pending->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'customers');
    }
};
