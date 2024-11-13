<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('item_type');
            $table->text('description')->nullable();
            $table->date('date_lost');
            $table->time('time_lost');
            $table->string('location');
            $table->enum('status', ['lost', 'found'])->default('lost');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
