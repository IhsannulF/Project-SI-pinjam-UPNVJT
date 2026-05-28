<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Prioritas - Dosen SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    
    @vite('resources/css/app.css')
    
    <style>
        /* Customisasi Flatpickr agar aksennya menjadi kuning/emas VIP */
        .flatpickr-day.selected {
            background: #eab308 !important; /* text-yellow-500 */
            border-color: #eab308 !important;
            color: #15181f !important;
            font-weight: bold;
        }
        /* Menyembunyikan input asli, menampilkan input bentukan flatpickr */
        input[type=date] { display: none; }
    </style>
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-yellow-500 selection:text-sipdark relative">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-xs font-bold text-sipblue uppercase tracking-widest">Panel Dosen & Tendik</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-home text-lg group-hover:text-sipblue transition-colors"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.fasilitas') ?? url('dosen/fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-search text-lg group-hover:text-sipblue transition-colors"></i> Cari Fasilitas
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.reservasi') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-yellow-500/10 text-yellow-500 font-semibold border border-yellow-500/20 transition-all">
                        <i class="fas fa-bolt text-lg"></i> Reservasi Prioritas
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.riwayat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-history text-lg group-hover:text-sipblue transition-colors"></i> Riwayat Pengajuan
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="{{ url('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Form Reservasi Prioritas</h4>
                    <div class="text-sm font-medium text-siptext">Pengajuan tanpa surat pengantar dengan persetujuan instan.</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="max-w-3xl mx-auto">
                    
                    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-6 mb-8 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-yellow-500/20 text-yellow-500 flex items-center justify-center text-xl shrink-0 mt-1">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h5 class="text-yellow-500 font-bold mb-1">Informasi Jalur VIP</h5>
                            <p class="text-sm text-gray-300 leading-relaxed">
                                Anda sedang menggunakan hak akses Dosen/Tendik. Reservasi yang dibuat melalui form ini akan <strong>langsung disetujui</strong> oleh sistem dan jadwal akan otomatis terblokir tanpa perlu menunggu validasi Admin.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('dosen.reservasi.store') }}" method="POST" class="bg-sipdark border border-sipborder rounded-3xl p-8 shadow-xl relative overflow-hidden" id="formReservasi">
                        @csrf
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-transparent"></div>

                        <div class="space-y-6">
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Fasilitas Kampus</label>
                                
                                <input type="hidden" name="id_fasilitas" id="inputHiddenFasilitas" required>
                                
                                <div onclick="bukaModalFasilitas()" class="relative group cursor-pointer">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500 group-hover:text-yellow-500 transition-colors">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div id="tampilanFasilitas" class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-12 pr-12 py-3.5 text-gray-400 text-sm group-hover:border-yellow-500 transition-all flex items-center justify-between">
                                        <span>Klik untuk mencari dan memilih fasilitas...</span>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                                        <i class="fas fa-external-link-square-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                                    <div class="relative">
                                        <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 z-10 pointer-events-none"></i>
                                        <input type="text" id="tgl_mulai" name="tanggal_mulai" placeholder="Pilih Tanggal Mulai" required class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white text-sm focus:outline-none focus:border-yellow-500 transition-all cursor-pointer">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Berakhir</label>
                                    <div class="relative">
                                        <i class="fas fa-calendar-check absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 z-10 pointer-events-none"></i>
                                        <input type="text" id="tgl_berakhir" name="tanggal_berakhir" placeholder="Pilih Tanggal Berakhir" required class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white text-sm focus:outline-none focus:border-yellow-500 transition-all cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Keperluan / Acara</label>
                                <textarea name="keperluan" rows="4" required placeholder="Contoh: Kuliah Pengganti Sistem Informasi, Seminar Nasional..." class="w-full bg-[#15181f] border border-gray-700 rounded-xl p-4 text-white text-sm focus:outline-none focus:border-yellow-500 transition-all placeholder-gray-600 resize-none"></textarea>
                            </div>

                            <div class="pt-4">
                                <button type="button" onclick="validasiSubmit()" class="w-full bg-yellow-500 hover:bg-yellow-400 text-sipdark px-8 py-4 rounded-xl font-extrabold text-sm transition-all shadow-[0_0_20px_rgba(234,179,8,0.3)] flex items-center justify-center gap-2 active:scale-[0.98]">
                                    <i class="fas fa-bolt"></i> Konfirmasi & Booking Instan
                                </button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </main>
    </div>

    <div id="modalFasilitas" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm cursor-pointer" onclick="tutupModalFasilitas()"></div>
        
        <div class="relative w-full max-w-4xl bg-sipdark border border-sipborder rounded-3xl shadow-2xl flex flex-col max-h-[85vh] m-4 transform scale-95 transition-transform duration-300" id="modalContent">
            
            <div class="flex items-center justify-between p-6 border-b border-sipborder bg-[#15181f] rounded-t-3xl">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-building text-yellow-500"></i> Katalog Fasilitas
                </h3>
                <button onclick="tutupModalFasilitas()" class="w-8 h-8 rounded-full bg-gray-800 text-gray-400 hover:bg-sipred hover:text-white flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 border-b border-sipborder bg-sipdark">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="text" id="cariFasilitasModal" placeholder="Ketik nama fasilitas..." class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white text-sm focus:outline-none focus:border-yellow-500 transition-all">
                    </div>
                    <div class="w-full md:w-48 relative">
                        <select id="filterKategoriModal" class="w-full bg-[#15181f] border border-gray-700 rounded-xl pl-4 pr-10 py-3 text-white text-sm focus:outline-none focus:border-yellow-500 transition-all appearance-none cursor-pointer">
                            <option value="semua">Semua Kategori</option>
                            <option value="gsg">GSG</option>
                            <option value="lab">Laboratorium</option>
                            <option value="kelas">Ruang Kelas</option>
                            <option value="rapat">Ruang Rapat</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 bg-[#15181f] rounded-b-3xl [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="daftarFasilitasModal">
                    @foreach($fasilitas as $f)
                        <div class="fasilitas-item bg-sipdark border border-gray-700 rounded-2xl p-4 cursor-pointer hover:border-yellow-500 hover:bg-yellow-500/5 transition-all group"
                             data-id="{{ $f->id_fasilitas }}"
                             data-nama="{{ strtolower($f->nama_fasilitas) }}"
                             data-kategori="{{ strtolower($f->kategori) }}"
                             onclick="pilihFasilitas('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}', '{{ $f->kategori }}')">
                            
                            <h5 class="text-white font-bold text-sm mb-2 group-hover:text-yellow-500">{{ $f->nama_fasilitas }}</h5>
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                <span><i class="fas fa-users text-siptext"></i> {{ $f->kapasitas }} Org</span>
                                <span><i class="fas fa-tag text-siptext"></i> {{ $f->kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div id="pesanKosong" class="hidden text-center py-10 text-gray-500">
                    <i class="fas fa-box-open text-3xl mb-2 opacity-50"></i>
                    <p>Fasilitas tidak ditemukan.</p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/dosen-reservasi.js') }}"></script>
</body>
</html>