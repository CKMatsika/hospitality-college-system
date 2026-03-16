<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_term_id')->constrained()->cascadeOnDelete();
            $table->date('enrollment_date');
            $table->enum('status', ['enrolled', 'completed', 'dropped', 'failed', 'withdrawn'])->default('enrolled');
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->string('grade_letter')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'academic_term_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
