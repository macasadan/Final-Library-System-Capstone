<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->string('status')->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->string('return_status')->nullable();
            $table->string('returned_condition')->nullable();
        });
    }

    public function down()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason', 'return_status', 'returned_condition']);
        });
    }
};
