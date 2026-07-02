<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('growth_events', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->uuid('anonymous_id')->nullable()->index();
            $table->string('name', 100)->index();
            $table->text('path')->nullable();
            $table->text('referrer')->nullable();
            $table->string('source')->nullable()->index();
            $table->string('medium')->nullable();
            $table->string('campaign')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->char('ip_hash', 64)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
            $table->index(['name', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('growth_events');
    }
};
