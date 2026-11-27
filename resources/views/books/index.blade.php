@extends('layouts.app')

@section('title', 'Data Buku')
@section('page_title', 'Katalog Koleksi Buku')

@section('content')
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Katalog Koleksi Buku</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola daftar judul buku, klasifikasi kategori, dan ketersediaan stok eksemplar.</p>
        </div>

        <a href="{{ route('books.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-all">
            <svg class="w-4 h-4 text-unsika-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Buku Baru</span>
        </a>
    </div>

    <!-- Bilah Pencarian & Filter -->
    <div class="glass-card rounded-2xl p-4">
        <form action="{{ route('books.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari berdasarkan judul buku, penulis, atau penerbit..."
                       class="w-full pl-10 pr-4 py-2 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-xs font-semibold text-white transition-colors cursor-pointer">
                    Cari Koleksi
                </button>
                @if (request()->filled('search') || request()->filled('category_id'))
                    <a href="{{ route('books.index') }}"
                       class="px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-xs font-medium text-zinc-700 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Buku -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3.5 px-5 w-12">No</th>
                        <th class="py-3.5 px-4">Judul & Penulis</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Penerbit & Tahun</th>
                        <th class="py-3.5 px-4">Stok</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($books->isNotEmpty())
                        @foreach ($books as $index => $book)
                            @php
                                $rowNum = method_exists($books, 'firstItem') ? $books->firstItem() + $index : $index + 1;
                                $pubYear = $book->publication_year ?? $book->year ?? '-';
                            @endphp
                            <tr class="hover:bg-unsika-maroon/[0.02] transition-colors">
                                <td class="py-3.5 px-5 font-mono text-zinc-400 tabular-nums">{{ $rowNum }}</td>
                                <td class="py-3.5 px-4">
                                    <a href="{{ route('books.show', $book->id) }}" class="font-semibold text-zinc-900 hover:text-unsika-maroon transition-colors">
                                        {{ $book->title }}
                                    </a>
                                    <div class="text-[11px] text-zinc-500 mt-0.5">
                                        {{ $book->author ?? 'Penulis tidak dicantumkan' }}
                                        @if (!empty($book->isbn))
                                            <span class="font-mono text-zinc-400"> &bull; ISBN {{ $book->isbn }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-unsika-maroon/8 text-unsika-maroon border border-unsika-maroon/12">
                                        {{ $book->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-600">
                                    <div>{{ $book->publisher ?? '-' }}</div>
                                    <div class="text-[11px] font-mono text-zinc-400 tabular-nums">{{ $pubYear }}</div>
                                </td>
                                <td class="py-3.5 px-4 tabular-nums">
                                    @if ($book->stock <= 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-unsika-maroon border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-unsika-maroon"></span>Habis (0)
                                        </span>
                                    @elseif ($book->stock <= 2)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-unsika-gold"></span>Menipis ({{ $book->stock }} eks)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>{{ $book->stock }} eks
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <a href="{{ route('books.show', $book->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg bg-zinc-100 hover:bg-zinc-200/80 text-[11px] font-semibold text-zinc-700 transition-colors">
                                            Detail
                                        </a>
                                        <a href="{{ route('books.edit', $book->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-[11px] font-semibold text-amber-800 border border-amber-200/70 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus buku {{ addslashes($book->title) }} dari katalog?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-[11px] font-semibold text-unsika-maroon border border-red-200/70 transition-colors cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-10 text-center text-xs text-zinc-400">
                                Tidak ada data buku yang ditemukan.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if (method_exists($books, 'hasPages') && $books->hasPages())
            <div class="px-5 py-3.5 border-t border-zinc-200/70 bg-white/50">
                {{ $books->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection