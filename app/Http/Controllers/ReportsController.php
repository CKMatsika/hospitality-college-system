<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Staff;
use App\Models\Course;
use App\Models\Program;
use App\Models\Department;
use App\Models\FeePayment;
use App\Models\BookLoan;
use App\Models\LmsCourse;
use App\Models\LmsEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function enrollmentReport()
    {
        $driver = DB::connection()->getDriverName();

        // Enrollment by Program
        $enrollmentByProgram = Student::selectRaw('programs.name, COUNT(*) as count')
            ->join('programs', 'students.program_id', '=', 'programs.id')
            ->groupBy('programs.id', 'programs.name')
            ->orderBy('count', 'desc')
            ->get();

        // Enrollment by Year
        $enrollmentByYearSelect = $driver === 'sqlite'
            ? "strftime('%Y', admission_date) as year, COUNT(*) as count"
            : 'YEAR(admission_date) as year, COUNT(*) as count';

        $enrollmentByYear = Student::selectRaw($enrollmentByYearSelect)
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Student Status Distribution
        $studentStatus = Student::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Gender Distribution
        $genderDistribution = Student::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get();

        return view('reports.enrollment', compact(
            'enrollmentByProgram',
            'enrollmentByYear',
            'studentStatus',
            'genderDistribution'
        ));
    }

    public function academicReport()
    {
        // Course Enrollment
        $courseEnrollment = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(10)
            ->get();

        // Program Statistics
        $programStats = Program::withCount('students', 'courses')
            ->get();

        // Department Statistics
        $departmentStats = Department::withCount('programs', 'staff')
            ->get();

        return view('reports.academic', compact(
            'courseEnrollment',
            'programStats',
            'departmentStats'
        ));
    }

    public function financialReport()
    {
        $driver = DB::connection()->getDriverName();

        // Monthly Revenue
        $monthlyRevenueSelect = $driver === 'sqlite'
            ? "CAST(strftime('%m', payment_date) AS INTEGER) as month, strftime('%Y', payment_date) as year, SUM(amount) as total"
            : 'MONTH(payment_date) as month, YEAR(payment_date) as year, SUM(amount) as total';

        $monthlyRevenue = FeePayment::selectRaw($monthlyRevenueSelect)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Revenue by Program
        $revenueByProgram = FeePayment::join('student_fees', 'fee_payments.student_fee_id', '=', 'student_fees.id')
            ->join('fee_structures', 'student_fees.fee_structure_id', '=', 'fee_structures.id')
            ->join('programs', 'fee_structures.program_id', '=', 'programs.id')
            ->selectRaw('programs.name, SUM(fee_payments.amount) as total')
            ->groupBy('programs.id', 'programs.name')
            ->orderBy('total', 'desc')
            ->get();

        // Payment Methods
        $paymentMethods = FeePayment::selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        return view('reports.financial', compact(
            'monthlyRevenue',
            'revenueByProgram',
            'paymentMethods'
        ));
    }

    public function libraryReport()
    {
        $driver = DB::connection()->getDriverName();

        // Most Popular Books
        $popularBooks = BookLoan::selectRaw('books.title, books.author, COUNT(*) as loan_count')
            ->join('books', 'book_loans.book_id', '=', 'books.id')
            ->groupBy('books.id', 'books.title', 'books.author')
            ->orderBy('loan_count', 'desc')
            ->take(10)
            ->get();

        // Library Usage by Month
        $libraryUsageSelect = $driver === 'sqlite'
            ? "CAST(strftime('%m', loan_date) AS INTEGER) as month, strftime('%Y', loan_date) as year, COUNT(*) as loans"
            : 'MONTH(loan_date) as month, YEAR(loan_date) as year, COUNT(*) as loans';

        $libraryUsage = BookLoan::selectRaw($libraryUsageSelect)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Overdue Books
        $overdueBooks = BookLoan::with(['book', 'user'])
            ->where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->get();

        return view('reports.library', compact(
            'popularBooks',
            'libraryUsage',
            'overdueBooks'
        ));
    }

    public function staffReport()
    {
        // Staff by Department
        $staffByDepartment = Staff::selectRaw('departments.name, COUNT(*) as count')
            ->join('departments', 'staff.department_id', '=', 'departments.id')
            ->groupBy('departments.id', 'departments.name')
            ->orderBy('count', 'desc')
            ->get();

        // Staff Status
        $staffStatus = Staff::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Employment Type Distribution
        $employmentTypes = Staff::selectRaw('employment_type, COUNT(*) as count')
            ->groupBy('employment_type')
            ->get();

        return view('reports.staff', compact(
            'staffByDepartment',
            'staffStatus',
            'employmentTypes'
        ));
    }

    public function lmsReport()
    {
        // Course Completion Rates
        $courseCompletion = LmsCourse::withCount(['enrollments', 'enrollments as completed_count' => function($query) {
                $query->whereNotNull('completed_at');
            }])
            ->get()
            ->map(function($course) {
                $course->completion_rate = $course->enrollments_count > 0 
                    ? ($course->completed_count / $course->enrollments_count) * 100 
                    : 0;
                return $course;
            });

        // Enrollment by Course
        $enrollmentByCourse = LmsCourse::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->get();

        // Student Progress
        $studentProgress = LmsEnrollment::selectRaw("CASE WHEN completed_at IS NOT NULL THEN 'completed' WHEN progress > 0 THEN 'in_progress' ELSE 'not_started' END as status, COUNT(*) as count, AVG(progress) as avg_progress")
            ->groupBy('status')
            ->get();

        return view('reports.lms', compact(
            'courseCompletion',
            'enrollmentByCourse',
            'studentProgress'
        ));
    }

    public function generateCustomReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:enrollment,academic,financial,library,staff,lms',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'required|in:web,pdf,excel',
        ]);

        $reportType = $request->report_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $format = $request->format;

        // Generate report based on type
        switch ($reportType) {
            case 'enrollment':
                return $this->generateEnrollmentReport($startDate, $endDate, $format);
            case 'academic':
                return $this->generateAcademicReport($startDate, $endDate, $format);
            case 'financial':
                return $this->generateFinancialReport($startDate, $endDate, $format);
            case 'library':
                return $this->generateLibraryReport($startDate, $endDate, $format);
            case 'staff':
                return $this->generateStaffReport($startDate, $endDate, $format);
            case 'lms':
                return $this->generateLmsReport($startDate, $endDate, $format);
        }
    }

    private function generateEnrollmentReport($startDate, $endDate, $format)
    {
        $query = Student::query();
        
        if ($startDate) {
            $query->where('admission_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('admission_date', '<=', $endDate);
        }

        $students = $query->with('program')->get();

        if ($format === 'pdf') {
            // Generate PDF report
            return response()->download($this->generatePdfReport('enrollment', $students));
        } elseif ($format === 'excel') {
            // Generate Excel report
            return response()->download($this->generateExcelReport('enrollment', $students));
        }

        return view('reports.custom.enrollment', compact('students'));
    }

    // Additional helper methods for PDF/Excel generation would go here
    private function generatePdfReport($type, $data)
    {
        // Implementation for PDF generation
        return 'report.pdf';
    }

    private function generateExcelReport($type, $data)
    {
        // Implementation for Excel generation
        return 'report.xlsx';
    }
}
