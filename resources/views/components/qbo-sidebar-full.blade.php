<!-- Complete QuickBooks Style Sidebar for Entire Application -->
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
        <a href="/qbo" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors {{ request()->is('qbo') ? 'active' : '' }}">
            <i class="fas fa-chart-line sidebar-icon text-lg w-5"></i>
            <span class="sidebar-text font-medium">QBO Dashboard</span>
        </a>
        
        <!-- Academic Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('academic')">
                <i class="fas fa-graduation-cap sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Academic</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="academic-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('students.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-user-graduate text-xs"></i>
                    <span class="sidebar-text">Students</span>
                </a>
                <a href="{{ route('courses.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Courses</span>
                </a>
                <a href="{{ route('programs.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-list text-xs"></i>
                    <span class="sidebar-text">Programs</span>
                </a>
                <a href="{{ route('subjects.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-book-open text-xs"></i>
                    <span class="sidebar-text">Subjects</span>
                </a>
                <a href="{{ route('lms.enrollments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-user-plus text-xs"></i>
                    <span class="sidebar-text">Enrollments</span>
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
                <a href="{{ route('finance.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">Finance Dashboard</span>
                </a>
                <a href="{{ route('finance.fee-structures.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-list-alt text-xs"></i>
                    <span class="sidebar-text">Fee Structures</span>
                </a>
                <a href="{{ route('finance.student-fees.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-user-graduate text-xs"></i>
                    <span class="sidebar-text">Student Fees</span>
                </a>
                <a href="{{ route('finance.payments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-money-bill text-xs"></i>
                    <span class="sidebar-text">Payments</span>
                </a>
                <a href="{{ route('financial.cash-book.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Cash Book</span>
                </a>
                <a href="{{ route('financial.banks.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-university text-xs"></i>
                    <span class="sidebar-text">Bank Accounts</span>
                </a>
            </div>
        </div>
        
        <!-- Accounting System -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('accounting')">
                <i class="fas fa-calculator sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Accounting</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="accounting-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('accounting.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span class="sidebar-text">Accounting Dashboard</span>
                </a>
                <a href="{{ route('accounting.general-ledger') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">General Ledger</span>
                </a>
                <a href="{{ route('accounting.accounts-receivable') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-hand-holding-usd text-xs"></i>
                    <span class="sidebar-text">Accounts Receivable</span>
                </a>
                <a href="{{ route('accounting.accounts-payable') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-credit-card text-xs"></i>
                    <span class="sidebar-text">Accounts Payable</span>
                </a>
                <a href="{{ route('accounting.student-statements') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-file-invoice text-xs"></i>
                    <span class="sidebar-text">Student Statements</span>
                </a>
                <a href="{{ route('accounting.journal') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-list text-xs"></i>
                    <span class="sidebar-text">Journal Entries</span>
                </a>
            </div>
        </div>
        
        <!-- Library Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('library')">
                <i class="fas fa-book sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Library</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="library-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('library.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">Library Dashboard</span>
                </a>
                <a href="{{ route('library.books.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Books</span>
                </a>
                <a href="{{ route('library.members.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-users text-xs"></i>
                    <span class="sidebar-text">Members</span>
                </a>
                <a href="{{ route('library.issues.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-exchange-alt text-xs"></i>
                    <span class="sidebar-text">Issues & Returns</span>
                </a>
            </div>
        </div>
        
        <!-- Staff Management -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('staff')">
                <i class="fas fa-users-cog sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Staff</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="staff-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('staff.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-users text-xs"></i>
                    <span class="sidebar-text">All Staff</span>
                </a>
                <a href="{{ route('staff.teachers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-chalkboard-teacher text-xs"></i>
                    <span class="sidebar-text">Teachers</span>
                </a>
                <a href="{{ route('staff.administrative.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-user-tie text-xs"></i>
                    <span class="sidebar-text">Administrative</span>
                </a>
                <a href="{{ route('payroll.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-money-check text-xs"></i>
                    <span class="sidebar-text">Payroll</span>
                </a>
            </div>
        </div>
        
        <!-- LMS (Learning Management System) -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('lms')">
                <i class="fas fa-laptop sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">LMS</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="lms-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('lms.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">LMS Dashboard</span>
                </a>
                <a href="{{ route('lms.courses.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-book text-xs"></i>
                    <span class="sidebar-text">Online Courses</span>
                </a>
                <a href="{{ route('lms.assignments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-tasks text-xs"></i>
                    <span class="sidebar-text">Assignments</span>
                </a>
                <a href="{{ route('lms.exams.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-clipboard-list text-xs"></i>
                    <span class="sidebar-text">Exams</span>
                </a>
                <a href="{{ route('certificates.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-certificate text-xs"></i>
                    <span class="sidebar-text">Certificates</span>
                </a>
            </div>
        </div>
        
        <!-- Reports -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('reports')">
                <i class="fas fa-chart-bar sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Reports</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="reports-submenu" class="ml-4 space-y-1 hidden">
                <a href="{{ route('reports.academic') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-graduation-cap text-xs"></i>
                    <span class="sidebar-text">Academic Reports</span>
                </a>
                <a href="{{ route('reports.financial') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-dollar-sign text-xs"></i>
                    <span class="sidebar-text">Financial Reports</span>
                </a>
                <a href="{{ route('reports.attendance') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-calendar-check text-xs"></i>
                    <span class="sidebar-text">Attendance Reports</span>
                </a>
                <a href="{{ route('reports.performance') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-chart-line text-xs"></i>
                    <span class="sidebar-text">Performance Reports</span>
                </a>
            </div>
        </div>
        
        <!-- System Administration -->
        @auth
            @if(auth()->user()->hasRole(['super-admin', 'admin']))
                <div class="sidebar-section">
                    <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('admin')">
                        <i class="fas fa-cog sidebar-icon text-lg w-5"></i>
                        <span class="sidebar-text font-medium">Admin</span>
                        <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
                    </div>
                    <div id="admin-submenu" class="ml-4 space-y-1 hidden">
                        <a href="/admin/users" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-users text-xs"></i>
                            <span class="sidebar-text">User Management</span>
                        </a>
                        <a href="/admin/roles" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-shield-alt text-xs"></i>
                            <span class="sidebar-text">Role Management</span>
                        </a>
                        <a href="/admin/permissions" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-key text-xs"></i>
                            <span class="sidebar-text">Permissions</span>
                        </a>
                        <a href="{{ route('system-settings.edit') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-cog text-xs"></i>
                            <span class="sidebar-text">System Settings</span>
                        </a>
                    </div>
                </div>
            @endif
        @endauth
        
        <!-- Modern Features -->
        <div class="sidebar-section">
            <div class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer" onclick="toggleSubmenu('modern')">
                <i class="fas fa-rocket sidebar-icon text-lg w-5"></i>
                <span class="sidebar-text font-medium">Modern Features</span>
                <i class="fas fa-chevron-down sidebar-text ml-auto text-xs"></i>
            </div>
            <div id="modern-submenu" class="ml-4 space-y-1 hidden">
                <a href="http://localhost:8000/admin" target="_blank" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span class="sidebar-text">Filament Admin</span>
                </a>
                <a href="{{ route('demo.livewire-payment', 3) }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-bolt text-xs"></i>
                    <span class="sidebar-text">Livewire Demo</span>
                </a>
                <a href="/api/documentation" target="_blank" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-code text-xs"></i>
                    <span class="sidebar-text">API Documentation</span>
                </a>
                <a href="http://localhost:8000/horizon" target="_blank" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                    <i class="fas fa-tasks text-xs"></i>
                    <span class="sidebar-text">Laravel Horizon</span>
                </a>
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
    const submenu = document.getElementById(menuId + '-submenu');
    const allSubmenus = document.querySelectorAll('[id$="-submenu"]');
    
    // Close all other submenus
    allSubmenus.forEach(menu => {
        if (menu.id !== menuId + '-submenu') {
            menu.classList.add('hidden');
        }
    });
    
    // Toggle current submenu
    submenu.classList.toggle('hidden');
}
</script>
