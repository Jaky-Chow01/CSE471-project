<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donation_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('bloodrequest_id')->nullable()->after('id');
            $table->foreign('bloodrequest_id')->references('id')->on('bloodrequests')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('donation_requests', function (Blueprint $table) {
            $table->dropForeign(['bloodrequest_id']);
            $table->dropColumn('bloodrequest_id');
        });
    }
};
