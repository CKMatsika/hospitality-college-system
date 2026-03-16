<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Add new columns for online exam integration
            $table->decimal('score', 8, 2)->nullable()->after('description');
            $table->decimal('percentage', 5, 2)->nullable()->after('score');
            $table->string('verification_code')->nullable()->after('certificate_url');
            $table->string('certificate_url')->nullable()->after('verification_code');
            
            // Add foreign keys for online exams
            $table->foreignId('exam_id')->nullable()->after('course_id')->constrained()->onDelete('set null');
            $table->foreignId('course_id')->nullable()->after('exam_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['exam_id', 'course_id']);
            $table->dropColumn(['score', 'percentage', 'verification_code', 'certificate_url']);
        });
    }
};
