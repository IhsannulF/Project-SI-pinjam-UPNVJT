@extends('layouts.eksternal')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-white tracking-tight">Katalog Fasilitas</h2>
        <p class="text-gray-400 mt-1 text-sm font-medium">Lihat rincian informasi, kapasitas, dan harga sewa fasilitas kampus.</p>
    </div>
    
    <!-- BARIS PENCARIAN (SEARCH BAR) -->
    <div class="w-full md:w-96 bg-[#1a1d24] border border-gray-700 rounded-xl p-1 flex items-center shadow-lg focus-within:border-sipblue focus-within:ring-1 focus-within:ring-sipblue transition-all">
        <div class="px-4 text-gray-400"><i class="fas fa-search"></i></div>
        <input type="text" id="inputCariFasilitas" onkeyup="filterKatalog()" placeholder="Cari nama ruangan atau kategori..." class="w-full bg-transparent border-none text-white text-sm py-2.5 focus:outline-none focus:ring-0 placeholder-gray-500">
    </div>
</div>

<!-- GRID KARTU FASILITAS -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 pb-10" id="gridKatalog">
    @forelse($q_fasilitas as $fasilitas)
        @php
            $gambar_tampil = $fasilitas->foto_fasilitas 
                            ? asset('assets/images/fasilitas/' . $fasilitas->foto_fasilitas) 
                            : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop';
            
            $harga_format = 'Rp ' . number_format($fasilitas->harga_per_hari ?? 0, 0, ',', '.');
        @endphp
        
        <!-- Tambahkan class 'kartu-fasilitas' di sini untuk target pencarian -->
        <div onclick="bukaModalFasilitas(this)"
             data-nama="{{ $fasilitas->nama_fasilitas }}"
             data-kategori="{{ $fasilitas->kategori }}"
             data-kapasitas="{{ $fasilitas->kapasitas }}"
             data-harga="{{ $harga_format }}"
             data-status="{{ strtolower($fasilitas->status) }}"
             data-gambar="{{ $gambar_tampil }}"
             class="kartu-fasilitas w-full h-[320px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-2xl border border-gray-700 hover:border-sipblue transition-all duration-500 transform hover:-translate-y-2">
            
            <img src="{{ $gambar_tampil }}" alt="{{ $fasilitas->nama_fasilitas }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/60 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 text-[10px] font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30 tracking-wider">
                        <i class="fas fa-users mr-1"></i> {{ $fasilitas->kapasitas }}
                    </span>
                    <span class="px-3 py-1 text-[10px] font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20 uppercase tracking-wider">
                        {{ $fasilitas->kategori }}
                    </span>
                </div>
                <!-- Teks nama dan kategori inilah yang akan dibaca oleh JavaScript -->
                <h4 class="nama-ruangan text-xl font-bold text-white mb-1 group-hover:text-sipblue transition-colors">{{ $fasilitas->nama_fasilitas }}</h4>
                <p class="text-sm font-black text-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-75">
                    Lihat Detail & Harga <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </p>
            </div>
        </div>
    @empty
        <div class="col-span-full w-full text-center py-16 bg-[#1a1d24] border border-gray-700 border-dashed rounded-3xl mx-auto">
            <i class="fas fa-building text-4xl text-gray-600 mb-3"></i>
            <p class="text-gray-400 font-medium">Belum ada fasilitas kampus yang tersedia.</p>
        </div>
    @endforelse

    <!-- Tampilan jika hasil pencarian tidak ditemukan -->
    <div id="pesanTidakKetemu" class="hidden col-span-full w-full text-center py-16 bg-[#1a1d24] border border-gray-700 border-dashed rounded-3xl mx-auto">
        <i class="fas fa-search-minus text-4xl text-gray-600 mb-3"></i>
        <p class="text-gray-400 font-medium">Fasilitas yang Anda cari tidak ditemukan.</p>
    </div>
</div>

<!-- MODAL POP-UP DETAIL FASILITAS -->
<div id="modalDetailFasilitas" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalFasilitas()"></div>
    
    <div class="relative w-full max-w-4xl bg-sipdark border border-sipborder rounded-3xl shadow-2xl flex flex-col transform scale-95 opacity-0 transition-all duration-300 overflow-hidden" id="modalDetailContent">
        
        <button onclick="tutupModalFasilitas()" class="absolute top-4 right-4 z-50 w-10 h-10 rounded-full bg-black/50 text-white hover:bg-sipred flex items-center justify-center backdrop-blur-md transition-all">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex flex-col md:flex-row h-full max-h-[85vh] overflow-y-auto [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700">
            
            <div class="w-full md:w-1/2 h-64 md:h-auto relative bg-[#1a1d24]">
                <img id="mdl_gambar" src="" alt="Foto Fasilitas" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-sipdark to-transparent md:hidden"></div>
                
                <div class="absolute top-4 left-4 flex gap-2">
                    <span id="mdl_kategori" class="px-3 py-1 rounded-lg bg-sipblue text-white text-[10px] font-bold shadow-lg uppercase tracking-widest"></span>
                    <span id="mdl_status" class="px-3 py-1 rounded-lg text-white text-[10px] font-bold shadow-lg uppercase tracking-widest border"></span>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 flex flex-col">
                <h2 id="mdl_nama" class="text-3xl font-extrabold text-white mb-4 leading-tight"></h2>
                
                <div class="mb-6 pb-6 border-b border-gray-700/50 flex items-baseline gap-2">
                    <span id="mdl_harga" class="text-3xl font-black text-orange-500"></span>
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">/ HARI</span>
                </div>
                
                <div class="flex items-center gap-4 mb-6 text-sm">
                    <div class="flex items-center gap-2 bg-[#1a1d24] border border-gray-700 px-4 py-2.5 rounded-xl shadow-sm">
                        <i class="fas fa-users text-sipblue"></i>
                        <span class="font-bold text-white"><span id="mdl_kapasitas"></span> Orang</span>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sipblue"></i> Informasi
                    </h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Fasilitas ini dikelola resmi oleh UPN "Veteran" Jawa Timur. Harga yang tertera adalah tarif sewa per hari untuk instansi/pihak eksternal. Silakan ajukan reservasi untuk mengecek ketersediaan jadwal.
                    </p>
                </div>

                <div class="mt-auto pt-4">
                    <a href="{{ route('eksternal.reservasi') }}" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-4 rounded-xl shadow-lg shadow-sipblue/30 transition-all flex items-center justify-center gap-2 active:scale-95">
                        <i class="fas fa-calendar-plus"></i> Pesan Fasilitas Ini
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- ==========================================
     SCRIPT PENCARIAN REAL-TIME
     ========================================== -->
<script>
    function filterKatalog() {
        // Ambil teks yang diketik pengguna dan ubah jadi huruf kecil semua
        let input = document.getElementById('inputCariFasilitas').value.toLowerCase();
        let kartuFasilitas = document.querySelectorAll('.kartu-fasilitas');
        let pesanKosong = document.getElementById('pesanTidakKetemu');
        let adaYangKetemu = false;

        // Cek setiap kartu satu per satu
        kartuFasilitas.forEach(kartu => {
            // Ambil nama ruangan dan kategori di dalam kartu tersebut
            let isiTeks = kartu.innerText.toLowerCase();
            
            // Jika isi kartu mengandung kata yang dicari, tampilkan. Jika tidak, sembunyikan.
            if (isiTeks.includes(input)) {
                kartu.style.display = "block";
                adaYangKetemu = true;
            } else {
                kartu.style.display = "none";
            }
        });

        // Munculkan pesan peringatan jika teks sembarang dimasukkan dan hasilnya kosong
        if (!adaYangKetemu && kartuFasilitas.length > 0) {
            pesanKosong.classList.remove('hidden');
        } else {
            pesanKosong.classList.add('hidden');
        }
    }
</script>

<!-- Script Pop-up tetap dipanggil -->
<script src="{{ asset('assets/js/eksternal-detail-fasilitas.js') }}"></script>
@endsection