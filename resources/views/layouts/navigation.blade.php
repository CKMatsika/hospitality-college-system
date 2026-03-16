<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        {{ __('Dashboard') }}
                    </a>
                    
                    <!-- Public Application -->
                    <a href="{{ route('applications.create.public') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-600 bg-white hover:text-blue-700 focus:outline-none transition ease-in-out duration-150">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        {{ __('Apply Now') }}
                    </a>
                    
                    <!-- Academic Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('Academic') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Students</div>
                                <x-dropdown-link :href="route('students.index')">
                                    <i class="fas fa-list mr-2"></i> All Students
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('students.create')">
                                    <i class="fas fa-plus mr-2"></i> Add Student
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Applications</div>
                                <x-dropdown-link :href="route('applications.index')">
                                    <i class="fas fa-file-alt mr-2"></i> All Applications
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('applications.create')">
                                    <i class="fas fa-plus mr-2"></i> New Application
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Enrollment</div>
                                <x-dropdown-link :href="route('enrollments.manual.index')">
                                    <i class="fas fa-user-graduate mr-2"></i> Manual Enrollment
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('enrollments.csv.upload')">
                                    <i class="fas fa-file-csv mr-2"></i> CSV Import
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Staff</div>
                                <x-dropdown-link :href="route('staff.index')">
                                    <i class="fas fa-list mr-2"></i> All Staff
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('staff.create')">
                                    <i class="fas fa-plus mr-2"></i> Add Staff
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Programs</div>
                                <x-dropdown-link :href="route('programs.index')">
                                    <i class="fas fa-list mr-2"></i> All Programs
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('programs.create')">
                                    <i class="fas fa-plus mr-2"></i> Add Program
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Courses</div>
                                <x-dropdown-link :href="route('courses.index')">
                                    <i class="fas fa-list mr-2"></i> All Courses
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('courses.create')">
                                    <i class="fas fa-plus mr-2"></i> Add Course
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- Finance Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('Finance') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Dashboard</div>
                                <x-dropdown-link :href="route('finance.dashboard')">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Finance Dashboard
                                </x-dropdown-link>
                                <x-dropdown-link href="/qbo" class="text-purple-600">
                                    <i class="fas fa-chart-line mr-2"></i> QuickBooks Style Dashboard
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Fee Management</div>
                                <x-dropdown-link :href="route('finance.fee-structures.index')">
                                    <i class="fas fa-list-alt mr-2"></i> Fee Structures
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('finance.fee-structures.create')">
                                    <i class="fas fa-plus mr-2"></i> Add Fee Structure
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('finance.student-fees.index')">
                                    <i class="fas fa-user-graduate mr-2"></i> Student Fees
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('finance.student-fees.create')">
                                    <i class="fas fa-plus mr-2"></i> Assign Fee
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Payments</div>
                                <x-dropdown-link :href="route('finance.payments.index')">
                                    <i class="fas fa-money-bill-wave mr-2"></i> All Payments
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('finance.payments.create')">
                                    <i class="fas fa-plus mr-2"></i> Record Payment
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Financial Management</div>
                                <x-dropdown-link :href="route('financial.dashboard')">
                                    <i class="fas fa-chart-line mr-2"></i> Financial Dashboard
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.banks.index')">
                                    <i class="fas fa-university mr-2"></i> Banks & Transactions
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.bank-accounts.index')">
                                    <i class="fas fa-list-alt mr-2"></i> Bank Accounts
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.cash-book.index')">
                                    <i class="fas fa-money-bill-wave mr-2"></i> Cash Book
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.receipts.index')">
                                    <i class="fas fa-receipt mr-2"></i> Receipts
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.payment-methods.index')">
                                    <i class="fas fa-credit-card mr-2"></i> Payment Methods
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.reconciliation.index')">
                                    <i class="fas fa-sync-alt mr-2"></i> Bank Reconciliation
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.invoices.index')">
                                    <i class="fas fa-file-invoice-dollar mr-2"></i> Enhanced Invoices
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Accounting</div>
                                <x-dropdown-link :href="route('accounting.dashboard')">
                                    <i class="fas fa-calculator mr-2"></i> Accounting Dashboard
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('accounting.general-ledger')">
                                    <i class="fas fa-book mr-2"></i> General Ledger
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('accounting.accounts-receivable')">
                                    <i class="fas fa-hand-holding-usd mr-2"></i> Accounts Receivable
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('accounting.accounts-receivable.aging')">
                                    <i class="fas fa-clock mr-2"></i> A/R Aging
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('accounting.accounts-payable')">
                                    <i class="fas fa-credit-card mr-2"></i> Accounts Payable
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('accounting.student-statements')">
                                    <i class="fas fa-file-invoice mr-2"></i> Student Statements
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('accounting.journal')">
                                    <i class="fas fa-list mr-2"></i> Journal Entries
                                </x-dropdown-link>
                            </div>
                            @auth
                                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                                    <div class="py-1 border-t border-gray-100">
                                        <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">System Administration</div>
                                        <x-dropdown-link :href="route('admin.users')">
                                            <i class="fas fa-users mr-2"></i> User Management
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.roles')">
                                            <i class="fas fa-shield-alt mr-2"></i> Role Management
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.permissions')">
                                            <i class="fas fa-key mr-2"></i> Permissions
                                        </x-dropdown-link>
                                    </div>
                                @endif
                            @endauth
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Quick Actions</div>
                                <x-dropdown-link :href="route('financial.banks.index')" class="text-green-600">
                                    <i class="fas fa-plus-circle mr-2"></i> Add Transaction
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.cash-book.create')" class="text-blue-600">
                                    <i class="fas fa-money-bill mr-2"></i> Cash Entry
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('financial.receipts.create')" class="text-purple-600">
                                    <i class="fas fa-file-invoice mr-2"></i> Generate Receipt
                                </x-dropdown-link>
                            </div>
                            @auth
                                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                                    <div class="py-1 border-t border-gray-100">
                                        <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">System Administration</div>
                                        <x-dropdown-link :href="route('admin.users')">
                                            <i class="fas fa-users mr-2"></i> User Management
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.roles')">
                                            <i class="fas fa-shield-alt mr-2"></i> Role Management
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.permissions')">
                                            <i class="fas fa-key mr-2"></i> Permissions
                                        </x-dropdown-link>
                                    </div>
                                @endif
                            @endauth
                            
                            <!-- Modern Features Section -->
                        </x-slot>
                    </x-dropdown>

                    <!-- Library Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('Library') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Dashboard</div>
                                <x-dropdown-link :href="route('library.dashboard')">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Library Dashboard
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Books</div>
                                <x-dropdown-link :href="route('library.books.index')">
                                    <i class="fas fa-book mr-2"></i> All Books
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('library.books.create')">
                                    <i class="fas fa-plus mr-2"></i> Add Book
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Loans</div>
                                <x-dropdown-link :href="route('library.loans.index')">
                                    <i class="fas fa-hand-holding mr-2"></i> All Loans
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('library.loans.create')">
                                    <i class="fas fa-plus mr-2"></i> Borrow Book
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Reservations</div>
                                <x-dropdown-link :href="route('library.reservations.index')">
                                    <i class="fas fa-bookmark mr-2"></i> All Reservations
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('library.reservations.create')">
                                    <i class="fas fa-plus mr-2"></i> Reserve Book
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- LMS Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('LMS') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Dashboard</div>
                                <x-dropdown-link :href="route('lms.dashboard')">
                                    <i class="fas fa-tachometer-alt mr-2"></i> LMS Dashboard
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Online Courses</div>
                                <x-dropdown-link :href="route('lms.courses.index')">
                                    <i class="fas fa-play-circle mr-2"></i> All Courses
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('lms.courses.create')">
                                    <i class="fas fa-plus mr-2"></i> Create Course
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Enrollments</div>
                                <x-dropdown-link :href="route('lms.enrollments.index')">
                                    <i class="fas fa-user-plus mr-2"></i> All Enrollments
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('lms.enrollments.create')">
                                    <i class="fas fa-plus mr-2"></i> Enroll Student
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Student Portal</div>
                                <x-dropdown-link :href="route('lms.student.courses')">
                                    <i class="fas fa-laptop mr-2"></i> Student Portal
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- Online Learning Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('Online Learning') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Exams</div>
                                <x-dropdown-link :href="route('online-learning.exams.index')">
                                    <i class="fas fa-graduation-cap mr-2"></i> All Exams
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('online-learning.exams.create')">
                                    <i class="fas fa-plus mr-2"></i> Create Exam
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Lessons</div>
                                <x-dropdown-link :href="route('online-learning.lessons.index')">
                                    <i class="fas fa-play-circle mr-2"></i> All Lessons
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('online-learning.lessons.create')">
                                    <i class="fas fa-plus mr-2"></i> Create Lesson
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Assignments</div>
                                <x-dropdown-link :href="route('online-learning.assignments.index')">
                                    <i class="fas fa-tasks mr-2"></i> All Assignments
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('online-learning.assignments.create')">
                                    <i class="fas fa-plus mr-2"></i> Create Assignment
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Certificates</div>
                                <x-dropdown-link :href="route('online-learning.certificates.index')">
                                    <i class="fas fa-certificate mr-2"></i> My Certificates
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('online-learning.certificates.verify', 'demo')">
                                    <i class="fas fa-check-circle mr-2"></i> Verify Certificate
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- Academic Integration Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('Academic Integration') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Dashboard</div>
                                <x-dropdown-link :href="route('academic-integration.dashboard')">
                                    <i class="fas fa-chart-line mr-2"></i> Integration Dashboard
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Analytics</div>
                                <x-dropdown-link :href="route('academic-integration.analytics')">
                                    <i class="fas fa-brain mr-2"></i> AI Analytics
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Automation</div>
                                <x-dropdown-link :href="route('academic-integration.auto-enrollment')">
                                    <i class="fas fa-robot mr-2"></i> Auto-Enrollment
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('academic-integration.sync-completion')">
                                    <i class="fas fa-sync mr-2"></i> Sync Completion
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">AI Features</div>
                                <x-dropdown-link :href="route('academic-integration.recommendations', auth()->user()->student ?? 1)">
                                    <i class="fas fa-magic mr-2"></i> AI Recommendations
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- CPD Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('CPD') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Dashboard</div>
                                <x-dropdown-link :href="route('cpd.dashboard')">
                                    <i class="fas fa-chart-line mr-2"></i> CPD Dashboard
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cpd.progress')">
                                    <i class="fas fa-trophy mr-2"></i> Level Progress
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Activities</div>
                                <x-dropdown-link :href="route('cpd.history')">
                                    <i class="fas fa-history mr-2"></i> CPD History
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cpd.external-training')">
                                    <i class="fas fa-external-link-alt mr-2"></i> External Training
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Certificates</div>
                                <x-dropdown-link :href="route('cpd.certificates')">
                                    <i class="fas fa-certificate mr-2"></i> My Certificates
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cpd.generate-certificate')">
                                    <i class="fas fa-plus mr-2"></i> Generate Certificate
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cpd.verify')">
                                    <i class="fas fa-check-circle mr-2"></i> Verify Certificate
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Analytics</div>
                                <x-dropdown-link :href="route('cpd.analytics')">
                                    <i class="fas fa-chart-bar mr-2"></i> CPD Analytics
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- Reports Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{ __('Reports') }}
                                <svg class="ms-2 -me-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Reports Center</div>
                                <x-dropdown-link :href="route('reports.index')">
                                    <i class="fas fa-chart-pie mr-2"></i> Reports Center
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Academic Reports</div>
                                <x-dropdown-link :href="route('reports.enrollment')">
                                    <i class="fas fa-users mr-2"></i> Enrollment Reports
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reports.academic')">
                                    <i class="fas fa-book mr-2"></i> Academic Reports
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">Financial Reports</div>
                                <x-dropdown-link :href="route('reports.financial')">
                                    <i class="fas fa-dollar-sign mr-2"></i> Financial Reports
                                </x-dropdown-link>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">System Reports</div>
                                <x-dropdown-link :href="route('reports.library')">
                                    <i class="fas fa-book-open mr-2"></i> Library Reports
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reports.staff')">
                                    <i class="fas fa-chalkboard-teacher mr-2"></i> Staff Reports
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reports.lms')">
                                    <i class="fas fa-laptop mr-2"></i> LMS Reports
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if(Auth::user()->role === 'super_admin')
                            <x-dropdown-link :href="route('system-settings.edit')">
                                <i class="fas fa-cog mr-2"></i> {{ __('System Settings') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
