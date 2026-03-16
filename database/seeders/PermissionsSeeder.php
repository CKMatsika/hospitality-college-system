<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard permissions
            'dashboard.view',
            
            // Student permissions
            'students.view',
            'students.create',
            'students.edit',
            'students.delete',
            'students.export',
            
            // Staff permissions
            'staff.view',
            'staff.create',
            'staff.edit',
            'staff.delete',
            
            // Course permissions
            'courses.view',
            'courses.create',
            'courses.edit',
            'courses.delete',
            
            // Program permissions
            'programs.view',
            'programs.create',
            'programs.edit',
            'programs.delete',
            
            // Academic permissions
            'academic.view',
            'academic.create',
            'academic.edit',
            'academic.delete',
            
            // Finance permissions
            'finance.view',
            'finance.create',
            'finance.edit',
            'finance.delete',
            'finance.reports',
            
            // Accounting permissions
            'accounting.view',
            'accounting.create',
            'accounting.edit',
            'accounting.delete',
            'accounting.reports',
            'accounting.general-ledger',
            'accounting.accounts-receivable',
            'accounting.accounts-payable',
            'accounting.student-statements',
            
            // Library permissions
            'library.view',
            'library.create',
            'library.edit',
            'library.delete',
            
            // Reports permissions
            'reports.view',
            'reports.create',
            'reports.export',
            
            // System permissions
            'system.settings',
            'system.users',
            'system.backup',
            'system.logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin role - has all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin role - has most permissions except system-level
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'dashboard.view',
            'students.view', 'students.create', 'students.edit', 'students.export',
            'staff.view', 'staff.create', 'staff.edit',
            'courses.view', 'courses.create', 'courses.edit',
            'programs.view', 'programs.create', 'programs.edit',
            'academic.view', 'academic.create', 'academic.edit',
            'finance.view', 'finance.create', 'finance.edit', 'finance.reports',
            'accounting.view', 'accounting.create', 'accounting.edit', 'accounting.reports',
            'accounting.general-ledger', 'accounting.accounts-receivable', 'accounting.accounts-payable',
            'accounting.student-statements',
            'library.view', 'library.create', 'library.edit',
            'reports.view', 'reports.create', 'reports.export',
        ]);

        // Finance Manager role - focused on financial operations
        $financeManager = Role::firstOrCreate(['name' => 'finance-manager']);
        $financeManager->givePermissionTo([
            'dashboard.view',
            'students.view',
            'finance.view', 'finance.create', 'finance.edit', 'finance.reports',
            'accounting.view', 'accounting.create', 'accounting.edit', 'accounting.reports',
            'accounting.general-ledger', 'accounting.accounts-receivable', 'accounting.accounts-payable',
            'accounting.student-statements',
            'reports.view', 'reports.create', 'reports.export',
        ]);

        // Academic Manager role - focused on academic operations
        $academicManager = Role::firstOrCreate(['name' => 'academic-manager']);
        $academicManager->givePermissionTo([
            'dashboard.view',
            'students.view', 'students.create', 'students.edit', 'students.export',
            'staff.view', 'staff.create', 'staff.edit',
            'courses.view', 'courses.create', 'courses.edit',
            'programs.view', 'programs.create', 'programs.edit',
            'academic.view', 'academic.create', 'academic.edit',
            'library.view', 'library.create', 'library.edit',
            'reports.view', 'reports.create', 'reports.export',
        ]);

        // Teacher/Lecturer role - focused on teaching activities
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'dashboard.view',
            'students.view',
            'courses.view', 'courses.edit',
            'academic.view', 'academic.create', 'academic.edit',
            'library.view',
            'reports.view',
        ]);

        // Librarian role - focused on library operations
        $librarian = Role::firstOrCreate(['name' => 'librarian']);
        $librarian->givePermissionTo([
            'dashboard.view',
            'students.view',
            'library.view', 'library.create', 'library.edit',
            'reports.view',
        ]);

        // Student role - limited permissions
        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            'dashboard.view',
            'academic.view',
            'library.view',
        ]);

        // Assign super-admin role to first user (if exists)
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasRole('super-admin')) {
            $firstUser->assignRole('super-admin');
        }

        $this->command->info('Permissions and roles created successfully!');
    }
}
