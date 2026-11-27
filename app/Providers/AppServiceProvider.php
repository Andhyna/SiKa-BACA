<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

        $previousHandler = set_error_handler(function ($level, $message, $file = '', $line = 0) use (&$previousHandler) {
    if (
        $level === E_DEPRECATED ||
        $level === E_USER_DEPRECATED ||
        str_contains($message, 'will be required in PHP 9.0')
    ) {
        return true;
    }

    return $previousHandler ? $previousHandler($level, $message, $file, $line) : false;
    });

        View::composer('layouts.app', function ($view) {$currentUser = auth()->user();
            $userName =$currentUser->name ?? 'Pengguna';
            $userRole =$currentUser->role ?? 'petugas';
            $userInitials = collect(explode(' ',$userName))
                ->filter()
                ->take(2)
                ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                ->implode('');

            $lowStockBooks = collect();$overdueBorrowings = collect();
            $latestActivities = collect();$activeMembersList = collect();

            try {
                $lowStockBooks = Book::where('stock', '<=', 2)
                    ->orderBy('stock')
                    ->take(3)
                    ->get();

                $overdueBorrowings = Borrowing::with('member')
                    ->where('status', 'borrowed')
                    ->whereDate('due_date', '<', now())
                    ->take(2)
                    ->get();

                $latestActivities = Borrowing::with(['member', 'user'])
                    ->latest('updated_at')
                    ->take(4)
                    ->get();

                $activeMembersList = Member::latest()
                    ->take(5)
                    ->get();
            } catch (\Throwable $e) {
                // Fallback aman jika tabel belum dimigrasi
            }

            $view->with([
                'userName'          => $userName,
                'userRole'          => $userRole,
                'userInitials'      => $userInitials,
                'lowStockBooks'     => $lowStockBooks,
                'overdueBorrowings' => $overdueBorrowings,
                'latestActivities'  => $latestActivities,
                'activeMembersList' => $activeMembersList,
            ]);
        });
    }
}