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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Province name');
            $table->string('code', 10)->unique()->comment('Province code');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Province latitude');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Province longitude');
            $table->json('boundaries')->nullable()->comment('GeoJSON boundaries data');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('code');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};