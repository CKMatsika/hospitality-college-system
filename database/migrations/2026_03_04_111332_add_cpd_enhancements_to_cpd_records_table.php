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
        Schema::table('cpd_records', function (Blueprint $table) {
            // Change student_id to user_id to support external candidates
            $table->dropForeign(['student_id']);
            $table->renameColumn('student_id', 'user_id');
            
            // Add new fields for enhanced CPD tracking
            $table->string('activity_type')->after('cpd_category_id'); // exam, lesson, short_course, external_training
            $table->unsignedBigInteger('activity_id')->nullable()->after('activity_type'); // Reference to specific activity
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
            $table->date('expiry_date')->nullable()->after('rejection_reason');
            $table->integer('validity_period_months')->nullable()->after('expiry_date');
            
            // Add foreign key for user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cpd_records', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'student_id');
            $table->dropColumn([
                'activity_type',
                'activity_id',
                'approved_at',
                'rejection_reason',
                'expiry_date',
                'validity_period_months'
            ]);
        });
        
        // Re-add foreign key for student_id
        Schema::table('cpd_records', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
};
