@extends('layouts.app')

@section('title', 'Kategori Koleksi')
@section('page_title', 'Klasifikasi Kategori Buku')

@section('content')
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Kategori Koleksi Buku</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Pengelompokan subjek literatur dan distribusi jumlah judul di setiap klasifikasi.</p>
        </div>

        @can('manage-categories')
            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-all">
                <svg class="w-4 h-4 text-unsika-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Kategori</span>
            </a>
        @else
            <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-amber-50/90 border border-amber-200/80 text-xs font-medium text-amber-900">
                <span class="w-2 h-2 rounded-full bg-unsika-gold"></span>
                <span>Mode Lihat Saja (Akses Petugas)</span>
            </span>
        @endcan
    </div>

    <!-- Tabel Kategori -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3.5 px-5 w-14">No</th>
                        <th class="py-3.5 px-4">Nama Kategori</th>
                        <th class="py-3.5 px-4">Deskripsi</th>
                        <th class="py-3.5 px-4">Jumlah Koleksi</th>
                        @can('manage-categories')
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($categories->isNotEmpty())
                        @foreach ($categories as $index => $category)
                            @php
                                $rowNum = method_exists($categories, 'firstItem') ? $categories->firstItem() + $index : $index + 1;
                                $bookTotal = $category->books_count ?? $category->books()->count();
                            @endphp
                            <tr class="hover:bg-unsika-maroon/[0.02] transition-colors">
                                <td class="py-3.5 px-5 font-mono text-zinc-400 tabular-nums">{{ $rowNum }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-zinc-900">{{ $category->name }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-500 max-w-md">
                                    {{ $category->description ?? 'Tidak ada keterangan tambahan.' }}
                                </td>
                                <td class="py-3.5 px-4 tabular-nums">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-unsika-maroon/8 text-unsika-maroon border border-unsika-maroon/12">
                                        {{ $bookTotal }} Judul
                                    </span>
                                </td>
                                @can('manage-categories')
                                    <td class="py-3.5 px-5 text-right">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                               class="px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-[11px] font-semibold text-amber-800 border border-amber-200/70 transition-colors">
                                                Edit
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-[11px] font-semibold text-unsika-maroon border border-red-200/70 transition-colors cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="py-10 text-center text-xs text-zinc-400">
                                Belum ada data kategori koleksi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if (method_exists($categories, 'hasPages') && $categories->hasPages())
            <div class="px-5 py-3.5 border-t border-zinc-200/70 bg-white/50">
                {{ $categories->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection