@extends('layouts.eksternal')

@section('content')
<!-- HEADER -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 gap-4">
    <div>
        <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Cari Fasilitas Umum</h2>
        <p class="text-xs md:text-sm text-gray-400 mt-1.5 md:mt-2 font-medium">Cek ketersediaan jadwal fasilitas sebelum melakukan pengajuan reservasi.</p>
    </div>
    <div class="w-full md:w-auto shrink-0">
        <a href="{{ route('eksternal.reservasi') }}" class="flex justify-center items-center gap-2 w-full md:w-auto bg-sipblue hover:bg-sipbluehover text-white px-5 md:px-6 py-3 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-sipblue/30 active:scale-95">
            <i class="fas fa-calendar-plus"></i> Buat Reservasi
        </a>
    </div>
</div>

<!-- GRID UTAMA -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 md:gap-6">
    
    <!-- KOLOM KIRI: PILIH FASILITAS -->
    <div class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-6 shadow-xl flex flex-col h-[350px] md:h-[450px] lg:h-auto lg:min-h-[750px] relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
        
        <h2 class="text-base md:text-lg font-bold mb-3 md:mb-4 flex items-center gap-2 md:gap-3 shrink-0">
            <i class="fas fa-building text-sipblue"></i> Pilih Fasilitas
        </h2>
        <p class="text-[10px] md:text-xs text-gray-400 mb-4 pb-4 border-b border-gray-700/50 shrink-0">Pilih fasilitas di bawah ini untuk melihat ketersediaan jadwalnya.</p>
        
        <div class="mb-4 relative shrink-0">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="cariFasilitasInput" placeholder="Cari nama fasilitas..." class="w-full bg-[#0f1115] border border-gray-700 rounded-xl pl-10 pr-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all shadow-inner">
        </div>
        
        <!-- Wadah List Fasilitas -->
        <div class="flex-1 overflow-y-auto space-y-2.5 md:space-y-3 pr-2 [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 hover:[&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full" id="facilityListContainer">
            @foreach($fasilitas as $f)
                <button type="button" class="w-full text-left p-3 md:p-4 rounded-xl border border-gray-700 bg-[#0f1115] hover:border-sipblue hover:bg-sipblue/10 focus:border-sipblue focus:bg-sipblue/10 transition-all group facility-btn" data-id="{{ $f->id_fasilitas }}" data-nama="{{ $f->nama_fasilitas }}">
                    <div class="font-bold text-white text-xs md:text-sm group-hover:text-sipblue transition-colors facility-name">{{ $f->nama_fasilitas }}</div>
                    <div class="text-[9px] md:text-[11px] font-medium text-gray-400 mt-1.5 md:mt-2 flex flex-wrap items-center gap-1.5 md:gap-2">
                        <span class="bg-gray-800 px-1.5 md:px-2 py-0.5 md:py-1 rounded text-gray-300">
                            <i class="fas fa-user-friends mr-1"></i> {{ $f->kapasitas ?? '-' }} Orang
                        </span>
                        <span class="bg-gray-800 px-1.5 md:px-2 py-0.5 md:py-1 rounded text-gray-300 uppercase tracking-wider">
                            {{ $f->kategori }}
                        </span>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- KOLOM KANAN: KALENDER -->
    <div class="lg:col-span-2 bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl flex flex-col h-auto min-h-[500px] lg:min-h-[750px] relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent to-[#00AE1C]"></div>

        <!-- Header Navigasi Kalender -->
        <div class="flex justify-between items-center mb-4 md:mb-6 bg-[#0f1115] p-2 md:p-3 rounded-xl md:rounded-2xl border border-gray-700 shrink-0">
            <button id="prevMonth" class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl flex items-center justify-center bg-[#1a1d24] border border-gray-600 hover:bg-sipblue hover:border-sipblue hover:text-white transition-all shadow-md active:scale-95 focus:outline-none shrink-0">
                <i class="fas fa-chevron-left text-xs md:text-base"></i>
            </button>
            
            <h2 id="monthYear" class="text-sm md:text-lg font-bold text-white uppercase tracking-wider truncate px-2 text-center">Memuat...</h2>
            
            <button id="nextMonth" class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl flex items-center justify-center bg-[#1a1d24] border border-gray-600 hover:bg-sipblue hover:border-sipblue hover:text-white transition-all shadow-md active:scale-95 focus:outline-none shrink-0">
                <i class="fas fa-chevron-right text-xs md:text-base"></i>
            </button>
        </div>

        <!-- Legend Indikator -->
        <div class="flex justify-center gap-4 md:gap-8 mb-4 md:mb-6 text-[10px] md:text-xs font-bold text-gray-300 bg-[#16181e] py-2 md:py-2.5 rounded-lg md:rounded-xl border border-gray-700/50 shrink-0 flex-wrap">
            <div class="flex items-center gap-1.5 md:gap-2">
                <span class="w-2.5 h-2.5 md:w-3.5 md:h-3.5 rounded-full bg-[#00AE1C] shadow-[0_0_8px_rgba(0,174,28,0.5)]"></span> Tersedia
            </div>
            <div class="flex items-center gap-1.5 md:gap-2">
                <span class="w-2.5 h-2.5 md:w-3.5 md:h-3.5 rounded-full bg-sipred shadow-[0_0_8px_rgba(222,40,40,0.5)]"></span> Penuh / Diblokir
            </div>
        </div>

        <!-- Nama Hari -->
        <div class="grid grid-cols-7 gap-1 md:gap-2 mb-2 md:mb-3 text-center text-[9px] md:text-[11px] font-bold text-gray-400 uppercase tracking-widest bg-gray-800/30 py-1.5 md:py-2 rounded-md md:rounded-lg shrink-0">
            <div class="truncate">Sen</div><div class="truncate">Sel</div><div class="truncate">Rab</div><div class="truncate">Kam</div><div class="truncate">Jum</div><div class="truncate">Sab</div><div class="truncate">Min</div>
        </div>

        <!-- Kotak-kotak Tanggal Kalender (Auto-height minimal agar tidak terpotong) -->
        <div id="calendarDays" class="grid grid-cols-7 gap-1 md:gap-2 flex-1 auto-rows-[minmax(60px,1fr)] md:auto-rows-[minmax(90px,1fr)]">
            <!-- Sel kalender akan di-render oleh JS di sini -->
        </div>
        
    </div>
</div>

<!-- DATA JADWAL JSON -->
<div id="jadwal-data" data-booking="{{ json_encode($events ?? []) }}" class="hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jadwalElement = document.getElementById('jadwal-data');
        if (jadwalElement) {
            // Memastikan variabel global ini tersedia untuk script-jadwal.js
            window.dataJadwalBooking = JSON.parse(jadwalElement.getAttribute('data-booking'));
        }
    });
</script>

<script src="{{ asset('assets/js/script-jadwal.js') }}?v={{ time() }}"></script>
@endsection