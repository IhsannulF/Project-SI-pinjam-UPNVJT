@extends('layouts.mahasiswa')

@section('content')

    <!-- HEADER KONTEN (Tanpa tag <header> agar menyatu dengan layout utama) -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Cari Fasilitas Kampus</h2>
            <div class="text-xs md:text-sm font-medium text-siptext">Cek ketersediaan jadwal fasilitas sebelum melakukan pengajuan peminjaman.</div>
        </div>
        
        <a href="{{ route('mahasiswa.pinjam.form') }}" class="w-full md:w-auto flex items-center justify-center gap-2 bg-[#00AE1C] hover:bg-green-700 text-white px-6 py-3 md:py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-green-500/30 active:scale-95">
            <i class="fas fa-calendar-plus text-white"></i> Langsung Pinjam
        </a>
    </div>

    <!-- AREA UTAMA (GRID KIRI DAN KANAN) -->
    <div class="flex flex-col lg:flex-row gap-6 md:gap-8 lg:h-[800px]">
        
        <!-- PANEL KIRI (DAFTAR FASILITAS) -->
        <div class="w-full lg:w-1/3 bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl flex flex-col h-[450px] lg:h-full overflow-hidden shadow-xl shrink-0 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
            
            <div class="p-5 md:p-8 border-b border-sipborder bg-[#15181f]">
                <h4 class="text-white font-bold mb-2 md:mb-3 flex items-center gap-2 md:gap-3 text-base md:text-lg">
                    <i class="fas fa-building text-sipblue"></i> Pilih Fasilitas
                </h4>
                <p class="text-xs md:text-sm text-gray-400 mb-4 md:mb-5 leading-relaxed">Pilih fasilitas di bawah ini untuk melihat ketersediaan jadwalnya.</p>
                
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-base md:text-lg"></i>
                    <input type="text" id="cariFasilitasInput" placeholder="Cari nama fasilitas..." class="w-full bg-sipdark border border-gray-700 rounded-xl pl-11 md:pl-12 pr-4 py-3 md:py-4 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all placeholder-gray-500 shadow-inner">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-3 md:space-y-4 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500" id="facilityListContainer">
                @forelse($data_fasilitas as $f)
                    <button type="button" class="w-full text-left p-4 md:p-5 rounded-xl border border-gray-700 bg-[#0f1115] hover:border-sipblue hover:bg-sipblue/5 hover:shadow-lg hover:shadow-sipblue/10 transition-all group facility-btn" data-id="{{ $f->id_fasilitas }}" data-nama="{{ $f->nama_fasilitas }}">
                        <div class="font-bold text-white text-sm md:text-base group-hover:text-sipblue transition-colors facility-name mb-2">{{ $f->nama_fasilitas }}</div>
                        <div class="text-[10px] md:text-xs font-medium text-gray-400 flex items-center gap-2">
                            <span class="bg-gray-800/80 px-2.5 py-1.5 rounded-lg text-gray-300 border border-gray-700/50"><i class="fas fa-users mr-1 text-siptext"></i> {{ $f->kapasitas }} Orang</span>
                        </div>
                    </button>
                @empty
                    <div class="text-center py-10 text-gray-500 text-sm md:text-base">
                        <i class="fas fa-box-open text-3xl md:text-4xl mb-3 block opacity-50"></i> Belum ada fasilitas terdaftar.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- PANEL KANAN (KALENDER) -->
        <div class="w-full lg:w-2/3 bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-8 flex flex-col min-h-[500px] lg:h-full shadow-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent to-[#00AE1C]"></div>

            <div class="flex justify-between items-center w-full mb-5 md:mb-8 bg-[#0f1115] p-3 md:p-4 rounded-xl md:rounded-2xl border border-gray-700/50 shadow-inner">
                <button id="prevMonth" class="w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl flex items-center justify-center bg-[#1a1d24] border border-gray-600 hover:bg-sipblue hover:border-sipblue hover:text-white transition-all shadow-md active:scale-95 focus:outline-none">
                    <i class="fas fa-chevron-left text-sm md:text-base"></i>
                </button>
                
                <!-- ID disesuaikan agar cocok dengan script-jadwal.js -->
                <div class="text-center flex flex-col items-center truncate px-2">
    
                    <h2 id="namaFasilitasJudul" class="text-sm md:text-lg font-extrabold text-sipblue mb-0.5 uppercase tracking-widest truncate max-w-[150px] sm:max-w-xs md:max-w-md">
                        PILIH FASILITAS
                    </h2>

                    <h3 id="calendarMonthYear" class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest m-0">
                        Bulan Tahun
                    </h3>
                </div>
                
                <button id="nextMonth" class="w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl flex items-center justify-center bg-[#1a1d24] border border-gray-600 hover:bg-sipblue hover:border-sipblue hover:text-white transition-all shadow-md active:scale-95 focus:outline-none">
                    <i class="fas fa-chevron-right text-sm md:text-base"></i>
                </button>
            </div>

            <div class="flex justify-center gap-5 md:gap-8 mb-5 md:mb-8 text-[10px] md:text-xs font-bold text-gray-300 bg-[#16181e] py-3 md:py-3.5 rounded-xl border border-gray-700/50 shadow-sm">
                <div class="flex items-center gap-2 uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-[#00AE1C] shadow-[0_0_8px_rgba(0,174,28,0.5)]"></span> Tersedia
                </div>
                <div class="flex items-center gap-2 uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-sipred shadow-[0_0_8px_rgba(222,40,40,0.5)]"></span> Penuh / Diblokir
                </div>
            </div>

            <div class="grid grid-cols-7 gap-2 md:gap-3 mb-2 md:mb-3 text-center text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-800/30 py-2.5 rounded-lg border border-gray-700/30">
                @php $hari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
                @foreach($hari as $h)
                    <div>{{ $h }}</div>
                @endforeach
            </div>

            <div id="calendarDays" class="grid grid-cols-7 gap-2 md:gap-3 flex-1 content-start"></div>
            
            <div id="overlayPilihFasilitas" class="absolute inset-0 z-20 bg-sipdark/90 backdrop-blur-md flex flex-col items-center justify-center transition-opacity duration-300 p-6 text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-sipborder/50 rounded-full flex items-center justify-center mb-4 md:mb-6 text-gray-500 animate-bounce shadow-xl">
                    <i class="fas fa-hand-pointer text-3xl md:text-4xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl md:text-2xl mb-2 md:mb-3">Pilih Fasilitas Terlebih Dahulu</h3>
                <p class="text-gray-400 text-sm md:text-base max-w-sm">Silakan klik salah satu fasilitas pada daftar di sebelah kiri untuk melihat ketersediaan jadwalnya.</p>
            </div>
            
        </div>
    </div>

    <!-- Data Jadwal -->
    <div id="jadwal-data" data-booking="{{ json_encode($jadwal_booking) }}" class="hidden"></div>

    <script>
        const jadwalElement = document.getElementById('jadwal-data');
        if(jadwalElement) {
            window.dataJadwalBooking = JSON.parse(jadwalElement.getAttribute('data-booking'));
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/script-jadwal.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/mahasiswa-fasilitas.js') }}?v={{ time() }}"></script>
@endsection