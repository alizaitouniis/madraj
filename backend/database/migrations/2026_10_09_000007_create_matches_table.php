<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->foreignId('stadium_id')->constrained()->restrictOnDelete();
            $table->string('opponent_name');
            $table->string('opponent_crest')->nullable();
            $table->string('opponent_colour', 7)->nullable();
            $table->string('competition');
            $table->string('round')->nullable();
            $table->dateTime('kickoff_at');
            $table->dateTime('sales_open_at')->nullable();
            $table->dateTime('sales_close_at')->nullable();
            $table->unsignedTinyInteger('max_per_order')->default(6);
            $table->string('status', 20)->default('draft');
            $table->timestamps();

            $table->index(['team_id', 'kickoff_at']);
            $table->index(['status', 'kickoff_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
