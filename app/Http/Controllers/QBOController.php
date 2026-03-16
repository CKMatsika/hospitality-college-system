<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Vendor;

class QBOController extends Controller
{
    /**
     * Display the QuickBooks style dashboard.
     */
    public function dashboard()
    {
        // Get dashboard data
        $stats = [
            'totalRevenue' => $this->getTotalRevenue(),
            'totalExpenses' => $this->getTotalExpenses(),
            'netProfit' => $this->getNetProfit(),
            'cashBalance' => $this->getCashBalance(),
        ];

        $recentTransactions = $this->getRecentTransactions();
        $invoiceStatus = $this->getInvoiceStatus();
        $cashFlowData = $this->getCashFlowData();

        return view('qbo-dashboard', compact('stats', 'recentTransactions', 'invoiceStatus', 'cashFlowData'));
    }

    /**
     * Get total revenue
     */
    private function getTotalRevenue(): float
    {
        return Invoice::where('status', 'paid')->sum('total') ?? 0;
    }

    /**
     * Get total expenses
     */
    private function getTotalExpenses(): float
    {
        return Expense::sum('amount') ?? 0;
    }

    /**
     * Get net profit
     */
    private function getNetProfit(): float
    {
        return $this->getTotalRevenue() - $this->getTotalExpenses();
    }

    /**
     * Get cash balance
     */
    private function getCashBalance(): float
    {
        // This would typically come from bank accounts
        return 89432.10; // Example value
    }

    /**
     * Get recent transactions
     */
    private function getRecentTransactions(): array
    {
        // Combine recent invoices and expenses
        $invoices = Invoice::with('customer')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'date' => $invoice->created_at->format('Y-m-d'),
                    'description' => 'Invoice #' . $invoice->invoice_number . ' - ' . ($invoice->customer->name ?? 'N/A'),
                    'category' => 'Sales',
                    'amount' => $invoice->total,
                    'status' => ucfirst($invoice->status),
                    'type' => 'income'
                ];
            });

        $expenses = Expense::latest()
            ->take(5)
            ->get()
            ->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'date' => $expense->date->format('Y-m-d'),
                    'description' => $expense->description,
                    'category' => $expense->category ?? 'General',
                    'amount' => -$expense->amount,
                    'status' => ucfirst($expense->status ?? 'completed'),
                    'type' => 'expense'
                ];
            });

        return $invoices->concat($expenses)
            ->sortByDesc('date')
            ->take(10)
            ->values()
            ->toArray();
    }

    /**
     * Get invoice status summary
     */
    private function getInvoiceStatus(): array
    {
        return [
            'paid' => Invoice::where('status', 'paid')->count(),
            'unpaid' => Invoice::where('status', 'unpaid')->count(),
            'overdue' => Invoice::where('status', 'overdue')->count(),
            'draft' => Invoice::where('status', 'draft')->count(),
        ];
    }

    /**
     * Get cash flow data for charts
     */
    private function getCashFlowData(): array
    {
        // This would typically aggregate data by month
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'revenue' => [30000, 35000, 32000, 38000, 42000, 45231],
            'expenses' => [15000, 18000, 14000, 16000, 13000, 12456],
        ];
    }

    /**
     * API endpoint for dashboard data
     */
    public function dashboardData(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month'); // month, quarter, year

        $data = [
            'stats' => [
                'totalRevenue' => $this->getTotalRevenue(),
                'totalExpenses' => $this->getTotalExpenses(),
                'netProfit' => $this->getNetProfit(),
                'cashBalance' => $this->getCashBalance(),
            ],
            'recentTransactions' => $this->getRecentTransactions(),
            'invoiceStatus' => $this->getInvoiceStatus(),
            'cashFlowData' => $this->getCashFlowData(),
        ];

        return response()->json($data);
    }

    /**
     * Search functionality
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // Search customers
        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($customer) {
                return [
                    'type' => 'customer',
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'url' => route('customers.show', $customer->id)
                ];
            });

        // Search invoices
        $invoices = Invoice::where('invoice_number', 'like', "%{$query}%")
            ->orWhereHas('customer', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->take(5)
            ->get()
            ->map(function ($invoice) {
                return [
                    'type' => 'invoice',
                    'id' => $invoice->id,
                    'name' => 'Invoice #' . $invoice->invoice_number,
                    'customer' => $invoice->customer->name ?? 'N/A',
                    'amount' => $invoice->total,
                    'url' => route('invoices.show', $invoice->id)
                ];
            });

        // Search expenses
        $expenses = Expense::where('description', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($expense) {
                return [
                    'type' => 'expense',
                    'id' => $expense->id,
                    'name' => $expense->description,
                    'amount' => $expense->amount,
                    'date' => $expense->date->format('M d, Y'),
                    'url' => route('expenses.show', $expense->id)
                ];
            });

        $results = $customers->concat($invoices)->concat($expenses);

        return response()->json(['results' => $results]);
    }

    /**
     * Get notifications
     */
    public function notifications(Request $request): JsonResponse
    {
        $notifications = [
            [
                'id' => 1,
                'type' => 'info',
                'title' => 'New invoice created',
                'message' => 'Invoice #1234 for John Doe - $1,250.00',
                'time' => '2 minutes ago',
                'read' => false
            ],
            [
                'id' => 2,
                'type' => 'success',
                'title' => 'Payment received',
                'message' => 'Customer ABC paid $500.00',
                'time' => '1 hour ago',
                'read' => false
            ],
            [
                'id' => 3,
                'type' => 'warning',
                'title' => 'Expense due tomorrow',
                'message' => 'Office rent payment due',
                'time' => '3 hours ago',
                'read' => false
            ]
        ];

        return response()->json($notifications);
    }
}
