<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Utama untuk 4 Kartu KPI (Termasuk Perbaikan 1: Total Stok Buku)
        $totalBooks = Book::count();
        $totalStock = (int) Book::sum('stock');
        $totalCategories = Category::count();
        $totalMembers = Member::count();
        $totalBorrowings = Borrowing::count();
        $activeBorrowings = Borrowing::where('status', 'borrowed')->count();

        // 2. Data Grafik Garis: Tren Sirkulasi 6 Bulan Terakhir (Pinjam vs Kembali)
        $startSixMonths = now()->subMonths(5)->startOfMonth();
        $borrowingsSixMonths = Borrowing::whereDate('borrowing_date', '>=', $startSixMonths)->get();

        $monthLabels = [];
        $monthlyBorrowedData = [];
        $monthlyReturnedData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $ym = $monthDate->format('Y-m');
            $monthLabels[] = $monthDate->translatedFormat('M Y');

            $monthlyBorrowedData[] = $borrowingsSixMonths->filter(function ($item) use ($ym) {
                return Carbon::parse($item->borrowing_date)->format('Y-m') === $ym;
            })->count();

            $monthlyReturnedData[] = $borrowingsSixMonths->filter(function ($item) use ($ym) {
                return $item->status === 'returned'
                    && $item->return_date
                    && Carbon::parse($item->return_date)->format('Y-m') === $ym;
            })->count();
        }

        // 3. Data Progress Bar: Sebaran Judul Buku per Kategori
        $categoriesDistribution = Category::withCount('books')
            ->orderByDesc('books_count')
            ->take(6)
            ->get();

        // 4. Data Vertical Pill Bar: Aktivitas Peminjaman 7 Hari Terakhir
        $startSevenDays = now()->subDays(6)->startOfDay();
        $borrowingsSevenDays = Borrowing::whereDate('borrowing_date', '>=', $startSevenDays)->get();

        $dayLabels = [];
        $dailyBorrowingData = [];

        for ($d = 6; $d >= 0; $d--) {
            $dayDate = now()->subDays($d);
            $ymd = $dayDate->format('Y-m-d');
            $dayLabels[] = $dayDate->translatedFormat('d M');

            $dailyBorrowingData[] = $borrowingsSevenDays->filter(function ($item) use ($ymd) {
                return Carbon::parse($item->borrowing_date)->format('Y-m-d') === $ymd;
            })->count();
        }

        // 5. Data Donut Chart: Proporsi Status Eksemplar Buku
        $activeRecords = Borrowing::with('details')->where('status', 'borrowed')->get();

        $borrowedOnTimeCount = $activeRecords->filter(function ($item) {
            return Carbon::parse($item->due_date)->gte(now()->startOfDay());
        })->sum(fn($item) => $item->details->sum('quantity'));

        $overdueCount = $activeRecords->filter(function ($item) {
            return Carbon::parse($item->due_date)->lt(now()->startOfDay());
        })->sum(fn($item) => $item->details->sum('quantity'));

        // 6. Tabel Transaksi Peminjaman Terbaru
        $recentBorrowings = Borrowing::with(['member', 'user', 'details.book'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooks',
            'totalStock',
            'totalCategories',
            'totalMembers',
            'totalBorrowings',
            'activeBorrowings',
            'monthLabels',
            'monthlyBorrowedData',
            'monthlyReturnedData',
            'categoriesDistribution',
            'dayLabels',
            'dailyBorrowingData',
            'borrowedOnTimeCount',
            'overdueCount',
            'recentBorrowings'
        ));
    }
}