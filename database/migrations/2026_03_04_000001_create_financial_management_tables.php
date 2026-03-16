<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code')->unique();
            $table->string('bank_name');
            $table->string('account_number')->nullable();
            $table->enum('account_type', ['checking', 'savings', 'business', 'investment']);
            $table->string('branch_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained()->cascadeOnDelete();
            $table->string('account_name');
            $table->string('account_number')->nullable();
            $table->enum('account_type', ['checking', 'savings', 'business', 'investment', 'credit_card']);
            $table->string('currency', 3)->default('USD');
            $table->decimal('balance', 14, 2)->default(0);
            $table->decimal('available_balance', 14, 2)->default(0);
            $table->decimal('overdraft_limit', 14, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name');
            $table->enum('method_type', ['cash', 'bank_transfer', 'mobile_money', 'credit_card', 'debit_card', 'online_payment', 'check']);
            $table->string('provider')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('supports_refunds')->default(false);
            $table->decimal('fees', 8, 2)->default(0);
            $table->decimal('daily_limit', 14, 2)->nullable();
            $table->decimal('monthly_limit', 14, 2)->nullable();
            $table->json('integration_config')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->date('receipt_date');
            $table->decimal('amount', 14, 2);
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->enum('category', ['tuition', 'fees', 'accommodation', 'meals', 'transport', 'supplies', 'other']);
            $table->string('received_from')->nullable();
            $table->foreignId('bank_account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('payment_status')->default(true);
            $table->string('receipt_path')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('cash_books', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->enum('category', ['income', 'expense', 'transfer', 'adjustment']);
            $table->decimal('debit_amount', 14, 2)->default(0);
            $table->decimal('credit_amount', 14, 2)->default(0);
            $table->decimal('balance', 14, 2);
            $table->enum('transaction_type', ['receipt', 'payment', 'transfer', 'adjustment']);
            $table->string('reference')->nullable();
            $table->foreignId('bank_account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('receipt_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->decimal('amount', 14, 2);
            $table->enum('transaction_type', ['deposit', 'withdrawal', 'transfer', 'fee', 'interest']);
            $table->string('reference')->nullable();
            $table->foreignId('bank_account_id')->constrained()->cascadeOnDelete();
            $table->decimal('balance_before', 14, 2)->default(0);
            $table->decimal('balance_after', 14, 2);
            $table->enum('category', ['operational', 'investment', 'loan', 'fee', 'transfer']);
            $table->json('tags')->nullable();
            $table->boolean('reconciled')->default(false);
            $table->date('reconciliation_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
        Schema::dropIfExists('cash_books');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('banks');
    }
};
