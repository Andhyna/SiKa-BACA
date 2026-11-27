@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page_title', 'Edit Data Buku')

@section('content')
<div class="max-w-2xl space-y-6">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Edit Data Buku</h1>
            <p class="text-xs text-zinc-500 mt-1">Perbarui informasi katalog dan jumlah eksemplar tersedia.</p>
        </div>
        <a href="{{ route('books.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/80 hover:bg-white border border-zinc-200 text-xs font-medium text-zinc-700 transition-colors">
            &larr; Kembali
        </a>
    </div>

    <!-- Alert Error Validasi -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-unsika-maroon space-y-1">
            <div class="font-semibold">Periksa kembali isian formulir:</div>
            @foreach ($errors->all() as $error)
                <div>&bull; {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Form Edit Buku -->
    <form action="{{ route('books.update', $book->id) }}" method="POST" class="glass-card rounded-2xl p-6 sm:p-7 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="category_id" class="block text-xs font-semibold text-zinc-700 mb-1.5">Kategori Buku</label>
            <select id="category_id" name="category_id" required
                    class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="title" class="block text-xs font-semibold text-zinc-700 mb-1.5">Judul Buku</label>
            <input id="title" type="text" name="title" value="{{ old('title', $book->title) }}" required
                   class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
        </div>

        <div>
            <label for="author" class="block text-xs font-semibold text-zinc-700 mb-1.5">Penulis / Pengarang</label>
            <input id="author" type="text" name="author" value="{{ old('author', $book->author) }}" required
                   class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="year" class="block text-xs font-semibold text-zinc-700 mb-1.5">Tahun Terbit</label>
                <input id="year" type="number" name="year" value="{{ old('year', $book->year) }}" min="1900" max="2099" required
                       class="w-full px-3.5 py-2.5 text-sm tabular-nums bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
            </div>

            <div>
                <label for="stock" class="block text-xs font-semibold text-zinc-700 mb-1.5">Jumlah Stok (Eksemplar)</label>
                <input id="stock" type="number" name="stock" value="{{ old('stock', $book->stock) }}" min="0" required
                       class="w-full px-3.5 py-2.5 text-sm tabular-nums bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
            </div>
        </div>

        <div class="pt-2 flex items-center gap-3">
            <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-white text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                Perbarui Data
            </button>
            <a href="{{ route('books.index') }}"
               class="px-4 py-2.5 rounded-xl border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection