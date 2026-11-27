<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login beserta statistik ringkas koleksi
     */
    public function showLogin()
    {
        $bookCount = 0;
        $memberCount = 0;

        try {
            $bookCount = Book::count();
            $memberCount = Member::count();
        } catch (\Throwable $e) {
            // Fallback aman jika tabel belum dimigrasi
        }

        return view('auth.login', compact('bookCount', 'memberCount'));
    }

    /**
     * Memproses data login yang diinputkan user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('books.index'));
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password tidak sesuai.',
            ])
            ->onlyInput('email');
    }

    /**
     * Memproses aksi logout (keluar dari sistem)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}