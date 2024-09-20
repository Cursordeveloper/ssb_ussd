<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'sessions', callback: function (Blueprint $table) {
            // Table ids
            $table->id();

            // Related fields
            $table->unsignedBigInteger(column: 'customer_id')->index()->nullable();

            // Table main attributes
            $table->string(column: 'session_id')->unique()->index();
            $table->string(column: 'msisdn');
            $table->string(column: 'phone_number')->index();
            $table->string(column: 'sequence')->nullable();
            $table->string(column: 'state')->nullable();
            $table->json(column: 'user_inputs')->nullable();
            $table->json(column: 'user_data')->nullable();

            // Table timestamps
            $table->timestamps();

            // Foreign key field
            $table->foreign(columns: 'customer_id')->references(columns: 'id')->on(table: 'customers')->onDelete(action: 'cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'sessions');
    }
};
