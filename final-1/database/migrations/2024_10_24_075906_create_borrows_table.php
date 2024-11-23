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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('id_number');
            $table->string('course');
            $table->enum('department', ['COT', 'COE', 'CEAS', 'CME']);
            $table->timestamp('borrow_date')->nullable(); // This is your borrow date
            $table->date('due_date'); // This is your due date
            $table->timestamp('returned_at')->nullable(); // To store the return date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
