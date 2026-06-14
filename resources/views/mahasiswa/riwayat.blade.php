@extends('layouts.mahasiswa')

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Riwayat Pengajuan</h2>
            <div class="text-xs md:text-sm font-medium text-siptext">Pantau status persetujuan peminjaman fasilitas Anda di sini.</div>
        </div>
        
        <a href="{{ route('mahasiswa.pinjam.form') }}" class="w-full sm:w-auto flex justify-center items-center gap-2 bg-[#00AE1C] hover:bg-green-700 text-white px-6 py-3 md:py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-green-500/30 active:scale-95">
            <i class="fas fa-plus"></i> Pinjam Baru
        </a>
    </div>

    <div class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-6 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
        
        <h2 class="text-base md:text-lg font-bold mb-4 md:mb-6 flex items-center gap-2 md:gap-3">
            <i class="fas fa-clipboard-list text-sipblue"></i> Daftar Riwayat Peminjaman
        </h2>

        <div class="overflow-x-auto [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar]:h-[6px] md:[&::-webkit-scrollbar]:h-[8px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full pb-2">
            
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                <thead>
                    <tr class="bg-[#15181f] text-gray-400 text-[10px] md:text-xs uppercase tracking-widest">
                        <th class="p-3 md:p-4 rounded-tl-lg md:rounded-tl-xl font-bold border-b border-gray-700/50">Tgl Pengajuan</th>
                        <th class="p-3 md:p-4 font-bold border-b border-gray-700/50">Nama Peminjam</th>
                        <th class="p-3 md:p-4 font-bold border-b border-gray-700/50">Fasilitas & Jadwal</th>
                        <th class="p-3 md:p-4 font-bold border-b border-gray-700/50 text-center rounded-tr-lg md:rounded-tr-xl">Status</th>
                    </tr>
                </thead>
                <tbody class="text-xs md:text-sm">
                    @forelse($riwayat as $item)
                        <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors group">
                            
                            <td class="py-3 px-4 md:py-4 md:px-6 align-top md:align-middle">
                                <div class="flex items-start md:items-center gap-2 md:gap-3">
                                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-[#15181f] border border-gray-700 flex items-center justify-center text-gray-400 shrink-0 shadow-inner mt-0.5 md:mt-0">
                                        <i class="far fa-calendar-alt text-sm md:text-base"></i>
                                    </div>
                                    <div>            
                                        <div class="text-xs md:text-sm font-bold text-white mb-0.5">
                                            {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') : \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-[9px] md:text-[10px] text-gray-500 font-medium tracking-wide">
                                            ID: #{{ str_pad($item->id_peminjaman ?? $item->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="p-3 md:p-4 font-medium text-white align-top md:align-middle">
                                <div class="text-xs md:text-sm font-bold truncate max-w-[150px] md:max-w-[200px]" title="{{ Auth::user()->nama_lengkap ?? 'Mahasiswa' }}">
                                    {{ Auth::user()->nama_lengkap ?? 'Mahasiswa' }}
                                </div>
                                <div class="text-[9px] md:text-[10px] text-siptext mt-0.5"><i class="fas fa-tag text-sipblue text-[8px] mr-1"></i>Mahasiswa</div>
                            </td>
                            
                            <td class="p-3 md:p-4 align-top md:align-middle">
                                <div class="font-bold text-sipblue mb-1.5 text-xs md:text-sm truncate max-w-[200px] md:max-w-[300px]" title="{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Telah Dihapus' }}">
                                    {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Telah Dihapus' }}
                                </div>
                                <div class="flex items-center gap-1.5 md:gap-2 text-[10px] md:text-xs text-gray-400 bg-[#16181e] w-fit px-2 py-1 md:px-2.5 md:py-1.5 rounded-md md:rounded-lg border border-gray-700 shadow-sm">
                                    <i class="far fa-calendar-alt text-gray-500"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            
                            <td class="py-3 px-4 md:py-5 md:px-4 align-middle text-center">
                                @if(strtolower($item->status) == 'pending' || strtolower($item->status) == 'menunggu')
                                    <span class="inline-flex items-center justify-center gap-1.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide min-w-[90px] md:min-w-[100px]">
                                        <i class="fas fa-hourglass-half"></i> Menunggu
                                    </span>
                                @elseif(strtolower($item->status) == 'disetujui')
                                    <span class="inline-flex items-center justify-center gap-1.5 bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide min-w-[90px] md:min-w-[100px]">
                                        <i class="fas fa-check-circle"></i> Disetujui
                                    </span>
                                @elseif(strtolower($item->status) == 'ditolak')
                                    <span class="inline-flex items-center justify-center gap-1.5 bg-sipred/10 text-sipred border border-sipred/20 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide min-w-[90px] md:min-w-[100px]">
                                        <i class="fas fa-ban"></i> Ditolak
                                    </span>
                                @elseif(strtolower($item->status) == 'dibatalkan')
                                    <span class="inline-flex items-center justify-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide min-w-[90px] md:min-w-[100px]">
                                        <i class="fas fa-times-circle"></i> Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide min-w-[90px] md:min-w-[100px]">
                                        <i class="fas fa-info-circle"></i> {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 md:py-16 text-center text-gray-500">
                                <div class="text-3xl md:text-4xl mb-2 md:mb-3"><i class="fas fa-folder-open opacity-50"></i></div>
                                <p class="text-xs md:text-sm font-medium">Anda belum pernah melakukan pengajuan peminjaman.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection