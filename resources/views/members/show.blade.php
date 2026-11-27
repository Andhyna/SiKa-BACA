@extends('layouts.app')

@section('title', 'Detail Anggota — ' . $member->name)
@section('page_title', 'Profil & Riwayat Anggota')

@section('content')
    @php
        $initials = collect(explode(' ', $member->name))
            ->filter()
            ->take(2)
            ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
            ->implode('');
    @endphp

    <!-- Navigasi Kembali & Edit -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-600 hover:text-unsika-maroon transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Daftar Anggota</span>
        </a>

        <a href="{{ route('members.edit', $member->id) }}"
           class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-xs font-semibold text-amber-900 transition-colors">
            Edit Profil Anggota
        </a>
    </div>

    <!-- Kartu Profil Anggota -->
    <div class="glass-card rounded-2xl p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200/70 pb-5">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-unsika-maroon to-unsika-maroonDark text-unsika-gold flex items-center justify-center text-lg font-bold shadow-xs shrink-0">
                    {{ $initials ?: 'A' }}
                </div>
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-unsika-maroon/10 text-unsika-maroon">
                        {{ $member->member_code }}
                    </span>
                    <h1 class="text-xl font-bold text-zinc-900 mt-1">{{ $member->name }}</h1>
                    <p class="text-xs text-zinc-500">Terdaftar sejak {{ $member->created_at?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <!-- 3 Mini KPI Ringkasan Pinjaman Anggota -->
            <div class="grid grid-cols-3 gap-2.5 shrink-0">
                <div class="px-3.5 py-2.5 rounded-xl bg-zinc-50 border border-zinc-200/80 text-center">
                    <div class="text-[10px] font-semibold uppercase text-zinc-400">Total</div>
                    <div class="text-lg font-bold text-zinc-900 tabular-nums">{{ $totalTransactions }}</div>
                </div>
                <div class="px-3.5 py-2.5 rounded-xl bg-[#FDF7E7] border border-unsika-gold/30 text-center">
                    <div class="text-[10px] font-semibold uppercase text-amber-800">Dipinjam</div>
                    <div class="text-lg font-bold text-zinc-900 tabular-nums">{{ $activeTransactions }}</div>
                </div>
                <div class="px-3.5 py-2.5 rounded-xl bg-[#ECF7F2] border border-emerald-200 text-center">
                    <div class="text-[10px] font-semibold uppercase text-emerald-800">Kembali</div>
                    <div class="text-lg font-bold text-zinc-900 tabular-nums">{{ $returnedTransactions }}</div>
                </div>
            </div>
        </div>

        <!-- Informasi Kontak -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Alamat Email</div>
                <div class="font-semibold text-zinc-800 mt-1">{{ $member->email ?? '-' }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Nomor Telepon / WhatsApp</div>
                <div class="font-mono font-semibold text-zinc-800 mt-1">{{ $member->phone ?? '-' }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-zinc-50/80 border border-zinc-200/60">
                <div class="text-zinc-400">Alamat Domisili</div>
                <div class="font-semibold text-zinc-800 mt-1">{{ $member->address ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Peminjaman Anggota -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-200/70">
            <h2 class="text-sm font-bold text-zinc-900">Riwayat Peminjaman Koleksi</h2>
            <p class="text-[11px] text-zinc-400">Seluruh transaksi peminjaman buku yang tercatat atas nama {{ $member->name }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3 px-5">Kode</th>
                        <th class="py-3 px-4">Daftar Buku</th>
                        <th class="py-3 px-4">Tgl Pinjam</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Tgl Kembali</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-5 text-right">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($borrowings->isNotEmpty())
                        @foreach ($borrowings as $b)
                            <tr class="hover:bg-unsika-maroon/[0.02]">
                                <td class="py-3.5 px-5 font-mono font-semibold text-zinc-700">#{{ $b->id }}</td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    @if ($b->details && $b->details->isNotEmpty())
                                        @foreach ($b->details as $d)
                                            <div class="text-zinc-800">
                                                {{ $d->book->title ?? 'Buku dihapus' }}
                                                <span class="font-mono text-zinc-400">({{ $d->quantity }} eks)</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">{{ \Carbon\Carbon::parse($b->borrowing_date)->format('d M Y') }}</td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">{{ \Carbon\Carbon::parse($b->due_date)->format('d M Y') }}</td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">
                                    {{ $b->return_date ? \Carbon\Carbon::parse($b->return_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4">
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
                                <td class="py-3.5 px-5 text-right text-zinc-500">{{ $b->user->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-8 text-center text-xs text-zinc-400">
                                Anggota ini belum memiliki riwayat peminjaman buku.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection