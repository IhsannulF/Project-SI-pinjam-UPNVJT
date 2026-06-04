@extends('layouts.dosen')

@section('content')
    <div class="flex h-screen w-full">
        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Riwayat Pengajuan</h4>
                    <div class="text-sm font-medium text-siptext">Pantau status dan rekam jejak reservasi fasilitas Anda.</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 [&::-webkit-scrollbar]:w-[8px] [&::-webkit-scrollbar-track]:bg-[#15181f] [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                
                <div class="bg-sipdark border border-sipborder rounded-3xl overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <tr class="bg-[#1a1e28] border-b border-sipborder text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="py-5 px-6">Tgl Pengajuan</th>
                                <th class="py-5 px-6">Nama Peminjam</th>
                                <th class="py-5 px-6">Fasilitas & Jadwal</th>
                                <th class="py-5 px-6">Status</th>
                                <th class="py-5 px-6 text-center">Aksi</th> </tr>
                            <tbody class="divide-y divide-sipborder">
                                @forelse($riwayat as $item)
                                    <tr class="hover:bg-sipbg/50 transition-colors group">
                                        
                                        <!-- TGL PENGAJUAN -->
                                        <td class="py-4 px-6 align-top">
                                            <div class="text-sm font-medium text-white">
                                                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') : '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                ID: #{{ str_pad($item->id_peminjaman, 4, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </td>
                                        
                                        <!-- NAMA PEMINJAM -->
                                        <td class="py-4 px-6 align-top">
                                            <div class="text-sm font-bold text-white">{{ $item->user->nama_lengkap ?? 'User Tidak Ditemukan' }}</div>
                                            <div class="text-xs text-gray-400 mt-1"><i class="fas fa-tag text-sipblue mr-1"></i> Dosen / Tendik</div>
                                        </td>
                                        
                                        <!-- FASILITAS & JADWAL -->
                                        <td class="py-4 px-6 align-top">
                                            <div class="text-sm font-bold text-white mb-1.5 group-hover:text-sipblue transition-colors">
                                                {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                                <i class="far fa-calendar-alt"></i> 
                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                                                <i class="fas fa-arrow-right text-gray-600 mx-1"></i> 
                                                {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-2 line-clamp-1 italic">
                                                "{{ $item->keperluan }}"
                                            </div>
                                        </td>
                                        
                                        <!-- STATUS -->
                                        <td class="py-4 px-6 align-top">
                                            @if($item->status == 'disetujui')
                                                <span class="inline-flex items-center gap-1.5 bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-check-circle"></i> Disetujui
                                                </span>
                                            @elseif($item->status == 'menunggu')
                                                <span class="inline-flex items-center gap-1.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-clock"></i> Menunggu
                                                </span>
                                            @elseif($item->status == 'dibatalkan')
                                                <span class="inline-flex items-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-ban"></i> Dibatalkan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 bg-sipred/10 text-sipred border border-sipred/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-times-circle"></i> {{ ucfirst($item->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-4 px-6 align-top text-center">
                                            @if(in_array($item->status, ['menunggu', 'disetujui']))
                                                <form action="{{ route('dosen.riwayat.batal', $item->id_peminjaman) }}" method="POST" class="m-0 inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn-batal-dosen bg-sipred/10 text-sipred hover:bg-sipred hover:text-white border border-sipred/20 px-4 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-1.5 mx-auto">
                                                        <i class="fas fa-times"></i> Batalkan
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs font-medium text-gray-600 flex items-center justify-center gap-1.5 mt-1.5">
                                                    <i class="fas fa-lock"></i> Terkunci
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-16 text-center">
                                            <div class="w-20 h-20 bg-sipborder/50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-500">
                                                <i class="fas fa-folder-open text-3xl"></i>
                                            </div>
                                            <h4 class="text-white font-bold text-lg mb-1">Belum Ada Riwayat</h4>
                                            <p class="text-siptext text-sm">Anda belum pernah melakukan pengajuan peminjaman fasilitas.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/dosen-riwayat.js') }}"></script>
@endsection