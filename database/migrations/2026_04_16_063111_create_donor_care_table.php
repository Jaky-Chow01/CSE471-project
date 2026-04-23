<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donor_care', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');
            $table->time('hydration_start')->default('08:00:00');
            $table->time('hydration_end')->default('20:00:00');
            $table->time('rest_start')->default('09:00:00');
            $table->time('rest_end')->default('17:00:00');
            $table->time('nutrition_start')->default('07:00:00');
            $table->time('nutrition_end')->default('21:00:00');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donor_care');
    }
};
