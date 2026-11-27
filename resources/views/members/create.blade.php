@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('page_title', 'Tambah Anggota Baru')

@section('content')
<div class="max-w-2xl space-y-6">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Tambah Anggota Baru</h1>
            <p class="text-xs text-zinc-500 mt-1">Daftarkan anggota perpustakaan baru untuk layanan sirkulasi peminjaman.</p>
        </div>
        <a href="{{ route('members.index') }}"
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

    <!-- Form Tambah Anggota -->
    <form action="{{ route('members.store') }}" method="POST" class="glass-card rounded-2xl p-6 sm:p-7 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="member_code" class="block text-xs font-semibold text-zinc-700 mb-1.5">Kode Anggota</label>
                <input id="member_code" type="text" name="member_code" value="{{ old('member_code') }}" required
                       placeholder="Contoh: MBR-001"
                       class="w-full px-3.5 py-2.5 text-sm font-mono bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold text-zinc-700 mb-1.5">No. Telepon / WhatsApp</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                       placeholder="Contoh: 081234567890"
                       class="w-full px-3.5 py-2.5 text-sm tabular-nums bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
            </div>
        </div>

        <div>
            <label for="name" class="block text-xs font-semibold text-zinc-700 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                   placeholder="Masukkan nama lengkap anggota"
                   class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
        </div>

        <div>
            <label for="address" class="block text-xs font-semibold text-zinc-700 mb-1.5">Alamat Domisili</label>
            <textarea id="address" name="address" rows="3"
                      placeholder="Masukkan alamat lengkap anggota (opsional)"
                      class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">{{ old('address') }}</textarea>
        </div>

        <div class="pt-2 flex items-center gap-3">
            <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-white text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                Simpan Anggota
            </button>
            <a href="{{ route('members.index') }}"
               class="px-4 py-2.5 rounded-xl border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection 