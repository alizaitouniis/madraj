<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stadiums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('map_link')->nullable();
            $table->unsignedSmallInteger('opens_minutes_before')->default(120);
            $table->json('parking')->nullable();
            $table->string('parking_note')->nullable();
            $table->json('allowed_items')->nullable();
            $table->json('forbidden_items')->nullable();
            $table->string('entry_note')->nullable();
            $table->text('accessibility_note')->nullable();
            $table->string('accessibility_phone', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stadiums');
    }
};
