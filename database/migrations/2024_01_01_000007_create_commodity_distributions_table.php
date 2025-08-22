<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commodity_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('regency_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('area_hectares', 12, 2)->nullable()->comment('Planted area in hectares');
            $table->decimal('production_tons', 12, 2)->nullable()->comment('Production in tons');
            $table->decimal('productivity', 8, 2)->nullable()->comment('Productivity (tons/hectare)');
            $table->year('year')->comment('Data year');
            $table->json('environmental_data')->nullable()->comment('Environmental conditions (temp, rainfall, etc.)');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['commodity_id', 'year']);
            $table->index(['province_id', 'commodity_id', 'year']);
            $table->index(['regency_id', 'commodity_id', 'year']);
            $table->index(['district_id', 'commodity_id', 'year']);
            $table->index('year');
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['commodity_id', 'province_id', 'regency_id', 'district_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodity_distributions');
    }
};