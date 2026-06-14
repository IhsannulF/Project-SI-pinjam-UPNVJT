@extends('layouts.mahasiswa')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Form Pengajuan Peminjaman</h2>
            <div class="text-xs md:text-sm font-medium text-siptext">Isi formulir di bawah ini untuk mengajukan peminjaman fasilitas kampus.</div>
        </div>
        
        <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 text-xs md:text-sm font-semibold text-siptext hover:text-white transition-colors border border-sipborder px-4 py-2.5 rounded-lg md:rounded-xl bg-sipdark shadow-sm">
            <i class="fas fa-external-link-alt"></i> Ke Halaman Utama
        </a>
    </div>

    <div class="max-w-3xl mx-auto pb-8 md:pb-12">
        
        @if(session('error'))
            <div class="bg-sipred/10 text-sipred border border-sipred/30 px-4 md:px-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl mb-5 md:mb-6 flex items-start gap-3 md:gap-4 shadow-lg">
                <i class="fas fa-exclamation-triangle text-lg md:text-xl mt-0.5"></i> 
                <div>
                    <h3 class="font-bold text-xs md:text-sm mb-1">Pengajuan Gagal</h3>
                    <p class="text-[10px] md:text-xs">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 md:px-5 py-3.5 md:py-4 rounded-xl md:rounded-2xl mb-5 md:mb-6 flex items-start gap-3 md:gap-4 shadow-lg">
                <i class="fas fa-check-circle text-lg md:text-xl mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-xs md:text-sm mb-1">Berhasil!</h3>
                    <p class="text-[10px] md:text-xs">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 md:w-1.5 h-full bg-sipblue"></div>
            
            <h2 class="text-lg md:text-xl font-bold mb-6 md:mb-8 flex items-center gap-2 md:gap-3">
                <i class="fas fa-file-signature text-sipblue"></i> Detail Peminjaman
            </h2>

            <form action="{{ route('mahasiswa.pinjam.store') }}" method="POST" id="formPinjam">
                @csrf
                
                <div class="space-y-5 md:space-y-6">
                    
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold text-siptext uppercase tracking-widest mb-1.5 md:mb-2">Fasilitas yang Dipinjam <span class="text-sipred">*</span></label>
                        
                        <input type="hidden" name="id_fasilitas" id="input_id_fasilitas" required>
                        
                        <button type="button" onclick="bukaModalFasilitas()" id="btnPilihFasilitas" class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3.5 md:py-4 text-left text-xs md:text-sm text-gray-400 hover:border-sipblue focus:outline-none transition-all flex justify-between items-center group shadow-inner min-h-[50px] md:min-h-[56px]">
                            <span id="textFasilitasTerpilih" class="flex items-center truncate pr-2">
                                <i class="fas fa-building mr-2 md:mr-3 text-gray-500 text-base md:text-lg shrink-0"></i> 
                                <span class="truncate">-- Klik untuk Cari & Pilih Fasilitas --</span>
                            </span>
                            <i class="fas fa-search text-sipblue group-hover:scale-110 transition-transform shrink-0"></i>
                        </button>
                    </div>

                    <div>
                        <label class="block text-[10px] md:text-xs font-bold text-siptext uppercase tracking-widest mb-1.5 md:mb-2">Rentang Waktu Penggunaan <span class="text-sipred">*</span></label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" name="tanggal_mulai" required placeholder="Tanggal Mulai" class="datepicker-mahasiswa w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 md:py-3.5 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all cursor-pointer shadow-inner">
                            </div>
                            
                            <div class="relative">
                                <i class="far fa-calendar-check absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" name="tanggal_berakhir" required placeholder="Tanggal Berakhir" class="datepicker-mahasiswa w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 md:py-3.5 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all cursor-pointer shadow-inner">
                            </div>
                        </div>

                        <p class="text-[9px] md:text-[10px] text-gray-500 mt-2 leading-relaxed"><i class="fas fa-info-circle mr-1"></i> Tentukan rentang hari. Pastikan tanggal yang dipilih tidak bentrok di halaman "Cari Fasilitas".</p>
                    </div>

                    <div>
                        <label class="block text-[10px] md:text-xs font-bold text-siptext uppercase tracking-widest mb-1.5 md:mb-2">Keperluan / Nama Acara <span class="text-sipred">*</span></label>
                        <textarea name="keperluan" required rows="4" placeholder="Contoh: Rapat Evaluasi BEM Fasilkom, Pelatihan Jaringan Komputer, dll..." class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 md:py-3.5 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all placeholder-gray-600 resize-none shadow-inner"></textarea>
                    </div>

                    <div class="bg-sipblue/5 border border-sipblue/20 rounded-xl md:rounded-2xl p-4 flex gap-3 text-xs md:text-sm shadow-sm">
                        <i class="fas fa-shield-alt text-sipblue mt-0.5 md:mt-1 text-base md:text-lg shrink-0"></i>
                        <div class="text-gray-300 leading-relaxed">
                            <strong class="text-sipblue block mb-0.5 md:mb-1">Penting!</strong>
                            Pengajuan Anda akan divalidasi terlebih dahulu oleh sistem. Jika jadwal tersedia, status akan menjadi <b>Menunggu Admin (Pending)</b>. Silakan pantau secara berkala di menu Riwayat Saya.
                        </div>
                    </div>

                    <div class="pt-2 md:pt-4 border-t border-sipborder/50">
                        <button type="submit" id="btnSubmit" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-3.5 md:py-4 rounded-xl transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98] flex justify-center items-center gap-2 text-sm md:text-base">
                            <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                        </button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

    <div id="modalFasilitas" class="fixed inset-0 z-[9999] hidden opacity-0 transition-opacity duration-300">
        
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalFasilitas()"></div>
        
        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
            
            <div id="modalBox" class="relative pointer-events-auto bg-[#1a1d24] border border-sipborder rounded-2xl xl:rounded-3xl w-full max-w-[96vw] sm:max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-5xl max-h-[88vh] xl:max-h-[82vh] flex flex-col shadow-2xl transform scale-95 transition-transform duration-300 overflow-hidden">
                
                <div class="px-4 py-3 sm:px-5 sm:py-4 md:px-6 md:py-5 border-b border-sipborder flex justify-between items-center bg-[#15181f] shrink-0">
                    <h3 class="text-sm sm:text-base md:text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-list-ul text-sipblue"></i> Katalog Fasilitas
                    </h3>
                    <button type="button" onclick="tutupModalFasilitas()" class="text-gray-400 hover:text-sipred transition-colors w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg hover:bg-sipred/10 focus:outline-none">
                        <i class="fas fa-times text-lg md:text-xl"></i>
                    </button>
                </div>

                <div class="p-3 sm:p-4 border-b border-sipborder bg-[#1a1d24] shrink-0">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchFasilitas" placeholder="Ketik nama fasilitas..." class="w-full bg-[#0f1115] border border-gray-700 rounded-xl pl-11 pr-4 py-3 text-sm text-white focus:outline-none focus:border-sipblue transition-all placeholder-gray-600 shadow-inner">
                    </div>
                </div>

                <div id="listFasilitasContainer" class="flex-1 overflow-y-auto p-3 sm:p-4 md:p-5 space-y-4 md:space-y-6 overscroll-contain [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
                    
                    @forelse($fasilitas->groupBy('kategori') as $kategori => $items)
                        <div class="kategori-group">
                            <h4 class="text-[10px] md:text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2.5 md:mb-3 pl-1 flex items-center gap-1.5 md:gap-2">
                                <i class="fas fa-tags text-siptext"></i> {{ $kategori ?: 'Lainnya' }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($items as $f)
                                    <button type="button" onclick="pilihFasilitas('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}')" class="fasilitas-item text-left bg-[#15181f] border border-gray-700 hover:border-sipblue hover:bg-sipblue/10 rounded-xl p-3 sm:p-4 transition-all group relative overflow-hidden shadow-sm w-full">
                                        <div class="absolute right-0 top-0 w-1 h-full bg-sipblue opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="font-bold text-white text-sm md:text-base mb-1.5 break-words group-hover:text-sipblue transition-colors fasilitas-name">{{ $f->nama_fasilitas }}</div>
                                        <div class="text-xs sm:text-sm text-gray-400 flex items-center gap-1.5 flex-wrap">
                                            <i class="fas fa-user-friends text-siptext"></i> Kapasitas: <span class="text-white">{{ $f->kapasitas }} Org</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @empty
                    @endforelse

                    <div id="noResultFasilitas" class="hidden text-center py-8 sm:py-10 flex-col items-center justify-center">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-800 rounded-full flex items-center justify-center mb-3 md:mb-4 text-gray-500 mx-auto">
                            <i class="fas fa-search text-xl md:text-2xl"></i>
                        </div>
                        <h4 class="text-white font-bold mb-1 text-sm md:text-base">Fasilitas tidak ditemukan</h4>
                        <p class="text-[10px] md:text-xs text-gray-400">Coba gunakan kata kunci pencarian yang lain.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/form-pinjam.js') }}?v={{ time() }}"></script>

    <script>
        window.bukaModalFasilitas = function() {
            const modal = document.getElementById('modalFasilitas');
            const modalBox = document.getElementById('modalBox');
            if(modal) {
                modal.style.display = 'block'; // Memaksa Modal Tampil
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    if(modalBox) modalBox.classList.remove('scale-95');
                }, 10);
            }
        }

        window.tutupModalFasilitas = function() {
            const modal = document.getElementById('modalFasilitas');
            const modalBox = document.getElementById('modalBox');
            if(modal) {
                modal.classList.add('opacity-0');
                if(modalBox) modalBox.classList.add('scale-95');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
        }
    </script>
@endsection