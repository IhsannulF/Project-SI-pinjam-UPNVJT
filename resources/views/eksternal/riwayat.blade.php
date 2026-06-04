@extends('layouts.eksternal')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-white tracking-tight">Riwayat Pengajuan</h2>
    <p class="text-gray-400 mt-1 text-sm font-medium">Pantau status persetujuan peminjaman fasilitas umum Anda di sini.</p>
</div>

@if(session('success'))
    <div class="bg-[#00AE1C]/10 border border-[#00AE1C]/30 text-[#00AE1C] px-6 py-4 rounded-xl mb-8 flex items-center gap-4 shadow-lg">
        <i class="fas fa-check-circle text-2xl"></i>
        <div>
            <h4 class="font-bold">Berhasil!</h4>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="bg-[#15181f] border border-gray-700 rounded-3xl p-8 shadow-xl">
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-700/50">
        <div class="w-10 h-10 rounded-xl bg-sipblue/10 flex items-center justify-center text-sipblue shadow-inner">
            <i class="fas fa-clipboard-list text-lg"></i>
        </div>
        <h3 class="text-lg font-bold text-white">Daftar Riwayat Reservasi</h3>
    </div>

    <div class="overflow-x-auto [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full pb-4">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
            <thead>
                <tr class="border-b border-gray-700 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="py-4 px-4">Tgl Pengajuan</th>
                    <th class="py-4 px-4">Fasilitas & Jadwal</th>
                    <th class="py-4 px-4">Keperluan</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($riwayat as $item)
                    
                    <!-- LOGIKA PERHITUNGAN TAGIHAN -->
                    @php
                        $tglMulai = \Carbon\Carbon::parse($item->tanggal_mulai ?? $item->tanggal_pinjam);
                        $tglAkhir = \Carbon\Carbon::parse($item->tanggal_berakhir ?? $item->tanggal_mulai);
                        $lamaSewa = $tglMulai->diffInDays($tglAkhir) + 1; // Ditambah 1 karena dihitung per hari penuh
                        $hargaAsli = $item->fasilitas->harga_per_hari ?? 0;
                        $totalBiaya = $lamaSewa * $hargaAsli;
                    @endphp

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
                                    <span class="ml-1 text-sipblue font-bold">({{ $lamaSewa }} Hari)</span>
                                </div>
                            @else
                                <div class="text-xs text-gray-400 flex items-center gap-1.5 bg-[#1a1d24] w-fit px-2.5 py-1 rounded-md border border-gray-700">
                                    <i class="fas fa-calendar-day text-gray-500"></i> 1 Hari
                                </div>
                            @endif
                        </td>

                        <td class="py-5 px-4 align-middle">
                            <p class="text-sm text-gray-300 truncate max-w-[200px]" title="{{ $item->keperluan }}">
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
                            @elseif($item->status == 'Menunggu Verifikasi MoU')
                                <span class="inline-flex items-center gap-1.5 bg-purple-500/10 text-purple-400 border border-purple-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fas fa-file-signature"></i> Cek MoU
                                </span>
                            @elseif($item->status == 'Menunggu Pembayaran')
                                <span class="inline-flex items-center gap-1.5 bg-orange-500/10 text-orange-400 border border-orange-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide animate-pulse">
                                    <i class="fas fa-file-invoice-dollar"></i> Tagihan Belum Dibayar
                                </span>
                            @elseif($item->status == 'Menunggu Konfirmasi Jadwal')
                                <span class="inline-flex items-center gap-1.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fas fa-search-dollar"></i> Verifikasi Pembayaran
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

                        <!-- KOLOM AKSI (TOMBOL BAYAR) -->
                        <td class="py-5 px-4 align-middle text-center">
                            @if($item->status == 'Menunggu Pembayaran')
                                <button type="button" 
                                    data-id="{{ $item->id_peminjaman }}"
                                    data-fasilitas="{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas' }}"
                                    data-lama="{{ $lamaSewa }}"
                                    data-harga="{{ $hargaAsli }}"
                                    data-total="{{ $totalBiaya }}"
                                    onclick="bukaModalBayar(this)" 
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg shadow-orange-500/30 transition-all flex items-center gap-2 mx-auto active:scale-95">
                                    <i class="fas fa-wallet"></i> Bayar Sekarang
                                </button>
                            @else
                                <span class="text-gray-600 text-2xl font-bold">-</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
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

<!-- ==========================================
     MODAL PEMBAYARAN (UPLOAD STRUK)
     ========================================== -->
<div id="modalBayar" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalBayar()"></div>
    
    <div class="relative w-full max-w-md bg-sipdark border border-sipborder rounded-3xl shadow-2xl flex flex-col transform scale-95 opacity-0 transition-all duration-300" id="modalBayarContent">
        
        <div class="flex items-center justify-between p-6 border-b border-sipborder bg-[#15181f] rounded-t-3xl">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-file-invoice-dollar text-orange-500"></i> Tagihan Pembayaran
            </h3>
            <button onclick="tutupModalBayar()" class="w-8 h-8 rounded-full bg-gray-800 text-gray-400 hover:bg-sipred hover:text-white flex items-center justify-center transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('eksternal.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <input type="hidden" name="id_peminjaman" id="bayar_id_peminjaman">
            
            <!-- Rincian Tagihan -->
            <div class="bg-[#15181f] rounded-xl border border-gray-700 p-5 mb-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-700/50 pb-2">Rincian Reservasi</h4>
                
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-400">Fasilitas</span>
                    <span class="text-sm font-bold text-white text-right" id="bayar_fasilitas"></span>
                </div>
                
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-400">Lama Sewa</span>
                    <span class="text-sm font-bold text-white" id="bayar_lama"></span>
                </div>
                
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-400">Harga Per Hari</span>
                    <span class="text-sm font-bold text-white" id="bayar_harga"></span>
                </div>

                <div class="flex justify-between items-center pt-3 border-t border-gray-700 border-dashed">
                    <span class="text-sm font-bold text-white">Total Tagihan</span>
                    <span class="text-xl font-extrabold text-orange-500" id="bayar_total"></span>
                </div>
            </div>

            <!-- Upload Struk -->
            <div class="bg-[#1a1d24] p-5 rounded-2xl border border-orange-500/30 border-dashed hover:border-orange-500 transition-colors mb-6">
                <label class="block text-sm font-bold text-white mb-1"><i class="fas fa-upload text-orange-500 mr-2"></i> Unggah Bukti Transfer</label>
                <p class="text-xs text-gray-400 mb-4">Format JPG, PNG, atau PDF. Maksimal 2MB.</p>
                <input type="file" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-500 hover:file:bg-orange-500 hover:file:text-white transition-all cursor-pointer">
            </div>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-xl font-bold text-lg transition-all shadow-lg shadow-orange-500/30 active:scale-[0.98] flex items-center justify-center gap-3">
                <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('assets/js/eksternal-riwayat.js') }}"></script>
@endsection