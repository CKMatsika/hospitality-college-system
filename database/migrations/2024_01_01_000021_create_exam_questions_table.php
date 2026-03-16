<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['multiple_choice', 'true_false', 'short_answer', 'essay', 'matching']);
            $table->decimal('marks', 5, 2)->default(1.00);
            $table->integer('order')->default(1);
            $table->json('options')->nullable(); // For multiple choice questions
            $table->text('correct_answer')->nullable();
            $table->text('explanation')->nullable(); // Explanation for the correct answer
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
