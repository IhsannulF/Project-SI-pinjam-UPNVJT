@extends('layouts.eksternal')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

<div class="p-8">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-white tracking-tight">Reservasi Fasilitas Umum</h2>
        <p class="text-gray-400 mt-2 font-medium">Formulir pengajuan peminjaman fasilitas kampus untuk instansi/pihak eksternal.</p>
    </div>

    @if(session('success'))
        <div class="bg-[#00AE1C]/10 border border-[#00AE1C]/30 text-[#00AE1C] px-6 py-4 rounded-xl mb-8 flex items-center gap-4">
            <i class="fas fa-check-circle text-2xl"></i>
            <div>
                <h4 class="font-bold">Berhasil!</h4>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-sipred/10 border border-sipred/30 text-sipred px-6 py-4 rounded-xl mb-8">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-exclamation-triangle"></i>
                <h4 class="font-bold">Gagal Mengirim Pengajuan!</h4>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#15181f] border border-gray-700 rounded-3xl p-8 shadow-xl">
        <form action="{{ route('eksternal.reservasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="formReservasi">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Pilih Fasilitas</label>
                <input type="hidden" name="id_fasilitas" id="input_id_fasilitas">
                
                <button type="button" onclick="bukaModalFasilitas()" id="btnPilihFasilitas" class="w-full bg-[#1a1d24] border border-gray-700 hover:border-sipblue rounded-xl px-5 py-4 text-left flex justify-between items-center group transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 group-hover:text-sipblue group-hover:bg-sipblue/10 transition-colors" id="iconFasilitas">
                            <i class="fas fa-building"></i>
                        </div>
                        <span id="teks_fasilitas_terpilih" class="text-gray-400 font-medium">-- Klik untuk Mencari & Memilih Fasilitas --</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-500 group-hover:text-sipblue group-hover:translate-x-1 transition-all"></i>
                </button>
                <p id="errorFasilitas" class="text-sipred text-xs mt-2 hidden"><i class="fas fa-exclamation-circle mr-1"></i> Anda wajib memilih fasilitas!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sipblue">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <input type="text" name="tanggal_mulai" id="tanggal_mulai" required placeholder="Pilih Tanggal Mulai..." class="datepicker w-full bg-[#1a1d24] border border-gray-700 rounded-xl pl-11 pr-4 py-4 text-white text-sm focus:outline-none focus:border-sipblue cursor-pointer">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Berakhir</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sipblue">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <input type="text" name="tanggal_berakhir" id="tanggal_berakhir" required placeholder="Pilih Tanggal Berakhir..." class="datepicker w-full bg-[#1a1d24] border border-gray-700 rounded-xl pl-11 pr-4 py-4 text-white text-sm focus:outline-none focus:border-sipblue cursor-pointer">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Keperluan Acara</label>
                <textarea name="keperluan" rows="3" required placeholder="Contoh: Turnamen Futsal Antar Instansi Kota Sidoarjo..." class="w-full bg-[#1a1d24] border border-gray-700 rounded-xl px-5 py-4 text-white text-sm focus:outline-none focus:border-sipblue"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-700/50 mt-6">
                <div class="bg-[#1a1d24] p-5 rounded-2xl border border-gray-700 border-dashed hover:border-sipblue transition-colors">
                    <label class="block text-sm font-bold text-white mb-1"><i class="fas fa-file-pdf text-sipred mr-2"></i> Surat MoU / Perizinan</label>
                    <p class="text-xs text-gray-400 mb-4">Wajib berformat PDF. Maksimal 2MB.</p>
                    <input type="file" name="dokumen_mou" accept=".pdf" required class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-sipblue/10 file:text-sipblue hover:file:bg-sipblue hover:file:text-white transition-all cursor-pointer">
                </div>

                <div class="bg-[#1a1d24] p-5 rounded-2xl border border-gray-700 border-dashed hover:border-[#00AE1C] transition-colors">
                    <label class="block text-sm font-bold text-white mb-1"><i class="fas fa-receipt text-[#00AE1C] mr-2"></i> Bukti Pembayaran</label>
                    <p class="text-xs text-gray-400 mb-4">Format PDF, JPG, atau PNG. Maksimal 2MB.</p>
                    <input type="file" name="bukti_bayar" accept=".pdf,image/*" required class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#00AE1C]/10 file:text-[#00AE1C] hover:file:bg-[#00AE1C] hover:file:text-white transition-all cursor-pointer">
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" onclick="return validasiForm()" class="w-full bg-sipblue hover:bg-sipbluehover text-white py-4 rounded-xl font-bold text-lg transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98] flex items-center justify-center gap-3">
                    <i class="fas fa-paper-plane"></i> Ajukan Reservasi Eksternal
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalFasilitas" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm transition-opacity opacity-0 duration-300">
    <div class="bg-[#15181f] border border-gray-700 rounded-3xl w-full max-w-4xl p-6 md:p-8 shadow-2xl transform scale-95 transition-transform duration-300" id="modalContent">
        
        <div class="flex justify-between items-center mb-4 border-b border-gray-700/50 pb-4">
            <div>
                <h3 class="text-2xl font-bold text-white">Pilih Fasilitas</h3>
                <p class="text-sm text-gray-400 mt-1">Pilih gedung serba guna atau lapangan untuk acara Anda.</p>
            </div>
            <button type="button" onclick="tutupModalFasilitas()" class="w-10 h-10 rounded-full bg-gray-800 text-gray-400 hover:text-white hover:bg-sipred hover:rotate-90 transition-all flex items-center justify-center">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="mb-5 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" id="inputCariFasilitas" placeholder="Ketik nama fasilitas yang ingin dicari..." autocomplete="off" class="w-full bg-[#1a1d24] border border-gray-700 rounded-xl pl-11 pr-4 py-3.5 text-white text-sm focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[50vh] overflow-y-auto pr-2 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full" id="wadahFasilitas">
            
            @forelse($fasilitas as $f)
                <div onclick="pilihFasilitas('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}')" class="kartu-fasilitas bg-[#1a1d24] border border-gray-700 hover:border-sipblue hover:bg-sipblue/5 rounded-2xl p-5 cursor-pointer transition-all group shadow-sm hover:shadow-sipblue/10" data-nama="{{ strtolower($f->nama_fasilitas) }}">
                    <div class="flex items-start gap-4 pointer-events-none">
                        <div class="w-12 h-12 rounded-xl bg-[#0f1115] border border-gray-700 flex items-center justify-center text-gray-400 group-hover:text-sipblue group-hover:bg-sipblue/10 group-hover:border-sipblue/30 transition-colors shrink-0">
                            <i class="fas {{ $f->kategori == 'Lapangan' ? 'fa-futbol' : 'fa-building' }} text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold group-hover:text-sipblue transition-colors text-sm mb-1 leading-tight nama-fasilitas-teks">{{ $f->nama_fasilitas }}</h4>
                            <span class="inline-block bg-gray-800 text-gray-300 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">{{ $f->kategori }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-gray-500" id="kosongDariDatabase">
                    <i class="fas fa-box-open text-4xl mb-3"></i>
                    <p>Fasilitas umum belum tersedia.</p>
                </div>
            @endforelse

            <div class="col-span-full py-10 text-center text-gray-500 hidden" id="pesanTidakDitemukan">
                <i class="fas fa-search-minus text-4xl mb-3"></i>
                <p>Fasilitas yang Anda cari tidak ditemukan.</p>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/reservasi-eksternal.js') }}"></script>
@endsection