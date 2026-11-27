@extends('layouts.app')

@section('title', 'Sirkulasi Pinjam')
@section('page_title', 'Sirkulasi Peminjaman & Pengembalian')

@section('content')
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Sirkulasi Peminjaman Buku</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Catat transaksi peminjaman baru, pantau tenggat waktu, dan proses pengembalian buku.</p>
        </div>

        <a href="{{ route('borrowings.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-all">
            <svg class="w-4 h-4 text-unsika-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Transaksi Peminjaman Baru</span>
        </a>
    </div>

    <!-- Tabel Sirkulasi Peminjaman -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-4">Anggota Peminjam</th>
                        <th class="py-3.5 px-4">Daftar Buku</th>
                        <th class="py-3.5 px-4">Tgl Pinjam & Tempo</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Petugas</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($borrowings->isNotEmpty())
                        @foreach ($borrowings as $borrowing)
                            @php
                                $isOverdue = $borrowing->status === 'borrowed' && \Carbon\Carbon::parse($borrowing->due_date)->lt(now()->startOfDay());
                            @endphp
                            <tr class="hover:bg-unsika-maroon/[0.02] transition-colors">
                                <td class="py-3.5 px-5 font-mono font-semibold text-zinc-700">#{{ $borrowing->id }}</td>
                                <td class="py-3.5 px-4">
                                    @if ($borrowing->member)
                                        <a href="{{ route('members.show', $borrowing->member->id) }}" class="font-semibold text-zinc-900 hover:text-unsika-maroon">
                                            {{ $borrowing->member->name }}
                                        </a>
                                        <div class="text-[11px] font-mono text-zinc-400">{{ $borrowing->member->member_code }}</div>
                                    @else
                                        <span class="text-zinc-400">Anggota dihapus</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    @if ($borrowing->details && $borrowing->details->isNotEmpty())
                                        @foreach ($borrowing->details as $detail)
                                            <div class="text-zinc-800">
                                                {{ $detail->book->title ?? 'Buku dihapus' }}
                                                <span class="font-mono text-zinc-400">({{ $detail->quantity }} eks)</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 tabular-nums">
                                    <div class="text-zinc-700">Pinjam: {{ \Carbon\Carbon::parse($borrowing->borrowing_date)->format('d M Y') }}</div>
                                    <div class="text-[11px] {{ $isOverdue ? 'text-unsika-maroon font-semibold' : 'text-zinc-400' }}">
                                        Tempo: {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($borrowing->status === 'returned')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Dikembalikan
                                        </span>
                                        @if ($borrowing->return_date)
                                            <div class="text-[10px] text-zinc-400 mt-1 tabular-nums">{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') }}</div>
                                        @endif
                                    @elseif ($isOverdue)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-unsika-maroon border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-unsika-maroon"></span>Terlambat
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-unsika-gold"></span>Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-zinc-500">
                                    {{ $borrowing->user->name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        @if ($borrowing->status === 'borrowed')
                                            <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku untuk transaksi #{{ $borrowing->id }}?')" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-[11px] font-semibold text-white shadow-2xs transition-colors cursor-pointer">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-2.5 py-1 text-[11px] font-medium text-zinc-400">Selesai</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-10 text-center text-xs text-zinc-400">
                                Belum ada catatan transaksi peminjaman.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if (method_exists($borrowings, 'hasPages') && $borrowings->hasPages())
            <div class="px-5 py-3.5 border-t border-zinc-200/70 bg-white/50">
                {{ $borrowings->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection