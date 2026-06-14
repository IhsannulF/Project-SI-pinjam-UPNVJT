@extends('layouts.dosen')

@section('content')

    <div class="bg-gradient-to-r from-sipdark to-sipbg border border-sipborder border-l-4 border-l-sipblue rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-xl mb-6 md:mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 md:gap-6 relative overflow-hidden">
        
        <div class="absolute -right-5 -top-5 text-sipblue/5 pointer-events-none hidden md:block">
            <i class="fas fa-bolt text-9xl"></i>
        </div>
        
        <div class="relative z-10 max-w-2xl">
            <h5 class="text-lg md:text-xl font-bold text-white mb-2 flex items-center gap-2">
                <i class="fas fa-bolt text-yellow-500"></i> Akses Reservasi Prioritas
            </h5>
            <p class="text-xs md:text-sm text-siptext font-medium leading-relaxed">
                Sebagai Dosen/Tendik, pengajuan Anda tidak memerlukan unggah surat izin pengantar dan akan diproses secara instan oleh sistem.
            </p>
        </div>
        
        <div class="relative z-10 shrink-0 w-full md:w-auto mt-2 md:mt-0">
            <a href="{{ route('dosen.reservasi') }}" class="flex justify-center items-center gap-2 w-full md:w-auto bg-sipblue hover:bg-sipbluehover text-white px-6 md:px-8 py-3 md:py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98] text-sm md:text-base">
                <i class="fas fa-bolt text-yellow-300"></i> Buat Reservasi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        
        <div class="bg-sipdark border border-sipborder rounded-2xl p-5 md:p-6 shadow-lg hover:-translate-y-1 hover:border-sipblue/50 hover:shadow-sipblue/10 transition-all group flex items-center gap-4 md:gap-5">
            <div class="w-14 h-14 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-sipblue/10 text-sipblue flex items-center justify-center text-2xl md:text-3xl shrink-0 group-hover:scale-110 group-hover:bg-sipblue group-hover:text-white transition-all">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <h5 class="text-xs md:text-sm font-bold text-siptext uppercase tracking-wider mb-0.5 md:mb-1">Jadwal Aktif</h5>
                <p class="text-3xl md:text-4xl font-extrabold text-white">{{ $jadwal_aktif }}</p>
            </div>
        </div>

        <div class="bg-sipdark border border-sipborder rounded-2xl p-5 md:p-6 shadow-lg hover:-translate-y-1 hover:border-siptext/50 transition-all group flex items-center gap-4 md:gap-5">
            <div class="w-14 h-14 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-sipborder text-siptext flex items-center justify-center text-2xl md:text-3xl shrink-0 group-hover:scale-110 group-hover:bg-gray-600 group-hover:text-white transition-all">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h5 class="text-xs md:text-sm font-bold text-siptext uppercase tracking-wider mb-0.5 md:mb-1">Total Riwayat</h5>
                <p class="text-3xl md:text-4xl font-extrabold text-white">{{ $total_riwayat }}</p>
            </div>
        </div>

    </div>

@endsection