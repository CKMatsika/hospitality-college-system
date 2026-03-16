<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LmsController;
use App\Http\Controllers\StudentLmsEnrollmentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ManualEnrollmentController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\OnlineExamController;
use App\Http\Controllers\OnlineLessonController;
use App\Http\Controllers\OnlineAssignmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\FinancialManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Load QuickBooks style routes
require __DIR__.'/qbo.php';

// Load test routes (remove in production)
require __DIR__.'/test.php';
require __DIR__.'/test-setup.php';

Route::get('/', function () {
    return view('welcome');
});

// Public application route (no auth required)
Route::get('/apply', [ApplicationController::class, 'create'])->name('applications.create.public');
Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store.public');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Financial Management routes
    require __DIR__.'/financial.php';
    
    // Student routes
    Route::resource('students', StudentController::class);

    Route::prefix('students/{student}')->name('students.')->group(function () {
        Route::post('/lms-enrollments', [StudentLmsEnrollmentController::class, 'store'])->name('lms-enrollments.store');
        Route::delete('/lms-enrollments/{enrollment}', [StudentLmsEnrollmentController::class, 'destroy'])->name('lms-enrollments.destroy');
    });

    // Admissions Dashboard
    Route::get('/admissions', function () {
        return view('admissions.dashboard');
    })->name('admissions.dashboard');
    
    // Application routes
    Route::resource('applications', ApplicationController::class);
    Route::get('applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
    Route::get('applications/documents/{document}/download', [ApplicationController::class, 'downloadDocument'])->name('applications.download-document');

    // Manual Enrollment routes
    Route::prefix('enrollments')->name('enrollments.')->group(function () {
        Route::get('manual', [ManualEnrollmentController::class, 'index'])->name('manual.index');
        Route::get('manual/create', [ManualEnrollmentController::class, 'create'])->name('manual.create');
        Route::post('manual', [ManualEnrollmentController::class, 'store'])->name('manual.store');
        
        Route::get('csv/upload', [ManualEnrollmentController::class, 'csvUpload'])->name('csv.upload');
        Route::post('csv/preview', [ManualEnrollmentController::class, 'csvPreview'])->name('csv.preview');
        Route::post('csv/import', [ManualEnrollmentController::class, 'csvImport'])->name('csv.import');
    });
    
    // Staff routes
    Route::resource('staff', StaffController::class);
    
    // User Management routes (super admin only)
    Route::middleware('super_admin')->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // Payroll routes
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('index');
        Route::get('/run', [PayrollController::class, 'run'])->name('run');
        Route::post('/process', [PayrollController::class, 'processPayroll'])->name('process');
        Route::get('/employees', [PayrollController::class, 'employees'])->name('employees');
        Route::get('/{id}', [PayrollController::class, 'showPayroll'])->name('show');
        Route::get('/payslip/{payrollId}/{staffId}', [PayrollController::class, 'payslip'])->name('payslip');
    });
    
    // Program routes
    Route::resource('programs', ProgramController::class);
    
    // Course routes
    Route::resource('courses', CourseController::class);
    
    // Finance routes
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/dashboard', [FinanceController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('fee-structures')->name('fee-structures.')->group(function () {
            Route::get('/', [FinanceController::class, 'feeStructures'])->name('index');
            Route::get('/create', [FinanceController::class, 'createFeeStructure'])->name('create');
            Route::post('/', [FinanceController::class, 'storeFeeStructure'])->name('store');
            Route::get('/{feeStructure}/edit', [FinanceController::class, 'editFeeStructure'])->name('edit');
            Route::put('/{feeStructure}', [FinanceController::class, 'updateFeeStructure'])->name('update');
            Route::delete('/{feeStructure}', [FinanceController::class, 'destroyFeeStructure'])->name('destroy');
        });
        
        Route::prefix('student-fees')->name('student-fees.')->group(function () {
            Route::get('/', [FinanceController::class, 'studentFees'])->name('index');
            Route::get('/create', [FinanceController::class, 'createStudentFee'])->name('create');
            Route::post('/', [FinanceController::class, 'storeStudentFee'])->name('store');
        });
        
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [FinanceController::class, 'payments'])->name('index');
            Route::get('/create', [FinanceController::class, 'createPayment'])->name('create');
            Route::post('/', [FinanceController::class, 'storePayment'])->name('store');
            Route::get('/{payment}', [FinanceController::class, 'showPayment'])->name('show');
            Route::delete('/{payment}', [FinanceController::class, 'destroyPayment'])->name('destroy');
            Route::get('/receipt/{id}', [FinanceController::class, 'generateReceipt'])->name('receipt');
        });
        
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/revenue', [FinanceController::class, 'revenueReport'])->name('revenue');
        });
    });
    
    // Accounting routes
    Route::prefix('accounting')->name('accounting.')->group(function () {
        Route::get('dashboard', [AccountingController::class, 'dashboard'])->name('dashboard');
        
        // Chart of Accounts
        Route::get('accounts', [AccountingController::class, 'accounts'])->name('accounts');
        Route::get('accounts/create', [AccountingController::class, 'createAccount'])->name('accounts.create');
        Route::post('accounts', [AccountingController::class, 'storeAccount'])->name('accounts.store');
        
        // Financial Periods
        Route::get('periods', [AccountingController::class, 'periods'])->name('periods');
        Route::get('periods/create', [AccountingController::class, 'createPeriod'])->name('periods.create');
        Route::post('periods', [AccountingController::class, 'storePeriod'])->name('periods.store');
        Route::post('periods/{period}/close', [AccountingController::class, 'closePeriod'])->name('periods.close');
        
        // Journal Entries
        Route::get('journal', [AccountingController::class, 'journalEntries'])->name('journal');
        Route::get('journal/create', [AccountingController::class, 'createJournalEntry'])->name('journal.create');
        Route::post('journal', [AccountingController::class, 'storeJournalEntry'])->name('journal.store');
        Route::get('journal/{journalEntry}', [AccountingController::class, 'showJournalEntry'])->name('journal.show');
        Route::post('journal/{journalEntry}/post', [AccountingController::class, 'postJournalEntry'])->name('journal.post');
        Route::post('journal/{journalEntry}/reverse', [AccountingController::class, 'reverseJournalEntry'])->name('journal.reverse');
        
        // Invoices
        Route::get('invoices', [AccountingController::class, 'invoices'])->name('invoices');
        Route::get('invoices/create', [AccountingController::class, 'createInvoice'])->name('invoices.create');
        Route::post('invoices', [AccountingController::class, 'storeInvoice'])->name('invoices.store');
        Route::get('invoices/{invoice}', [AccountingController::class, 'showInvoice'])->name('invoices.show');
        Route::post('invoices/{invoice}/post', [AccountingController::class, 'postInvoice'])->name('invoices.post');
        
        // Financial Reports
        Route::get('reports/trial-balance', [AccountingController::class, 'trialBalance'])->name('reports.trial-balance');
        Route::get('reports/income-statement', [AccountingController::class, 'incomeStatement'])->name('reports.income-statement');
        Route::get('reports/balance-sheet', [AccountingController::class, 'balanceSheet'])->name('reports.balance-sheet');
        Route::get('reports/cash-flow', [AccountingController::class, 'cashFlow'])->name('reports.cash-flow');
        
        // General Ledger
        Route::get('general-ledger', [AccountingController::class, 'generalLedger'])->name('general-ledger');
        Route::get('general-ledger/{account}', [AccountingController::class, 'generalLedgerAccount'])->name('general-ledger.account');
        
        // Accounts Receivable
        Route::get('accounts-receivable', [AccountingController::class, 'accountsReceivable'])->name('accounts-receivable');
        Route::get('accounts-receivable/aging', [AccountingController::class, 'accountsReceivableAging'])->name('accounts-receivable.aging');
        Route::get('accounts-receivable/{customer}', [AccountingController::class, 'accountsReceivableCustomer'])->name('accounts-receivable.customer');
        
        // Accounts Payable
        Route::get('accounts-payable', [AccountingController::class, 'accountsPayable'])->name('accounts-payable');
        Route::get('accounts-payable/aging', [AccountingController::class, 'accountsPayableAging'])->name('accounts-payable.aging');
        Route::get('accounts-payable/{vendor}', [AccountingController::class, 'accountsPayableVendor'])->name('accounts-payable.vendor');
        
        // Student Statements
        Route::get('student-statements', [AccountingController::class, 'studentStatements'])->name('student-statements');
        Route::get('student-statements/{student}', [AccountingController::class, 'studentStatement'])->name('student-statements.show');
        Route::get('student-statements/{student}/pdf', [AccountingController::class, 'studentStatementPdf'])->name('student-statements.pdf');
        
        // Cashbook
        Route::get('cashbook', [AccountingController::class, 'cashbook'])->name('cashbook');
    });
    
    // Library routes
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/dashboard', [LibraryController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('books')->name('books.')->group(function () {
            Route::get('/', [LibraryController::class, 'books'])->name('index');
            Route::get('/create', [LibraryController::class, 'createBook'])->name('create');
            Route::post('/', [LibraryController::class, 'storeBook'])->name('store');
            Route::get('/{book}', [LibraryController::class, 'showBook'])->name('show');
        });
        
        Route::prefix('loans')->name('loans.')->group(function () {
            Route::get('/', [LibraryController::class, 'loans'])->name('index');
            Route::get('/create', [LibraryController::class, 'createLoan'])->name('create');
            Route::post('/', [LibraryController::class, 'storeLoan'])->name('store');
            Route::patch('/{loan}/return', [LibraryController::class, 'returnBook'])->name('return');
        });
        
        Route::prefix('reservations')->name('reservations.')->group(function () {
            Route::get('/', [LibraryController::class, 'reservations'])->name('index');
            Route::get('/create', [LibraryController::class, 'createReservation'])->name('create');
            Route::post('/', [LibraryController::class, 'storeReservation'])->name('store');
        });
        
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [LibraryController::class, 'categories'])->name('index');
            Route::post('/', [LibraryController::class, 'storeCategory'])->name('store');
        });
    });
    
    // LMS routes
    Route::prefix('lms')->name('lms.')->group(function () {
        Route::get('/dashboard', [LmsController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('courses')->name('courses.')->group(function () {
            Route::get('/', [LmsController::class, 'courses'])->name('index');
            Route::get('/create', [LmsController::class, 'createCourse'])->name('create');
            Route::post('/', [LmsController::class, 'storeCourse'])->name('store');
            Route::get('/{course}', [LmsController::class, 'showCourse'])->name('show');
            
            Route::prefix('modules')->name('modules.')->group(function () {
                Route::get('/{course}/create', [LmsController::class, 'createModule'])->name('create');
                Route::post('/{course}', [LmsController::class, 'storeModule'])->name('store');
                
                Route::prefix('lessons')->name('lessons.')->group(function () {
                    Route::get('/{course}/{module}/create', [LmsController::class, 'createLesson'])->name('create');
                    Route::post('/{course}/{module}', [LmsController::class, 'storeLesson'])->name('store');
                });
            });
        });
        
        Route::prefix('enrollments')->name('enrollments.')->group(function () {
            Route::get('/', [LmsController::class, 'enrollments'])->name('index');
            Route::get('/create', [LmsController::class, 'createEnrollment'])->name('create');
            Route::post('/', [LmsController::class, 'storeEnrollment'])->name('store');
            Route::patch('/{enrollment}/progress', [LmsController::class, 'updateProgress'])->name('update-progress');
        });
        
        Route::prefix('student')->name('student.')->group(function () {
            Route::get('/courses', [LmsController::class, 'studentCourses'])->name('courses');
            Route::get('/course/{course}', [LmsController::class, 'viewCourse'])->name('course');
            Route::post('/enroll/{course}', [LmsController::class, 'enrollInCourse'])->name('enroll');
        });
    });
    
    // Reports routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/enrollment', [ReportsController::class, 'enrollmentReport'])->name('enrollment');
        Route::get('/academic', [ReportsController::class, 'academicReport'])->name('academic');
        Route::get('/financial', [ReportsController::class, 'financialReport'])->name('financial');
        Route::get('/library', [ReportsController::class, 'libraryReport'])->name('library');
        Route::get('/staff', [ReportsController::class, 'staffReport'])->name('staff');
        Route::get('/lms', [ReportsController::class, 'lmsReport'])->name('lms');
        Route::post('/custom', [ReportsController::class, 'generateCustomReport'])->name('custom');
    });

    Route::middleware('super_admin')->group(function () {
        Route::get('/system-settings', [SystemSettingsController::class, 'edit'])->name('system-settings.edit');
        Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');
        
        // Role Management Routes
        Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super-admin,admin'])->group(function () {
            Route::get('/users', [RoleManagementController::class, 'users'])->name('users');
            Route::put('/users/{user}/roles', [RoleManagementController::class, 'updateUserRoles'])->name('users.update-roles');
            Route::get('/roles', [RoleManagementController::class, 'roles'])->name('roles');
            Route::post('/roles', [RoleManagementController::class, 'storeRole'])->name('roles.store');
            Route::put('/roles/{role}', [RoleManagementController::class, 'updateRole'])->name('roles.update');
            Route::delete('/roles/{role}', [RoleManagementController::class, 'destroyRole'])->name('roles.destroy');
            Route::get('/permissions', [RoleManagementController::class, 'permissions'])->name('permissions');
            Route::post('/permissions', [RoleManagementController::class, 'storePermission'])->name('permissions.store');
            Route::delete('/permissions/{permission}', [RoleManagementController::class, 'destroyPermission'])->name('permissions.destroy');
        });
    });
});

require __DIR__.'/auth.php';
// Load online learning routes
require __DIR__.'/online-learning.php';
require __DIR__.'/academic-integration.php';
require __DIR__.'/cpd.php';

// Demo route for Livewire payment
Route::get('/demo/livewire-payment/{student?}', function ($student = null) {
    if ($student) {
        $student = \App\Models\Student::findOrFail($student);
    }
    return view('demo.livewire-payment', compact('student'));
})->name('demo.livewire-payment');
