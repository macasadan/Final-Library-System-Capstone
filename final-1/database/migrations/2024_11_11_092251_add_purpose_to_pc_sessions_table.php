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
        Schema::table('pc_sessions', function (Blueprint $table) {
            // Add purpose column if it doesn't exist
            if (!Schema::hasColumn('pc_sessions', 'purpose')) {
                $table->string('purpose')->nullable()->after('status');
            }

            // Ensure status is using correct data type
            // Assuming you want an enum for status
            $table->string('status')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pc_sessions', function (Blueprint $table) {
            $table->dropColumn('purpose');
        });
    }
};
