<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('category')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'required|integer|min:1900|max:2099',
            'stock'       => 'required|integer|min:0',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku baru berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load('category');

        $borrowings = Borrowing::with([
                'member',
                'user',
                'details' => function ($query) use ($book) {
                    $query->where('book_id', $book->id);
                }
            ])
            ->whereHas('details', function ($query) use ($book) {
                $query->where('book_id', $book->id);
            })
            ->latest('borrowing_date')
            ->get();

        $currentlyBorrowedQty = $borrowings->where('status', 'borrowed')
            ->sum(fn ($b) => $b->details->sum('quantity'));

        return view('books.show', compact('book', 'borrowings', 'currentlyBorrowedQty'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'required|integer|min:1900|max:2099',
            'stock'       => 'required|integer|min:0',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->borrowingDetails()->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena tercatat dalam riwayat peminjaman.');
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}