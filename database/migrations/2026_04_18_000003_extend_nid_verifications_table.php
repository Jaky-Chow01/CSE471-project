<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nid_verifications', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('id');
            $table->string('full_name', 150)->nullable()->after('user_id');
            $table->string('image_path', 500)->nullable()->after('nid_number');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    public function down(): void
    {
        Schema::table('nid_verifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['user_id', 'full_name', 'image_path', 'verified_by', 'verified_at']);
        });
    }
};
