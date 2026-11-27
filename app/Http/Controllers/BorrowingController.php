<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Menampilkan daftar seluruh transaksi peminjaman & pengembalian
     */
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'user', 'details.book'])
            ->latest()
            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Menampilkan form transaksi peminjaman baru
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::where('stock', '>', 0)->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    /**
     * Memvalidasi stok, menyimpan transaksi peminjaman, dan mengurangi stok buku
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id'   => 'required|exists:books,id',
            'quantity'  => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Aturan bisnis: tolak transaksi jika jumlah pinjaman melebihi stok tersedia
        if ($book->stock < $validated['quantity']) {
            return back()
                ->withErrors(['quantity' => 'Stok buku tidak mencukupi. Stok tersedia: ' . $book->stock])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $book) {
            $borrowing = Borrowing::create([
                'user_id'        => auth()->id(),
                'member_id'      => $validated['member_id'],
                'borrowing_date' => now()->toDateString(),
                'due_date'       => now()->addDays(7)->toDateString(),
                'status'         => 'borrowed',
            ]);

            $borrowing->details()->create([
                'book_id'  => $book->id,
                'quantity' => $validated['quantity'],
            ]);

            $book->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Transaksi peminjaman berhasil disimpan dan stok buku telah diperbarui.');
    }

    /**
     * Memproses pengembalian buku dan menambah kembali stok buku
     */
    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Transaksi ini sudah berstatus dikembalikan.');
        }

        $borrowing->load('details.book');

        DB::transaction(function () use ($borrowing) {
            $borrowing->update([
                'return_date' => now()->toDateString(),
                'status'      => 'returned',
            ]);

            foreach ($borrowing->details as $detail) {
                $detail->book->increment('stock', $detail->quantity);
            }
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan dan stok telah bertambah kembali.');
    }
}