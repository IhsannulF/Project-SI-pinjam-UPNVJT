@extends('layouts.dosen')

@section('content')

    <!-- HEADER KONTEN -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Cari Fasilitas Kampus</h2>
            <div class="text-xs md:text-sm font-medium text-siptext">Cek ketersediaan jadwal fasilitas sebelum melakukan pengajuan peminjaman.</div>
        </div>
        
        <a href="{{ route('dosen.reservasi') }}" class="w-full md:w-auto flex items-center justify-center gap-2 bg-sipblue hover:bg-sipbluehover text-white px-6 py-3.5 md:py-3 rounded-xl font-bold text-sm md:text-base transition-all shadow-lg shadow-sipblue/30 active:scale-95">
            <i class="fas fa-bolt text-yellow-300"></i> Reservasi Prioritas
        </a>
    </div>

    <!-- AREA UTAMA (KIRI DAN KANAN) -->
    <!-- PERBAIKAN: Mempertinggi kontainer menjadi lg:h-[800px] agar lebih lega di PC -->
    <div class="flex flex-col lg:flex-row gap-6 md:gap-8 lg:h-[800px]">
        
        <!-- PANEL KIRI (DAFTAR FASILITAS) -->
        <div class="w-full lg:w-1/3 bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl flex flex-col h-[450px] lg:h-full overflow-hidden shadow-xl shrink-0">
            
            <!-- PERBAIKAN: Ruang padding diperbesar (p-6 md:p-8) dan kolom input ditinggikan (py-4) -->
            <div class="p-6 md:p-8 border-b border-sipborder bg-[#15181f]">
                <h4 class="text-white font-bold mb-3 flex items-center gap-3 text-base md:text-lg">
                    <i class="fas fa-list text-sipblue"></i> Pilih Fasilitas
                </h4>
                <p class="text-xs md:text-sm text-gray-400 mb-5 leading-relaxed">Pilih fasilitas di bawah ini untuk melihat ketersediaan jadwalnya.</p>
                
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-lg"></i>
                    <input type="text" id="searchInput" placeholder="Cari nama fasilitas..." class="w-full bg-sipdark border border-gray-700 rounded-xl pl-12 pr-4 py-3.5 md:py-4 text-white text-sm md:text-base focus:outline-none focus:border-sipblue transition-all placeholder-gray-500 shadow-inner">
                </div>
            </div>

            <!-- PERBAIKAN: Spasi antar kartu fasilitas dilonggarkan -->
            <div class="flex-1 overflow-y-auto p-5 md:p-6 space-y-4 md:space-y-5 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
                @forelse($fasilitas as $f)
                    <div class="facility-card cursor-pointer bg-[#15181f] border border-gray-700 rounded-xl p-4 md:p-5 transition-all hover:border-sipblue hover:bg-sipblue/5 hover:shadow-lg hover:shadow-sipblue/10 group" 
                            data-id="{{ $f->id_fasilitas }}"
                            data-nama="{{ strtolower($f->nama_fasilitas) }}">
                        <h5 class="text-white font-bold text-sm md:text-base mb-2 group-hover:text-sipblue transition-colors">{{ $f->nama_fasilitas }}</h5>
                        <div class="flex items-center gap-2 text-xs md:text-sm text-gray-400 font-medium">
                            <i class="fas fa-users text-siptext"></i> {{ $f->kapasitas }} Orang
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-500 text-sm md:text-base">
                        <i class="fas fa-box-open text-3xl md:text-4xl mb-3 block opacity-50"></i> Belum ada fasilitas terdaftar.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- PANEL KANAN (KALENDER) -->
        <div class="w-full lg:w-2/3 bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-8 flex flex-col min-h-[500px] lg:h-full shadow-xl relative overflow-hidden">
            
            <!-- PERBAIKAN: Ruang header kalender diluaskan -->
            <div class="flex justify-between items-center w-full mb-6 md:mb-8 border border-gray-700/50 rounded-xl md:rounded-2xl p-4 md:p-6 bg-[#15181f] shadow-inner">
                <button id="prevMonth" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg md:rounded-xl transition-all border border-gray-700 bg-sipdark focus:outline-none">
                    <i class="fas fa-chevron-left text-sm md:text-base"></i>
                </button>
                
                <!-- PERBAIKAN BUG: Tag judul ganda dihapus, sepenuhnya diserahkan ke JavaScript -->
                <div class="text-center flex flex-col items-center px-4 w-full">
                    <h3 id="calendarMonthYear" class="text-center m-0 leading-relaxed">
                        <span class="text-sipblue text-base md:text-xl font-extrabold uppercase tracking-widest">PILIH FASILITAS</span>
                    </h3>
                </div>

                <button id="nextMonth" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg md:rounded-xl transition-all border border-gray-700 bg-sipdark focus:outline-none">
                    <i class="fas fa-chevron-right text-sm md:text-base"></i>
                </button>
            </div>

            <div class="flex justify-center gap-6 md:gap-10 mb-5 md:mb-8 pb-5 md:pb-8 border-b border-gray-700/50">
                <div class="flex items-center gap-2 md:gap-3 text-xs md:text-sm font-bold text-gray-300 uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-[#00AE1C] shadow-[0_0_8px_#00AE1C]"></span> Tersedia
                </div>
                <div class="flex items-center gap-2 md:gap-3 text-xs md:text-sm font-bold text-gray-300 uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-sipred shadow-[0_0_8px_#DE2828]"></span> Penuh
                </div>
            </div>

            <div class="flex-1 flex flex-col relative z-0">
                <!-- PERBAIKAN: Spasi antar hari diperlebar -->
                <div class="grid grid-cols-7 gap-2 md:gap-3 mb-3 md:mb-4">
                    @php $hari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
                    @foreach($hari as $h)
                        <div class='text-center text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest py-1'>{{ $h }}</div>
                    @endforeach
                </div>
                
                <div class="grid grid-cols-7 gap-2 md:gap-3 flex-1 content-start" id="calendarDays"></div>
            </div>

            <!-- OVERLAY BELUM PILIH -->
            <div id="overlayPilihFasilitas" class="absolute inset-0 z-20 bg-sipdark/90 backdrop-blur-md flex flex-col items-center justify-center transition-opacity duration-300 p-6 text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-sipborder/50 rounded-full flex items-center justify-center mb-4 md:mb-6 text-gray-500 animate-bounce shadow-xl">
                    <i class="fas fa-hand-pointer text-3xl md:text-4xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl md:text-2xl mb-2 md:mb-3">Pilih Fasilitas Terlebih Dahulu</h3>
                <p class="text-gray-400 text-sm md:text-base max-w-sm">Silakan klik salah satu fasilitas pada daftar di sebelah kiri untuk melihat ketersediaan jadwalnya.</p>
            </div>

        </div>
    </div>

    <meta id="jadwal-data" data-booking='{!! json_encode($jadwal_booking ?? (object)[]) !!}'>
    <script src="{{ asset('assets/js/script-jadwal.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/dosen-fasilitas.js') }}?v={{ time() }}"></script>
@endsection