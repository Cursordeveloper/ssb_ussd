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

            // Table main attributes
            $table->string(column: 'session_id')->unique();
            $table->string(column: 'msisdn');
            $table->string(column: 'phone_number');
            $table->string(column: 'sequence');
            $table->string(column: 'state')->nullable();

            // Table timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'sessions');
    }
};
