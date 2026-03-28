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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            
            // 1. Change to string to store 'Urgent' or '' as requested
            $table->string('urgent')->default(''); 
            
            $table->string('bloodgroup');
            $table->string('location'); 
            
            // 2. Renamed to 'datetime' to match standard Laravel naming in the controller
            $table->dateTime('datetime'); 
            
            $table->integer('noofbags');
            $table->string('patienttype');
            $table->integer('patientage');
            $table->string('patientgender');
            $table->string('contactno');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloodrequests');
    }
};
