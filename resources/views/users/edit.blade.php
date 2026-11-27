@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page_title', 'Ubah Akun Pengguna')

@section('content')
    <div class="max-w-2xl space-y-5">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-600 hover:text-unsika-maroon transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Daftar Pengguna</span>
        </a>

        <div class="glass-card rounded-2xl p-6">
            <div class="border-b border-zinc-200/70 pb-4 mb-5">
                <h1 class="text-lg font-bold text-zinc-900">Edit Pengguna: {{ $user->name }}</h1>
                <p class="text-xs text-zinc-500 mt-0.5">Kosongkan kolom kata sandi jika tidak ingin mengganti password akun ini.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs text-unsika-maroon space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-semibold text-zinc-700 mb-1.5">Nama Lengkap <span class="text-unsika-maroon">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-semibold text-zinc-700 mb-1.5">Alamat Email <span class="text-unsika-maroon">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
                    </div>

                    <div>
                        <label for="role" class="block text-xs font-semibold text-zinc-700 mb-1.5">Peran Akses <span class="text-unsika-maroon">*</span></label>
                        <select id="role" name="role" required
                                class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
                            <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas Perpustakaan</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-semibold text-zinc-700 mb-1.5">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password" placeholder="Kosongkan jika tetap"
                               class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-zinc-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
                    </div>
                </div>

                <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-zinc-200/70">
                    <a href="{{ route('users.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-xs font-semibold text-zinc-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-colors cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection