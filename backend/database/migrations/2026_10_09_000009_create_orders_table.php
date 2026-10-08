<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // e.g. MD-10482
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->foreignId('match_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('zone_id')->constrained()->restrictOnDelete();
            $table->unsignedTinyInteger('quantity');
            $table->decimal('total', 10, 2);
            $table->string('method', 20);
            $table->string('status', 20);
            $table->dateTime('reserved_until')->nullable();
            $table->timestamps();

            $table->index(['match_id', 'status']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
