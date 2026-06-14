@extends('layouts.dosen')

@section('content')

    <div class="mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Riwayat Pengajuan</h2>
        <div class="text-xs md:text-sm font-medium text-siptext">Pantau status dan rekam jejak reservasi fasilitas Anda.</div>
    </div>

    <div class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[8px] [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-[#15181f] [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead class="bg-[#1a1e28]">
                    <tr class="border-b border-sipborder text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        <th class="py-4 px-4 md:py-5 md:px-6">Tgl Pengajuan</th>
                        <th class="py-4 px-4 md:py-5 md:px-6">Nama Peminjam</th>
                        <th class="py-4 px-4 md:py-5 md:px-6">Fasilitas & Jadwal</th>
                        <th class="py-4 px-4 md:py-5 md:px-6">Status</th>
                        <th class="py-4 px-4 md:py-5 md:px-6 text-center">Aksi</th> 
                    </tr>
                </thead>
                <tbody class="divide-y divide-sipborder text-xs md:text-sm">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-sipbg/50 transition-colors group">
                            
                            <td class="py-3 px-4 md:py-4 md:px-6 align-top whitespace-nowrap">
                                <div class="font-medium text-white">
                                    {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') : '-' }}
                                </div>
                                <div class="text-[10px] md:text-xs text-gray-500 mt-1">
                                    ID: #{{ str_pad($item->id_peminjaman, 4, '0', STR_PAD_LEFT) }}
                                </div>
                            </td>
                            
                            <td class="py-3 px-4 md:py-4 md:px-6 align-top">
                                <div class="font-bold text-white truncate max-w-[150px] md:max-w-[200px]" title="{{ $item->user->nama_lengkap ?? 'User Tidak Ditemukan' }}">
                                    {{ $item->user->nama_lengkap ?? 'User Tidak Ditemukan' }}
                                </div>
                                <div class="text-[10px] md:text-xs text-gray-400 mt-1 flex items-center gap-1.5 whitespace-nowrap">
                                    <i class="fas fa-tag text-sipblue"></i> Dosen / Tendik
                                </div>
                            </td>
                            
                            <td class="py-3 px-4 md:py-4 md:px-6 align-top">
                                <div class="font-bold text-white mb-1.5 group-hover:text-sipblue transition-colors truncate max-w-[200px] md:max-w-[250px]" title="{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}">
                                    {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}
                                </div>
                                <div class="flex items-center gap-1.5 md:gap-2 text-[10px] md:text-xs text-gray-400 font-medium whitespace-nowrap">
                                    <i class="far fa-calendar-alt"></i> 
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                                    <i class="fas fa-arrow-right text-gray-600 mx-0.5 md:mx-1"></i> 
                                    {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-[10px] md:text-xs text-gray-500 mt-1.5 line-clamp-1 italic max-w-[250px]" title="{{ $item->keperluan }}">
                                    "{{ $item->keperluan }}"
                                </div>
                            </td>
                            
                            <td class="py-3 px-4 md:py-4 md:px-6 align-top whitespace-nowrap">
                                @if($item->status == 'disetujui')
                                    <span class="inline-flex items-center gap-1.5 bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide">
                                        <i class="fas fa-check-circle"></i> Disetujui
                                    </span>
                                @elseif($item->status == 'menunggu')
                                    <span class="inline-flex items-center gap-1.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide">
                                        <i class="fas fa-clock"></i> Menunggu
                                    </span>
                                @elseif($item->status == 'dibatalkan')
                                    <span class="inline-flex items-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide">
                                        <i class="fas fa-ban"></i> Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-sipred/10 text-sipred border border-sipred/20 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wide">
                                        <i class="fas fa-times-circle"></i> {{ ucfirst($item->status) }}
                                    </span>
                                @endif
                            </td>
                            
                            <td class="py-3 px-4 md:py-4 md:px-6 align-top text-center">
                                @if(in_array($item->status, ['menunggu', 'disetujui']))
                                    <form action="{{ route('dosen.riwayat.batal', $item->id_peminjaman) }}" method="POST" class="m-0 inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn-batal-dosen bg-sipred/10 text-sipred hover:bg-sipred hover:text-white border border-sipred/20 px-3 md:px-4 py-1.5 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold transition-all shadow-sm flex items-center gap-1.5 mx-auto whitespace-nowrap">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] md:text-xs font-medium text-gray-600 flex items-center justify-center gap-1.5 mt-1.5 whitespace-nowrap">
                                        <i class="fas fa-lock"></i> Terkunci
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 md:py-16 text-center">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-sipborder/50 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4 text-gray-500">
                                    <i class="fas fa-folder-open text-2xl md:text-3xl"></i>
                                </div>
                                <h4 class="text-white font-bold text-base md:text-lg mb-1">Belum Ada Riwayat</h4>
                                <p class="text-siptext text-xs md:text-sm">Anda belum pernah melakukan pengajuan peminjaman fasilitas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/dosen-riwayat.js') }}?v={{ time() }}"></script>
@endsection