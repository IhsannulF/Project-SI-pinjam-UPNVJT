@extends('layouts.eksternal')

@section('content')

    @if($pengajuan_terakhir)
        @php
            if ($pengajuan_terakhir->status == 'pending' || $pengajuan_terakhir->status == 'menunggu') {
                $bgBanner = 'from-yellow-600/20 to-sipbg border-yellow-500/30 border-l-yellow-500';
                $iconBanner = 'fa-clock text-yellow-500';
            } elseif ($pengajuan_terakhir->status == 'disetujui') {
                $bgBanner = 'from-[#00AE1C]/20 to-sipbg border-[#00AE1C]/30 border-l-[#00AE1C]';
                $iconBanner = 'fa-check-circle text-[#00AE1C]';
            } elseif ($pengajuan_terakhir->status == 'dibatalkan') {
                $bgBanner = 'from-gray-600/20 to-sipbg border-gray-600/30 border-l-gray-500';
                $iconBanner = 'fa-ban text-gray-400';
            } else {
                $bgBanner = 'from-sipred/20 to-sipbg border-sipred/30 border-l-sipred';
                $iconBanner = 'fa-times-circle text-sipred';
            }
        @endphp
        
        <div class="bg-gradient-to-r {{ $bgBanner }} border border-l-4 rounded-2xl md:rounded-3xl p-5 md:p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-5 md:gap-6 relative overflow-hidden transition-all mb-6 md:mb-8">
            <div class="relative z-10 flex items-center gap-4 md:gap-6">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-[#0f1115]/50 flex items-center justify-center shrink-0 border border-gray-700/50 shadow-inner">
                    <i class="fas {{ $iconBanner }} text-2xl md:text-3xl"></i>
                </div>
                <div>
                    <h5 class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5 md:mb-1">Status Pengajuan Terakhir</h5>
                    <p class="text-base md:text-lg font-bold text-white flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                        <span class="truncate max-w-[200px] md:max-w-md">{{ $pengajuan_terakhir->fasilitas->nama_fasilitas ?? 'Fasilitas' }}</span>
                        <span class="text-xs md:text-sm font-medium text-gray-400">({{ \Carbon\Carbon::parse($pengajuan_terakhir->tanggal_mulai ?? $pengajuan_terakhir->tanggal_pinjam)->format('d M Y') }})</span>
                    </p>
                </div>
            </div>
            <div class="relative z-10 shrink-0 w-full md:w-auto mt-2 md:mt-0 flex gap-3">
                <a href="{{ route('eksternal.riwayat') }}" class="flex justify-center items-center gap-2 bg-[#1a1d24] hover:bg-gray-800 text-white border border-gray-600 px-5 md:px-6 py-2.5 md:py-3 rounded-xl font-semibold transition-all shadow-sm text-sm md:text-base w-full md:w-auto">
                    Lihat Detail
                </a>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-r from-sipdark to-sipbg border border-sipborder border-l-4 border-l-[#00AE1C] rounded-2xl md:rounded-3xl p-5 md:p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-5 md:gap-6 relative overflow-hidden mb-6 md:mb-8">
            <div class="absolute -right-5 -bottom-10 text-[#00AE1C]/5 pointer-events-none hidden md:block">
                <i class="fas fa-handshake text-9xl"></i>
            </div>
            <div class="relative z-10 flex items-center gap-4 md:gap-6">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-[#00AE1C]/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-file-contract text-2xl md:text-3xl text-[#00AE1C]"></i>
                </div>
                <div>
                    <h5 class="text-base md:text-xl font-bold text-white mb-0.5 md:mb-1">Mulai Reservasi Fasilitas</h5>
                    <p class="text-xs md:text-sm text-siptext font-medium">Anda belum memiliki pengajuan aktif. Siapkan dokumen MoU dan Bukti Pembayaran.</p>
                </div>
            </div>
            <div class="relative z-10 shrink-0 w-full md:w-auto mt-2 md:mt-0">
                <a href="{{ route('eksternal.reservasi') }}" class="flex justify-center items-center gap-2 w-full md:w-auto bg-[#00AE1C] hover:bg-[#009017] text-white px-5 md:px-6 py-2.5 md:py-3 rounded-xl font-semibold transition-all shadow-lg shadow-[#00AE1C]/30 active:scale-[0.98] text-sm md:text-base">
                    <i class="fas fa-plus"></i> Buat Reservasi
                </a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 md:gap-6">
        
        <div class="grid grid-cols-2 lg:grid-cols-1 gap-3 md:gap-4">
            
            <div class="bg-sipdark border border-sipborder rounded-xl md:rounded-2xl p-4 md:p-5 flex items-center justify-between shadow-lg">
                <div>
                    <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5 md:mb-1">Menunggu</p>
                    <h3 class="text-xl md:text-2xl font-bold text-yellow-500">{{ $stat_pending ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500 text-lg md:text-xl border border-yellow-500/20 shrink-0">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
            
            <div class="bg-sipdark border border-sipborder rounded-xl md:rounded-2xl p-4 md:p-5 flex items-center justify-between shadow-lg">
                <div>
                    <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5 md:mb-1">Disetujui</p>
                    <h3 class="text-xl md:text-2xl font-bold text-[#00AE1C]">{{ $stat_disetujui ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#00AE1C]/10 flex items-center justify-center text-[#00AE1C] text-lg md:text-xl border border-[#00AE1C]/20 shrink-0">
                    <i class="fas fa-check-double"></i>
                </div>
            </div>

            <div class="col-span-2 lg:col-span-1 bg-[#15181f] border border-gray-700 rounded-xl md:rounded-2xl p-4 md:p-5 flex items-center justify-between shadow-sm hover:border-gray-500 transition-colors">
                <div>
                    <h5 class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5 md:mb-1">Dibatalkan</h5>
                    <span class="text-xl md:text-2xl font-extrabold text-white">{{ $dibatalkan ?? 0 }}</span>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gray-600/10 border border-gray-600/30 flex items-center justify-center text-gray-400 shrink-0">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
            
        </div>

        <div class="lg:col-span-2 bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-6 shadow-lg flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-sm md:text-base font-bold text-white flex items-center gap-2">
                    <i class="fas fa-history text-sipblue"></i> Riwayat Terbaru
                </h2>
                <a href="{{ route('eksternal.riwayat') }}" class="text-[10px] md:text-xs font-bold text-sipblue hover:text-white transition-colors">Lihat Semua &rarr;</a>
            </div>
            
            <div class="flex-1 overflow-x-auto [&::-webkit-scrollbar]:h-[4px] md:[&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                <table class="w-full text-left border-collapse min-w-[400px]">
                    <tbody>
                        @forelse($riwayat_singkat ?? [] as $item)
                            <tr class="border-b border-gray-700/50 last:border-0 hover:bg-[#15181f] transition-colors">
                                <td class="py-3 pr-4">
                                    <div class="font-bold text-xs md:text-sm text-white truncate max-w-[200px] sm:max-w-xs md:max-w-sm" title="{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}">
                                        {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}
                                    </div>
                                    <div class="text-[10px] md:text-[11px] text-gray-400 mt-1 flex items-center gap-1.5">
                                        <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($item->tanggal_mulai ?? $item->tanggal_pinjam)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="py-3 text-right whitespace-nowrap">
                                    @if(strtolower($item->status) == 'pending' || strtolower($item->status) == 'menunggu')
                                        <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-2 py-1 rounded text-[9px] md:text-[10px] font-bold uppercase tracking-wider">Menunggu</span>
                                    @elseif(strtolower($item->status) == 'disetujui')
                                        <span class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-2 py-1 rounded text-[9px] md:text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                                    @elseif(strtolower($item->status) == 'ditolak')
                                        <span class="bg-sipred/10 text-sipred border border-sipred/20 px-2 py-1 rounded text-[9px] md:text-[10px] font-bold uppercase tracking-wider">Ditolak</span>
                                    @else
                                        <span class="bg-gray-600/10 text-gray-400 border border-gray-600/20 px-2 py-1 rounded text-[9px] md:text-[10px] font-bold uppercase tracking-wider">{{ $item->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8 text-xs md:text-sm text-gray-500">
                                    <i class="fas fa-folder-open text-2xl md:text-3xl mb-2 block opacity-50"></i>
                                    Belum ada aktivitas peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

@endsection