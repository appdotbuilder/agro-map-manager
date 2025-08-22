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
        Schema::create('regencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();
            $table->string('name')->comment('Regency name');
            $table->string('code', 15)->unique()->comment('Regency code');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Regency latitude');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Regency longitude');
            $table->json('boundaries')->nullable()->comment('GeoJSON boundaries data');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('code');
            $table->index(['province_id', 'name']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regencies');
    }
};