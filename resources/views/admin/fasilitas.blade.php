@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

@if(session('success'))
    <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
    
    <div class="space-y-6 lg:space-y-8">
        
        <div class="bg-sipdark border border-sipborder rounded-3xl p-5 md:p-8 shadow-xl">
            <h2 class="text-base md:text-lg font-bold mb-5 md:mb-6 flex items-center gap-3">
                <i class="fas fa-plus-circle text-sipblue text-lg md:text-xl"></i> Tambah Fasilitas
            </h2>
            
            <form id="formTambahFasilitas" method="POST" action="{{ route('admin.fasilitas.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4 md:space-y-5">
                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Nama Fasilitas</label>
                        <input type="text" name="nama" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm" placeholder="Contoh: Lab Komputer FIK 1">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Kategori</label>
                            <select name="kategori" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white appearance-none focus:outline-none focus:border-sipblue transition-all text-sm">
                                <option value="gsg">GSG</option>
                                <option value="lab">Lab</option>
                                <option value="kelas">Kelas</option>
                                <option value="rapat">Ruang Rapat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Kapasitas</label>
                            <div class="relative">
                                <input type="number" name="kapasitas" required class="w-full bg-sipbg border border-sipborder rounded-xl pl-4 pr-16 py-3 text-white focus:outline-none focus:border-sipblue transition-all text-sm" placeholder="40">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-siptext text-xs">Orang</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Harga Sewa / Hari</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-siptext text-xs font-bold">Rp</span>
                                <input type="number" name="harga_per_hari" required class="w-full bg-sipbg border border-sipborder rounded-xl pl-10 pr-4 py-3 text-white focus:outline-none focus:border-sipblue transition-all text-sm" placeholder="350000">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Pilih Ikon</label>
                            <select name="ikon" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm appearance-none focus:outline-none focus:border-sipblue transition-all">
                                <option value="fas fa-building">🏢 Gedung Umum</option>
                                <option value="fas fa-laptop-code">💻 Lab Komputer</option>
                                <option value="fas fa-chalkboard-teacher">👨‍🏫 Ruang Kelas</option>
                                <option value="fas fa-users">👥 Ruang Rapat</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Foto Ruangan</label>
                        <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-sipblue/10 file:text-sipblue hover:file:bg-sipblue/20 transition-all cursor-pointer">
                    </div>
                    
                    <button type="submit" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-3 md:py-3.5 rounded-xl transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98] text-sm md:text-base mt-2">
                        <i class="fas fa-save mr-1.5"></i> Simpan Fasilitas
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-sipdark border border-sipborder rounded-3xl p-5 md:p-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-sipred"></div>
            <h2 class="text-base md:text-lg font-bold mb-5 md:mb-6 flex items-center gap-3">
                <i class="fas fa-calendar-times text-sipred text-lg md:text-xl"></i> Tutup/Blokir Jadwal
            </h2>
            
            <form id="formBlokirJadwal" method="POST" action="{{ route('admin.block') }}">
                @csrf
                <div class="space-y-4 md:space-y-5">
                    
                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-widest mb-2">Pilih Fasilitas <span class="text-sipred">*</span></label>
                        <input type="hidden" name="id_fasilitas_blokir" id="input_id_fasilitas_blokir">
                        <button type="button" onclick="bukaModalFasilitasBlokir()" id="btnPilihFasilitasBlokir" class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 md:py-4 text-left text-xs md:text-sm text-gray-400 hover:border-sipred focus:outline-none transition-all flex justify-between items-center group shadow-inner">
                            <span id="textFasilitasTerpilihBlokir" class="flex items-center truncate pr-2">
                                <i class="fas fa-building mr-2 md:mr-3 text-gray-500 text-base md:text-lg shrink-0"></i> 
                                <span class="truncate">-- Klik untuk Cari & Pilih --</span>
                            </span>
                            <i class="fas fa-search text-sipred group-hover:scale-110 transition-transform shrink-0"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-widest mb-2">Mulai</label>
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" name="tanggal_mulai" required placeholder="Pilih Tanggal" class="datepicker-custom w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 text-white text-sm focus:outline-none focus:border-sipred transition-all cursor-pointer">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-widest mb-2">Berakhir</label>
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" name="tanggal_berakhir" required placeholder="Pilih Tanggal" class="datepicker-custom w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 text-white text-sm focus:outline-none focus:border-sipred transition-all cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-siptext uppercase tracking-widest mb-2">Alasan Blokir</label>
                        <input type="text" name="keperluan" required placeholder="Contoh: Renovasi Lab, Libur" class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipred placeholder-gray-600">
                    </div>

                    <button type="submit" id="btnSubmitBlokir" class="w-full bg-sipred hover:bg-red-700 text-white font-bold py-3 md:py-3.5 rounded-xl transition-all shadow-lg shadow-sipred/30 active:scale-95 flex justify-center items-center gap-2 text-sm md:text-base">
                        <i class="fas fa-ban"></i> Eksekusi Blokir
                    </button>
                </div>
            </form>
        </div>

    </div>

    <div class="lg:col-span-2 space-y-6 lg:space-y-8">
        
        <div class="bg-sipdark border border-sipborder rounded-3xl p-5 md:p-8 shadow-xl flex flex-col h-[400px] md:h-[700px]">
            <h2 class="text-base md:text-lg font-bold mb-4 md:mb-6 flex items-center gap-3"><i class="fas fa-list text-sipblue text-lg md:text-xl"></i> Daftar Fasilitas</h2>

            <div class="flex flex-wrap gap-2 mb-4 md:mb-6 border-b border-sipborder pb-4 md:pb-6">
                <button class="filter-btn bg-sipblue text-white border border-sipblue px-4 md:px-5 py-1.5 md:py-2 rounded-full text-[10px] md:text-xs font-bold transition-all" data-filter="semua">Semua</button>
                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-4 md:px-5 py-1.5 md:py-2 rounded-full text-[10px] md:text-xs font-bold transition-all" data-filter="gsg">GSG</button>
                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-4 md:px-5 py-1.5 md:py-2 rounded-full text-[10px] md:text-xs font-bold transition-all" data-filter="lab">Lab</button>
                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-4 md:px-5 py-1.5 md:py-2 rounded-full text-[10px] md:text-xs font-bold transition-all" data-filter="kelas">Kelas</button>
                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-4 md:px-5 py-1.5 md:py-2 rounded-full text-[10px] md:text-xs font-bold transition-all" data-filter="rapat">Rapat</button>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 md:pr-3 space-y-3 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder hover:[&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full">
                @forelse($q_fasilitas as $row)
                <div class="fasilitas-item flex items-center justify-between p-3 md:p-4 bg-sipbg border border-sipborder rounded-2xl group transition-all hover:border-sipblue/50" data-kategori="{{ $row->kategori }}">
                    <div class="flex items-center gap-3 md:gap-4 truncate pr-2">
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl bg-sipdark border border-sipborder flex items-center justify-center text-sipblue group-hover:bg-sipblue/10 group-hover:scale-110 transition-all shrink-0">
                            <i class="{{ $row->ikon }} text-lg md:text-2xl"></i>
                        </div>
                        <div class="truncate">
                            <div class="font-bold text-xs md:text-sm text-white truncate">{{ $row->nama_fasilitas }}</div>
                            <div class="text-[10px] md:text-xs text-siptext"><i class="fas fa-users mr-1"></i> {{ $row->kapasitas }} Orang</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-1 md:gap-2 shrink-0">
                        <button type="button" onclick="bukaModalEdit('{{ $row->id_fasilitas }}', '{{ addslashes($row->nama_fasilitas) }}', '{{ $row->kategori }}', '{{ $row->kapasitas }}', '{{ $row->harga_per_hari }}', '{{ $row->ikon }}')" class="text-sipblue p-2 hover:scale-110 transition-transform"><i class="fas fa-edit"></i></button>
                        
                        <form method="POST" action="{{ route('admin.fasilitas.delete') }}" class="inline">
                            @csrf
                            <input type="hidden" name="id_hapus" value="{{ $row->id_fasilitas }}">
                            <button type="button" onclick="konfirmasiHapus(this)" class="text-red-500 p-2 hover:scale-110 transition-transform"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-siptext">
                    <i class="fas fa-box-open text-3xl md:text-4xl mb-4 opacity-50"></i>
                    <p class="text-sm md:text-base">Belum ada data fasilitas.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-sipdark border border-sipborder rounded-3xl p-5 md:p-8 shadow-xl">
        <h2 class="text-base md:text-lg font-bold mb-5 md:mb-6 flex items-center gap-3">
            <i class="fas fa-calendar-minus text-siptext text-lg md:text-xl"></i> Fasilitas Yang Diblokir
        </h2>
        
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 mb-5 md:mb-6">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-siptext"></i>
                <input type="text" id="searchBlokir" placeholder="Cari nama fasilitas..." class="w-full bg-sipbg border border-sipborder rounded-xl pl-10 pr-4 py-2.5 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all">
            </div>
            <select id="filterKategoriBlokir" class="bg-sipbg border border-sipborder rounded-xl px-4 py-2.5 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all">
                <option value="semua">Semua Kategori</option>
                <option value="gsg">GSG</option>
                <option value="lab">Lab</option>
                <option value="kelas">Kelas</option>
                <option value="rapat">Ruang Rapat</option>
            </select>
        </div>

        <div class="overflow-y-auto overflow-x-auto max-h-[400px] pr-2 [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
            <table class="w-full text-left border-collapse relative min-w-[500px]">
                <thead class="sticky top-0 bg-sipdark z-20">
                    <tr class="text-siptext text-[10px] md:text-xs uppercase font-bold tracking-wider whitespace-nowrap">
                        <th class="py-3 md:py-4 px-4 border-b border-sipborder shadow-sm">Fasilitas</th>
                        <th class="py-3 md:py-4 px-4 border-b border-sipborder shadow-sm">Keterangan & Tanggal</th>
                        <th class="py-3 md:py-4 px-4 border-b border-sipborder shadow-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBlokirBody">
                    @php
                        $grouped_blokir = $q_blokir->groupBy('id_fasilitas');
                    @endphp
                    
                    @forelse($grouped_blokir as $id_fasilitas => $blocks)
                    @php
                        $first = $blocks->first();
                        $total_jadwal = $blocks->count();
                        
                        // Logika tampilan alasan blokir
                        $reasons = $blocks->pluck('keperluan')->unique();
                        $display_reason = $reasons->count() > 1 ? $reasons->count() . ' Keperluan Berbeda' : $first->keperluan;
                        
                        // 1. Data mentah untuk modal JavaScript (Diperbaiki kolom tanggalnya)
                        $blocked_data = $blocks->map(function($item) {
                            return [
                                'tanggal_mulai'    => $item->tanggal_mulai,
                                'tanggal_berakhir' => $item->tanggal_berakhir,
                                'alasan'           => $item->keperluan
                            ];
                        })->sortBy('tanggal_mulai')->values()->toArray();

                        // 2. Data visual badge tanggal untuk ditampilkan di tabel
                        $date_badges = $blocks->map(function($item) {
                            $tgl_mulai = \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y');
                            $tgl_akhir = \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y');
                            return $tgl_mulai === $tgl_akhir ? $tgl_mulai : "$tgl_mulai s/d $tgl_akhir";
                        })->unique()->take(2); // Ambil maksimal 2 rentang agar tabel tidak kepanjangan
                    @endphp
                    <tr class="blokir-row border-b border-sipborder/50 hover:bg-sipbg/50 transition-colors whitespace-nowrap" 
                        data-nama="{{ strtolower($first->fasilitas->nama_fasilitas) }}" 
                        data-kategori="{{ strtolower($first->fasilitas->kategori) }}">
                        
                        <td class="py-3 md:py-4 px-4 text-white flex items-center gap-3">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-sipred/10 text-sipred flex items-center justify-center shrink-0">
                                <i class="fas fa-lock text-sm md:text-base"></i>
                            </div>
                            <div class="truncate max-w-[150px] md:max-w-[200px]">
                                <div class="font-bold text-xs md:text-sm truncate" title="{{ $first->fasilitas->nama_fasilitas }}">{{ $first->fasilitas->nama_fasilitas }}</div>
                                <div class="text-[9px] md:text-[10px] font-bold text-sipred mt-0.5">{{ $total_jadwal }} Sesi Terblokir</div>
                            </div>
                        </td>
                        
                        <td class="py-3 md:py-4 px-4">
                            <div class="text-xs md:text-sm text-siptext italic truncate max-w-[200px] mb-1.5" title="{{ $display_reason }}">
                                "{{ $display_reason }}"
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($date_badges as $badge)
                                    <span class="px-2 py-0.5 bg-gray-800 border border-gray-700 text-gray-300 rounded text-[9px] font-medium tracking-wide">
                                        <i class="far fa-calendar-alt text-sipblue mr-1"></i> {{ $badge }}
                                    </span>
                                @endforeach
                                
                                @if($blocks->count() > 2)
                                    <span class="px-2 py-0.5 bg-gray-800 border border-gray-700 text-gray-400 rounded text-[9px] font-medium">
                                        +{{ $blocks->count() - 2 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td class="py-3 md:py-4 px-4 text-right">
                            <button type="button" 
                                    data-dates="{{ json_encode($blocked_data) }}"
                                    onclick="bukaModalEditRentang('{{ $id_fasilitas }}', '{{ addslashes($first->fasilitas->nama_fasilitas) }}', this)" 
                                    class="inline-flex items-center gap-1.5 md:gap-2 text-sipblue bg-sipblue/10 hover:bg-sipblue hover:text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold transition-all">
                                <i class="fas fa-edit"></i> Atur Jadwal
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyBlokirRow">
                        <td colspan="3" class="py-8 text-center text-siptext text-xs md:text-sm">
                            <i class="fas fa-check-circle text-xl md:text-2xl mb-2 opacity-50 block text-[#00AE1C]"></i> Tidak ada fasilitas yang sedang diblokir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <form id="formUnblockRange" method="POST" action="{{ route('admin.unblock.range') }}" class="hidden">
            @csrf
            <input type="hidden" name="id_fasilitas_unblock" id="unblock_id_fasilitas">
            <input type="hidden" name="tanggal_mulai_unblock" id="unblock_tanggal_mulai">
            <input type="hidden" name="tanggal_berakhir_unblock" id="unblock_tanggal_berakhir">
        </form>
    </div>

</div>

<div id="modalFasilitasBlokir" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm transition-opacity" onclick="tutupModalFasilitasBlokir()"></div>
    
    <div id="modalBoxFasilitasBlokir" class="bg-[#1a1d24] border border-sipborder rounded-2xl md:rounded-3xl w-full max-w-2xl max-h-[85vh] md:max-h-[80vh] relative z-10 flex flex-col shadow-2xl scale-95 opacity-0 transition-all duration-300 overflow-hidden">
        
        <div class="p-4 md:p-6 border-b border-sipborder flex justify-between items-center bg-[#15181f]">
            <h3 class="text-base md:text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-list-ul text-sipred"></i> Katalog Fasilitas
            </h3>
            <button type="button" onclick="tutupModalFasilitasBlokir()" class="text-gray-400 hover:text-sipred transition-colors w-8 h-8 flex items-center justify-center rounded-lg hover:bg-sipred/10">
                <i class="fas fa-times text-lg md:text-xl"></i>
            </button>
        </div>

        <div class="p-4 border-b border-sipborder bg-[#1a1d24]">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchFasilitasBlokir" placeholder="Ketik nama fasilitas..." class="w-full bg-[#0f1115] border border-gray-700 rounded-xl pl-11 pr-4 py-2.5 md:py-3 text-white text-sm focus:outline-none focus:border-sipred transition-all placeholder-gray-600">
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-5 space-y-5 md:space-y-6 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
            
            @foreach($q_fasilitas->groupBy('kategori') as $kategori => $items)
                <div class="kategori-group-blokir">
                    <h4 class="text-[10px] md:text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 pl-1 flex items-center gap-2">
                        <i class="fas fa-tags text-siptext"></i> {{ $kategori ?: 'Lainnya' }}
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
                        @foreach($items as $f)
                            <button type="button" onclick="pilihFasilitasBlokir('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}')" class="fasilitas-item-blokir text-left bg-[#15181f] border border-gray-700 hover:border-sipred hover:bg-sipred/10 rounded-xl p-3 md:p-4 transition-all group relative overflow-hidden">
                                <div class="absolute right-0 top-0 w-1 h-full bg-sipred opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="font-bold text-white text-xs md:text-sm group-hover:text-sipred transition-colors fasilitas-name-blokir truncate">{{ $f->nama_fasilitas }}</div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div id="noResultFasilitasBlokir" class="hidden text-center py-8 flex-col items-center justify-center">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-800 rounded-full flex items-center justify-center mb-3 md:mb-4 mx-auto">
                    <i class="fas fa-search text-xl md:text-2xl text-gray-500"></i>
                </div>
                <h4 class="text-white font-bold text-sm md:text-base mb-1">Fasilitas tidak ditemukan</h4>
                <p class="text-[10px] md:text-xs text-gray-400">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        </div>
    </div>
</div>

<script>
    window.updateFasilitasUrl = "{{ route('admin.fasilitas.update') }}";
    window.csrfToken = "{{ csrf_token() }}";
    window.fasilitasOptions = `
        <option value="" disabled selected>-- Pilih Fasilitas --</option>
        @foreach($q_fasilitas as $f)
            <option value="{{ $f->id_fasilitas }}">{{ $f->nama_fasilitas }}</option>
        @endforeach
    `;
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="{{ asset('assets/js/admin_fasilitas.js') }}?v={{ time() }}"></script>

@endsection