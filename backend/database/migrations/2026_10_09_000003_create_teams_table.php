<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('slug')->unique();
            $table->string('crest')->nullable();
            $table->string('colour', 7);
            $table->string('status', 20)->default('invited');
            $table->string('wishmoney_merchant_id')->nullable();
            $table->json('payment_methods')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
