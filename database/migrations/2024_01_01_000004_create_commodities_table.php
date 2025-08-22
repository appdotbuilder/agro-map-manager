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
        Schema::create('commodities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Commodity name');
            $table->string('scientific_name')->nullable()->comment('Scientific name');
            $table->text('description')->nullable()->comment('Commodity description');
            $table->string('category')->comment('Commodity category (food crop, horticulture, plantation, etc.)');
            $table->string('image_url')->nullable()->comment('Commodity image URL');
            $table->json('growing_conditions')->nullable()->comment('Optimal growing conditions');
            $table->json('harvest_info')->nullable()->comment('Harvest information');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('category');
            $table->index(['category', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodities');
    }
};