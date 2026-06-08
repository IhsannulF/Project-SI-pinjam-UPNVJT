<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-xs font-bold text-sipblue uppercase tracking-widest">Panel Administrator</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all">
                        <i class="fas fa-home text-lg"></i> Dashboard
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('admin.fasilitas') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all">
                        <i class="fas fa-building text-lg"></i> Kelola Fasilitas
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.antrean') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('admin.antrean') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all">
                        <i class="fas fa-clipboard-list text-lg"></i> Antrean Pinjaman
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->routeIs('admin.pengguna') ? 'bg-sipblue/10 text-sipblue border-sipblue/20' : 'text-siptext hover:bg-sipborder/50 hover:text-white border-transparent' }} font-semibold border transition-all">
                        <i class="fas fa-users text-lg"></i> Data Pengguna
                    </a>
                </li>

                <hr class="border-sipborder my-4 mx-2">
                
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white border border-transparent font-semibold transition-all">
                        <i class="fas fa-external-link-alt text-lg"></i> Lihat Situs Utama
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Halo, {{ Auth::user()->nama_lengkap ?? 'Administrator' }}!</h4>
                    <div class="text-sm font-medium text-siptext">Selamat datang di pusat kendali SI-PINJAM.</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 space-y-6 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                @yield('content')
            </div>
            
        </main>
    </div>

</body>
</html>