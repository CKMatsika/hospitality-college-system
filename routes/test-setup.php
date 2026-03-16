<?php

use Illuminate\Support\Facades\Route;

Route::get('/setup-test-data', function() {
    try {
        echo "🔧 Setting up test data...\n\n";
        
        // Create a test user
        $user = \App\Models\User::firstOrCreate([
            'email' => 'test@example.com'
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        echo "👤 Created test user: {$user->email}\n";
        
        // Create a test department
        $department = \App\Models\Department::firstOrCreate([
            'name' => 'Test Department'
        ], [
            'code' => 'TEST-DEPT',
            'description' => 'Test department for workflow testing',
        ]);
        echo "🏢 Created test department: {$department->name}\n";
        
        // Create a test program
        $program = \App\Models\Program::firstOrCreate([
            'name' => 'Test Program'
        ], [
            'code' => 'TEST',
            'description' => 'Test program for workflow testing',
            'duration_months' => 12,
            'department_id' => $department->id,
            'level' => 'degree',
            'tuition_fee' => 1000.00,
            'is_active' => true,
        ]);
        echo "📚 Created test program: {$program->name}\n";
        
        // Create a test academic term
        $academicTerm = \App\Models\AcademicTerm::firstOrCreate([
            'name' => '2026 Academic Year'
        ], [
            'code' => '2026-AY',
            'slug' => '2026-academic-year',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'is_current' => true,
        ]);
        echo "📅 Created test academic term: {$academicTerm->name}\n";
        
        // Create a test student
        $student = \App\Models\Student::firstOrCreate([
            'email' => 'student@test.com'
        ], [
            'first_name' => 'Test',
            'last_name' => 'Student',
            'student_id' => 'STU' . time(),
            'date_of_birth' => '2000-01-01',
            'gender' => 'male',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'country' => 'Test Country',
            'program_id' => $program->id,
            'admission_date' => now(),
            'registration_status' => 'accepted_pending_payment',
            'user_id' => $user->id,
        ]);
        echo "🎓 Created test student: {$student->first_name} {$student->last_name}\n";
        
        // Create a test fee structure
        $feeStructure = \App\Models\FeeStructure::firstOrCreate([
            'name' => 'Test Tuition Fee'
        ], [
            'code' => 'TUIT-TEST',
            'description' => 'Test tuition fee',
            'amount' => 1000.00,
            'fee_type' => 'tuition',
            'is_mandatory' => true,
            'program_id' => $program->id,
            'academic_term_id' => $academicTerm->id,
        ]);
        echo "💰 Created test fee structure: {$feeStructure->name} ({$feeStructure->amount})\n";
        
        // Create a test student fee
        $studentFee = \App\Models\StudentFee::firstOrCreate([
            'student_id' => $student->id,
            'fee_structure_id' => $feeStructure->id,
        ], [
            'academic_term_id' => $academicTerm->id,
            'amount' => $feeStructure->amount,
            'due_date' => now()->addDays(30),
            'status' => 'pending',
            'paid' => 0,
            'balance' => $feeStructure->amount,
        ]);
        echo "📝 Created test student fee: {$studentFee->amount} (Status: {$studentFee->status})\n";
        
        echo "\n✅ Test data setup complete!\n";
        echo "🧪 You can now run: /test-workflow\n";
        
    } catch (\Exception $e) {
        echo "❌ Setup failed: " . $e->getMessage() . "\n";
        echo "📍 Line: " . $e->getLine() . "\n";
    }
});
