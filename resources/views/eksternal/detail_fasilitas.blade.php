@extends('layouts.eksternal')

@section('content')

<!-- PENGAMAN TINGGI KARTU (Responsif) -->
<style>
    .kartu-fasilitas-safe {
        height: 150px;
        min-height: 150px;
    }
    @media (min-width: 768px) {
        .kartu-fasilitas-safe {
            height: 320px;
            min-height: 320px;
        }
    }
</style>

<!-- HEADER DAN PENCARIAN -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 md:gap-6 mb-5 md:mb-6">
    <div class="w-full md:w-1/2 lg:w-3/5">
        <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Katalog Fasilitas</h2>
        <p class="text-xs md:text-sm text-gray-400 mt-1.5 md:mt-2 font-medium">Lihat rincian informasi, kapasitas, dan harga sewa fasilitas kampus.</p>
    </div>
    
    <div class="w-full md:w-1/2 lg:w-2/5 bg-[#1a1d24] border border-gray-700 rounded-xl p-1 flex items-center shadow-lg focus-within:border-sipblue focus-within:ring-1 focus-within:ring-sipblue transition-all">
        <div class="px-3 md:px-4 text-gray-400"><i class="fas fa-search"></i></div>
        <input type="text" id="inputCariFasilitas" onkeyup="filterKatalog()" placeholder="Cari nama ruangan atau kategori..." class="w-full bg-transparent border-none text-white text-xs md:text-sm py-2.5 md:py-3 focus:outline-none focus:ring-0 placeholder-gray-500">
    </div>
</div>

<!-- DETAIL / PEMBATAS VISUAL (Tambahan Jarak & Info) -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-10 md:mb-14 pb-4 border-b border-gray-700/50">
    <div class="flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-sipblue animate-pulse"></div>
        <p class="text-xs md:text-sm text-gray-400 font-medium">
            Menampilkan <span class="text-white font-bold" id="totalFasilitas">{{ count($q_fasilitas) }}</span> fasilitas
        </p>
    </div>
</div>



<!-- GRID KARTU FASILITAS -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-8 pb-10" id="gridKatalog">
    @forelse($q_fasilitas as $fasilitas)
        @php
            $gambar_tampil = $fasilitas->foto_fasilitas 
                            ? asset('assets/images/fasilitas/' . $fasilitas->foto_fasilitas) 
                            : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop';
            
            $harga_format = 'Rp ' . number_format($fasilitas->harga_per_hari ?? 0, 0, ',', '.');
        @endphp
        
        <div onclick="bukaModalFasilitas(this)"
             data-nama="{{ $fasilitas->nama_fasilitas }}"
             data-kategori="{{ $fasilitas->kategori }}"
             data-kapasitas="{{ $fasilitas->kapasitas }}"
             data-harga="{{ $harga_format }}"
             data-status="{{ strtolower($fasilitas->status) }}"
             data-gambar="{{ $gambar_tampil }}"
             class="kartu-fasilitas kartu-fasilitas-safe relative w-full rounded-2xl md:rounded-3xl overflow-hidden group cursor-pointer shadow-xl border border-gray-700 hover:border-sipblue transition-all duration-500 transform hover:-translate-y-1 md:hover:-translate-y-2 flex flex-col justify-end">
            
            <img src="{{ $gambar_tampil }}" alt="{{ $fasilitas->nama_fasilitas }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 z-0">
            
            <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/80 md:via-[#0f1115]/60 to-transparent opacity-95 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
            
            <div class="relative z-20 w-full p-4 md:p-6 translate-y-1.5 md:translate-y-4 group-hover:translate-y-0 transition-transform duration-500 mt-auto">
                <div class="flex items-center gap-1.5 md:gap-2 mb-1.5 md:mb-3 flex-wrap">
                    <span class="px-2 md:px-3 py-0.5 md:py-1 text-[8px] md:text-[10px] font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30 tracking-wider">
                        <i class="fas fa-users mr-1"></i> {{ $fasilitas->kapasitas }}
                    </span>
                    <span class="px-2 md:px-3 py-0.5 md:py-1 text-[8px] md:text-[10px] font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20 uppercase tracking-wider">
                        {{ $fasilitas->kategori }}
                    </span>
                </div>
                <h4 class="nama-ruangan text-sm md:text-xl font-bold text-white mb-0.5 md:mb-1 group-hover:text-sipblue transition-colors line-clamp-2 leading-tight">{{ $fasilitas->nama_fasilitas }}</h4>
                <p class="text-[10px] md:text-sm font-black text-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-75 hidden md:block">
                    Lihat Detail & Harga <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </p>
            </div>
        </div>
    @empty
        <div class="col-span-full w-full text-center py-12 md:py-16 bg-[#1a1d24] border border-gray-700 border-dashed rounded-2xl md:rounded-3xl mx-auto">
            <i class="fas fa-building text-3xl md:text-4xl text-gray-600 mb-3 md:mb-4"></i>
            <p class="text-xs md:text-sm text-gray-400 font-medium">Belum ada fasilitas kampus yang tersedia.</p>
        </div>
    @endforelse

    <div id="pesanTidakKetemu" class="hidden col-span-full w-full text-center py-12 md:py-16 bg-[#1a1d24] border border-gray-700 border-dashed rounded-2xl md:rounded-3xl mx-auto">
        <i class="fas fa-search-minus text-3xl md:text-4xl text-gray-600 mb-3 md:mb-4"></i>
        <p class="text-xs md:text-sm text-gray-400 font-medium">Fasilitas yang Anda cari tidak ditemukan.</p>
    </div>
</div>

<!-- ==============================================
     MODAL POP-UP DETAIL FASILITAS 
     ============================================== -->
<div id="modalDetailFasilitas" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4 sm:p-6 transition-opacity duration-300">
    
    <div class="absolute inset-0 cursor-pointer -z-10" onclick="tutupModalFasilitas()"></div>
    
    <div id="modalDetailContent" class="relative bg-[#1a1d24] border border-gray-700 rounded-2xl md:rounded-3xl w-full max-w-4xl max-h-[90vh] flex flex-col md:flex-row shadow-2xl pointer-events-auto transform scale-95 opacity-0 transition-all duration-300 overflow-hidden">
        
        <button onclick="tutupModalFasilitas()" class="absolute top-3 right-3 md:top-4 md:right-4 z-50 w-8 h-8 md:w-10 md:h-10 rounded-full bg-black/60 text-white hover:bg-sipred flex items-center justify-center backdrop-blur-md transition-all focus:outline-none border border-white/10">
            <i class="fas fa-times text-sm md:text-base"></i>
        </button>

        <!-- KIRI: GAMBAR (Diubah ke md:h-[450px] agar absolut mengunci gambar di Desktop) -->
        <div class="w-full md:w-5/12 md:flex-none h-48 sm:h-56 md:h-[450px] relative bg-[#0f1115] shrink-0 overflow-hidden">
            <img id="mdl_gambar" src="" alt="Foto Fasilitas" class="w-full h-full object-cover z-0">
            <div class="absolute inset-0 bg-gradient-to-t from-[#1a1d24] md:from-transparent via-transparent to-transparent md:bg-gradient-to-r md:from-transparent md:to-[#1a1d24] z-10"></div>
        </div>

        <!-- KANAN: DETAIL (Diubah ke md:h-[450px] dan scroll mandiri) -->
        <div class="w-full md:w-7/12 md:flex-none p-5 md:p-8 flex flex-col md:h-[450px] overflow-y-auto [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 hover:[&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full">
            
            <!-- TAGS -->
            <div class="flex flex-wrap items-center gap-2 mb-2 md:mb-3">
                <span id="mdl_kategori" class="px-2.5 py-1 md:px-3 rounded-lg bg-sipblue text-white text-[9px] md:text-[10px] font-bold shadow-lg uppercase tracking-widest"></span>
                <span id="mdl_status"></span>
            </div>
            
            <h2 id="mdl_nama" class="text-xl md:text-3xl font-extrabold text-white mb-2 md:mb-4 leading-tight"></h2>
            
            <div class="mb-4 md:mb-6 pb-4 md:pb-6 border-b border-gray-700/50 flex items-baseline gap-1.5 md:gap-2">
                <span id="mdl_harga" class="text-2xl md:text-3xl font-black text-orange-500"></span>
                <span class="text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-wider">/ HARI</span>
            </div>
            
            <div class="flex items-center gap-3 md:gap-4 mb-5 md:mb-6 text-xs md:text-sm">
                <div class="flex items-center gap-2 bg-[#0f1115] border border-gray-700 px-3 py-2 md:px-4 md:py-2.5 rounded-lg md:rounded-xl shadow-sm">
                    <i class="fas fa-users text-sipblue"></i>
                    <span class="font-bold text-white"><span id="mdl_kapasitas"></span> Orang</span>
                </div>
            </div>

            <div class="mb-6 md:mb-8">
                <h3 class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2 flex items-center gap-2">
                    <i class="fas fa-info-circle text-sipblue"></i> Informasi
                </h3>
                <p class="text-gray-300 text-xs md:text-sm leading-relaxed text-justify">
                    Fasilitas ini dikelola resmi oleh UPN "Veteran" Jawa Timur. Harga yang tertera adalah tarif sewa per hari untuk instansi/pihak eksternal. Silakan ajukan reservasi untuk mengecek ketersediaan jadwal dan melakukan pemesanan.
                </p>
            </div>

            <div class="mt-auto pt-4 border-t border-gray-700/50 md:border-0 md:pt-0">
                <a href="{{ route('eksternal.reservasi') }}" class="w-full bg-[#00AE1C] hover:bg-green-700 text-white font-bold py-3.5 md:py-4 rounded-xl shadow-lg shadow-green-500/30 transition-all flex items-center justify-center gap-2 active:scale-[0.98] text-sm md:text-base">
                    <i class="fas fa-calendar-plus"></i> Pesan Fasilitas Ini
                </a>
            </div>
        </div>
        
    </div>
</div>

<!-- ==========================================
     SCRIPT PENCARIAN REAL-TIME
     ========================================== -->
<script>
    function filterKatalog() {
        let input = document.getElementById('inputCariFasilitas').value.toLowerCase();
        let kartuFasilitas = document.querySelectorAll('.kartu-fasilitas');
        let pesanKosong = document.getElementById('pesanTidakKetemu');
        let adaYangKetemu = false;

        kartuFasilitas.forEach(kartu => {
            let isiTeks = kartu.innerText.toLowerCase();
            if (isiTeks.includes(input)) {
                kartu.style.display = "flex"; 
                adaYangKetemu = true;
            } else {
                kartu.style.display = "none";
            }
        });

        if (!adaYangKetemu && kartuFasilitas.length > 0) {
            pesanKosong.classList.remove('hidden');
        } else {
            pesanKosong.classList.add('hidden');
        }
    }
</script>

<script src="{{ asset('assets/js/eksternal-detail-fasilitas.js') }}?v={{ time() }}"></script>
@endsection