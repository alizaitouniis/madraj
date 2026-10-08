<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->restrictOnDelete();
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->string('method', 20);
            $table->decimal('amount', 14, 2); // LBP amounts are large
            $table->string('currency', 3)->default('USD');
            $table->string('status', 20);
            $table->string('provider_ref')->nullable()->index();
            $table->foreignId('collected_by')->nullable()->constrained('team_members')->nullOnDelete();
            $table->dateTime('collected_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
