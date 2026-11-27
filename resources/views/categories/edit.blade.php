@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Ubah Kategori Koleksi')

@section('content')
    <div class="max-w-2xl space-y-5">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-600 hover:text-unsika-maroon transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Daftar Kategori</span>
        </a>

        <div class="glass-card rounded-2xl p-6">
            <div class="border-b border-zinc-200/70 pb-4 mb-5">
                <h1 class="text-lg font-bold text-zinc-900">Edit Kategori: {{ $category->name }}</h1>
                <p class="text-xs text-zinc-500 mt-0.5">Perbarui nama klasifikasi atau keterangan kategori koleksi.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs text-unsika-maroon space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-semibold text-zinc-700 mb-1.5">Nama Kategori <span class="text-unsika-maroon">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold text-zinc-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3.5 py-2.5 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-zinc-200/70">
                    <a href="{{ route('categories.index') }}"
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