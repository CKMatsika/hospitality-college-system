<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('lesson_type', ['video', 'text', 'interactive', 'live_session', 'assignment']);
            $table->text('content')->nullable(); // Lesson content (HTML, video URL, etc.)
            $table->string('video_url')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->dateTime('scheduled_start_time')->nullable();
            $table->dateTime('scheduled_end_time')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->integer('order')->default(1);
            $table->json('materials')->nullable(); // Additional learning materials
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_lessons');
    }
};
