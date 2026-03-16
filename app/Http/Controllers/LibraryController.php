<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\BookReservation;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::where('status', 'available')->count(),
            'borrowed_books' => BookLoan::where('status', 'borrowed')->count(),
            'overdue_books' => BookLoan::where('status', 'borrowed')->where('due_date', '<', now())->count(),
        ];

        $recentLoans = BookLoan::with(['book', 'borrowable'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('library.dashboard', compact('stats', 'recentLoans'));
    }

    // Books Management
    public function books()
    {
        $books = Book::with('category')
            ->orderBy('title')
            ->paginate(10);
        
        return view('library.books.index', compact('books'));
    }

    public function createBook()
    {
        $categories = BookCategory::all();
        return view('library.books.create', compact('categories'));
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'required|exists:book_categories,id',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
        ]);

        $book = Book::create(array_merge($validated, [
            'available_copies' => $validated['total_copies'],
            'status' => 'available',
        ]));

        return redirect()->route('library.books.show', $book)
            ->with('success', 'Book added successfully.');
    }

    public function showBook(Book $book)
    {
        $book->load(['category', 'loans.borrowable']);
        return view('library.books.show', compact('book'));
    }

    // Book Loans Management
    public function loans()
    {
        $loans = BookLoan::with(['book', 'borrowable'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('library.loans.index', compact('loans'));
    }

    public function createLoan()
    {
        $availableBooks = Book::where('available_copies', '>', 0)->get();
        $students = Student::where('status', 'active')->get();
        $staff = Staff::where('status', 'active')->get();
        
        return view('library.loans.create', compact('availableBooks', 'students', 'staff'));
    }

    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_type' => 'required|in:student,staff',
            'borrower_id' => 'required|integer',
            'due_date' => 'required|date|after:today',
        ]);

        $book = Book::find($validated['book_id']);
        
        if ($book->available_copies <= 0) {
            return redirect()->back()
                ->with('error', 'This book is not available for borrowing.');
        }

        BookLoan::create([
            'book_id' => $validated['book_id'],
            'borrowable_type' => $validated['borrower_type'] === 'student' ? Student::class : Staff::class,
            'borrowable_id' => $validated['borrower_id'],
            'borrow_date' => now(),
            'due_date' => $validated['due_date'],
            'status' => 'borrowed',
        ]);

        // Update book available copies
        $book->decrement('available_copies');

        return redirect()->route('library.loans')
            ->with('success', 'Book borrowed successfully.');
    }

    public function returnBook(BookLoan $loan)
    {
        if ($loan->status !== 'borrowed') {
            return redirect()->back()
                ->with('error', 'This book has already been returned.');
        }

        $loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        // Update book available copies
        $loan->book->increment('available_copies');

        return redirect()->route('library.loans')
            ->with('success', 'Book returned successfully.');
    }

    // Book Reservations
    public function reservations()
    {
        $reservations = BookReservation::with(['book', 'reservable'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('library.reservations.index', compact('reservations'));
    }

    public function createReservation()
    {
        $books = Book::all();
        $students = Student::where('status', 'active')->get();
        $staff = Staff::where('status', 'active')->get();
        
        return view('library.reservations.create', compact('books', 'students', 'staff'));
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'reserver_type' => 'required|in:student,staff',
            'reserver_id' => 'required|integer',
        ]);

        BookReservation::create([
            'book_id' => $validated['book_id'],
            'reservable_type' => $validated['reserver_type'] === 'student' ? Student::class : Staff::class,
            'reservable_id' => $validated['reserver_id'],
            'status' => 'pending',
        ]);

        return redirect()->route('library.reservations')
            ->with('success', 'Book reserved successfully.');
    }

    // Categories Management
    public function categories()
    {
        $categories = BookCategory::withCount('books')
            ->orderBy('name')
            ->paginate(10);
        
        return view('library.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:book_categories,name',
            'description' => 'nullable|string',
        ]);

        BookCategory::create($validated);

        return redirect()->route('library.categories')
            ->with('success', 'Category created successfully.');
    }
}
