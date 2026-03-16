<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('certificate_number')->unique();
            $table->enum('type', ['completion', 'merit', 'distinction', 'participation', 'professional']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['issued', 'revoked', 'expired'])->default('issued');
            $table->string('file_path')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('cpd_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('max_points')->nullable();
            $table->timestamps();
        });

        Schema::create('cpd_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cpd_category_id')->constrained()->cascadeOnDelete();
            $table->string('activity_name');
            $table->text('description')->nullable();
            $table->string('provider')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('hours');
            $table->integer('points')->default(0);
            $table->string('certificate_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpd_records');
        Schema::dropIfExists('cpd_categories');
        Schema::dropIfExists('certificates');
    }
};
