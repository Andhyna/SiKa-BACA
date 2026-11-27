<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan') — SiKa-BACA System</title>

    <!-- Tipografi Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Konfigurasi Tema UNSIKA -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        unsika: {
                            maroon: '#801818',
                            maroonDark: '#5C1010',
                            maroonLight: '#A32424',
                            gold: '#C5931D',
                            goldLight: '#F3E6C3',
                            alabaster: '#F5F4F0',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #F5F4F0;
            color: #18181B;
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
        }
        .tabular-nums {
            font-variant-numeric: tabular-nums;
        }
        .bg-architectural-grid {
            background-image:
                radial-gradient(circle at 12% 10%, rgba(128, 24, 24, 0.065) 0%, transparent 42%),
                radial-gradient(circle at 88% 85%, rgba(197, 147, 29, 0.075) 0%, transparent 45%),
                linear-gradient(to right, rgba(128, 24, 24, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(128, 24, 24, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 36px 36px, 36px 36px;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(128, 24, 24, 0.09);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(24, 24, 27, 0.07);
            box-shadow: 0 2px 12px -4px rgba(128, 24, 24, 0.04);
        }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(128, 24, 24, 0.18); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(128, 24, 24, 0.35); }
    </style>
    @stack('styles')
</head>
<body class="bg-architectural-grid min-h-screen antialiased selection:bg-unsika-maroon selection:text-white">

<!-- Overlay Mobile Sidebar -->
<div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 z-30 bg-zinc-900/30 backdrop-blur-xs hidden lg:hidden"></div>

<div class="flex min-h-screen">

    <!-- ==================== KOLOM 1: SIDEBAR KIRI ==================== -->
    <aside id="leftSidebar" class="fixed inset-y-0 left-0 z-40 w-64 glass-panel border-r border-unsika-maroon/10 flex flex-col justify-between transition-transform duration-200 -translate-x-full lg:translate-x-0 lg:static lg:shrink-0">
        <div>
            <!-- Identitas Brand SiKa-BACA -->
            <div class="h-16 px-5 flex items-center gap-3 border-b border-zinc-200/70">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-unsika-maroon to-unsika-maroonDark flex items-center justify-center text-unsika-gold shadow-xs shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="leading-tight overflow-hidden">
                    <div class="text-sm font-bold tracking-tight text-zinc-900 truncate">SiKa-BACA</div>
                    <div class="text-[11px] font-medium text-unsika-maroon/80 truncate">Sistem Informasi Katalog & Bacaan</div>
                </div>
            </div>

            <!-- Menu Navigasi Terstruktur -->
            <nav class="p-3.5 space-y-5 overflow-y-auto max-h-[calc(100vh-145px)]">
                <!-- Kelompok 1: Ringkasan -->
                <div>
                    <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Ringkasan</div>
                    <a href="{{ route('dashboard') }}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-xl text-[13.5px] font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-unsika-maroon text-white shadow-xs' : 'text-zinc-600 hover:bg-unsika-maroon/5 hover:text-unsika-maroon' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-unsika-gold' : 'text-zinc-400 group-hover:text-unsika-maroon' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- Kelompok 2: Katalog & Sirkulasi -->
                <div>
                    <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Katalog & Sirkulasi</div>
                    <div class="space-y-1">
                        <a href="{{ route('books.index') }}"
                           class="group flex items-center gap-3 px-3 py-2 rounded-xl text-[13.5px] font-medium transition-all {{ request()->routeIs('books.*') ? 'bg-unsika-maroon text-white shadow-xs' : 'text-zinc-600 hover:bg-unsika-maroon/5 hover:text-unsika-maroon' }}">
                            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('books.*') ? 'text-unsika-gold' : 'text-zinc-400 group-hover:text-unsika-maroon' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>Data Buku</span>
                        </a>

                        <a href="{{ route('categories.index') }}"
                           class="group flex items-center gap-3 px-3 py-2 rounded-xl text-[13.5px] font-medium transition-all {{ request()->routeIs('categories.*') ? 'bg-unsika-maroon text-white shadow-xs' : 'text-zinc-600 hover:bg-unsika-maroon/5 hover:text-unsika-maroon' }}">
                            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('categories.*') ? 'text-unsika-gold' : 'text-zinc-400 group-hover:text-unsika-maroon' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                            <span>Kategori Koleksi</span>
                        </a>

                        <a href="{{ route('members.index') }}"
                           class="group flex items-center gap-3 px-3 py-2 rounded-xl text-[13.5px] font-medium transition-all {{ request()->routeIs('members.*') ? 'bg-unsika-maroon text-white shadow-xs' : 'text-zinc-600 hover:bg-unsika-maroon/5 hover:text-unsika-maroon' }}">
                            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('members.*') ? 'text-unsika-gold' : 'text-zinc-400 group-hover:text-unsika-maroon' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            <span>Data Anggota</span>
                        </a>

                        <a href="{{ route('borrowings.index') }}"
                           class="group flex items-center gap-3 px-3 py-2 rounded-xl text-[13.5px] font-medium transition-all {{ request()->routeIs('borrowings.*') ? 'bg-unsika-maroon text-white shadow-xs' : 'text-zinc-600 hover:bg-unsika-maroon/5 hover:text-unsika-maroon' }}">
                            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('borrowings.*') ? 'text-unsika-gold' : 'text-zinc-400 group-hover:text-unsika-maroon' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                            <span>Sirkulasi Pinjam</span>
                        </a>
                    </div>
                </div>

                <!-- Kelompok 3: Administrasi (Khusus Admin via Gate) -->
                @can('manage-users')
                <div>
                    <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Administrasi</div>
                    <a href="{{ route('users.index') }}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-xl text-[13.5px] font-medium transition-all {{ request()->routeIs('users.*') ? 'bg-unsika-maroon text-white shadow-xs' : 'text-zinc-600 hover:bg-unsika-maroon/5 hover:text-unsika-maroon' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('users.*') ? 'text-unsika-gold' : 'text-zinc-400 group-hover:text-unsika-maroon' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <span>Kelola Pengguna</span>
                    </a>
                </div>
                @endcan
            </nav>
        </div>

        <!-- Profil Pengguna & Tombol Keluar -->
        <div class="p-3.5 border-t border-zinc-200/70 bg-white/40">
            <div class="flex items-center justify-between gap-2.5 px-2 py-1.5">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-unsika-maroon/10 border border-unsika-maroon/20 text-unsika-maroon flex items-center justify-center text-xs font-bold shrink-0">
                        {{ $userInitials ?: 'U' }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-semibold text-zinc-900 truncate">{{ $userName }}</div>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wide {{ $userRole === 'admin' ? 'bg-unsika-goldLight text-amber-900' : 'bg-zinc-200/80 text-zinc-700' }}">
                            {{ $userRole }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar dari Sistem" class="p-2 rounded-lg text-zinc-400 hover:text-unsika-maroon hover:bg-unsika-maroon/10 transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ==================== KOLOM 2: AREA KERJA TENGAH ==================== -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Glass Header -->
        <header class="h-16 px-4 sm:px-7 glass-panel border-b border-zinc-200/70 flex items-center justify-between gap-4 sticky top-0 z-20">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-zinc-600 hover:bg-zinc-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm truncate">
                    <span class="text-zinc-400 hidden sm:inline">SiKa-BACA</span>
                    <span class="text-zinc-300 hidden sm:inline">/</span>
                    <span class="font-semibold text-zinc-900 truncate">@yield('page_title', 'Dashboard')</span>
                </div>
            </div>

            <!-- Search Cepat Katalog & Tanggal -->
            <div class="flex items-center gap-3">
                <form action="{{ route('books.index') }}" method="GET" class="hidden md:flex items-center relative">
                    <svg class="w-4 h-4 text-zinc-400 absolute left-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku..."
                           class="w-56 lg:w-64 pl-9 pr-3 py-1.5 text-xs bg-zinc-100/80 border border-transparent rounded-xl text-zinc-800 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon/30 focus:outline-none transition-all">
                </form>

                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-unsika-maroon/5 border border-unsika-maroon/10 text-xs font-medium text-unsika-maroon">
                    <span class="w-1.5 h-1.5 rounded-full bg-unsika-gold"></span>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </header>

        <!-- Konten Utama -->
        <main class="flex-1 p-4 sm:p-7 space-y-6">
            @if (session('success'))
                <div class="glass-card border-l-4 border-emerald-600 px-4 py-3 rounded-xl flex items-center justify-between text-sm text-emerald-900">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-xs text-emerald-700 hover:underline">Tutup</button>
                </div>
            @endif

            @if (session('error'))
                <div class="glass-card border-l-4 border-unsika-maroon px-4 py-3 rounded-xl flex items-center justify-between text-sm text-unsika-maroonDark">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-unsika-maroon"></span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-xs text-unsika-maroon hover:underline">Tutup</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- ==================== KOLOM 3: RIGHT ACTIVITY RAIL ==================== -->
    <aside class="hidden xl:flex w-80 shrink-0 glass-panel border-l border-unsika-maroon/10 flex-col p-5 space-y-6">

        <!-- Bagian 1: Peringatan Sistem -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-800">Peringatan Sistem</h3>
                <span class="text-[11px] font-medium text-unsika-maroon">{{ $lowStockBooks->count() + $overdueBorrowings->count() }} info</span>
            </div>
            <div class="space-y-2.5">
                @if ($overdueBorrowings->isNotEmpty())
                    @foreach ($overdueBorrowings as $overdue)
                        <div class="p-2.5 rounded-xl bg-red-50/80 border border-red-200/70 flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-unsika-maroon mt-1.5 shrink-0"></span>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-zinc-900 truncate">Terlambat: {{ $overdue->member->name ?? 'Anggota' }}</p>
                                <p class="text-[11px] text-zinc-500">Jatuh tempo {{ \Carbon\Carbon::parse($overdue->due_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if ($lowStockBooks->isNotEmpty())
                    @foreach ($lowStockBooks as $book)
                        <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/70 flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-unsika-gold mt-1.5 shrink-0"></span>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-zinc-900 truncate">{{ $book->title }}</p>
                                <p class="text-[11px] text-amber-800 tabular-nums">Sisa stok: {{ $book->stock }} eksemplar</p>
                            </div>
                        </div>
                    @endforeach
                @elseif ($overdueBorrowings->isEmpty())
                    <p class="text-xs text-zinc-400 py-2">Seluruh stok buku dan jadwal pengembalian dalam kondisi aman.</p>
                @endif
            </div>
        </div>

        <hr class="border-zinc-200/70">

        <!-- Bagian 2: Aktivitas Sirkulasi Terbaru -->
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-800 mb-3">Aktivitas Terbaru</h3>
            <div class="relative pl-4 border-l border-zinc-200 space-y-3.5">
                @if ($latestActivities->isNotEmpty())
                    @foreach ($latestActivities as $act)
                        <div class="relative">
                            <span class="w-2 h-2 rounded-full {{ $act->status === 'returned' ? 'bg-emerald-500' : 'bg-unsika-maroon' }} absolute -left-[20.5px] top-1.5 ring-4 ring-white"></span>
                            <p class="text-xs text-zinc-800 leading-snug">
                                <span class="font-semibold">{{ $act->member->name ?? 'Anggota' }}</span>
                                {{ $act->status === 'returned' ? 'mengembalikan buku' : 'meminjam koleksi' }}
                            </p>
                            <p class="text-[11px] text-zinc-400 mt-0.5">{{ $act->updated_at?->diffForHumans() }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-xs text-zinc-400">Belum ada riwayat sirkulasi tercatat.</p>
                @endif
            </div>
        </div>

        <hr class="border-zinc-200/70">

        <!-- Bagian 3: Anggota Terbaru -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-800">Anggota Terbaru</h3>
                <a href="{{ route('members.index') }}" class="text-[11px] font-semibold text-unsika-maroon hover:underline">Semua</a>
            </div>
            <div class="space-y-2">
                @if ($activeMembersList->isNotEmpty())
                    @foreach ($activeMembersList as $member)
                        @php
                            $memberUrl = Route::has('members.show') ? route('members.show', $member->id) : route('members.index');
                            $mInitial = mb_strtoupper(mb_substr($member->name, 0, 1));
                        @endphp
                        <a href="{{ $memberUrl }}" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-unsika-maroon/5 transition-colors">
                            <div class="w-7 h-7 rounded-full bg-zinc-200/80 text-zinc-700 flex items-center justify-center text-[11px] font-bold shrink-0">
                                {{ $mInitial }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-xs font-medium text-zinc-800 truncate">{{ $member->name }}</div>
                                <div class="text-[10px] font-mono text-zinc-400 truncate">{{ $member->member_code }}</div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-xs text-zinc-400">Belum ada data anggota.</p>
                @endif
            </div>
        </div>

    </aside>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('leftSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
    }
</script>
@stack('scripts')
</body>
</html>