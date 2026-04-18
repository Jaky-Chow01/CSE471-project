<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('initials', 5)->nullable();
            $table->string('blood_group', 5);
            $table->string('location', 200)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->date('last_donation')->nullable();
            $table->integer('min_wait')->default(90);
            $table->boolean('availability_today')->default(true);
            $table->string('status', 20)->default('Available');
            $table->timestamps();

            $table->index('blood_group');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
