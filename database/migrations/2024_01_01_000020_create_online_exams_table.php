<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration_minutes')->default(60);
            $table->decimal('passing_score', 5, 2)->default(50.00);
            $table->decimal('total_marks', 8, 2)->default(100.00);
            $table->boolean('allow_multiple_attempts')->default(false);
            $table->integer('max_attempts')->default(1);
            $table->boolean('is_published')->default(false);
            $table->boolean('require_proctoring')->default(false);
            $table->text('proctoring_instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_exams');
    }
};
