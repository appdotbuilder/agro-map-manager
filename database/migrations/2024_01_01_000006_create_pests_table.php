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
        Schema::create('pests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Pest or disease name');
            $table->string('scientific_name')->nullable()->comment('Scientific name');
            $table->enum('type', ['pest', 'disease'])->comment('Type: pest or disease');
            $table->text('description')->nullable()->comment('Pest/disease description');
            $table->json('symptoms')->nullable()->comment('Symptoms and identification signs');
            $table->json('affected_commodities')->nullable()->comment('List of affected commodity IDs');
            $table->json('control_methods')->nullable()->comment('Prevention and control methods');
            $table->json('insecticide_recommendations')->nullable()->comment('Recommended insecticides/treatments');
            $table->string('image_url')->nullable()->comment('Pest/disease image URL');
            $table->json('environmental_factors')->nullable()->comment('Environmental conditions that favor development');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('type');
            $table->index(['type', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pests');
    }
};