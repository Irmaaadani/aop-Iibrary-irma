<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                  ->constrained('books')
                  ->cascadeOnDelete();

            $table->foreignId('librarian_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('member_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->dateTime('loan_at');
            $table->dateTime('returned_at')->nullable();
            $table->string('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
