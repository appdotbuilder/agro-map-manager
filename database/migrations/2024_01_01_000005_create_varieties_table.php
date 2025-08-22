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
        Schema::create('varieties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_id')->constrained()->cascadeOnDelete();
            $table->string('name')->comment('Variety name');
            $table->text('description')->nullable()->comment('Variety description');
            $table->json('agronomic_traits')->nullable()->comment('Agronomic characteristics');
            $table->json('pest_susceptibility')->nullable()->comment('Pest and disease susceptibility data');
            $table->integer('maturity_days')->nullable()->comment('Days to maturity');
            $table->decimal('potential_yield', 10, 2)->nullable()->comment('Potential yield per hectare');
            $table->string('yield_unit', 20)->default('tons')->comment('Yield measurement unit');
            $table->string('image_url')->nullable()->comment('Variety image URL');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index(['commodity_id', 'name']);
            $table->index('maturity_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varieties');
    }
};