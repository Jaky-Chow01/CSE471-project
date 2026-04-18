<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donation_requests', function (Blueprint $table) {
            $table->foreignId('donor_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('donation_requests', function (Blueprint $table) {
            $table->dropForeign(['donor_user_id']);
            $table->dropColumn('donor_user_id');
        });
    }
};
