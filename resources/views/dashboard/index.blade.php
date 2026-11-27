@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')
@section('page_title', 'Ringkasan Operasional')

@section('content')
    <!-- HEADER SAMBUTAN & AKSI CEPAT -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Ikhtisar Perpustakaan</h1>
            <p class="text-xs text-zinc-500 mt-0.5">
                Selamat datang kembali, <span class="font-semibold text-zinc-700">{{ auth()->user()->name ?? 'Petugas' }}</span>. Pantau stok koleksi dan sirkulasi hari ini.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('books.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/80 hover:bg-white border border-zinc-200/90 text-xs font-semibold text-zinc-700 shadow-2xs transition-all">
                <svg class="w-3.5 h-3.5 text-unsika-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Buku</span>
            </a>
            <a href="{{ route('borrowings.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-xs font-semibold text-white shadow-xs transition-all">
                <svg class="w-3.5 h-3.5 text-unsika-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Catat Peminjaman</span>
            </a>
        </div>
    </div>

    <!-- BARIS 1: 4 KARTU METRIK KPI (GAYA SNOWUI DENGAN TINT WARNA HALUS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Kartu 1: Total Judul Buku -->
        <div class="rounded-2xl p-5 bg-[#F8EFEF]/90 border border-unsika-maroon/12 backdrop-blur-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-unsika-maroon/80">Total Judul Buku</span>
                <span class="w-7 h-7 rounded-lg bg-unsika-maroon/10 text-unsika-maroon flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
            </div>
            <div class="mt-3 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-zinc-900 tabular-nums">{{ number_format($totalBooks) }}</div>
                <span class="text-[11px] font-medium text-unsika-maroon">{{ $totalCategories }} kategori</span>
            </div>
        </div>

        <!-- Kartu 2: Total Stok Buku (PERBAIKAN KODE 1) -->
        <div class="rounded-2xl p-5 bg-[#FDF7E7]/90 border border-unsika-gold/25 backdrop-blur-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-900/80">Total Stok Buku</span>
                <span class="w-7 h-7 rounded-lg bg-unsika-gold/20 text-amber-900 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-zinc-900 tabular-nums">{{ number_format($totalStock) }}</div>
                <span class="text-[11px] font-medium text-amber-800">Eksemplar siap</span>
            </div>
        </div>

        <!-- Kartu 3: Anggota Terdaftar -->
        <div class="rounded-2xl p-5 bg-[#EEF3F8]/90 border border-slate-300/60 backdrop-blur-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-700">Anggota Terdaftar</span>
                <span class="w-7 h-7 rounded-lg bg-slate-200/80 text-slate-700 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-zinc-900 tabular-nums">{{ number_format($totalMembers) }}</div>
                <span class="text-[11px] font-medium text-slate-600">Pemustaka aktif</span>
            </div>
        </div>

        <!-- Kartu 4: Peminjaman Aktif -->
        <div class="rounded-2xl p-5 bg-[#ECF7F2]/90 border border-emerald-200/80 backdrop-blur-md transition-transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-900/80">Sedang Dipinjam</span>
                <span class="w-7 h-7 rounded-lg bg-emerald-500/15 text-emerald-700 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </span>
            </div>
            <div class="mt-3 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-zinc-900 tabular-nums">{{ number_format($activeBorrowings) }}</div>
                <span class="text-[11px] font-medium text-emerald-700">dari {{ $totalBorrowings }} transaksi</span>
            </div>
        </div>
    </div>

    <!-- BARIS 2: LINE CHART TREN SIRKULASI (KIRI) & SEBARAN KATEGORI (KANAN) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Line Chart: Tren Sirkulasi 6 Bulan -->
        <div class="lg:col-span-8 glass-card rounded-2xl p-5 flex flex-col justify-between">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                <div>
                    <h2 class="text-sm font-bold text-zinc-900">Tren Sirkulasi Koleksi</h2>
                    <p class="text-[11px] text-zinc-400">Perbandingan transaksi peminjaman dan pengembalian (6 bulan terakhir)</p>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <span class="inline-flex items-center gap-1.5 font-medium text-zinc-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-unsika-maroon"></span>Peminjaman
                    </span>
                    <span class="inline-flex items-center gap-1.5 font-medium text-zinc-500">
                        <span class="w-2.5 h-2.5 rounded-full bg-unsika-gold"></span>Pengembalian
                    </span>
                </div>
            </div>
            <div class="relative h-60 w-full">
                <canvas id="circulationTrendChart"></canvas>
            </div>
        </div>

        <!-- Progress List: Sebaran Koleksi per Kategori -->
        <div class="lg:col-span-4 glass-card rounded-2xl p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-zinc-900">Koleksi per Kategori</h2>
                        <p class="text-[11px] text-zinc-400">Proporsi judul buku terdata</p>
                    </div>
                    <a href="{{ route('categories.index') }}" class="text-[11px] font-semibold text-unsika-maroon hover:underline">Detail</a>
                </div>

                <div class="space-y-3.5">
                    @php
                        $maxCatCount = max($categoriesDistribution->max('books_count') ?? 1, 1);
                    @endphp
                    @if ($categoriesDistribution->isNotEmpty())
                        @foreach ($categoriesDistribution as $cat)
                            @php
                                $pct = round(($cat->books_count / $maxCatCount) * 100);
                            @endphp
                            <div>
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-medium text-zinc-700 truncate pr-2">{{ $cat->name }}</span>
                                    <span class="font-mono text-[11px] font-semibold text-zinc-900 tabular-nums">{{ $cat->books_count }} judul</span>
                                </div>
                                <div class="w-full h-1.5 bg-zinc-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-unsika-maroon to-unsika-gold" style="width: {{ max($pct, 6) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-xs text-zinc-400 py-6 text-center">Belum ada kategori buku.</p>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-zinc-100 flex items-center justify-between text-[11px] text-zinc-500">
                <span>Total Klasifikasi</span>
                <span class="font-semibold text-zinc-800">{{ $totalCategories }} Kategori</span>
            </div>
        </div>
    </div>

    <!-- BARIS 3: VERTICAL PILL BAR (7 HARI) & DONUT CHART (STATUS STOK) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Vertical Pill Bar Chart: Aktivitas 7 Hari -->
        <div class="lg:col-span-6 glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-sm font-bold text-zinc-900">Aktivitas Peminjaman Harian</h2>
                    <p class="text-[11px] text-zinc-400">Frekuensi transaksi 7 hari terakhir</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-unsika-maroon/8 text-[11px] font-semibold text-unsika-maroon">7 Hari</span>
            </div>
            <div class="relative h-52 w-full">
                <canvas id="dailyPillChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart: Status Ketersediaan Eksemplar -->
        <div class="lg:col-span-6 glass-card rounded-2xl p-5 flex flex-col justify-between">
            <div>
                <h2 class="text-sm font-bold text-zinc-900">Status Ketersediaan Eksemplar</h2>
                <p class="text-[11px] text-zinc-400">Perbandingan stok di rak terhadap buku yang beredar</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4 my-2">
                <div class="relative h-44 flex items-center justify-center">
                    <canvas id="stockStatusDonut"></canvas>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="inline-flex items-center gap-2 text-zinc-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#801818]"></span>Tersedia di Rak
                        </span>
                        <span class="font-bold text-zinc-900 tabular-nums">{{ number_format($totalStock) }} eks</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="inline-flex items-center gap-2 text-zinc-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#C5931D]"></span>Dipinjam (Aktif)
                        </span>
                        <span class="font-bold text-zinc-900 tabular-nums">{{ number_format($borrowedOnTimeCount) }} eks</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="inline-flex items-center gap-2 text-zinc-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#3F3F46]"></span>Lewat Jatuh Tempo
                        </span>
                        <span class="font-bold text-zinc-900 tabular-nums">{{ number_format($overdueCount) }} eks</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 4: TABEL TRANSAKSI PEMINJAMAN TERBARU -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-200/70 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-zinc-900">Transaksi Peminjaman Terbaru</h2>
                <p class="text-[11px] text-zinc-400">5 aktivitas sirkulasi terakhir yang dicatat petugas</p>
            </div>
            <a href="{{ route('borrowings.index') }}" class="text-xs font-semibold text-unsika-maroon hover:underline">Lihat Semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200/70 bg-zinc-50/60 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">
                        <th class="py-3 px-5">Kode</th>
                        <th class="py-3 px-4">Anggota Peminjam</th>
                        <th class="py-3 px-4">Koleksi Buku</th>
                        <th class="py-3 px-4">Tgl Pinjam</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-5 text-right">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 text-xs">
                    @if ($recentBorrowings->isNotEmpty())
                        @foreach ($recentBorrowings as $borrowing)
                            <tr class="hover:bg-unsika-maroon/[0.02] transition-colors">
                                <td class="py-3.5 px-5 font-mono font-semibold text-zinc-700">#{{ $borrowing->id }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-zinc-900">{{ $borrowing->member->name ?? '-' }}</div>
                                    <div class="text-[11px] font-mono text-zinc-400">{{ $borrowing->member->member_code ?? '' }}</div>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    @if ($borrowing->details && $borrowing->details->isNotEmpty())
                                        @foreach ($borrowing->details as $detail)
                                            <div class="text-zinc-800 truncate">
                                                {{ $detail->book->title ?? 'Buku dihapus' }}
                                                <span class="text-zinc-400 font-mono">({{ $detail->quantity }} eks)</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">
                                    {{ \Carbon\Carbon::parse($borrowing->borrowing_date)->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 tabular-nums text-zinc-600">
                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($borrowing->status === 'returned')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                                            <span class="w-1.5 h-1.5 rounded-full bg-unsika-gold"></span>Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-right text-zinc-500">
                                    {{ $borrowing->user->name ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-8 text-center text-xs text-zinc-400">
                                Belum ada aktivitas transaksi peminjaman.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.font.family = '"Plus Jakarta Sans", system-ui, sans-serif';
        Chart.defaults.color = '#71717A';

        // 1. Line Chart: Tren Sirkulasi
        const trendCtx = document.getElementById('circulationTrendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthLabels) !!},
                    datasets: [
                        {
                            label: 'Peminjaman',
                            data: {!! json_encode($monthlyBorrowedData) !!},
                            borderColor: '#801818',
                            backgroundColor: 'rgba(128, 24, 24, 0.08)',
                            borderWidth: 2.2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#801818'
                        },
                        {
                            label: 'Pengembalian',
                            data: {!! json_encode($monthlyReturnedData) !!},
                            borderColor: '#C5931D',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.4,
                            fill: false,
                            pointRadius: 3,
                            pointBackgroundColor: '#C5931D'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { color: 'rgba(24, 24, 27, 0.05)' },
                            ticks: { precision: 0, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // 2. Vertical Pill Bar Chart: Aktivitas 7 Hari (Gaya SnowUI Figma)
        const pillCtx = document.getElementById('dailyPillChart');
        if (pillCtx) {
            new Chart(pillCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($dayLabels) !!},
                    datasets: [{
                        label: 'Transaksi',
                        data: {!! json_encode($dailyBorrowingData) !!},
                        backgroundColor: [
                            '#D6A2A2',
                            '#E6C77A',
                            '#18181B',
                            '#801818',
                            '#B8860B',
                            '#A34848',
                            '#C5931D'
                        ],
                        borderRadius: 10,
                        borderSkipped: false,
                        barThickness: 22
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { color: 'rgba(24, 24, 27, 0.05)' },
                            ticks: { precision: 0, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // 3. Donut Chart: Status Eksemplar Buku
        const donutCtx = document.getElementById('stockStatusDonut');
        if (donutCtx) {
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Tersedia di Rak', 'Dipinjam (Aktif)', 'Lewat Jatuh Tempo'],
                    datasets: [{
                        data: [
                            {{ (int) $totalStock }},
                            {{ (int) $borrowedOnTimeCount }},
                            {{ (int) $overdueCount }}
                        ],
                        backgroundColor: ['#801818', '#C5931D', '#3F3F46'],
                        borderWidth: 3,
                        borderColor: '#FFFFFF',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
@endpush