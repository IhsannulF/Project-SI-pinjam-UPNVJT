<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman - Mahasiswa SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-xs font-bold text-sipblue uppercase tracking-widest">Panel Mahasiswa</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-home text-lg group-hover:text-sipblue transition-colors"></i> Dashboard
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('mahasiswa.cari_fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-search text-lg group-hover:text-sipblue transition-colors"></i> Cari Fasilitas
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('mahasiswa.pinjam.form') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-calendar-plus text-lg"></i> Buat Jadwal Pinjam
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-history text-lg group-hover:text-sipblue transition-colors"></i> Riwayat Saya
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Form Pengajuan Peminjaman</h4>
                    <div class="text-sm font-medium text-siptext">Isi formulir di bawah ini untuk mengajukan peminjaman fasilitas kampus.</div>
                </div>
                <div>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-siptext hover:text-white transition-colors border border-sipborder px-4 py-2 rounded-lg bg-sipdark">
                        <i class="fas fa-external-link-alt"></i> Ke Halaman Utama
                    </a>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="max-w-3xl mx-auto">
                    
                    @if(session('error'))
                        <div class="bg-sipred/10 text-sipred border border-sipred/30 px-5 py-4 rounded-2xl mb-6 flex items-start gap-4 shadow-lg">
                            <i class="fas fa-exclamation-triangle text-xl mt-0.5"></i> 
                            <div>
                                <h3 class="font-bold text-sm mb-1">Pengajuan Gagal</h3>
                                <p class="text-xs">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-5 py-4 rounded-2xl mb-6 flex items-start gap-4 shadow-lg">
                            <i class="fas fa-check-circle text-xl mt-0.5"></i>
                            <div>
                                <h3 class="font-bold text-sm mb-1">Berhasil!</h3>
                                <p class="text-xs">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-10 shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1 h-full bg-sipblue"></div>
                        
                        <h2 class="text-xl font-bold mb-8 flex items-center gap-3">
                            <i class="fas fa-file-signature text-sipblue"></i> Detail Peminjaman
                        </h2>

                        <form action="{{ route('mahasiswa.pinjam.store') }}" method="POST" id="formPinjam">
                            @csrf
                            
                            <div class="space-y-6">
                                
                                <div>
                                    <label class="block text-xs font-bold text-siptext uppercase tracking-widest mb-2">Fasilitas yang Dipinjam <span class="text-sipred">*</span></label>
                                    
                                    <input type="hidden" name="id_fasilitas" id="input_id_fasilitas">
                                    
                                    <button type="button" onclick="bukaModalFasilitas()" id="btnPilihFasilitas" class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-4 text-left text-sm text-gray-400 hover:border-sipblue focus:outline-none transition-all flex justify-between items-center group shadow-inner">
                                        <span id="textFasilitasTerpilih" class="flex items-center">
                                            <i class="fas fa-building mr-3 text-gray-500 text-lg"></i> 
                                            <span>-- Klik untuk Cari & Pilih Fasilitas --</span>
                                        </span>
                                        <i class="fas fa-search text-sipblue group-hover:scale-110 transition-transform"></i>
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-siptext uppercase tracking-widest mb-2">Tanggal Penggunaan <span class="text-sipred">*</span></label>
                                    <div class="relative">
                                        <input type="date" name="tanggal_pinjam" required min="{{ date('Y-m-d') }}" class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-sipblue transition-all [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert cursor-pointer">
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Pastikan tanggal yang dipilih tidak bentrok di halaman "Cari Fasilitas".</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-siptext uppercase tracking-widest mb-2">Keperluan / Nama Acara <span class="text-sipred">*</span></label>
                                    <textarea name="keperluan" required rows="4" placeholder="Contoh: Rapat Evaluasi BEM Fasilkom, Pelatihan Jaringan Komputer, dll..." class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-sipblue transition-all placeholder-gray-600 resize-none"></textarea>
                                </div>

                                <div class="bg-sipblue/5 border border-sipblue/20 rounded-xl p-4 flex gap-3 text-sm">
                                    <i class="fas fa-shield-alt text-sipblue mt-1"></i>
                                    <div class="text-gray-300">
                                        <strong class="text-sipblue block mb-1">Penting!</strong>
                                        Pengajuan Anda akan divalidasi terlebih dahulu oleh sistem. Jika jadwal tersedia, status akan menjadi <b>Menunggu Admin (Pending)</b>. Silakan pantau secara berkala di menu Riwayat Saya.
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-sipborder/50">
                                    <button type="submit" id="btnSubmit" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-sipblue/30 active:scale-95 flex justify-center items-center gap-2 text-sm">
                                        <i class="fas fa-paper-plane"></i> Ajukan Peminjaman Fasilitas
                                    </button>
                                </div>
                                
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div id="modalFasilitas" class="fixed inset-0 z-[60] hidden items-center justify-center opacity-0 transition-opacity duration-300">
                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="tutupModalFasilitas()"></div>
                
                <div class="relative bg-[#1a1d24] border border-sipborder rounded-3xl w-full max-w-2xl max-h-[85vh] flex flex-col shadow-2xl transform scale-95 transition-transform duration-300 overflow-hidden" id="modalBox">
                    
                    <div class="p-6 border-b border-sipborder flex justify-between items-center bg-[#15181f]">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-list-ul text-sipblue"></i> Katalog Fasilitas
                        </h3>
                        <button type="button" onclick="tutupModalFasilitas()" class="text-gray-400 hover:text-sipred transition-colors w-8 h-8 flex items-center justify-center rounded-lg hover:bg-sipred/10">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="p-4 border-b border-sipborder bg-[#1a1d24]">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchFasilitas" placeholder="Ketik nama fasilitas (contoh: FIK 2, Kolam Renang)..." class="w-full bg-[#0f1115] border border-gray-700 rounded-xl pl-11 pr-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all placeholder-gray-600">
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-5 space-y-6 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full" id="listFasilitasContainer">
                        
                        @foreach($fasilitas->groupBy('kategori') as $kategori => $items)
                            <div class="kategori-group">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 pl-1 flex items-center gap-2">
                                    <i class="fas fa-tags text-siptext"></i> {{ $kategori ?: 'Lainnya' }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($items as $f)
                                        <button type="button" onclick="pilihFasilitas('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}')" class="fasilitas-item text-left bg-[#15181f] border border-gray-700 hover:border-sipblue hover:bg-sipblue/10 rounded-xl p-4 transition-all group relative overflow-hidden">
                                            <div class="absolute right-0 top-0 w-1 h-full bg-sipblue opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            <div class="font-bold text-white text-sm mb-1.5 group-hover:text-sipblue transition-colors fasilitas-name">{{ $f->nama_fasilitas }}</div>
                                            <div class="text-xs text-gray-400 flex items-center gap-1.5">
                                                <i class="fas fa-user-friends text-siptext"></i> Kapasitas: <span class="text-white">{{ $f->kapasitas }} Org</span>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div id="noResultFasilitas" class="hidden text-center py-10 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-search text-2xl text-gray-500"></i>
                            </div>
                            <h4 class="text-white font-bold mb-1">Fasilitas tidak ditemukan</h4>
                            <p class="text-xs text-gray-400">Coba gunakan kata kunci pencarian yang lain.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/form-pinjam.js') }}"></script>
</body>
</html>