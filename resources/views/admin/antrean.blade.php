@extends('layouts.admin')

@section('content')


    <div class="flex h-screen w-full">


        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Kelola Antrean Pinjaman</h4>
                    <div class="text-sm font-medium text-siptext">Tinjau dan proses pengajuan peminjaman fasilitas.</div>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-400"><i class="far fa-calendar-alt mr-2"></i>{{ date('d M Y') }}</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                @if(session('success'))
                    <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-2 max-w-4xl">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="bg-sipred/10 text-sipred border border-sipred/30 px-4 py-3 rounded-xl mb-6 text-sm font-bold max-w-4xl">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle"></i> Gagal Memproses!
                        </div>
                        <ul class="list-disc list-inside font-normal text-xs ml-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- BAGIAN 1: TABEL ANTREAN BARU -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-yellow-500 mb-4 flex items-center gap-2">
                        <i class="fas fa-hourglass-half"></i> Perlu Diproses 
                        <span class="bg-yellow-500 text-sipdark px-2 py-0.5 rounded-md text-xs">{{ $antrean_baru->count() }}</span>
                    </h3>
                    
                    <div class="bg-sipdark border border-yellow-500/30 rounded-2xl shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-transparent"></div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead class="bg-[#1a1d24]">
                                    <tr class="text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-700/50">
                                        <th class="p-4 font-bold">Peminjam</th>
                                        <th class="p-4 font-bold">Fasilitas & Tgl</th>
                                        <th class="p-4 font-bold">Keperluan</th>
                                        <th class="p-4 font-bold text-center">Status</th>
                                        <th class="p-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @forelse($antrean_baru as $item)
                                        
                                        <!-- LOGIKA PERHITUNGAN TAGIHAN UNTUK ADMIN -->
                                        @php
                                            $tglMulai = \Carbon\Carbon::parse($item->tanggal_mulai);
                                            $tglAkhir = \Carbon\Carbon::parse($item->tanggal_berakhir ?? $item->tanggal_mulai);
                                            $lamaSewa = $tglMulai->diffInDays($tglAkhir) + 1;
                                            $hargaAsli = $item->fasilitas->harga_per_hari ?? 0;
                                            $totalBiaya = $lamaSewa * $hargaAsli;
                                        @endphp

                                        <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors">
                                            <td class="p-4">
                                                <div class="font-bold text-white">{{ $item->user->nama_lengkap ?? 'User Dihapus' }}</div>
                                                <div class="text-xs text-sipblue uppercase font-bold">{{ $item->user->role ?? '-' }}</div>
                                            </td>
                                            <td class="p-4">
                                                <div class="font-bold text-gray-200">{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}</div>
                                                <div class="text-xs text-yellow-500 mt-1 flex items-center gap-1.5 font-medium">
                                                    <i class="far fa-calendar-alt"></i> 
                                                    @if($item->tanggal_mulai == $item->tanggal_berakhir)
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} s/d {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="text-xs text-gray-300 max-w-[250px] truncate mb-1" title="{{ $item->keperluan }}">{{ $item->keperluan }}</div>
                                                
                                                @if($item->dokumen_mou)
                                                    <a href="{{ asset('uploads/mou/'.$item->dokumen_mou) }}" target="_blank" class="text-[10px] bg-gray-800 hover:bg-sipblue/20 text-sipblue px-2 py-1 rounded inline-flex items-center gap-1 transition-colors mt-1">
                                                        <i class="fas fa-file-pdf"></i> Lihat MoU
                                                    </a>
                                                @endif
                                                @if($item->bukti_bayar)
                                                    <a href="{{ asset('uploads/bukti_bayar/'.$item->bukti_bayar) }}" target="_blank" class="text-[10px] bg-gray-800 hover:bg-[#00AE1C]/20 text-[#00AE1C] px-2 py-1 rounded inline-flex items-center gap-1 transition-colors mt-1 ml-1">
                                                        <i class="fas fa-receipt"></i> Bukti Bayar
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center">
                                                @if($item->status == 'Menunggu Verifikasi MoU')
                                                    <span class="bg-purple-500/10 text-purple-400 border border-purple-500/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider shadow-sm animate-pulse"><i class="fas fa-file-signature mr-1"></i> Cek MoU</span>
                                                @elseif($item->status == 'Menunggu Konfirmasi Jadwal')
                                                    <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider shadow-sm animate-pulse"><i class="fas fa-money-check-alt mr-1"></i> Cek Bayar</span>
                                                @else
                                                    <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider shadow-sm animate-pulse"><i class="fas fa-hourglass-half mr-1"></i> Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    
                                                    @if($item->status == 'Menunggu Verifikasi MoU')
                                                        <!-- TOMBOL TRIGGER POP-UP TAGIHAN (Form dihapus) -->
                                                        <button type="button" 
                                                            data-url="{{ route('admin.antrean.status', $item->id_peminjaman) }}"
                                                            data-nama="{{ $item->user->nama_lengkap ?? 'Instansi Eksternal' }}"
                                                            data-fasilitas="{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas' }}"
                                                            data-lama="{{ $lamaSewa }}"
                                                            data-harga="{{ $hargaAsli }}"
                                                            data-total="{{ $totalBiaya }}"
                                                            onclick="bukaModalTagihan(this)" 
                                                            class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 hover:bg-purple-500 hover:text-white transition-colors flex items-center justify-center shadow-lg" 
                                                            title="Setujui MoU & Terbitkan Tagihan">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                        </button>

                                                    @elseif($item->status == 'Menunggu Konfirmasi Jadwal')
                                                        <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <button type="button" onclick="konfirmasiSetuju(this)" class="w-8 h-8 rounded-lg bg-[#00AE1C]/10 text-[#00AE1C] hover:bg-[#00AE1C] hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Konfirmasi Lunas & Kunci Jadwal">
                                                                <i class="fas fa-check-double"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <!-- Tombol Setuju Default (Untuk Mahasiswa/Dosen) -->
                                                        <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <button type="button" onclick="konfirmasiSetuju(this)" class="w-8 h-8 rounded-lg bg-[#00AE1C]/10 text-[#00AE1C] hover:bg-[#00AE1C] hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Setujui Langsung">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Tombol Tolak -->
                                                    <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="button" onclick="konfirmasiTolak(this)" class="w-8 h-8 rounded-lg bg-sipred/10 text-sipred hover:bg-sipred hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Tolak">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-10 text-center text-gray-500">
                                                <i class="fas fa-check-double text-3xl mb-2 text-gray-600"></i>
                                                <p>Hebat! Semua antrean sudah diproses.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: TABEL RIWAYAT PROSES -->
                <div>
                    <h3 class="text-lg font-bold text-gray-400 mb-4 flex items-center gap-2">
                        <i class="fas fa-history"></i> Riwayat Proses
                    </h3>
                    
                    <div class="bg-sipdark border border-sipborder rounded-2xl shadow-xl overflow-hidden opacity-90 hover:opacity-100 transition-opacity">
                        <!-- Scrollable Container untuk Riwayat -->
                        <div class="overflow-x-auto max-h-[350px] overflow-y-auto [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead class="sticky top-0 z-10 bg-[#1a1d24]">
                                    <tr class="text-gray-500 text-[10px] uppercase tracking-widest border-b border-gray-700/50">
                                        <th class="p-4 font-bold">Peminjam</th>
                                        <th class="p-4 font-bold">Fasilitas & Tgl</th>
                                        <th class="p-4 font-bold">Keperluan</th>
                                        <th class="p-4 font-bold text-center">Status</th>
                                        <th class="p-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @forelse($riwayat_proses as $item)
                                        <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
                                            <td class="p-4">
                                                <div class="font-bold text-gray-300">{{ $item->user->nama_lengkap ?? 'User Dihapus' }}</div>
                                                
                                                <!-- TAMBAHAN LABEL ROLE -->
                                                <div class="text-[10px] font-bold uppercase tracking-widest mt-1 flex items-center gap-1.5">
                                                    @if(strtolower($item->user->role ?? '') == 'dosen' || strtolower($item->user->role ?? '') == 'tendik')
                                                        <i class="fas fa-star text-yellow-500"></i> <span class="text-yellow-500">Dosen / Tendik</span>
                                                    @elseif(strtolower($item->user->role ?? '') == 'umum' || strtolower($item->user->role ?? '') == 'eksternal')
                                                        <i class="fas fa-building text-sipblue"></i> <span class="text-sipblue">Instansi / Eksternal</span>
                                                    @elseif(strtolower($item->user->role ?? '') == 'mahasiswa')
                                                        <i class="fas fa-user-graduate text-gray-400"></i> <span class="text-gray-400">Mahasiswa</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="text-xs text-gray-500 max-w-[200px] truncate" title="{{ $item->keperluan }}">{{ $item->keperluan }}</div>
                                            </td>
                                            <td class="p-4 text-center">
                                                @if($item->status == 'disetujui')
                                                    @elseif($item->status == 'ditolak' || $item->status == 'diblokir')
                                                    @elseif($item->status == 'dibatalkan')
                                                    <span class="inline-flex items-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wide">
                                                        <i class="fas fa-ban"></i> Dibatalkan
                                                    </span>
                                                @endif
                                            </td>
                                            <!-- Kolom Aksi Riwayat -->
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <!-- Tombol Edit Tanggal -->
                                                    <!-- KITA GUNAKAN DATA- ATTRIBUTE AGAR 100% AMAN DARI ERROR TANDA PETIK -->
                                                    <button type="button" 
                                                            data-id="{{ $item->id_peminjaman }}"
                                                            data-mulai="{{ $item->tanggal_mulai }}"
                                                            data-akhir="{{ $item->tanggal_berakhir }}"
                                                            data-nama="{{ $item->user->nama_lengkap ?? 'User' }}"
                                                            data-fasilitas="{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas' }}"
                                                            onclick="bukaModalEdit(this)"
                                                            class="w-8 h-8 rounded-lg bg-sipblue/10 text-sipblue hover:bg-sipblue hover:text-white flex items-center justify-center transition-colors shadow-sm"
                                                            title="Edit Tanggal">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('admin.antrean.batal', $item->id_peminjaman) }}" method="POST" class="form-batal-riwayat m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" 
                                                                class="btn-batal-riwayat w-8 h-8 rounded-lg bg-sipred/10 text-sipred hover:bg-sipred hover:text-white flex items-center justify-center transition-colors shadow-sm"
                                                                title="Batalkan Jadwal">
                                                            <i class="fas fa-times"></i> </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-600 text-sm">Belum ada riwayat pemrosesan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ==========================================
         MODAL EDIT JADWAL RIWAYAT
         ========================================== -->
    <div id="modalEditJadwal" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalEdit()"></div>
        
        <div class="relative w-full max-w-md bg-sipdark border border-sipborder rounded-3xl shadow-2xl flex flex-col transform scale-95 transition-transform duration-300" id="modalEditContent">
            
            <div class="flex items-center justify-between p-6 border-b border-sipborder bg-[#15181f] rounded-t-3xl">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-calendar-edit text-sipblue"></i> Edit Jadwal
                </h3>
                <button onclick="tutupModalEdit()" class="w-8 h-8 rounded-full bg-gray-800 text-gray-400 hover:bg-sipred hover:text-white flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formEditJadwal" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="mb-5 bg-[#15181f] p-4 rounded-xl border border-gray-700">
                    <p class="text-xs text-gray-400 mb-1">Peminjam: <span id="editNama" class="text-white font-bold ml-1"></span></p>
                    <p class="text-xs text-gray-400">Fasilitas: <span id="editFasilitas" class="text-sipblue font-bold ml-1"></span></p>
                </div>

                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Mulai Baru</label>
                        <input type="date" name="tanggal_mulai" id="editTglMulai" required class="w-full bg-[#15181f] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue [color-scheme:dark]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Berakhir Baru</label>
                        <input type="date" name="tanggal_berakhir" id="editTglBerakhir" required class="w-full bg-[#15181f] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue [color-scheme:dark]">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="tutupModalEdit()" class="flex-1 bg-transparent border border-gray-600 hover:border-gray-400 text-gray-300 px-4 py-3 rounded-xl font-bold transition-all">Batal</button>
                    <button type="submit" class="flex-1 bg-sipblue hover:bg-sipbluehover text-white px-4 py-3 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30">Update Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
     MODAL TERBITKAN TAGIHAN (ADMIN)
     ========================================== -->
    <div id="modalTagihan" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalTagihan()"></div>
        
        <div class="relative w-full max-w-md bg-sipdark border border-sipborder rounded-3xl shadow-2xl flex flex-col transform scale-95 opacity-0 transition-all duration-300" id="modalTagihanContent">
            
            <div class="flex items-center justify-between p-6 border-b border-sipborder bg-[#15181f] rounded-t-3xl">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-purple-500"></i> Review Tagihan
                </h3>
                <button onclick="tutupModalTagihan()" class="w-8 h-8 rounded-full bg-gray-800 text-gray-400 hover:bg-sipred hover:text-white flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formTerbitkanTagihan" method="POST" class="p-6">
                @csrf
                <!-- Ini yang akan mengubah statusnya saat form disubmit -->
                <input type="hidden" name="status" value="Menunggu Pembayaran">
                
                <div class="bg-[#15181f] rounded-xl border border-gray-700 p-5 mb-6">
                    <p class="text-xs text-gray-400 mb-1">Peminjam: <span id="tagihan_nama" class="text-white font-bold ml-1"></span></p>
                    <p class="text-xs text-gray-400 mb-4 pb-3 border-b border-gray-700/50">Fasilitas: <span id="tagihan_fasilitas" class="text-sipblue font-bold ml-1"></span></p>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-400">Lama Sewa</span>
                        <span class="text-sm font-bold text-white" id="tagihan_lama"></span>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-400">Harga Per Hari</span>
                        <span class="text-sm font-bold text-white" id="tagihan_harga"></span>
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-gray-700 border-dashed">
                        <span class="text-sm font-bold text-white">Total Tagihan</span>
                        <span class="text-xl font-extrabold text-purple-500" id="tagihan_total"></span>
                    </div>
                </div>

                <div class="bg-purple-500/10 border border-purple-500/20 text-purple-400 px-4 py-3 rounded-xl mb-6 text-xs font-medium flex items-start gap-3">
                    <i class="fas fa-info-circle mt-0.5 text-base"></i>
                    <p>Jika diterbitkan, status pengajuan akan berubah dan pihak instansi akan diminta untuk mentransfer sesuai nominal di atas.</p>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="tutupModalTagihan()" class="flex-1 bg-transparent border border-gray-600 hover:border-gray-400 text-gray-300 px-4 py-3 rounded-xl font-bold transition-all">Batal</button>
                    <button type="submit" class="flex-1 bg-purple-500 hover:bg-purple-600 text-white px-4 py-3 rounded-xl font-bold transition-all shadow-lg shadow-purple-500/30">Terbitkan Tagihan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/admin-antrean.js') }}"></script>
@endsection