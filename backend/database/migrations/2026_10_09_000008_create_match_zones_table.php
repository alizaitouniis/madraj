<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_zones', function (Blueprint $table) {
            // Per-match settings for each stadium zone. Capacity comes from the zone.
            $table->id();
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->foreignId('match_id')->constrained()->cascadeOnDelete();
            $table->foreignId('zone_id')->constrained()->restrictOnDelete();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('tickets_for_sale');
            $table->unsignedTinyInteger('max_per_order')->nullable(); // null: use the match's
            $table->boolean('on_sale')->default(false);
            $table->timestamps();

            $table->unique(['match_id', 'zone_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_zones');
    }
};
