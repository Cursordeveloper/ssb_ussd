<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'policy_contents', callback: function (Blueprint $table) {
            // Table ids
            $table->id();
            $table->unsignedBigInteger(column: 'policy_id');

            // Table main attributes
            $table->string(column: 'text');

            // Foreign key field
            $table->foreign(columns: 'policy_id')->references(columns: 'id')->on(table: 'policies')->onDelete(action: 'cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'policy_contents');
    }
};
