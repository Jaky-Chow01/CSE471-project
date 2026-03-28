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
        Schema::create('bloodtypes', function (Blueprint $table) {
            $table->id();
            $table->string('blood_group');
            $table->string('antigens_on_RBC');
            $table->string('antibodies_in_plasma');
            $table->string('can_donate_to');
            $table->string('can_receive_from');
            $table->timestamps();
        });
    }

};