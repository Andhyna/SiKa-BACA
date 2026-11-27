@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Manajemen Akun & Hak Akses')

@section('content')
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Manajemen Pengguna Sistem</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola akun Administrator dan Petugas operasional perpustakaan.</p>
        </div>

        <a href="{{ route('users.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-all">
            <svg class="w-4 h-4 text-unsika-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Tabel Pengguna -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3.5 px-5 w-14">No</th>
                        <th class="py-3.5 px-4">Nama Pengguna</th>
                        <th class="py-3.5 px-4">Alamat Email</th>
                        <th class="py-3.5 px-4">Peran (Role)</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($users->isNotEmpty())
                        @foreach ($users as $index => $user)
                            @php
                                $rowNum = method_exists($users, 'firstItem') ? $users->firstItem() + $index : $index + 1;
                                $initial = mb_strtoupper(mb_substr($user->name, 0, 1));
                            @endphp
                            <tr class="hover:bg-unsika-maroon/[0.02] transition-colors">
                                <td class="py-3.5 px-5 font-mono text-zinc-400 tabular-nums">{{ $rowNum }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full {{ $user->role === 'admin' ? 'bg-unsika-maroon text-unsika-gold' : 'bg-zinc-200/80 text-zinc-700' }} flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-zinc-900">{{ $user->name }}</div>
                                            @if (auth()->id() === $user->id)
                                                <span class="text-[10px] font-medium text-unsika-maroon">Sesi aktif Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-600">{{ $user->email }}</td>
                                <td class="py-3.5 px-4">
                                    @if ($user->role === 'admin')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-unsika-goldLight/80 text-amber-900 border border-unsika-gold/30 uppercase">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-zinc-100 text-zinc-700 border border-zinc-200 uppercase">
                                            Petugas
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-500">
                                    {{ $user->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-[11px] font-semibold text-amber-800 border border-amber-200/70 transition-colors">
                                            Edit
                                        </a>
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-[11px] font-semibold text-unsika-maroon border border-red-200/70 transition-colors cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-10 text-center text-xs text-zinc-400">
                                Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if (method_exists($users, 'hasPages') && $users->hasPages())
            <div class="px-5 py-3.5 border-t border-zinc-200/70 bg-white/50">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection