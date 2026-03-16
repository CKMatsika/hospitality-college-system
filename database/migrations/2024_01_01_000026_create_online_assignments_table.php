<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('deadline');
            $table->dateTime('published_at')->nullable();
            $table->decimal('total_marks', 8, 2)->default(100.00);
            $table->boolean('allow_late_submission')->default(false);
            $table->integer('late_penalty_percentage')->default(0);
            $table->text('instructions')->nullable();
            $table->json('attachment_files')->nullable(); // Store file information
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_assignments');
    }
};
