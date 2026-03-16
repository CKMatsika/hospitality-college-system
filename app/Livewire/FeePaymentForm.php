<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\StudentFee;
use App\Models\FeePayment;
use Livewire\Component;

class FeePaymentForm extends Component
{
    public $student;
    public $selectedFees = [];
    public $paymentMethod = 'cash';
    public $amount = 0;
    public $referenceNumber = '';
    public $paymentDate;
    public $notes = '';

    protected $rules = [
        'paymentMethod' => 'required|string',
        'amount' => 'required|numeric|min:0.01',
        'referenceNumber' => 'nullable|string',
        'paymentDate' => 'required|date',
        'notes' => 'nullable|string',
    ];

    public function mount(Student $student)
    {
        $this->student = $student;
        $this->paymentDate = now()->format('Y-m-d');
        $this->student->load(['fees' => function($query) {
            $query->where('balance', '>', 0);
        }]);
    }

    public function updatedSelectedFees()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->amount = 0;
        
        foreach ($this->selectedFees as $feeId) {
            $fee = $this->student->fees->find($feeId);
            if ($fee) {
                $this->amount += $fee->balance;
            }
        }
    }

    public function processPayment()
    {
        $this->validate();

        if (empty($this->selectedFees)) {
            $this->addError('selectedFees', 'Please select at least one fee to pay.');
            return;
        }

        // Create payment record
        $payment = FeePayment::create([
            'student_fee_id' => $this->selectedFees[0], // Primary fee
            'amount' => $this->amount,
            'payment_method' => $this->paymentMethod,
            'payment_date' => $this->paymentDate,
            'reference_number' => $this->referenceNumber,
            'notes' => $this->notes,
            'status' => 'completed',
        ]);

        // Update fee balances
        $remainingAmount = $this->amount;
        foreach ($this->selectedFees as $feeId) {
            $fee = StudentFee::find($feeId);
            if ($fee && $remainingAmount > 0) {
                $paymentAmount = min($fee->balance, $remainingAmount);
                $fee->paid += $paymentAmount;
                $fee->balance -= $paymentAmount;
                $fee->save();
                $remainingAmount -= $paymentAmount;
            }
        }

        // Reset form
        $this->reset(['selectedFees', 'amount', 'referenceNumber', 'notes']);
        $this->paymentDate = now()->format('Y-m-d');
        
        // Refresh student data
        $this->student->load(['fees' => function($query) {
            $query->where('balance', '>', 0);
        }]);

        $this->dispatch('payment-processed', studentId: $this->student->id);
        
        session()->flash('success', 'Payment processed successfully!');
    }

    public function render()
    {
        return view('livewire.fee-payment-form');
    }
}
