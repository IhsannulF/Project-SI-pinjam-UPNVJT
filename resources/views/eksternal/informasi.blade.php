@extends('layouts.eksternal')

@section('content')
<!-- HEADER -->
<div class="mb-6 md:mb-8">
    <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Panduan & Unduhan</h2>
    <p class="text-xs md:text-sm text-gray-400 mt-1.5 md:mt-2 font-medium">Informasi tata cara pembayaran dan format dokumen perizinan untuk pihak eksternal.</p>
</div>

<!-- GRID UTAMA -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 md:gap-8">
    
    <!-- KOLOM KIRI: DOWNLOAD TEMPLATE MOU -->
    <div class="bg-gradient-to-br from-[#15181f] to-[#0f1115] border border-gray-700 rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 right-0 p-4 md:p-6 text-sipblue/5 pointer-events-none">
            <i class="fas fa-file-signature text-7xl md:text-9xl"></i>
        </div>
        
        <div class="relative z-10 mb-6 md:mb-8">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-sipblue/10 flex items-center justify-center text-sipblue mb-4 md:mb-6 border border-sipblue/20">
                <i class="fas fa-file-pdf text-xl md:text-2xl"></i>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Template Surat MoU</h3>
            <p class="text-gray-400 text-xs md:text-sm leading-relaxed">
                Setiap peminjaman oleh instansi luar / pihak eksternal wajib melampirkan Surat Perjanjian Kerja Sama (MoU). Silakan unduh format baku yang telah kami sediakan, lengkapi datanya, tandatangani, dan unggah kembali pada form reservasi dalam format PDF.
            </p>
        </div>

        <div class="relative z-10 mt-auto">
            <!-- CATATAN DEVELOPER: Pastikan Anda meletakkan file template-nya di folder public/assets/file/Template_MoU.pdf -->
            <a href="{{ asset('assets/file/Template_MoU.pdf') }}" download class="w-full sm:w-auto flex justify-center items-center gap-2.5 bg-sipblue hover:bg-sipbluehover text-white px-6 py-3 md:px-8 md:py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-95 group text-sm md:text-base">
                <i class="fas fa-cloud-download-alt group-hover:-translate-y-1 transition-transform"></i> Unduh Template MoU
            </a>
        </div>
    </div>

    <!-- KOLOM KANAN: INFORMASI PEMBAYARAN -->
    <div class="bg-[#15181f] border border-gray-700 rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-xl">
        <div class="mb-5 md:mb-6 pb-5 md:pb-6 border-b border-gray-700/50">
            <h3 class="text-lg md:text-xl font-bold text-white mb-1 flex items-center gap-2">
                <i class="fas fa-wallet text-[#00AE1C]"></i> Rekening Pembayaran
            </h3>
            <p class="text-[10px] md:text-xs text-gray-400">Pilih salah satu metode pembayaran di bawah ini. Harap simpan struk sebagai bukti.</p>
        </div>

        <div class="space-y-4">
            <!-- KARTU BCA -->
            <div class="bg-[#1a1d24] border border-gray-700 hover:border-[#005AAA] rounded-xl md:rounded-2xl p-4 md:p-5 transition-all group relative overflow-hidden">
                <div class="absolute right-0 top-0 bottom-0 w-1 md:w-1.5 bg-[#005AAA] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start mb-3 md:mb-4">
                    <div>
                        <h4 class="text-[10px] md:text-sm font-bold text-gray-400 uppercase tracking-widest mb-0.5 md:mb-1">Bank Central Asia (BCA)</h4>
                        <div class="text-xl md:text-2xl font-extrabold text-white tracking-wider flex items-center gap-3" id="rek-bca">
                            6730495054
                        </div>
                    </div>
                    <!-- Icon / Logo Bank Teks (Jika tidak ada gambar logo) -->
                    <div class="text-[#005AAA] font-black text-lg md:text-xl italic tracking-tighter">BCA</div>
                </div>
                <div class="flex justify-between items-center bg-[#0f1115] rounded-lg md:rounded-xl p-2.5 md:p-3 border border-gray-700/50">
                    <div class="flex items-center gap-1.5 md:gap-2 text-xs md:text-sm text-gray-300 font-medium truncate pr-2">
                        <i class="fas fa-user-circle text-gray-500 shrink-0"></i> 
                        <span class="truncate">a/n Muhammad Ihsanul Fikri</span>
                    </div>
                    <button onclick="copyTeks('6730495054', 'BCA')" class="text-sipblue hover:text-white text-[10px] md:text-xs font-bold px-2.5 py-1 md:px-3 md:py-1.5 bg-sipblue/10 hover:bg-sipblue rounded-md md:rounded-lg transition-all shrink-0">
                        <i class="far fa-copy mr-1"></i> Salin
                    </button>
                </div>
            </div>

            <!-- KARTU BNI -->
            <div class="bg-[#1a1d24] border border-gray-700 hover:border-[#F15A23] rounded-xl md:rounded-2xl p-4 md:p-5 transition-all group relative overflow-hidden">
                <div class="absolute right-0 top-0 bottom-0 w-1 md:w-1.5 bg-[#F15A23] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start mb-3 md:mb-4">
                    <div>
                        <h4 class="text-[10px] md:text-sm font-bold text-gray-400 uppercase tracking-widest mb-0.5 md:mb-1">Bank Negara Indonesia (BNI)</h4>
                        <div class="text-xl md:text-2xl font-extrabold text-white tracking-wider flex items-center gap-3" id="rek-bni">
                            1868600210
                        </div>
                    </div>
                    <div class="text-[#F15A23] font-black text-lg md:text-xl italic tracking-tighter">BNI</div>
                </div>
                <div class="flex justify-between items-center bg-[#0f1115] rounded-lg md:rounded-xl p-2.5 md:p-3 border border-gray-700/50">
                    <div class="flex items-center gap-1.5 md:gap-2 text-xs md:text-sm text-gray-300 font-medium truncate pr-2">
                        <i class="fas fa-user-circle text-gray-500 shrink-0"></i> 
                        <span class="truncate">a/n Muhammad Ihsanul Fikri</span>
                    </div>
                    <button onclick="copyTeks('1868600210', 'BNI')" class="text-[#F15A23] hover:text-white text-[10px] md:text-xs font-bold px-2.5 py-1 md:px-3 md:py-1.5 bg-[#F15A23]/10 hover:bg-[#F15A23] rounded-md md:rounded-lg transition-all shrink-0">
                        <i class="far fa-copy mr-1"></i> Salin
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPT UNTUK FITUR COPY TO CLIPBOARD -->
<!-- ========================================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function copyTeks(teks, bank) {
        navigator.clipboard.writeText(teks).then(() => {
            Swal.fire({
                title: 'Berhasil Disalin!',
                text: `Nomor rekening ${bank} (${teks}) telah disalin ke clipboard.`,
                icon: 'success',
                background: '#16181e',
                color: '#fff',
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'rounded-2xl border border-gray-700' }
            });
        }).catch(err => {
            console.error('Gagal menyalin teks: ', err);
            // Fallback alert jika clipboard API diblokir browser
            alert('Gagal menyalin. Silakan blok teks secara manual.');
        });
    }
</script>
@endsection