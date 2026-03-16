@extends('layouts.qbo')

@section('title', 'Assign Student Fee')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-plus mr-2"></i>
            Assign Student Fee
        </h1>
        <p class="text-gray-600 mt-2">Assign fee structures to students.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('finance.student-fees.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                                <select id="student_id" name="student_id" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Select a student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->full_name }} - {{ $student->student_id }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="fee_structure_id" class="block text-sm font-medium text-gray-700">Fee Structure</label>
                                <select id="fee_structure_id" name="fee_structure_id" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Select a fee structure</option>
                                    @foreach($feeStructures as $feeStructure)
                                        <option value="{{ $feeStructure->id }}" {{ old('fee_structure_id') == $feeStructure->id ? 'selected' : '' }}>
                                            {{ $feeStructure->name }} - {{ $feeStructure->amount }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fee_structure_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                                <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('notes') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Add any additional notes about this fee assignment.</p>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('finance.student-fees.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-user-graduate mr-2"></i> Assign Fee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
