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
        Schema::table('diagonosticcenters', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->json('services')->nullable()->after('contactno');
            $table->json('prices')->nullable()->after('services');
            $table->string('operating_hours')->nullable()->after('prices');
            $table->boolean('emergency_services')->default(false)->after('operating_hours');
            $table->decimal('latitude', 10, 8)->nullable()->after('emergency_services');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagonosticcenters', function (Blueprint $table) {
            $table->dropColumn(['description', 'services', 'prices', 'operating_hours', 'emergency_services', 'latitude', 'longitude']);
        });
    }
};
