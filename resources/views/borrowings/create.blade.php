@extends('layouts.app')

@section('title', 'Catat Peminjaman')
@section('page_title', 'Catat Peminjaman Buku Baru')

@section('content')
<div class="max-w-2xl space-y-6">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Catat Peminjaman Buku Baru</h1>
            <p class="text-xs text-zinc-500 mt-1">Pilih anggota peminjam dan koleksi buku yang tersedia. Jatuh tempo otomatis ditetapkan 7 hari.</p>
        </div>
        <a href="{{ route('borrowings.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/80 hover:bg-white border border-zinc-200 text-xs font-medium text-zinc-700 transition-colors">
            &larr; Kembali
        </a>
    </div>

    <!-- Alert Error Validasi -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-unsika-maroon space-y-1">
            <div class="font-semibold">Transaksi tidak dapat diproses:</div>
            @foreach ($errors->all() as $error)
                <div>&bull; {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Form Peminjaman Baru -->
    <form action="{{ route('borrowings.store') }}" method="POST" class="glass-card rounded-2xl p-6 sm:p-7 space-y-5">
        @csrf

        <div>
            <label for="member_id" class="block text-xs font-semibold text-zinc-700 mb-1.5">Pilih Anggota Peminjam</label>
            <select id="member_id" name="member_id" required
                    class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
                <option value="">-- Pilih Anggota --</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                        {{ $member->member_code }} - {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="book_id" class="block text-xs font-semibold text-zinc-700 mb-1.5">Pilih Buku (Hanya stok &gt; 0)</label>
            <select id="book_id" name="book_id" required
                    class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
                <option value="">-- Pilih Buku --</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>
                        {{ $book->title }} (Stok tersedia: {{ $book->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-end">
            <div>
                <label for="quantity" class="block text-xs font-semibold text-zinc-700 mb-1.5">Jumlah Eksemplar Pinjam</label>
                <input id="quantity" type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                       class="w-full px-3.5 py-2.5 text-sm tabular-nums bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
            </div>

            <div class="p-3 rounded-xl bg-unsika-maroon/5 border border-unsika-maroon/10 text-xs text-zinc-600">
                <span class="font-semibold text-unsika-maroon">Estimasi Jatuh Tempo:</span>
                <span class="tabular-nums font-medium text-zinc-800">{{ now()->addDays(7)->translatedFormat('d M Y') }}</span>
            </div>
        </div>

        <div class="pt-2 flex items-center gap-3">
            <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-white text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                Simpan Peminjaman
            </button>
            <a href="{{ route('borrowings.index') }}"
               class="px-4 py-2.5 rounded-xl border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection