<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Staff;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'total_students' => Student::count(),
            'total_staff' => Staff::count(),
            'total_courses' => Course::count(),
            'total_programs' => Program::count(),
        ];

        // Get recent students
        $recentStudents = Student::with('program')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent staff
        $recentStaff = Staff::with('department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('qbo-dashboard', compact('stats', 'recentStudents', 'recentStaff'));
    }

    public function admin()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $stats = [
            'total_students' => Student::count(),
            'total_staff' => Staff::count(),
            'total_courses' => Course::count(),
            'total_programs' => Program::count(),
        ];

        // Get enrollment statistics
        $enrollmentStats = Student::selectRaw('program_id, COUNT(*) as count')
            ->with('program')
            ->groupBy('program_id')
            ->get();

        return view('admin.dashboard', compact('stats', 'enrollmentStats'));
    }
}
