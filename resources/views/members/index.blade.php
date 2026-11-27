@extends('layouts.app')

@section('title', 'Data Anggota')
@section('page_title', 'Manajemen Anggota Perpustakaan')

@section('content')
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Data Anggota Perpustakaan</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola identitas pemustaka terdaftar dan pantau riwayat peminjaman masing-masing anggota.</p>
        </div>

        <a href="{{ route('members.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-all">
            <svg class="w-4 h-4 text-unsika-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Daftarkan Anggota</span>
        </a>
    </div>

    <!-- Bilah Pencarian -->
    <div class="glass-card rounded-2xl p-4">
        <form action="{{ route('members.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama anggota, kode anggota (MBR-xxx), atau email..."
                       class="w-full pl-10 pr-4 py-2 text-xs bg-zinc-50/80 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:outline-none transition-all">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-xs font-semibold text-white transition-colors cursor-pointer">
                    Cari Anggota
                </button>
                @if (request()->filled('search'))
                    <a href="{{ route('members.index') }}"
                       class="px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-xs font-medium text-zinc-700 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Anggota -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3.5 px-5">Kode Anggota</th>
                        <th class="py-3.5 px-4">Nama Lengkap</th>
                        <th class="py-3.5 px-4">Kontak & Email</th>
                        <th class="py-3.5 px-4">Alamat</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($members->isNotEmpty())
                        @foreach ($members as $member)
                            @php
                                $initial = mb_strtoupper(mb_substr($member->name, 0, 1));
                            @endphp
                            <tr class="hover:bg-unsika-maroon/[0.02] transition-colors">
                                <td class="py-3.5 px-5 font-mono font-semibold text-unsika-maroon">
                                    {{ $member->member_code }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-unsika-maroon/10 text-unsika-maroon flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ $initial }}
                                        </div>
                                        <a href="{{ route('members.show', $member->id) }}" class="font-semibold text-zinc-900 hover:text-unsika-maroon transition-colors">
                                            {{ $member->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-600">
                                    <div>{{ $member->email ?? '-' }}</div>
                                    <div class="text-[11px] font-mono text-zinc-400">{{ $member->phone ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-500 max-w-xs truncate">
                                    {{ $member->address ?? '-' }}
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <a href="{{ route('members.show', $member->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg bg-zinc-100 hover:bg-zinc-200/80 text-[11px] font-semibold text-zinc-700 transition-colors">
                                            Detail
                                        </a>
                                        <a href="{{ route('members.edit', $member->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-[11px] font-semibold text-amber-800 border border-amber-200/70 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Hapus data anggota {{ addslashes($member->name) }}?')" class="inline">
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
                            <td colspan="5" class="py-10 text-center text-xs text-zinc-400">
                                Belum ada data anggota terdaftar.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if (method_exists($members, 'hasPages') && $members->hasPages())
            <div class="px-5 py-3.5 border-t border-zinc-200/70 bg-white/50">
                {{ $members->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection