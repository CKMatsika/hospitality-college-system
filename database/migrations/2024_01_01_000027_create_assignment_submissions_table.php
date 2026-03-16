<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('submitted_at');
            $table->decimal('score', 8, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->enum('status', ['submitted', 'graded', 'returned_for_revision'])->default('submitted');
            $table->text('feedback')->nullable();
            $table->decimal('late_penalty_applied', 5, 2)->default(0.00);
            $table->boolean('is_late')->default(false);
            $table->text('submission_text')->nullable();
            $table->json('attachment_files')->nullable(); // Store uploaded file information
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
