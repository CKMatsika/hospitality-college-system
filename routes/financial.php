<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinancialManagementController;

/*
|--------------------------------------------------------------------------
| Financial Management Routes
|--------------------------------------------------------------------------
|
| Routes for comprehensive financial management system
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Financial Dashboard
    Route::get('/financial', [FinancialManagementController::class, 'financialDashboard'])->name('financial.dashboard');
    
    // Banks Management
    Route::prefix('financial/banks')->name('financial.banks.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'banks'])->name('index');
        Route::get('/create', [FinancialManagementController::class, 'createBank'])->name('create');
        Route::post('/', [FinancialManagementController::class, 'storeBank'])->name('store');
        Route::get('/{bank}/edit', [FinancialManagementController::class, 'editBank'])->name('edit');
        Route::put('/{bank}', [FinancialManagementController::class, 'updateBank'])->name('update');
    });
    
    // Bank Accounts Management
    Route::prefix('financial/bank-accounts')->name('financial.bank-accounts.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'bankAccounts'])->name('index');
        Route::get('/create', [FinancialManagementController::class, 'createBankAccount'])->name('create');
        Route::post('/', [FinancialManagementController::class, 'storeBankAccount'])->name('store');
    });
    
    // Bank Transactions Management
    Route::prefix('financial/bank-transactions')->name('financial.bank-transactions.')->group(function () {
        Route::post('/store', [FinancialManagementController::class, 'storeBankTransaction'])->name('store');
        Route::post('/store-multiple', [FinancialManagementController::class, 'storeMultipleBankTransactions'])->name('store-multiple');
        Route::post('/import', [FinancialManagementController::class, 'importBankTransactions'])->name('import');
    });
    
    // Cash Book Management
    Route::prefix('financial/cash-book')->name('financial.cash-book.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'cashBook'])->name('index');
        Route::get('/create', [FinancialManagementController::class, 'createCashBookEntry'])->name('create');
        Route::post('/', [FinancialManagementController::class, 'storeCashBookEntry'])->name('store');
    });
    
    // Receipts Management
    Route::prefix('financial/receipts')->name('financial.receipts.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'receipts'])->name('index');
        Route::get('/create', [FinancialManagementController::class, 'createReceipt'])->name('create');
        Route::post('/', [FinancialManagementController::class, 'storeReceipt'])->name('store');
    });
    
    // Payment Methods Management
    Route::prefix('financial/payment-methods')->name('financial.payment-methods.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'paymentMethods'])->name('index');
        Route::get('/create', [FinancialManagementController::class, 'createPaymentMethod'])->name('create');
        Route::post('/', [FinancialManagementController::class, 'storePaymentMethod'])->name('store');
    });
    
    // Bank Reconciliation
    Route::prefix('financial/reconciliation')->name('financial.reconciliation.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'bankReconciliation'])->name('index');
        Route::post('/{bankAccount}', [FinancialManagementController::class, 'reconcileBank'])->name('reconcile');
        Route::post('/import', [FinancialManagementController::class, 'importBankStatement'])->name('import');
    });
    
    // Enhanced Invoice Management
    Route::prefix('financial/invoices')->name('financial.invoices.')->group(function () {
        Route::get('/', [FinancialManagementController::class, 'enhancedInvoices'])->name('index');
        Route::post('/{invoice}/payment', [FinancialManagementController::class, 'processInvoicePayment'])->name('payment.process');
    });
});
