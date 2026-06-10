@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    
    <div class="bg-sipdark border border-sipborder rounded-2xl p-5 md:p-6 shadow-lg hover:-translate-y-1 hover:border-yellow-500/50 hover:shadow-yellow-500/10 transition-all group flex items-center gap-4 md:gap-5 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 text-yellow-500/5 pointer-events-none">
            <i class="fas fa-clock text-7xl"></i>
        </div>
        <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-yellow-500/10 text-yellow-500 flex items-center justify-center text-2xl md:text-3xl shrink-0 group-hover:scale-110 group-hover:bg-yellow-500 group-hover:text-white transition-all z-10">
            <i class="fas fa-clock"></i>
        </div>
        <div class="z-10">
            <h5 class="text-xs md:text-sm font-bold text-siptext uppercase tracking-wider mb-1">Pending</h5>
            <p class="text-3xl md:text-4xl font-extrabold text-white">{{ $count_pending }}</p>
        </div>
    </div>

    <div class="bg-sipdark border border-sipborder rounded-2xl p-5 md:p-6 shadow-lg hover:-translate-y-1 hover:border-[#00AE1C]/50 hover:shadow-[#00AE1C]/10 transition-all group flex items-center gap-4 md:gap-5 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 text-[#00AE1C]/5 pointer-events-none">
            <i class="fas fa-check-double text-7xl"></i>
        </div>
        <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-[#00AE1C]/10 text-[#00AE1C] flex items-center justify-center text-2xl md:text-3xl shrink-0 group-hover:scale-110 group-hover:bg-[#00AE1C] group-hover:text-white transition-all z-10">
            <i class="fas fa-check-double"></i>
        </div>
        <div class="z-10">
            <h5 class="text-xs md:text-sm font-bold text-siptext uppercase tracking-wider mb-1">Disetujui</h5>
            <p class="text-3xl md:text-4xl font-extrabold text-white">{{ $count_disetujui }}</p>
        </div>
    </div>

    <div class="bg-sipdark border border-sipborder rounded-2xl p-5 md:p-6 shadow-lg hover:-translate-y-1 hover:border-sipblue/50 hover:shadow-sipblue/10 transition-all group flex items-center gap-4 md:gap-5 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 text-sipblue/5 pointer-events-none">
            <i class="fas fa-door-open text-7xl"></i>
        </div>
        <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-sipblue/10 text-sipblue flex items-center justify-center text-2xl md:text-3xl shrink-0 group-hover:scale-110 group-hover:bg-sipblue group-hover:text-white transition-all z-10">
            <i class="fas fa-door-open"></i>
        </div>
        <div class="z-10">
            <h5 class="text-xs md:text-sm font-bold text-siptext uppercase tracking-wider mb-1">Total Ruangan</h5>
            <p class="text-3xl md:text-4xl font-extrabold text-white">{{ $count_fasilitas }}</p>
        </div>
    </div>

</div>

<div class="bg-sipdark border border-sipborder rounded-3xl shadow-xl flex flex-col overflow-hidden">
    
    <div class="p-5 md:p-6 border-b border-sipborder flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0 bg-sipbg/50">
        <h5 class="text-base md:text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-list-alt text-sipblue"></i> Pengajuan Peminjaman Terbaru
        </h5>
        <a href="{{ url('admin/antrean') }}" class="text-xs md:text-sm font-semibold text-sipblue hover:text-white transition-colors">Lihat Semua &rarr;</a>
    </div>

    <div class="overflow-x-auto [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full">
        <table class="w-full text-left border-collapse min-w-[700px]">
        <thead>
            <tr class="bg-sipbg border-b border-sipborder text-[10px] md:text-xs font-bold text-siptext uppercase tracking-wider whitespace-nowrap">
                <th class="py-4 px-4 pl-6">Nama Peminjam</th>
                <th class="py-4 px-4">Fasilitas</th>
                <th class="py-4 px-4">Tanggal</th>
                <th class="py-4 px-4">Status</th>
                <th class="py-4 px-4 pr-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-xs md:text-sm font-medium text-gray-300 divide-y divide-sipborder whitespace-nowrap">
            
            @forelse($recent_bookings as $booking)
            <tr class="hover:bg-sipblue/5 transition-colors group">
                <td class="py-3 px-4 pl-6 flex items-center gap-3 min-w-[200px]">
                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs text-white font-bold shrink-0">
                        <i class="fas fa-user"></i>
                    </div>
                    
                    <div class="flex flex-col">
                        <span class="text-white font-bold group-hover:text-sipblue transition-colors leading-tight truncate max-w-[150px] md:max-w-[200px]" title="{{ $booking->user->nama_lengkap ?? 'User Dihapus' }}">
                            {{ $booking->user->nama_lengkap ?? 'User Dihapus' }}
                        </span>
                        
                        <div class="text-[9px] md:text-[10px] font-bold uppercase tracking-widest mt-0.5 flex items-center gap-1">
                            @if(strtolower($booking->user->role ?? '') == 'dosen' || strtolower($booking->user->role ?? '') == 'tendik')
                                <i class="fas fa-star text-yellow-500"></i> <span class="text-yellow-500">Dosen / Tendik</span>
                            @elseif(strtolower($booking->user->role ?? '') == 'umum' || strtolower($booking->user->role ?? '') == 'eksternal')
                                <i class="fas fa-building text-sipblue"></i> <span class="text-sipblue">Instansi / Eksternal</span>
                            @else
                                <i class="fas fa-user-graduate text-gray-400"></i> <span class="text-gray-400">Mahasiswa</span>
                            @endif
                        </div>
                    </div>
                </td>
                
                <td class="py-3 px-4 truncate max-w-[150px]" title="{{ $booking->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}">
                    {{ $booking->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}
                </td>
                
                <td class="py-3 px-4 text-siptext">
                    @if($booking->tanggal_mulai == $booking->tanggal_berakhir)
                        {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M') }} s/d {{ \Carbon\Carbon::parse($booking->tanggal_berakhir)->format('d M Y') }}
                    @endif
                </td>
                
                <td class="py-3 px-4">
                    @if($booking->status == 'menunggu' || $booking->status == 'pending')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-[11px] font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 animate-pulse"></span> Menunggu
                        </span>
                    @elseif($booking->status == 'disetujui')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-[11px] font-bold bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20">
                            <i class="fas fa-check mr-1"></i> Disetujui
                        </span>
                    @elseif($booking->status == 'ditolak')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-[11px] font-bold bg-sipred/10 text-sipred border border-sipred/20">
                            <i class="fas fa-times mr-1"></i> Ditolak
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-[11px] font-bold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                            {{ ucfirst($booking->status) }}
                        </span>
                    @endif
                </td>
                
                <td class="py-3 px-4 pr-6">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.antrean') }}" class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-sipblue/10 text-sipblue border border-sipblue/30 hover:bg-sipblue hover:text-white flex items-center justify-center transition-all shadow-lg" title="Lihat di Antrean">
                            <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-8 text-center text-siptext text-sm">Belum ada pengajuan peminjaman saat ini.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    </div>
</div>
@endsection