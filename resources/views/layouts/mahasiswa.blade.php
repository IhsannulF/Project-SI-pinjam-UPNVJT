<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Mahasiswa - SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <!-- SIDEBAR PANEL MAHASISWA -->
        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-sm font-medium text-sipblue uppercase tracking-widest">Panel Mahasiswa</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                
                <!-- Menu Dashboard -->
                <li>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all">
                        <i class="fas fa-home text-lg"></i> Dashboard
                    </a>
                </li>
                
                <!-- Menu Cari Fasilitas -->
                <li>
                    <a href="{{ route('mahasiswa.cari_fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('mahasiswa.cari_fasilitas') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all group">
                        <i class="fas fa-search text-lg {{ request()->routeIs('mahasiswa.cari_fasilitas') ? '' : 'group-hover:text-sipblue transition-colors' }}"></i> Cari Fasilitas
                    </a>
                </li>
                
                <!-- Menu Buat Jadwal Pinjam (Tema Hijau) -->
                <li>
                    <a href="{{ route('mahasiswa.pinjam.form') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('mahasiswa.pinjam.form') ? 'bg-[#00AE1C]/10 text-[#00AE1C] border-[#00AE1C]/20 shadow-[0_0_15px_rgba(0,174,28,0.1)]' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all group">
                        <i class="fas fa-calendar-plus text-lg {{ request()->routeIs('mahasiswa.pinjam.form') ? '' : 'group-hover:text-[#00AE1C] transition-colors' }}"></i> Buat Jadwal Pinjam
                    </a>
                </li>
                
                <!-- Menu Riwayat Saya -->
                <li>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('mahasiswa.riwayat') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all group">
                        <i class="fas fa-history text-lg {{ request()->routeIs('mahasiswa.riwayat') ? '' : 'group-hover:text-sipblue transition-colors' }}"></i> Riwayat Saya
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="{{ url('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Halo, {{ Auth::user()->nama_lengkap ?? 'Mahasiswa' }}!</h4>
                    <div class="text-sm font-medium text-siptext">Selamat datang di layanan reservasi fasilitas mahasiswa.</div>
                </div>
                
                <a href="{{ url('/') }}" class="flex items-center gap-2 bg-sipdark text-white px-5 py-2.5 rounded-xl border border-sipborder hover:border-sipblue hover:bg-sipblue/5 font-semibold text-sm transition-all shadow-md group">
                    <i class="fas fa-external-link-alt text-sipblue group-hover:scale-110 transition-transform"></i> Ke Situs Utama
                </a>
            </header>

            <!-- ISI HALAMAN (DARI SETIAP VIEW) AKAN MUNCUL DI SINI -->
            <div class="flex-1 overflow-y-auto p-8 space-y-6 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                @yield('content')
            </div>
            
        </main>
    </div>

</body>
</html>