<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem — SiKa-BACA System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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
                            maroonDark: '#520D0D',
                            gold: '#C5931D',
                            alabaster: '#F5F4F0',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .unsika-hero-pattern {
            background-color: #520D0D;
            background-image:
                radial-gradient(circle at 80% 15%, rgba(197, 147, 29, 0.24) 0%, transparent 45%),
                radial-gradient(circle at 15% 85%, rgba(163, 36, 36, 0.45) 0%, transparent 50%),
                linear-gradient(to right, rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 44px 44px, 44px 44px;
        }
    </style>
</head>
<body class="min-h-screen bg-unsika-alabaster text-zinc-900 antialiased flex">

    <!-- PANEL KIRI: IDENTITAS VISUAL UNSIKA -->
    <div class="hidden lg:flex lg:w-[46%] unsika-hero-pattern text-white p-12 flex-col justify-between relative overflow-hidden">
        <!-- Ornamen Garis Lingkaran Arsitektural -->
        <div class="w-96 h-96 rounded-full border border-unsika-gold/20 absolute -bottom-28 -right-28 pointer-events-none"></div>
        <div class="w-64 h-64 rounded-full border border-white/10 absolute -bottom-12 -right-12 pointer-events-none"></div>

        <!-- Header Brand -->
        <div class="flex items-center gap-3.5 relative z-10">
            <div class="w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 flex items-center justify-center text-unsika-gold">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold tracking-wide uppercase text-unsika-gold">SiKa-BACA</div>
                <div class="text-xs text-white/70">Universitas Singaperbangsa Karawang</div>
            </div>
        </div>

        <!-- Pernyataan Utama -->
        <div class="space-y-4 max-w-md relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-medium text-unsika-gold">
                <span class="w-1.5 h-1.5 rounded-full bg-unsika-gold"></span>
                <span>Sistem Manajemen Sirkulasi & Katalog</span>
            </div>
            <h1 class="text-3xl font-bold leading-tight tracking-tight">
                Tata Kelola Koleksi & Peminjaman Terintegrasi.
            </h1>
            <p class="text-sm text-white/75 leading-relaxed">
                Platform operasional bagi Admin dan Petugas perpustakaan untuk memantau ketersediaan eksemplar buku, keanggotaan, dan riwayat sirkulasi secara akurat.
            </p>
        </div>

        <!-- Ringkasan Statistik Ringan -->
        <div class="grid grid-cols-2 gap-4 max-w-sm relative z-10">
            <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15">
                <div class="text-2xl font-bold text-white">{{ number_format($bookCount ?? 0) }}</div>
                <div class="text-xs text-white/70 mt-0.5">Judul Koleksi Terdata</div>
            </div>
            <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15">
                <div class="text-2xl font-bold text-unsika-gold">{{ number_format($memberCount ?? 0) }}</div>
                <div class="text-xs text-white/70 mt-0.5">Anggota Aktif</div>
            </div>
        </div>
    </div>

    <!-- PANEL KANAN: FORM LOGIN -->
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md space-y-7">
            <div class="space-y-1.5">
                <div class="lg:hidden inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-unsika-maroon mb-2">
                    <span>SiKa-BACA System</span>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Masuk ke Ruang Kerja</h2>
                <p class="text-sm text-zinc-500">Gunakan akun Admin atau Petugas yang terdaftar pada sistem.</p>
            </div>

            @if ($errors->any())
                <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs text-unsika-maroon space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="bg-white/85 backdrop-blur-xl border border-zinc-200/80 rounded-2xl p-6 sm:p-7 shadow-xs space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-zinc-700 mb-1.5">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@example.com"
                           class="w-full px-3.5 py-2.5 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-zinc-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               placeholder="Masukkan kata sandi"
                               class="w-full px-3.5 py-2.5 pr-10 text-sm bg-zinc-50/70 border border-zinc-200 rounded-xl text-zinc-900 placeholder-zinc-400 focus:bg-white focus:border-unsika-maroon focus:ring-2 focus:ring-unsika-maroon/15 focus:outline-none transition-all">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-700 text-xs font-medium">
                            Lihat
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-zinc-300 text-unsika-maroon focus:ring-unsika-maroon">
                        <span class="text-xs text-zinc-600">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-unsika-maroon hover:bg-unsika-maroonDark text-white text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                    Masuk ke Dashboard
                </button>
            </form>

            <p class="text-center text-xs text-zinc-400">
                Sistem Informasi Katalog & Bacaan &bull; Fakultas Ilmu Komputer UNSIKA
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>