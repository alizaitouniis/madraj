<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->foreignId('match_id')->constrained()->restrictOnDelete();
            $table->foreignId('zone_id')->constrained()->restrictOnDelete();
            $table->string('holder_name');
            $table->string('holder_phone', 20);
            $table->string('qr_token', 64)->unique(); // random, never personal data
            $table->string('status', 20)->default('valid');
            $table->dateTime('checked_in_at')->nullable();
            $table->foreignId('checked_in_by')->nullable()->constrained('team_members')->nullOnDelete();
            $table->timestamps();

            $table->index(['match_id', 'status']);
            $table->index('holder_phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
