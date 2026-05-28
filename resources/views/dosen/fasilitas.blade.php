<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Fasilitas - Dosen SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-xs font-bold text-sipblue uppercase tracking-widest">Panel Dosen & Tendik</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-home text-lg group-hover:text-sipblue transition-colors"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.fasilitas') ?? url('dosen/fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-search text-lg"></i> Cari Fasilitas
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.reservasi') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-yellow-500/10 hover:text-yellow-500 font-medium transition-all group">
                        <i class="fas fa-bolt text-lg text-yellow-500/70 group-hover:text-yellow-500 transition-colors"></i> Reservasi Prioritas
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.riwayat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-history text-lg group-hover:text-sipblue transition-colors"></i> Riwayat Pengajuan
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="{{ url('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Cari Fasilitas Kampus</h4>
                    <div class="text-sm font-medium text-siptext">Cek ketersediaan jadwal fasilitas sebelum melakukan pengajuan peminjaman.</div>
                </div>
                
                <a href="{{ route('dosen.reservasi') }}" class="flex items-center gap-2 bg-sipblue hover:bg-sipbluehover text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-sipblue/30 active:scale-95">
                    <i class="fas fa-bolt text-yellow-300"></i> Reservasi Prioritas
                </a>
            </header>

            <div class="flex-1 overflow-hidden p-6 md:p-8">
                
                <div class="flex flex-col lg:flex-row gap-6 h-full">
                    
                    <div class="w-full lg:w-1/3 bg-sipdark border border-sipborder rounded-3xl flex flex-col h-full overflow-hidden shadow-xl">
                        <div class="p-6 border-b border-sipborder">
                            <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                                <i class="fas fa-list text-sipblue"></i> Pilih Fasilitas
                            </h4>
                            <p class="text-xs text-gray-400 mb-4">Pilih fasilitas di bawah ini untuk melihat ketersediaan jadwalnya.</p>
                            
                            <div class="relative">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                                <input type="text" id="searchInput" placeholder="Cari nama fasilitas..." class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all placeholder-gray-600">
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6 space-y-4 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                            @forelse($fasilitas as $f)
                                <div class="facility-card cursor-pointer bg-[#15181f] border border-gray-700 rounded-xl p-4 transition-all hover:border-sipblue/50" 
                                     data-id="{{ $f->id_fasilitas }}"
                                     data-nama="{{ strtolower($f->nama_fasilitas) }}">
                                    <h5 class="text-white font-bold text-sm mb-2">{{ $f->nama_fasilitas }}</h5>
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                        <i class="fas fa-users text-siptext"></i> {{ $f->kapasitas }} Orang
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-gray-500 text-sm">Belum ada fasilitas terdaftar.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="w-full lg:w-2/3 bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 flex flex-col h-full shadow-xl relative">
                        <div class="flex justify-between items-center w-full mb-8 border border-gray-700/50 rounded-2xl p-4 bg-[#15181f]">
                            <button id="prevMonth" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-xl transition-all border border-gray-700 bg-sipdark">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <div class="text-center flex flex-col items-center">
                                <h2 id="namaFasilitasJudul" class="text-xl font-extrabold text-sipblue mb-1 uppercase tracking-widest">
                                    PILIH FASILITAS
                                </h2>
                                <h3 id="calendarMonthYear" class="text-xs font-bold text-gray-400 uppercase tracking-widest m-0">
                                    Bulan Tahun
                                </h3>
                            </div>

                            <button id="nextMonth" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-xl transition-all border border-gray-700 bg-sipdark">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="flex justify-center gap-8 mb-6 pb-6 border-b border-gray-700/50">
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-300 uppercase tracking-wider">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#00AE1C] shadow-[0_0_8px_#00AE1C]"></span> Tersedia
                            </div>
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-300 uppercase tracking-wider">
                                <span class="w-2.5 h-2.5 rounded-full bg-sipred shadow-[0_0_8px_#DE2828]"></span> Penuh / Diblokir
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col min-h-[300px]">
                            <div class="grid grid-cols-7 gap-2 mb-2">
                                @php $hari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
                                @foreach($hari as $h)
                                    <div class='text-center text-[10px] font-bold text-gray-500 uppercase tracking-widest py-1'>{{ $h }}</div>
                                @endforeach
                            </div>
                            <div class="grid grid-cols-7 gap-2 flex-1 content-start" id="calendarDays">
                                </div>
                        </div>

                        <div id="overlayPilihFasilitas" class="absolute inset-0 z-10 bg-sipdark/80 backdrop-blur-sm rounded-3xl flex flex-col items-center justify-center transition-opacity duration-300">
                            <div class="w-20 h-20 bg-sipborder/50 rounded-full flex items-center justify-center mb-4 text-gray-500 animate-bounce">
                                <i class="fas fa-mouse-pointer text-3xl"></i>
                            </div>
                            <h3 class="text-white font-bold text-xl mb-2">Pilih Fasilitas di Sebelah Kiri</h3>
                            <p class="text-gray-400 text-sm">Klik salah satu fasilitas untuk melihat ketersediaan jadwalnya.</p>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <meta id="jadwal-data" data-booking='{!! json_encode($jadwal_booking ?? (object)[]) !!}'>

    <script src="{{ asset('assets/js/script-jadwal.js') }}"></script>
    <script src="{{ asset('assets/js/dosen-fasilitas.js') }}"></script>
</body>
</html>