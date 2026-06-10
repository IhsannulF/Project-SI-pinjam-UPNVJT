<!DOCTYPE html>
<!-- PERBAIKAN 1: Tambahkan overflow-x-hidden dan w-full di tag HTML -->
<html lang="id" class="scroll-smooth overflow-x-hidden w-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
    <title>SI-PINJAM - Universitas Pembangunan Nasional "Veteran" Jawa Timur</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @vite('resources/css/app.css')
</head>

<!-- PERBAIKAN 2: Tambahkan max-w-full di tag Body -->
<body class="bg-sipbg text-white font-sans antialiased relative overflow-x-hidden w-full max-w-full">
    
    <!-- PERBAIKAN 3: Bungkus efek cahaya dalam wadah fixed anti-bocor -->
    <div class="fixed inset-0 w-full h-full overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] rounded-full bg-sipblue/20 blur-[90px] md:blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[250px] md:w-[400px] h-[250px] md:h-[400px] rounded-full bg-sipblue/10 blur-[80px] md:blur-[100px]"></div>
    </div>

    <!-- HEADER / NAVBAR -->
    <header class="fixed w-full top-0 z-50 bg-sipbg/80 backdrop-blur-md border-b border-sipborder transition-all duration-300">
        <div class="w-full px-4 sm:px-6 md:px-12 lg:px-20 mx-auto">
            <div class="flex justify-between items-center h-16 md:h-20">
                
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-base sm:text-lg md:text-xl font-bold tracking-wide z-[60] shrink-0">
                    SI-PINJAM <span class="text-sipblue">UPNVJT</span>
                </a>

                <!-- Navigasi Desktop -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="#welcome" class="nav-link text-white font-medium hover:text-sipblue transition">Beranda</a>
                    <a href="#perbandingan" class="nav-link text-siptext hover:text-white transition">Hak Akses</a>
                    <a href="#showcase" class="nav-link text-siptext hover:text-white transition">Fasilitas</a>
                    
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ url('admin/dashboard') }}" class="px-5 py-2.5 rounded-full bg-sipborder text-white text-sm font-semibold hover:bg-gray-700 transition flex items-center gap-2">
                                <i class="fas fa-user-shield"></i> Panel Admin
                            </a>
                        @endif
                        
                        <a href="{{ url('logout') }}" class="px-5 py-2.5 rounded-full border border-red-500/50 text-red-500 bg-red-500/10 text-sm font-semibold hover:bg-red-500 hover:text-white transition flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="px-6 py-2.5 rounded-full bg-sipblue text-white text-sm font-semibold hover:bg-sipbluehover shadow-lg shadow-sipblue/30 transition">
                            Log In Akun
                        </a>
                    @endauth
                </nav>

                <!-- Tombol Menu Mobile -->
                <button id="btnMobileMenu" onclick="toggleMobileMenu()" class="md:hidden text-white hover:text-sipblue focus:outline-none transition-colors p-2 relative z-[60] shrink-0 ml-auto">
                    <i id="ikonMobileMenu" class="fas fa-bars text-xl sm:text-2xl"></i>
                </button>

                <!-- Dropdown Menu Mobile -->
                <div id="mobileMenu" class="hidden md:hidden absolute top-16 left-0 w-full bg-sipdark/95 backdrop-blur-md border-b border-sipborder p-6 flex-col space-y-4 shadow-2xl z-50 transition-all">
                    <a href="#welcome" onclick="tutupMobileMenu()" class="text-white font-medium hover:text-sipblue transition">Beranda</a>
                    <a href="#perbandingan" onclick="tutupMobileMenu()" class="text-siptext hover:text-white transition">Hak Akses</a>
                    <a href="#showcase" onclick="tutupMobileMenu()" class="text-siptext hover:text-white transition">Fasilitas</a>
                    
                    <hr class="border-sipborder my-2">
                    
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ url('admin/dashboard') }}" class="w-full py-3 rounded-xl bg-sipborder text-white text-sm font-semibold hover:bg-gray-700 transition flex items-center justify-center gap-2">
                                <i class="fas fa-user-shield"></i> Panel Admin
                            </a>
                        @endif
                        
                        <a href="{{ url('logout') }}" class="w-full py-3 rounded-xl border border-red-500/50 text-red-500 bg-red-500/10 text-sm font-semibold hover:bg-red-500 hover:text-white transition flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="w-full py-3 rounded-xl bg-sipblue text-white text-sm font-semibold hover:bg-sipbluehover shadow-lg shadow-sipblue/30 transition text-center block">
                            Log In Akun
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- SECTION: Beranda -->
    <div class="pt-28 pb-16 md:pt-40 md:pb-28 px-4" id="welcome">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="inline-block py-1.5 px-4 rounded-full bg-sipblue/10 border border-sipblue/30 text-sipblue text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 md:mb-6">
                UPN "Veteran" Jawa Timur
            </div>
            
            <h1 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold text-white leading-snug md:leading-tight mb-4 md:mb-6">
                Peminjaman Fasilitas UPN <br class="hidden md:block">
                <span class="text-sipblue">"Veteran" Jawa Timur</span>
            </h1>
            
            <p class="text-xs sm:text-sm md:text-base text-siptext mb-8 px-2 md:px-0 max-w-2xl mx-auto leading-relaxed">
                SI-PINJAM adalah Platform digital terpadu untuk memudahkan civitas akademika dan masyarakat umum dalam melakukan reservasi peminjaman fasilitas kampus di UPN "Veteran" Jawa Timur.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 md:gap-4 px-4 md:px-0 max-w-xs sm:max-w-none mx-auto">
                <a href="#perbandingan" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 rounded-full bg-sipblue text-white font-bold hover:bg-sipbluehover shadow-lg shadow-sipblue/30 transition-all text-center text-xs md:text-base">
                    Lihat Perbandingan Akses
                </a>
                <a href="{{ url('jadwal-fasilitas') }}" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 rounded-full bg-transparent border border-sipborder text-siptext hover:text-white hover:border-sipblue font-bold transition-all text-center text-xs md:text-base">
                    Lihat Jadwal Fasilitas
                </a>
            </div>

            @auth
                <div class="mt-4 md:mt-6 flex justify-center px-4 md:px-0 max-w-xs sm:max-w-none mx-auto">
                    @if(Auth::user()->role === 'mahasiswa')
                        <a href="{{ url('dashboard/mahasiswa') }}" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 rounded-full bg-[#00AE1C] text-white font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 text-xs md:text-base">
                            <i class="fas fa-calendar-plus"></i> Buat Jadwal (Mahasiswa)
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ url('admin/dashboard') }}" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 rounded-full bg-siptext text-white font-semibold hover:bg-gray-500 transition shadow-lg shadow-gray-500/30 flex items-center justify-center gap-2 text-xs md:text-base">
                            <i class="fas fa-user-shield"></i> Masuk Panel Admin
                        </a>
                    @else
                        <a href="{{ url('dashboard') }}" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 rounded-full bg-[#00AE1C] text-white font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 text-xs md:text-base">
                            <i class="fas fa-calendar-plus"></i> Buat Jadwal
                        </a>
                    @endif
                </div>
            @endauth

        </div>
    </div>

    <!-- SECTION: Hak Akses -->
    <section class="py-16 md:py-24 bg-sipbg" id="perbandingan">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 w-full">
            
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Pilih Akses Sesuai Status Anda</h2>
                <p class="text-sm md:text-base text-siptext max-w-2xl mx-auto">Sistem kami membedakan alur birokrasi dan ketersediaan fasilitas berdasarkan role pengguna untuk memastikan efisiensi.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Kartu Mahasiswa -->
                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 md:p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/5 hover:border-sipblue/30 transition-all duration-300">
                    <div class="border-b border-sipborder pb-6 mb-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Mahasiswa / UKM</h3>
                        <div class="text-2xl md:text-3xl font-extrabold text-white mb-1">Gratis</div>
                        <div class="text-sm text-sipblue font-medium">Akademik & Organisasi</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Login via NPM Mahasiswa</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Kelas & Lab Fakultas</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Lapangan Olahraga</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> <span><strong>Wajib:</strong> Surat Izin BEM/Wadek</span></li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1 shrink-0"></i> Akses Bebas GSG & Auditorium</li>
                    </ul>
                    @auth
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? url('admin/antrean') : url('login') }}" class="flex justify-center items-center gap-2 w-full bg-sipblue hover:bg-sipbluehover text-white px-6 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
                            @if(Auth::check() && Auth::user()->role == 'admin')
                                <i class="fas fa-list-ul"></i> Lihat Permintaan
                            @else
                                <i class="fas fa-calendar-plus"></i> Buat Jadwal
                            @endif
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="block w-full py-3 text-center rounded-xl border border-sipborder text-white hover:border-sipblue hover:bg-sipblue/10 transition">Lanjut Login</a>
                    @endauth
                </div>

                <!-- Kartu Dosen (Prioritas) -->
                <div class="bg-sipdark border border-sipblue relative rounded-2xl p-6 md:p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/20 transition-all duration-300 mt-4 md:mt-0 lg:-mt-4">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-sipblue text-white text-[10px] md:text-xs font-bold px-4 py-1 rounded-b-lg tracking-widest">PRIORITAS</div>
                    <div class="border-b border-sipborder pb-6 mb-6 mt-2">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Dosen & Tendik</h3>
                        <div class="text-2xl md:text-3xl font-extrabold text-sipblue mb-1">Gratis</div>
                        <div class="text-sm text-sipblue font-medium">Prioritas Utama</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Login via NIP Pegawai</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Semua Ruang Kelas & Lab</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Auditorium & Seminar</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Gedung Serba Guna (GSG)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> <span><strong>Bebas:</strong> Tanpa Surat Pengantar</span></li>
                    </ul>
                    @auth
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? url('admin/antrean') : url('login') }}" class="flex justify-center items-center gap-2 w-full bg-sipblue hover:bg-sipbluehover text-white px-6 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
                            @if(Auth::check() && Auth::user()->role == 'admin')
                                <i class="fas fa-list-ul"></i> Lihat Permintaan
                            @else
                                <i class="fas fa-calendar-plus"></i> Buat Jadwal
                            @endif
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="block w-full py-3 text-center rounded-xl border border-sipborder text-white hover:border-sipblue hover:bg-sipblue/10 transition">Lanjut Login</a>
                    @endauth
                </div>

                <!-- Kartu Umum -->
                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 md:p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/5 hover:border-sipblue/30 transition-all duration-300 mt-4 lg:mt-0">
                    <div class="border-b border-sipborder pb-6 mb-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Umum / Eksternal</h3>
                        <div class="text-2xl md:text-3xl font-extrabold text-white mb-1">Berbayar</div>
                        <div class="text-sm text-sipblue font-medium">Sesuai Tarif Sewa</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Login via NIK (KTP)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Gedung Serba Guna (GSG)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> Akses Lapangan Olahraga Umum</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue shrink-0"></i> <span><strong>Wajib:</strong> MoU & Bukti Bayar</span></li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1 shrink-0"></i> Akses Ruang Kelas Pembelajaran</li>
                    </ul>
                    @auth
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? url('admin/antrean') : url('login') }}" class="flex justify-center items-center gap-2 w-full bg-sipblue hover:bg-sipbluehover text-white px-6 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
                            @if(Auth::check() && Auth::user()->role == 'admin')
                                <i class="fas fa-list-ul"></i> Lihat Permintaan
                            @else
                                <i class="fas fa-calendar-plus"></i> Buat Jadwal
                            @endif
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="block w-full py-3 text-center rounded-xl border border-sipborder text-white hover:border-sipblue hover:bg-sipblue/10 transition">Lanjut Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: Fasilitas Showcase -->
    <section id="showcase" class="py-16 md:py-24 relative z-10 bg-sipbg overflow-hidden w-full">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1600px] w-full">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 md:mb-12 gap-6 w-full">
                <div class="max-w-2xl">
                    <h2 class="text-sipblue font-bold tracking-widest uppercase text-sm mb-3">Galeri UPNVJT</h2>
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white mb-4">Fasilitas Kampus <span class="text-transparent bg-clip-text bg-gradient-to-r from-sipblue to-blue-400">Unggulan</span></h3>
                    <p class="text-sm md:text-base text-siptext leading-relaxed">
                        Eksplorasi berbagai ruang representatif yang siap mendukung setiap agenda akademik, organisasi, maupun kegiatan kolaboratif Anda.
                    </p>
                </div>
            </div>
        </div>

        <div id="carouselFasilitas" class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:gap-6 px-4 md:px-12 lg:px-20 pb-12 pt-4 [&::-webkit-scrollbar]:h-1.5 md:[&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-track]:bg-sipdark [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-siptext transition-all w-full">
            
            @forelse($q_fasilitas as $fasilitas)
                @php
                    $gambar_tampil = $fasilitas->foto_fasilitas 
                                    ? asset('assets/images/fasilitas/' . $fasilitas->foto_fasilitas) 
                                    : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop';
                @endphp
                
                <a href="{{ route('fasilitas.detail', $fasilitas->id_fasilitas) }}" class="snap-start shrink-0 w-[85vw] md:w-[500px] lg:w-[600px] h-[300px] md:h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-2xl border border-sipborder/50 hover:border-sipblue transition-all duration-500">
                    <img src="{{ $gambar_tampil }}" alt="{{ $fasilitas->nama_fasilitas }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/60 to-transparent opacity-90"></div>
                    
                    <div class="absolute bottom-0 left-0 w-full p-6 md:p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3">
                            <span class="px-3 py-1 text-[10px] md:text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30">
                                <i class="fas fa-users mr-1"></i> {{ $fasilitas->kapasitas }}
                            </span>
                            <span class="px-3 py-1 text-[10px] md:text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20 uppercase">
                                {{ $fasilitas->kategori }}
                            </span>
                        </div>
                        <h4 class="text-xl md:text-2xl font-bold text-white mb-2">{{ $fasilitas->nama_fasilitas }}</h4>
                        <p class="text-xs md:text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2 hidden md:block">
                            Fasilitas ruangan representatif kategori {{ strtoupper($fasilitas->kategori) }} yang dapat menampung hingga {{ $fasilitas->kapasitas }} pengguna.
                        </p>
                    </div>
                </a>
            @empty
                <div class="w-full text-center py-16 bg-sipdark/50 border border-sipborder border-dashed rounded-3xl mx-auto">
                    <i class="fas fa-image text-4xl text-siptext mb-3"></i>
                    <p class="text-sm md:text-base text-siptext font-medium">Belum ada fasilitas kampus yang diunggah.</p>
                </div>
            @endforelse

            @if(count($q_fasilitas) > 0)
                <div class="snap-start shrink-0 w-4 md:w-12"></div>
            @endif
        </div>
        
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1600px] mt-4 md:mt-8 text-center md:text-left w-full">
            <a href="{{ route('fasilitas.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-sipdark border border-sipborder text-white text-sm font-semibold hover:bg-sipblue hover:border-sipblue hover:shadow-lg hover:shadow-sipblue/30 transition-all">
                Cek Ketersediaan Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- SECTION: FAQ -->
    <section id="faq" class="py-16 md:py-24 bg-sipbg w-full">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-4xl w-full">
            
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-sipblue font-bold tracking-widest uppercase text-sm mb-3">Bantuan & Informasi</h2>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white mb-4">Pertanyaan yang Sering <span class="text-transparent bg-clip-text bg-gradient-to-r from-sipblue to-blue-400">Diajukan</span></h3>
                <p class="text-sm md:text-base text-siptext">Temukan jawaban cepat untuk pertanyaan seputar penggunaan sistem peminjaman fasilitas kampus.</p>
            </div>

            <div class="space-y-4">
                
                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between p-5 md:p-6 cursor-pointer font-bold text-white hover:text-sipblue transition-colors text-xs md:text-base">
                        <span class="pr-4">Siapa saja yang dapat meminjam fasilitas melalui SI-PINJAM?</span>
                        <span class="transition group-open:rotate-180 shrink-0">
                            <i class="fas fa-chevron-down text-siptext"></i>
                        </span>
                    </summary>
                    <div class="px-5 md:px-6 pb-6 text-siptext text-xs md:text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Seluruh civitas akademika UPN "Veteran" Jawa Timur, baik Mahasiswa, Dosen, maupun Tenaga Kependidikan yang telah memiliki akun terdaftar di sistem.
                    </div>
                </details>

                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between p-5 md:p-6 cursor-pointer font-bold text-white hover:text-sipblue transition-colors text-xs md:text-base">
                        <span class="pr-4">Bagaimana langkah-langkah mengajukan peminjaman ruangan?</span>
                        <span class="transition group-open:rotate-180 shrink-0">
                            <i class="fas fa-chevron-down text-siptext"></i>
                        </span>
                    </summary>
                    <div class="px-5 md:px-6 pb-6 text-siptext text-xs md:text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Silakan <strong>Log In</strong> menggunakan akun Anda, masuk ke menu <strong>Daftar Fasilitas</strong>, pilih ruangan yang sesuai dengan kapasitas kegiatan Anda, lalu klik <strong>Pinjam Sekarang</strong>. Isi formulir (tanggal, waktu, dan keperluan) lalu tunggu persetujuan dari Admin.
                    </div>
                </details>

                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between p-5 md:p-6 cursor-pointer font-bold text-white hover:text-sipblue transition-colors text-xs md:text-base">
                        <span class="pr-4">Apa arti dari status "Pending", "Disetujui", dan "Ditolak"?</span>
                        <span class="transition group-open:rotate-180 shrink-0">
                            <i class="fas fa-chevron-down text-siptext"></i>
                        </span>
                    </summary>
                    <div class="px-5 md:px-6 pb-6 text-siptext text-xs md:text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2 space-y-2">
                        <p><span class="text-yellow-500 font-bold">Pending:</span> Pengajuan Anda sudah masuk dan sedang menunggu ditinjau oleh Admin.</p>
                        <p><span class="text-[#00AE1C] font-bold">Disetujui:</span> Ruangan telah di-booking untuk Anda dan siap digunakan pada tanggal tersebut.</p>
                        <p><span class="text-sipred font-bold">Ditolak:</span> Pengajuan tidak dapat diproses, biasanya karena ruangan sudah dipesan pihak lain atau sedang dalam perbaikan.</p>
                    </div>
                </details>

                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between p-5 md:p-6 cursor-pointer font-bold text-white hover:text-sipblue transition-colors text-xs md:text-base">
                        <span class="pr-4">Apakah saya bisa membatalkan pengajuan yang sudah disetujui?</span>
                        <span class="transition group-open:rotate-180 shrink-0">
                            <i class="fas fa-chevron-down text-siptext"></i>
                        </span>
                    </summary>
                    <div class="px-5 md:px-6 pb-6 text-siptext text-xs md:text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Bisa. Pembatalan dapat dilakukan langsung melalui <em>Dashboard</em> pengguna Anda, selambat-lambatnya H-1 sebelum tanggal pemakaian. Jika pada hari H, harap hubungi langsung pihak Admin pengelola gedung.
                    </div>
                </details>

            </div>
        </div>
    </section>

    <!-- Panggilan File Script Eksternal -->
    <script src="{{ asset('assets/js/script-landing.js') }}?v={{ time() }}"></script>
</body>
</html>