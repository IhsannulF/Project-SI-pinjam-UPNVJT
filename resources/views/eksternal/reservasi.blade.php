@extends('layouts.eksternal')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

<div class="max-w-4xl mx-auto pb-8 md:pb-12">
    
    <div class="mb-6 md:mb-8">
        <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Reservasi Fasilitas Umum</h2>
        <p class="text-xs md:text-sm text-gray-400 mt-1.5 md:mt-2 font-medium">Formulir pengajuan peminjaman fasilitas kampus untuk instansi/pihak eksternal.</p>
    </div>

    @if(session('success'))
        <div class="bg-[#00AE1C]/10 border border-[#00AE1C]/30 text-[#00AE1C] px-5 py-4 md:px-6 md:py-4 rounded-xl md:rounded-2xl mb-6 md:mb-8 flex items-start md:items-center gap-3 md:gap-4 shadow-lg">
            <i class="fas fa-check-circle text-xl md:text-2xl mt-0.5 md:mt-0"></i>
            <div>
                <h4 class="font-bold text-sm md:text-base">Berhasil!</h4>
                <p class="text-xs md:text-sm mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-sipred/10 border border-sipred/30 text-sipred px-5 py-4 md:px-6 md:py-4 rounded-xl md:rounded-2xl mb-6 md:mb-8 shadow-lg">
            <div class="flex items-center gap-3 mb-2.5">
                <i class="fas fa-exclamation-triangle text-lg md:text-xl"></i>
                <h4 class="font-bold text-sm md:text-base">Gagal Mengirim Pengajuan!</h4>
            </div>
            <ul class="list-disc list-inside text-xs md:text-sm space-y-1 ml-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#15181f] border border-gray-700 rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 md:w-1.5 h-full bg-[#00AE1C]"></div>

        <form action="{{ route('eksternal.reservasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 md:space-y-6" id="formReservasi">
            @csrf

            <div>
                <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Pilih Fasilitas</label>
                <input type="hidden" name="id_fasilitas" id="input_id_fasilitas">
                
                <button type="button" onclick="bukaModalFasilitas()" id="btnPilihFasilitas" class="w-full bg-[#1a1d24] border border-gray-700 hover:border-sipblue focus:outline-none focus:border-sipblue rounded-xl px-4 py-3.5 md:px-5 md:py-4 text-left flex justify-between items-center group transition-all shadow-inner">
                    <div class="flex items-center gap-3 truncate pr-4">
                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 group-hover:text-sipblue group-hover:bg-sipblue/10 transition-colors shrink-0" id="iconFasilitas">
                            <i class="fas fa-building"></i>
                        </div>
                        <span id="teks_fasilitas_terpilih" class="text-xs md:text-sm text-gray-400 font-medium truncate">-- Klik untuk Mencari & Memilih Fasilitas --</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-500 group-hover:text-sipblue group-hover:translate-x-1 transition-all shrink-0"></i>
                </button>
                <p id="errorFasilitas" class="text-sipred text-[10px] md:text-xs mt-2 hidden"><i class="fas fa-exclamation-circle mr-1"></i> Anda wajib memilih fasilitas!</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Tanggal Mulai</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sipblue">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <input type="text" name="tanggal_mulai" id="tanggal_mulai" required placeholder="Pilih Tanggal Mulai..." class="datepicker w-full bg-[#1a1d24] border border-gray-700 rounded-xl pl-11 pr-4 py-3 md:py-4 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all cursor-pointer shadow-inner">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Tanggal Berakhir</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sipblue">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <input type="text" name="tanggal_berakhir" id="tanggal_berakhir" required placeholder="Pilih Tanggal Berakhir..." class="datepicker w-full bg-[#1a1d24] border border-gray-700 rounded-xl pl-11 pr-4 py-3 md:py-4 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all cursor-pointer shadow-inner">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Keperluan Acara</label>
                <textarea name="keperluan" rows="3" required placeholder="Contoh: Turnamen Futsal Antar Instansi Kota Sidoarjo..." class="w-full bg-[#1a1d24] border border-gray-700 rounded-xl px-4 py-3.5 md:px-5 md:py-4 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all shadow-inner resize-y"></textarea>
            </div>

            <div class="pt-4 border-t border-gray-700/50 mt-4 md:mt-6">
                <div class="bg-[#1a1d24] p-4 md:p-5 rounded-xl md:rounded-2xl border border-gray-700 border-dashed hover:border-[#00AE1C] transition-colors focus-within:border-[#00AE1C]">
                    <label class="block text-xs md:text-sm font-bold text-white mb-1">
                        <i class="fas fa-file-pdf text-sipred mr-1.5"></i> Surat MoU / Perizinan
                    </label>
                    <p class="text-[10px] md:text-xs text-gray-400 mb-3 md:mb-4">Wajib berformat PDF. Maksimal 2MB.</p>
                    <input type="file" name="dokumen_mou" accept=".pdf" required class="block w-full text-[10px] md:text-xs text-gray-400 file:mr-3 md:file:mr-4 file:py-2 md:file:py-2.5 file:px-3 md:file:px-4 file:rounded-lg md:file:rounded-xl file:border-0 file:text-[10px] md:file:text-sm file:font-bold file:bg-[#00AE1C]/10 file:text-[#00AE1C] hover:file:bg-[#00AE1C] hover:file:text-white transition-all cursor-pointer focus:outline-none">
                </div>
            </div>

            <div class="mt-6 md:mt-8">
                <button type="submit" onclick="return validasiForm()" class="w-full bg-[#00AE1C] hover:bg-green-700 text-white py-3.5 md:py-4 rounded-xl font-bold text-sm md:text-lg transition-all shadow-lg shadow-green-500/30 active:scale-[0.98] flex items-center justify-center gap-2 md:gap-3 focus:outline-none">
                    <i class="fas fa-paper-plane"></i> Ajukan Reservasi Eksternal
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalFasilitas" class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black/70 backdrop-blur-sm p-4 sm:p-6 transition-all duration-300">
    
    <div class="fixed inset-0 cursor-pointer -z-10" onclick="tutupModalFasilitas()"></div>
    
    <div class="flex min-h-full items-center justify-center pointer-events-none w-full max-w-4xl mx-auto">
        
        <div id="modalContent" class="relative bg-[#15181f] border border-gray-700 rounded-2xl md:rounded-3xl w-full max-h-[85vh] flex flex-col shadow-2xl pointer-events-auto transform scale-95 opacity-0 transition-all duration-300 overflow-hidden">
            
            <div class="p-4 md:p-6 lg:p-8 border-b border-gray-700/50 flex justify-between items-start md:items-center bg-[#15181f] shrink-0">
                <div class="pr-4">
                    <h3 class="text-lg md:text-2xl font-bold text-white mb-0.5 md:mb-1">Pilih Fasilitas</h3>
                    <p class="text-[10px] md:text-sm text-gray-400">Pilih gedung serba guna atau lapangan untuk acara Anda.</p>
                </div>
                <button type="button" onclick="tutupModalFasilitas()" class="w-8 h-8 md:w-10 md:h-10 shrink-0 rounded-lg md:rounded-full bg-gray-800/50 md:bg-gray-800 text-gray-400 hover:text-white hover:bg-sipred md:hover:rotate-90 transition-all flex items-center justify-center focus:outline-none">
                    <i class="fas fa-times text-lg md:text-xl"></i>
                </button>
            </div>

            <div class="flex-1 flex flex-col overflow-hidden bg-[#15181f]">
                
                <div class="p-4 md:px-8 md:pt-6 md:pb-4 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" id="inputCariFasilitas" placeholder="Ketik nama fasilitas..." autocomplete="off" class="w-full bg-[#1a1d24] border border-gray-700 rounded-xl pl-11 pr-4 py-3 md:py-3.5 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all shadow-inner">
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-4 pt-0 md:px-8 md:pb-8 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 hover:[&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full" id="wadahFasilitas">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                        @forelse($fasilitas as $f)
                            <div onclick="pilihFasilitas('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}')" class="kartu-fasilitas bg-[#1a1d24] border border-gray-700 hover:border-[#00AE1C] hover:bg-[#00AE1C]/5 rounded-xl md:rounded-2xl p-4 md:p-5 cursor-pointer transition-all group shadow-sm flex flex-col justify-center min-h-[80px] md:min-h-[96px]" data-nama="{{ strtolower($f->nama_fasilitas) }}">
                                <div class="flex items-start gap-3 md:gap-4 pointer-events-none">
                                    
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl bg-[#0f1115] border border-gray-700 flex items-center justify-center text-gray-400 group-hover:text-[#00AE1C] group-hover:bg-[#00AE1C]/10 group-hover:border-[#00AE1C]/30 transition-colors shrink-0">
                                        <i class="fas {{ $f->kategori == 'Lapangan' ? 'fa-futbol' : 'fa-building' }} text-lg md:text-xl"></i>
                                    </div>
                                    
                                    <div class="flex-1 overflow-hidden">
                                        <h4 class="text-white font-bold group-hover:text-[#00AE1C] transition-colors text-xs md:text-sm mb-1.5 md:mb-1.5 leading-tight nama-fasilitas-teks line-clamp-2">{{ $f->nama_fasilitas }}</h4>
                                        <span class="inline-flex items-center justify-center bg-[#15181f] border border-gray-800 text-gray-300 text-[9px] md:text-[10px] font-bold px-2 py-0.5 md:px-2 md:py-1 rounded md:rounded-md uppercase tracking-wider truncate max-w-full">{{ $f->kategori }}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-10 md:py-12 text-center text-gray-500" id="kosongDariDatabase">
                                <i class="fas fa-box-open text-3xl md:text-4xl mb-3"></i>
                                <p class="text-xs md:text-sm">Fasilitas umum belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="col-span-full py-10 md:py-12 text-center text-gray-500 hidden flex-col items-center justify-center" id="pesanTidakDitemukan">
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-gray-800/50 rounded-full flex items-center justify-center mb-3 text-gray-500 mx-auto">
                            <i class="fas fa-search-minus text-xl md:text-2xl"></i>
                        </div>
                        <p class="text-xs md:text-sm font-bold text-white">Fasilitas tidak ditemukan.</p>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

<script src="{{ asset('assets/js/reservasi-eksternal.js') }}?v={{ time() }}"></script>

<script>
    function bukaModalFasilitas() {
        const modal = document.getElementById('modalFasilitas');
        const modalBox = document.getElementById('modalContent');
        if(modal) {
            modal.style.display = 'block';
            setTimeout(() => {
                if(modalBox) {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }
            }, 20);
        }
    }

    function tutupModalFasilitas() {
        const modal = document.getElementById('modalFasilitas');
        const modalBox = document.getElementById('modalContent');
        if(modal) {
            if(modalBox) {
                modalBox.classList.remove('scale-100', 'opacity-100');
                modalBox.classList.add('scale-95', 'opacity-0');
            }
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }
</script>
@endsection