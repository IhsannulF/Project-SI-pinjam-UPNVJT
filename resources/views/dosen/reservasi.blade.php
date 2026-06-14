@extends('layouts.dosen')

@section('content')

    <div class="mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Form Reservasi Prioritas</h2>
        <div class="text-xs md:text-sm font-medium text-siptext">Pengajuan tanpa surat pengantar dengan persetujuan instan.</div>
    </div>

    <div class="max-w-4xl mx-auto pb-8 md:pb-12">
        
        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-5 md:p-6 mb-6 md:mb-8 flex flex-col sm:flex-row items-start gap-3 md:gap-4 shadow-sm">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-yellow-500/20 text-yellow-500 flex items-center justify-center text-lg md:text-xl shrink-0 sm:mt-1">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h5 class="text-yellow-500 font-bold mb-1.5 md:mb-1 text-sm md:text-base">Informasi Jalur VIP</h5>
                <p class="text-xs md:text-sm text-gray-300 leading-relaxed">
                    Anda sedang menggunakan hak akses Dosen/Tendik. Reservasi yang dibuat melalui form ini akan <strong class="text-yellow-400">langsung disetujui</strong> oleh sistem dan jadwal akan otomatis terblokir tanpa perlu menunggu validasi Admin.
                </p>
            </div>
        </div>

        <form action="{{ route('dosen.reservasi.store') }}" method="POST" class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-xl relative overflow-hidden" id="formReservasi">
            @csrf
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-transparent"></div>

            <div class="space-y-5 md:space-y-6">
                
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Fasilitas Kampus</label>
                    <input type="hidden" name="id_fasilitas" id="inputHiddenFasilitas" required>
                    
                    <div onclick="bukaModalFasilitas()" class="relative group cursor-pointer shadow-inner">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500 group-hover:text-yellow-500 transition-colors">
                            <i class="fas fa-building text-base md:text-lg"></i>
                        </div>
                        <div id="tampilanFasilitas" class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-11 pr-10 py-3.5 text-gray-400 text-xs md:text-sm group-hover:border-yellow-500 transition-all flex items-center justify-between min-h-[50px] md:min-h-[52px]">
                            <span class="truncate pr-2">Klik untuk mencari dan memilih fasilitas...</span>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                            <i class="fas fa-external-link-square-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Tanggal Mulai</label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 z-10 pointer-events-none"></i>
                            <input type="text" id="tgl_mulai" name="tanggal_mulai" placeholder="Pilih Tanggal Mulai" required class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-11 pr-4 py-3 text-white text-xs md:text-sm focus:outline-none focus:border-yellow-500 transition-all cursor-pointer shadow-inner">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Tanggal Berakhir</label>
                        <div class="relative">
                            <i class="fas fa-calendar-check absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 z-10 pointer-events-none"></i>
                            <input type="text" id="tgl_berakhir" name="tanggal_berakhir" placeholder="Pilih Tanggal Berakhir" required class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-11 pr-4 py-3 text-white text-xs md:text-sm focus:outline-none focus:border-yellow-500 transition-all cursor-pointer shadow-inner">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Keperluan / Acara</label>
                    <textarea name="keperluan" rows="4" required placeholder="Contoh: Kuliah Pengganti Sistem Informasi, Seminar Nasional..." class="w-full bg-[#15181f] border border-gray-700 rounded-xl p-4 text-white text-xs md:text-sm focus:outline-none focus:border-yellow-500 transition-all placeholder-gray-600 resize-none shadow-inner"></textarea>
                </div>

                <div class="pt-3 md:pt-4">
                    <button type="button" onclick="validasiSubmit()" class="w-full bg-yellow-500 hover:bg-yellow-400 text-sipdark px-6 py-3.5 md:py-4 rounded-xl font-extrabold text-sm transition-all shadow-[0_0_15px_rgba(234,179,8,0.3)] flex items-center justify-center gap-2 active:scale-[0.98]">
                        <i class="fas fa-bolt"></i> Konfirmasi & Booking Instan
                    </button>
                </div>

            </div>
        </form>

    </div>


    <div id="modalFasilitas" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300 p-4">
        
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalFasilitas()"></div>
        
        <div class="relative w-full max-w-4xl bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl shadow-2xl flex flex-col max-h-[85vh] md:max-h-[80vh] transform scale-95 transition-transform duration-300 overflow-hidden" id="modalContent">
            
            <div class="flex items-center justify-between p-4 md:p-6 border-b border-sipborder bg-[#15181f] shrink-0">
                <h3 class="text-base md:text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-building text-yellow-500"></i> Katalog Fasilitas
                </h3>
                <button onclick="tutupModalFasilitas()" class="w-8 h-8 rounded-lg md:rounded-full bg-gray-800 text-gray-400 hover:bg-sipred hover:text-white flex items-center justify-center transition-all focus:outline-none">
                    <i class="fas fa-times text-sm md:text-base"></i>
                </button>
            </div>

            <div class="p-4 md:p-6 border-b border-sipborder bg-sipdark shrink-0">
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="text" id="cariFasilitasModal" placeholder="Ketik nama fasilitas..." class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-11 pr-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-yellow-500 transition-all shadow-inner">
                    </div>
                    <div class="w-full sm:w-48 relative shrink-0">
                        <select id="filterKategoriModal" class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-yellow-500 transition-all appearance-none cursor-pointer shadow-inner">
                            <option value="semua">Semua Kategori</option>
                            <option value="gsg">GSG</option>
                            <option value="lab">Laboratorium</option>
                            <option value="kelas">Ruang Kelas</option>
                            <option value="rapat">Ruang Rapat</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none text-[10px] md:text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 md:p-6 bg-[#15181f] [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4" id="daftarFasilitasModal">
                    @forelse($fasilitas as $f)
                        <div class="fasilitas-item bg-sipdark border border-gray-700 rounded-xl md:rounded-2xl p-4 cursor-pointer hover:border-yellow-500 hover:bg-yellow-500/5 transition-all group"
                             data-id="{{ $f->id_fasilitas }}"
                             data-nama="{{ strtolower($f->nama_fasilitas) }}"
                             data-kategori="{{ strtolower($f->kategori) }}"
                             onclick="pilihFasilitas('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}', '{{ $f->kategori }}')">
                            
                            <h5 class="text-white font-bold text-sm md:text-base mb-2 group-hover:text-yellow-500 transition-colors">{{ $f->nama_fasilitas }}</h5>
                            <div class="flex items-center gap-3 text-[10px] md:text-xs text-gray-400">
                                <span><i class="fas fa-users text-siptext mr-1"></i> {{ $f->kapasitas }} Org</span>
                                <span><i class="fas fa-tag text-siptext mr-1"></i> {{ $f->kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">Belum ada fasilitas.</div>
                    @endforelse
                </div>
                
                <div id="pesanKosong" class="hidden text-center py-10 flex-col items-center justify-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-800 rounded-full flex items-center justify-center mb-3 md:mb-4 mx-auto text-gray-500">
                        <i class="fas fa-box-open text-xl md:text-3xl"></i>
                    </div>
                    <p class="text-xs md:text-sm text-gray-400">Fasilitas tidak ditemukan.</p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/dosen-reservasi.js') }}?v={{ time() }}"></script>
@endsection