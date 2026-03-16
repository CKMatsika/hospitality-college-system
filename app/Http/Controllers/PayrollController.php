<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Payroll;
use App\Models\PayrollItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('staff')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $totalStaff = Staff::count();
        $activeStaff = Staff::where('status', 'active')->count();
        $totalPayrollThisMonth = Payroll::whereMonth('pay_date', now()->month)
            ->whereYear('pay_date', now()->year)
            ->sum('total_amount');
        
        return view('payroll.index', compact('payrolls', 'totalStaff', 'activeStaff', 'totalPayrollThisMonth'));
    }

    public function run()
    {
        $activeStaff = Staff::where('status', 'active')->get();
        
        return view('payroll.run', compact('activeStaff'));
    }

    public function processPayroll(Request $request)
    {
        $request->validate([
            'pay_date' => 'required|date',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'selected_staff' => 'required|array',
            'selected_staff.*' => 'exists:staff,id'
        ]);

        DB::beginTransaction();
        try {
            $payroll = Payroll::create([
                'pay_date' => $request->pay_date,
                'pay_period_start' => $request->pay_period_start,
                'pay_period_end' => $request->pay_period_end,
                'status' => 'processed',
                'total_amount' => 0,
                'total_staff' => count($request->selected_staff)
            ]);

            $totalAmount = 0;
            foreach ($request->selected_staff as $staffId) {
                $staff = Staff::find($staffId);
                $baseSalary = $staff->salary ?? 0;
                $allowances = $request->input("allowances.{$staffId}", 0);
                $deductions = $request->input("deductions.{$staffId}", 0);
                $grossPay = $baseSalary + $allowances;
                $netPay = $grossPay - $deductions;

                PayrollItem::create([
                    'payroll_id' => $payroll->id,
                    'staff_id' => $staffId,
                    'base_salary' => $baseSalary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'gross_pay' => $grossPay,
                    'net_pay' => $netPay
                ]);

                $totalAmount += $netPay;
            }

            $payroll->update(['total_amount' => $totalAmount]);
            DB::commit();

            return redirect()->route('payroll.index')
                ->with('success', 'Payroll processed successfully for ' . count($request->selected_staff) . ' staff members.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error processing payroll: ' . $e->getMessage());
        }
    }

    public function employees()
    {
        $staff = Staff::with('payrollItems')
            ->orderBy('last_name')
            ->paginate(10);
        
        return view('payroll.employees.index', compact('staff'));
    }

    public function showPayroll($id)
    {
        $payroll = Payroll::with(['staff', 'payrollItems.staff'])
            ->findOrFail($id);
        
        return view('payroll.show', compact('payroll'));
    }

    public function payslip($payrollId, $staffId)
    {
        $payrollItem = PayrollItem::with(['payroll', 'staff'])
            ->where('payroll_id', $payrollId)
            ->where('staff_id', $staffId)
            ->firstOrFail();
        
        return view('payroll.payslip', compact('payrollItem'));
    }
}
