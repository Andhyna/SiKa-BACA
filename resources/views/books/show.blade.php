@extends('layouts.app')

@section('title', 'Detail Buku — ' . $book->title)
@section('page_title', 'Detail Koleksi Buku')

@section('content')
    @php
        $pubYear = $book->publication_year ?? $book->year ?? '-';
    @endphp

    <!-- Navigasi Kembali & Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-600 hover:text-unsika-maroon transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Katalog Buku</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('books.edit', $book->id) }}"
               class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-xs font-semibold text-amber-900 transition-colors">
                Edit Informasi Buku
            </a>
        </div>
    </div>

    <!-- Kartu Informasi Utama Buku -->
    <div class="glass-card rounded-2xl p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 border-b border-zinc-200/70 pb-5">
            <div class="space-y-1.5">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-unsika-maroon/10 text-unsika-maroon">
                    {{ $book->category->name ?? 'Tanpa Kategori' }}
                </span>
                <h1 class="text-xl font-bold text-zinc-900 leading-snug">{{ $book->title }}</h1>
                <p class="text-xs text-zinc-500">Ditulis oleh <span class="font-semibold text-zinc-700">{{ $book->author ?? '-' }}</span></p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <div class="px-4 py-3 rounded-xl bg-[#FDF7E7] border border-unsika-gold/30 text-center">
                    <div class="text-[11px] font-medium text-amber-900">Tersedia di Rak</div>
                    <div class="text-xl font-bold text-zinc-900 tabular-nums mt-0.5">{{ $book->stock }} <span class="text-xs font-normal text-zinc-500">eks</span></div>
                </div>
                <div class="px-4 py-3 rounded-xl bg-[#F8EFEF] border border-unsika-maroon/15 text-center">
                    <div class="text-[11px] font-medium text-unsika-maroon">Sedang Dipinjam</div>
                    <div class="text-xl font-bold text-zinc-900 tabular-nums mt-0.5">{{ $currentlyBorrowedQty }} <span class="text-xs font-normal text-zinc-500">eks</span></div>
                </div>
            </div>
        </div>

        <!-- Grid Spesifikasi Bibliografi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Kode / ISBN</div>
                <div class="font-mono font-semibold text-zinc-800 mt-1">{{ $book->isbn ?? 'ID #' . $book->id }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Penerbit</div>
                <div class="font-semibold text-zinc-800 mt-1">{{ $book->publisher ?? '-' }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Tahun Terbit</div>
                <div class="font-mono font-semibold text-zinc-800 mt-1 tabular-nums">{{ $pubYear }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Terakhir Diperbarui</div>
                <div class="font-semibold text-zinc-800 mt-1">{{ $book->updated_at?->format('d M Y, H:i') ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman Buku Ini -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-200/70">
            <h2 class="text-sm font-bold text-zinc-900">Riwayat Sirkulasi Buku Ini</h2>
            <p class="text-[11px] text-zinc-400">Daftar anggota yang pernah maupun sedang meminjam koleksi ini</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3 px-5">Kode Pinjam</th>
                        <th class="py-3 px-4">Anggota Peminjam</th>
                        <th class="py-3 px-4">Jumlah</th>
                        <th class="py-3 px-4">Tgl Pinjam</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($borrowings->isNotEmpty())
                        @foreach ($borrowings as $b)
                            @php
                                $qty = $b->details->sum('quantity');
                            @endphp
                            <tr class="hover:bg-unsika-maroon/[0.02]">
                                <td class="py-3.5 px-5 font-mono font-semibold text-zinc-700">#{{ $b->id }}</td>
                                <td class="py-3.5 px-4">
                                    @if ($b->member)
                                        <a href="{{ route('members.show', $b->member->id) }}" class="font-semibold text-zinc-900 hover:text-unsika-maroon">
                                            {{ $b->member->name }}
                                        </a>
                                        <div class="text-[11px] font-mono text-zinc-400">{{ $b->member->member_code }}</div>
                                    @else
                                        <span class="text-zinc-400">Anggota dihapus</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-mono tabular-nums text-zinc-800">{{ $qty }} eks</td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">{{ \Carbon\Carbon::parse($b->borrowing_date)->format('d M Y') }}</td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">{{ \Carbon\Carbon::parse($b->due_date)->format('d M Y') }}</td>
                                <td class="py-3.5 px-5">
                                    @if ($b->status === 'returned')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-unsika-gold"></span>Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-8 text-center text-xs text-zinc-400">
                                Buku ini belum pernah dipinjam oleh anggota mana pun.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection