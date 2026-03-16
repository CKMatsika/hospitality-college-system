# MANUAL FIX INSTRUCTIONS

## CRITICAL FILES TO FIX IMMEDIATELY:

### 1. Accounting Views (Most Important)
- ✅ `resources/views/accounting/accounts.blade.php` - Already fixed
- ✅ `resources/views/accounting/journal.blade.php` - Already fixed  
- 🔄 `resources/views/accounting/invoices.blade.php` - NEEDS FIX
- 🔄 `resources/views/accounting/general-ledger/index.blade.php` - NEEDS FIX
- 🔄 `resources/views/accounting/reports/*.blade.php` - NEEDS FIX

### 2. Academic Integration Views
- 🔄 `resources/views/academic/integration/*.blade.php` - NEEDS FIX

### 3. Financial Views  
- 🔄 `resources/views/financial/*.blade.php` - NEEDS FIX

### 4. Online Learning Views
- 🔄 `resources/views/online-exams/*.blade.php` - NEEDS FIX
- 🔄 `resources/views/online-learning-dashboard.blade.php` - NEEDS FIX

## QUICK FIX METHOD:

### For Each File:
1. Open the file
2. Find: `@extends('layouts.app')`
3. Replace with: `@extends('layouts.qbo')`
4. Save the file

### ALTERNATIVE: VS Code批量替换
1. Open VS Code
2. Ctrl+Shift+F: Find `@extends('layouts.app')`
3. Ctrl+H: Replace with `@extends('layouts.qbo')`
4. Click "Replace All"

### PRIORITY ORDER:
1. 🚨 ACCOUNTING VIEWS (Highest Priority)
2. 🚨 ACADEMIC INTEGRATION
3. ⚠️ FINANCIAL VIEWS
4. ⚠️ ONLINE LEARNING

## FILES ALREADY FIXED:
✅ Accounting Dashboard
✅ Chart of Accounts  
✅ Journal Entries
✅ Accounts Receivable
✅ Accounts Payable
✅ Student Statements
✅ Cashbook
