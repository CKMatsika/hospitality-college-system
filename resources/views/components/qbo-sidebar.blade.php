<!-- QuickBooks Style Sidebar -->
<aside id="sidebar" class="bg-white shadow-lg w-64 min-h-screen transition-all duration-300 fixed left-0 top-0 z-50 lg:relative lg:z-auto">
    
    <!-- Logo Area -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <div class="sidebar-text">
                    <h1 class="text-lg font-bold text-gray-800">Hospitality</h1>
                    <p class="text-xs text-gray-500">College System</p>
                </div>
            </div>
            <button id="sidebarToggle" class="hidden lg:block text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="p-4 space-y-1">
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt sidebar-icon text-lg w-5"></i>
            <span class="sidebar-text font-medium">Dashboard</span>
        </a>
        
        <!-- Academic Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('academic')">
                <i class="fas fa-graduation-cap sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Academic</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="academic-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('students.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate text-xs"></i>
                    <span class="sidebar-text">Students</span>
                </a>
                <a href="{{ route('staff.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher text-xs"></i>
                    <span class="sidebar-text">Staff</span>
                </a>
                <a href="{{ route('courses.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Courses</span>
                </a>
                <a href="{{ route('programs.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('programs.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap text-xs"></i>
                    <span class="sidebar-text">Programs</span>
                </a>
            </div>
        </div>

        <!-- Admissions Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('admissions')">
                <i class="fas fa-user-plus sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Admissions</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="admissions-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('admissions.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('admissions.*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">Admissions Dashboard</span>
                </a>
                <a href="{{ route('applications.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('applications.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt text-xs"></i>
                    <span class="sidebar-text">Applications</span>
                </a>
                <a href="{{ route('lms.enrollments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('lms.enrollments.*') ? 'active' : '' }}">
                    <i class="fas fa-user-check text-xs"></i>
                    <span class="sidebar-text">LMS Enrollments</span>
                </a>
                <a href="{{ route('enrollments.manual.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('enrollments.manual.*') ? 'active' : '' }}">
                    <i class="fas fa-user-plus text-xs"></i>
                    <span class="sidebar-text">Manual Enrollment</span>
                </a>
                <a href="{{ route('enrollments.csv.upload') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('enrollments.csv.*') ? 'active' : '' }}">
                    <i class="fas fa-file-csv text-xs"></i>
                    <span class="sidebar-text">CSV Enrollment</span>
                </a>
            </div>
        </div>
        
        <!-- Financial Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('financial')">
                <i class="fas fa-dollar-sign sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Financial</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="financial-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('finance.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('finance.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line text-xs"></i>
                    <span class="sidebar-text">Finance</span>
                </a>
                <a href="{{ route('accounting.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.*') ? 'active' : '' }}">
                    <i class="fas fa-calculator text-xs"></i>
                    <span class="sidebar-text">Accounting</span>
                </a>
                <a href="{{ route('finance.fee-structures.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-list-alt text-xs"></i>
                    <span class="sidebar-text">Fee Structures</span>
                </a>
                <a href="{{ route('finance.payments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-money-bill-wave text-xs"></i>
                    <span class="sidebar-text">Payments</span>
                </a>
                <a href="{{ route('payroll.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                    <i class="fas fa-users text-xs"></i>
                    <span class="sidebar-text">Payroll</span>
                </a>
                <a href="{{ route('banking.accounts') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('banking.*') ? 'active' : '' }}">
                    <i class="fas fa-university text-xs"></i>
                    <span class="sidebar-text">Banking</span>
                </a>
            </div>
        </div>

        <!-- Academic Integration -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('academic-integration')">
                <i class="fas fa-brain sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Academic Integration</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="academic-integration-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('academic-integration.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('academic-integration.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line text-xs"></i>
                    <span class="sidebar-text">Integration Dashboard</span>
                </a>
                <a href="{{ route('academic-integration.analytics') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-brain text-xs"></i>
                    <span class="sidebar-text">AI Analytics</span>
                </a>
                <a href="{{ route('academic-integration.auto-enrollment') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-robot text-xs"></i>
                    <span class="sidebar-text">Auto-Enrollment</span>
                </a>
                <a href="{{ route('academic-integration.sync-completion') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-sync text-xs"></i>
                    <span class="sidebar-text">Sync Completion</span>
                </a>
            </div>
        </div>

        <!-- Sales Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('sales')">
                <i class="fas fa-shopping-cart sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Sales</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="sales-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('sales.invoices') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice text-xs"></i>
                    <span class="sidebar-text">Sales Invoices</span>
                </a>
                <a href="{{ route('sales.receipts') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-receipt text-xs"></i>
                    <span class="sidebar-text">Receipts</span>
                </a>
                <a href="{{ route('customers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends text-xs"></i>
                    <span class="sidebar-text">Customers</span>
                </a>
            </div>
        </div>

        <!-- Expenses Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('expenses')">
                <i class="fas fa-receipt sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Expenses</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="expenses-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('expenses.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar text-xs"></i>
                    <span class="sidebar-text">Expenses</span>
                </a>
                <a href="{{ route('vendors.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                    <i class="fas fa-truck text-xs"></i>
                    <span class="sidebar-text">Vendors</span>
                </a>
            </div>
        </div>
        
        <!-- Library Management -->
        <a href="{{ route('library.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->routeIs('library.*') ? 'active' : '' }}">
            <i class="fas fa-book-open sidebar-icon text-lg w-5"></i>
            <span class="sidebar-text font-medium">Library</span>
        </a>
        
        <!-- Learning Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('learning')">
                <i class="fas fa-laptop sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Learning</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="learning-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('online-learning.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('online-learning.*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">Learning Dashboard</span>
                </a>
                <a href="{{ route('lms.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('lms.*') ? 'active' : '' }}">
                    <i class="fas fa-laptop text-xs"></i>
                    <span class="sidebar-text">LMS Dashboard</span>
                </a>
                <a href="{{ route('online-learning.exams.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('online-learning.exams.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap text-xs"></i>
                    <span class="sidebar-text">Online Exams</span>
                </a>
                <a href="{{ route('online-learning.lessons.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('online-learning.lessons.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open text-xs"></i>
                    <span class="sidebar-text">Online Lessons</span>
                </a>
                <a href="{{ route('online-learning.assignments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('online-learning.assignments.*') ? 'active' : '' }}">
                    <i class="fas fa-tasks text-xs"></i>
                    <span class="sidebar-text">Assignments</span>
                </a>
                <a href="{{ route('online-learning.certificates.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('online-learning.certificates.*') ? 'active' : '' }}">
                    <i class="fas fa-certificate text-xs"></i>
                    <span class="sidebar-text">Certificates</span>
                </a>
            </div>
        </div>
        
        <!-- CPD Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('cpd')">
                <i class="fas fa-award sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">CPD Management</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="cpd-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('cpd.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">CPD Dashboard</span>
                </a>
                <a href="{{ route('cpd.history') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.history') ? 'active' : '' }}">
                    <i class="fas fa-history text-xs"></i>
                    <span class="sidebar-text">CPD History</span>
                </a>
                <a href="{{ route('cpd.progress') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.progress') ? 'active' : '' }}">
                    <i class="fas fa-chart-line text-xs"></i>
                    <span class="sidebar-text">Level Progress</span>
                </a>
                <a href="{{ route('cpd.external-training') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.external-training*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap text-xs"></i>
                    <span class="sidebar-text">External Training</span>
                </a>
                <a href="{{ route('cpd.certificates') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.certificates') ? 'active' : '' }}">
                    <i class="fas fa-certificate text-xs"></i>
                    <span class="sidebar-text">CPD Certificates</span>
                </a>
                <a href="{{ route('cpd.generate-certificate') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.generate-certificate') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle text-xs"></i>
                    <span class="sidebar-text">Generate Certificate</span>
                </a>
                <a href="{{ route('cpd.analytics') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.analytics') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span class="sidebar-text">CPD Analytics</span>
                </a>
                <a href="{{ route('cpd.verify') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.verify') ? 'active' : '' }}">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span class="sidebar-text">Verify Certificate</span>
                </a>
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
                    <a href="{{ route('cpd.admin.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('cpd.admin.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield text-xs"></i>
                        <span class="sidebar-text">CPD Admin</span>
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Reports -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('reports')">
                <i class="fas fa-chart-bar sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Reports</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="finance-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('finance.reports.revenue') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-dollar-sign text-xs"></i>
                    <span class="sidebar-text">Revenue Report</span>
                </a>
                <a href="{{ route('finance.payments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-money-check-alt text-xs"></i>
                    <span class="sidebar-text">Payments</span>
                </a>
            </div>
        </div>
        
        <!-- Accounting Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('accounting')">
                <i class="fas fa-calculator sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Accounting</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="accounting-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('accounting.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line text-xs"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="{{ route('accounting.accounts') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.accounts*') ? 'active' : '' }}">
                    <i class="fas fa-list-alt text-xs"></i>
                    <span class="sidebar-text">Chart of Accounts</span>
                </a>
                <a href="{{ route('accounting.journal') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.journal*') ? 'active' : '' }}">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Journal Entries</span>
                </a>
                <a href="{{ route('accounting.general-ledger') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-list-ol text-xs"></i>
                    <span class="sidebar-text">General Ledger</span>
                </a>
                <div class="border-t border-gray-200 my-2 pt-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Financial Reports</p>
                </div>
                <a href="{{ route('accounting.reports.trial-balance') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-balance-scale text-xs"></i>
                    <span class="sidebar-text">Trial Balance</span>
                </a>
                <a href="{{ route('accounting.reports.income-statement') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-chart-bar text-xs"></i>
                    <span class="sidebar-text">Income Statement</span>
                </a>
                <a href="{{ route('accounting.reports.balance-sheet') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span class="sidebar-text">Balance Sheet</span>
                </a>
                <a href="{{ route('accounting.reports.cash-flow') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-water text-xs"></i>
                    <span class="sidebar-text">Cash Flow</span>
                </a>
                <a href="{{ route('accounting.invoices') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-file-invoice-dollar text-xs"></i>
                    <span class="sidebar-text">Invoices</span>
                </a>
                <a href="{{ route('accounting.periods') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-calendar-alt text-xs"></i>
                    <span class="sidebar-text">Financial Periods</span>
                </a>
                <div class="border-t border-gray-200 my-2 pt-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Accounts Management</p>
                </div>
                <a href="{{ route('accounting.accounts-receivable') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.accounts-receivable*') ? 'active' : '' }}">
                    <i class="fas fa-arrow-down text-xs"></i>
                    <span class="sidebar-text">Accounts Receivable</span>
                </a>
                <a href="{{ route('accounting.accounts-receivable.aging') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-clock text-xs"></i>
                    <span class="sidebar-text">Aging Report</span>
                </a>
                <a href="{{ route('accounting.accounts-payable') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-arrow-up text-xs"></i>
                    <span class="sidebar-text">Accounts Payable</span>
                </a>
                <a href="{{ route('accounting.student-statements') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.student-statements*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar text-xs"></i>
                    <span class="sidebar-text">Student Statements</span>
                </a>
                <a href="{{ route('accounting.cashbook') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('accounting.cashbook*') ? 'active' : '' }}">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Cashbook</span>
                </a>
            </div>
        </div>
        
        <!-- Settings -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('settings')">
                <i class="fas fa-cog sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Settings</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="settings-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('system-settings.edit') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('system-settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog text-xs"></i>
                    <span class="sidebar-text">System Settings</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user text-xs"></i>
                    <span class="sidebar-text">Profile</span>
                </a>
                @if(Auth::user()->role === 'super_admin')
                    <a href="{{ route('users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog text-xs"></i>
                        <span class="sidebar-text">User Management</span>
                    </a>
                @endif
            </div>
        </div>
        
    </nav>
    
    <!-- Mobile Menu Button -->
    <button id="mobileSidebarToggle" class="lg:hidden fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg z-50">
        <i class="fas fa-bars"></i>
    </button>
    
</aside>

<script>
function toggleSubmenu(menuId) {
    console.log('=== TOGGLE DEBUG START ===');
    console.log('Toggling submenu:', menuId);
    
    const submenu = document.getElementById(menuId + '-submenu');
    const allSubmenus = document.querySelectorAll('[id$="-submenu"]');
    
    console.log('Found submenu element:', submenu);
    console.log('Submenu current classes:', submenu ? submenu.className : 'NOT FOUND');
    console.log('Currently hidden?', submenu ? submenu.classList.contains('hidden') : 'N/A');
    console.log('All submenus found:', allSubmenus.length);
    
    // Close all other submenus
    allSubmenus.forEach(menu => {
        if (menu && menu.id !== menuId + '-submenu') {
            console.log('Closing other submenu:', menu.id);
            menu.classList.add('hidden');
        }
    });
    
    // Toggle current submenu
    if (submenu) {
        submenu.classList.toggle('hidden');
        const isNowHidden = submenu.classList.contains('hidden');
        console.log('After toggle - submenu hidden:', isNowHidden);
        console.log('=== TOGGLE DEBUG END ===');
    } else {
        console.log('ERROR: Submenu not found for menu:', menuId);
    }
}

// Auto-debug on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PAGE LOAD DEBUG ===');
    
    // Check for accounting submenu
    const accountingSubmenu = document.getElementById('accounting-submenu');
    if (accountingSubmenu) {
        console.log('Accounting submenu found on page load');
        console.log('Initial classes:', accountingSubmenu.className);
        console.log('Initially hidden?', accountingSubmenu.classList.contains('hidden'));
    }
    
    // Check for finance submenu
    const financeSubmenu = document.getElementById('finance-submenu');
    if (financeSubmenu) {
        console.log('Finance submenu found on page load');
        console.log('Initial classes:', financeSubmenu.className);
        console.log('Initially hidden?', financeSubmenu.classList.contains('hidden'));
    }
});
</script>
