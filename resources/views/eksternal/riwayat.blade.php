@extends('layouts.eksternal')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-white tracking-tight">Riwayat Pengajuan</h2>
    <p class="text-gray-400 mt-1 text-sm font-medium">Pantau status persetujuan peminjaman fasilitas umum Anda di sini.</p>
</div>

<div class="bg-[#15181f] border border-gray-700 rounded-3xl p-8 shadow-xl">
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-700/50">
        <div class="w-10 h-10 rounded-xl bg-sipblue/10 flex items-center justify-center text-sipblue shadow-inner">
            <i class="fas fa-clipboard-list text-lg"></i>
        </div>
        <h3 class="text-lg font-bold text-white">Daftar Riwayat Reservasi</h3>
    </div>

    <div class="overflow-x-auto [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full pb-4">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
            <thead>
                <tr class="border-b border-gray-700 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="py-4 px-4">Tgl Pengajuan</th>
                    <th class="py-4 px-4">Fasilitas & Jadwal</th>
                    <th class="py-4 px-4">Keperluan</th>
                    <th class="py-4 px-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($riwayat as $item)
                    <tr class="hover:bg-gray-800/30 transition-colors group">
                        <td class="py-5 px-4 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#1a1d24] border border-gray-700 flex items-center justify-center text-gray-400 shrink-0">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white mb-0.5">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai ?? $item->tanggal_pinjam)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                                        Tanggal Acara
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="py-5 px-4 align-middle">
                            <div class="font-bold text-sm text-sipblue mb-1 group-hover:text-sipbluehover transition-colors">
                                {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Terhapus' }}
                            </div>
                            @if(isset($item->tanggal_berakhir) && $item->tanggal_mulai != $item->tanggal_berakhir)
                                <div class="text-xs text-gray-400 flex items-center gap-1.5 bg-[#1a1d24] w-fit px-2.5 py-1 rounded-md border border-gray-700">
                                    <i class="fas fa-calendar-day text-gray-500"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}
                                </div>
                            @endif
                        </td>

                        <td class="py-5 px-4 align-middle">
                            <p class="text-sm text-gray-300 truncate max-w-[250px]" title="{{ $item->keperluan }}">
                                {{ $item->keperluan }}
                            </p>
                            <div class="flex gap-2 mt-2">
                                @if($item->dokumen_mou)
                                    <span class="text-[10px] bg-gray-700/50 text-gray-400 px-2 py-0.5 rounded border border-gray-600" title="MoU Terlampir"><i class="fas fa-file-pdf mr-1 text-sipred"></i> MoU</span>
                                @endif
                                @if($item->bukti_bayar)
                                    <span class="text-[10px] bg-gray-700/50 text-gray-400 px-2 py-0.5 rounded border border-gray-600" title="Bukti Bayar Terlampir"><i class="fas fa-receipt mr-1 text-[#00AE1C]"></i> Bayar</span>
                                @endif
                            </div>
                        </td>

                        <td class="py-5 px-4 align-middle text-center">
                            @if($item->status == 'pending' || $item->status == 'menunggu')
                                <span class="inline-flex items-center gap-1.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fas fa-hourglass-half"></i> Menunggu
                                </span>
                            @elseif($item->status == 'disetujui')
                                <span class="inline-flex items-center gap-1.5 bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fas fa-check-circle"></i> Disetujui
                                </span>
                            @elseif($item->status == 'ditolak')
                                <span class="inline-flex items-center gap-1.5 bg-sipred/10 text-sipred border border-sipred/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fas fa-ban"></i> Ditolak
                                </span>
                            @elseif($item->status == 'dibatalkan')
                                <span class="inline-flex items-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fas fa-times"></i> Dibatalkan
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center">
                            <div class="inline-flex flex-col items-center justify-center text-gray-500">
                                <div class="w-16 h-16 bg-[#1a1d24] rounded-full flex items-center justify-center mb-4 border border-gray-700">
                                    <i class="fas fa-folder-open text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-white mb-1">Belum Ada Riwayat</h4>
                                <p class="text-sm">Anda belum pernah melakukan pengajuan reservasi fasilitas.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection