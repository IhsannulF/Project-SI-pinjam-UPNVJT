<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SI-PINJAM - Universitas Pembangunan Nasional "Veteran" Jawa Timur</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite('resources/css/app.css')
</head>
<body class="bg-sipbg text-white font-sans antialiased relative overflow-x-hidden">
    
    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-sipblue/20 blur-[120px] -z-10 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] rounded-full bg-sipblue/10 blur-[100px] -z-10 pointer-events-none"></div>

    <header class="fixed w-full top-0 z-50 bg-sipbg/80 backdrop-blur-md border-b border-sipborder transition-all duration-300">
        <div class="w-full px-6 md:px-12 lg:px-20">
            <div class="flex justify-between items-center h-20">
                
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-xl font-bold tracking-wide">
                    SI-PINJAM <span class="text-sipblue">UPNVJT</span>
                </a>

                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="#welcome" class="text-white font-medium hover:text-sipblue transition">Beranda</a>
                    <a href="#perbandingan" class="text-siptext hover:text-white transition">Hak Akses</a>
                    <a href="#showcase" class="text-siptext hover:text-white transition">Fasilitas</a>
                    
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

            </div>
        </div>
    </header>

    <div class="pt-32 pb-20 lg:pt-40 lg:pb-28 px-4" id="welcome">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="inline-block py-1.5 px-4 rounded-full bg-sipblue/10 border border-sipblue/30 text-sipblue text-xs font-bold tracking-widest uppercase mb-6">
                UPN "Veteran" Jawa Timur
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                Peminjaman Fasilitas UPN <br> <span class="text-sipblue">"Veteran" Jawa Timur"</span>
            </h1>
            
            <p class="text-lg md:text-xl text-siptext mb-10 max-w-2xl mx-auto leading-relaxed">
                SI Pinjam adalah Platform digital terpadu untuk memudahkan civitas akademika dan masyarakat umum dalam melakukan reservasi peminjaman fasilitas kampus di UPN "Veteran" Jawa Timur.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-5">
                <a href="#perbandingan" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-sipblue text-white font-semibold hover:bg-sipbluehover transition shadow-lg shadow-sipblue/30">
                    Lihat Perbandingan Akses
                </a>
                <a href="{{ url('fasilitas') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-full border border-siptext text-siptext font-semibold hover:text-white hover:border-white transition bg-transparent">
                    Lihat Jadwal Fasilitas
                </a>
            </div>

            @auth
                <div class="mt-6 flex justify-center">
                    @if(Auth::user()->role === 'mahasiswa')
                        <a href="{{ url('dashboard/mahasiswa') }}" class="px-8 py-3.5 rounded-full bg-[#00AE1C] text-white font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30 flex items-center gap-2">
                            <i class="fas fa-calendar-plus"></i> Buat Jadwal (Mahasiswa)
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ url('admin/dashboard') }}" class="px-8 py-3.5 rounded-full bg-siptext text-white font-semibold hover:bg-gray-500 transition flex items-center gap-2">
                            <i class="fas fa-user-shield"></i> Masuk Panel Admin
                        </a>
                    @else
                        <a href="{{ url('dashboard') }}" class="px-8 py-3.5 rounded-full bg-[#00AE1C] text-white font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30 flex items-center gap-2">
                            <i class="fas fa-calendar-plus"></i> Buat Jadwal
                        </a>
                    @endif
                </div>
            @endauth

        </div>
    </div>

    <section class="py-30 bg-sipbg" id="perbandingan">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Pilih Akses Sesuai Status Anda</h2>
                <p class="text-siptext max-w-2xl mx-auto">Sistem kami membedakan alur birokrasi dan ketersediaan fasilitas berdasarkan role pengguna untuk memastikan efisiensi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-sipdark border border-sipborder rounded-2xl p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/5 hover:border-sipblue/30 transition-all duration-300">
                    <div class="border-b border-sipborder pb-6 mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Mahasiswa / UKM</h3>
                        <div class="text-3xl font-extrabold text-white mb-1">Gratis</div>
                        <div class="text-sm text-sipblue font-medium">Akademik & Organisasi</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Login via NPM Mahasiswa</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Kelas & Lab Fakultas</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Lapangan Olahraga</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> <span><strong>Wajib:</strong> Surat Izin BEM/Wadek</span></li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Akses Bebas GSG & Auditorium</li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Peminjaman Tanpa Batas Waktu</li>
                    </ul>
                    @auth
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? url('admin/dashboard') : url('login') }}" 
   class="flex justify-center items-center gap-2 w-full bg-sipblue hover:bg-sipbluehover text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
    
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

                <div class="bg-sipdark border border-sipblue relative rounded-2xl p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/20 transition-all duration-300">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-sipblue text-white text-xs font-bold px-4 py-1 rounded-b-lg">PRIORITAS</div>
                    <div class="border-b border-sipborder pb-6 mb-6 mt-2">
                        <h3 class="text-xl font-bold text-white mb-2">Dosen & Tendik</h3>
                        <div class="text-3xl font-extrabold text-sipblue mb-1">Gratis</div>
                        <div class="text-sm text-sipblue font-medium">Prioritas Utama</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Login via NIP Pegawai</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Semua Ruang Kelas & Lab</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Auditorium & Seminar</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Gedung Serba Guna (GSG)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> <span><strong>Bebas:</strong> Tanpa Surat Pengantar</span></li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Approval Otomatis / Instan</li>
                    </ul>
                    @auth
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? url('admin/dashboard') : url('login') }}" 
   class="flex justify-center items-center gap-2 w-full bg-sipblue hover:bg-sipbluehover text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
    
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

                <div class="bg-sipdark border border-sipborder rounded-2xl p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/5 hover:border-sipblue/30 transition-all duration-300">
                    <div class="border-b border-sipborder pb-6 mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Umum / Eksternal</h3>
                        <div class="text-3xl font-extrabold text-white mb-1">Berbayar</div>
                        <div class="text-sm text-sipblue font-medium">Sesuai Tarif Sewa</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Login via NIK (KTP)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Gedung Serba Guna (GSG)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Lapangan Olahraga Umum</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> <span><strong>Wajib:</strong> MoU & Bukti Bayar</span></li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Akses Ruang Kelas Pembelajaran</li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Akses Laboratorium Komputer</li>
                    </ul>
                    @auth
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? url('admin/dashboard') : url('login') }}" 
   class="flex justify-center items-center gap-2 w-full bg-sipblue hover:bg-sipbluehover text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
    
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

    <section id="showcase" class="py-24 relative z-10 bg-sipbg overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1600px]">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-sipblue font-bold tracking-widest uppercase text-sm mb-3">Galeri UPNVJT</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Fasilitas Kampus <span class="text-transparent bg-clip-text bg-gradient-to-r from-sipblue to-blue-400">Unggulan</span></h3>
                    <p class="text-siptext text-base leading-relaxed">
                        Eksplorasi berbagai ruang representatif yang siap mendukung setiap agenda akademik, organisasi, maupun kegiatan kolaboratif Anda.
                    </p>
                </div>
            </div>
        </div>

        <div id="carouselFasilitas" class="flex overflow-x-auto snap-x snap-mandatory gap-6 px-6 md:px-12 lg:px-20 pb-12 pt-4 [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-track]:bg-sipdark [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-siptext transition-all">
            
            <a href="{{ url('fasilitas/1') }}" class="snap-start shrink-0 w-[85vw] md:w-[600px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-2xl border border-sipborder/50 hover:border-sipblue transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop" alt="Gedung Serba Guna" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 1000</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">GSG</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Gedung Serba Guna (GSG)</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Pusat kegiatan utama kampus dengan kapasitas masif, cocok untuk seminar nasional, yudisium, maupun pementasan besar.
                    </p>
                </div>
            </a>

            <div class="snap-start shrink-0 w-6 md:w-12"></div>
        </div>
        
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1600px] mt-8 text-center md:text-left">
            <a href="{{ url('fasilitas') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-sipdark border border-sipborder text-white text-sm font-semibold hover:bg-sipblue hover:border-sipblue hover:shadow-lg hover:shadow-sipblue/30 transition-all">
                Cek Ketersediaan Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <section id="faq" class="py-24 relative z-10 bg-sipbg border-t border-sipborder/30">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1000px]">
            <div class="text-center mb-16">
                <h2 class="text-sipblue font-bold tracking-widest uppercase text-sm mb-3">Bantuan & Informasi</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Pertanyaan yang Sering <span class="text-transparent bg-clip-text bg-gradient-to-r from-sipblue to-blue-400">Diajukan</span></h3>
            </div>
            </div>
    </section>

    <script src="{{ asset('assets/js/script-landing.js') }}"></script>
</body>
</html>