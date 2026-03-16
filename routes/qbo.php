<?php

use App\Http\Controllers\QBOController;
use App\Http\Controllers\LayoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| QuickBooks Style Routes
|--------------------------------------------------------------------------
|
| Here is where you can register QuickBooks style routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::middleware(['auth'])->group(function () {
    
    // Layout Management
    Route::prefix('layout')->name('layout.')->group(function () {
        Route::get('/current', [LayoutController::class, 'current'])->name('current');
        Route::post('/toggle', [LayoutController::class, 'toggle'])->name('toggle');
    });
    
    // Dashboard
    Route::get('/qbo', [QBOController::class, 'dashboard'])->name('qbo.dashboard');
    
    // API Endpoints for AJAX functionality
    Route::prefix('api/qbo')->group(function () {
        Route::get('/dashboard', [QBOController::class, 'dashboardData'])->name('qbo.api.dashboard');
        Route::get('/search', [QBOController::class, 'search'])->name('qbo.api.search');
        Route::get('/notifications', [QBOController::class, 'notifications'])->name('qbo.api.notifications');
    });
    
    // Sales Routes
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/invoices', function () {
            return view('sales.invoices.index');
        })->name('invoices');
        
        Route::get('/invoices/create', function () {
            return view('sales.invoices.create');
        })->name('invoices.create');
        
        Route::get('/receipts', function () {
            return view('sales.receipts.index');
        })->name('receipts');
    });
    
    // Customers Routes
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', function () {
            return view('customers.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('customers.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('customers.show', compact('id'));
        })->name('show');
    });
    
    // Invoices Routes
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', function () {
            return view('invoices.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('invoices.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('invoices.show', compact('id'));
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('invoices.edit', compact('id'));
        })->name('edit');
    });
    
    // Expenses Routes
    Route::prefix('expenses')->name('expenses.')->group(function () {
        Route::get('/', function () {
            return view('expenses.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('expenses.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('expenses.show', compact('id'));
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('expenses.edit', compact('id'));
        })->name('edit');
    });
    
    // Vendors Routes
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', function () {
            return view('vendors.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('vendors.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('vendors.show', compact('id'));
        })->name('show');
    });
    
    // Banking Routes
    Route::prefix('banking')->name('banking.')->group(function () {
        Route::get('/accounts', function () {
            return view('banking.accounts.index');
        })->name('accounts');
        
        Route::get('/transactions', function () {
            return view('banking.transactions.index');
        })->name('transactions');
        
        Route::get('/reconciliation', function () {
            return view('banking.reconciliation.index');
        })->name('reconciliation');
    });
    
    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/profit-loss', function () {
            return view('reports.profit-loss');
        })->name('profit-loss');
        
        Route::get('/balance-sheet', function () {
            return view('reports.balance-sheet');
        })->name('balance-sheet');
        
        Route::get('/cash-flow', function () {
            return view('reports.cash-flow');
        })->name('cash-flow');
    });
    
    // Payroll Routes
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', function () {
            return view('payroll.index');
        })->name('index');
        
        Route::get('/run-payroll', function () {
            return view('payroll.run');
        })->name('run');
        
        Route::get('/employees', function () {
            return view('payroll.employees.index');
        })->name('employees');
    });
    
    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/company', function () {
            return view('settings.company');
        })->name('company');
        
        Route::get('/users', function () {
            return view('settings.users');
        })->name('users');
        
        Route::get('/integrations', function () {
            return view('settings.integrations');
        })->name('integrations');
    });
    
    // Payments Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/receive', function () {
            return view('payments.receive');
        })->name('receive');
        
        Route::get('/make', function () {
            return view('payments.make');
        })->name('make');
    });
    
    // Transactions Routes
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', function () {
            return view('transactions.index');
        })->name('index');
        
        Route::get('/{id}', function ($id) {
            return view('transactions.show', compact('id'));
        })->name('show');
    });
});
