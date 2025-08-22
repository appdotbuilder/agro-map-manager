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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regency_id')->constrained()->cascadeOnDelete();
            $table->string('name')->comment('District name');
            $table->string('code', 20)->unique()->comment('District code');
            $table->decimal('latitude', 10, 8)->nullable()->comment('District latitude');
            $table->decimal('longitude', 11, 8)->nullable()->comment('District longitude');
            $table->json('boundaries')->nullable()->comment('GeoJSON boundaries data');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('code');
            $table->index(['regency_id', 'name']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};