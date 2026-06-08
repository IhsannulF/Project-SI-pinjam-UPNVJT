<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $fasilitas->nama_fasilitas }} - SI-PINJAM UPNVJT</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
</head>
<body class="bg-sipbg text-white font-sans antialiased pb-20">

    <nav class="fixed w-full top-0 z-50 bg-sipbg/90 backdrop-blur-md border-b border-sipborder">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">SI-PINJAM <span class="text-sipblue">UPNVJT</span></a>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-siptext hover:text-white transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-6 pt-32 max-w-6xl">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="w-full lg:w-3/5">
                <div class="rounded-[40px] overflow-hidden shadow-2xl border border-sipborder aspect-video relative group bg-sipdark">
                    
                    @php
                        // Logika Cerdas Gambar: Pakai gambar dari database jika ada, jika tidak pakai default Unsplash
                        $gambar_tampil = $fasilitas->foto_fasilitas 
                                        ? asset('assets/images/fasilitas/' . $fasilitas->foto_fasilitas) 
                                        : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200';
                    @endphp

                    <img src="{{ $gambar_tampil }}" alt="{{ $fasilitas->nama_fasilitas }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    
                    <div class="absolute top-6 left-6">
                        <span class="px-4 py-2 rounded-full bg-sipblue text-white text-xs font-bold shadow-lg uppercase tracking-wider">
                            {{ $fasilitas->kategori }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/5 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">{{ $fasilitas->nama_fasilitas }}</h1>
                
                <div class="flex items-center gap-6 mb-8 text-siptext">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-users text-sipblue text-lg"></i>
                        <span class="font-semibold text-white">{{ $fasilitas->kapasitas }}</span> Orang
                    </div>
                    <div class="flex items-center gap-2">
                        @if(strtolower($fasilitas->status) == 'tersedia')
                            <i class="fas fa-check-circle text-[#00AE1C] text-lg"></i>
                            <span class="font-semibold text-white">Status: Tersedia</span>
                        @else
                            <i class="fas fa-times-circle text-sipred text-lg"></i>
                            <span class="font-semibold text-white">Status: {{ ucfirst($fasilitas->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-3xl p-8 mb-8 shadow-lg">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sipblue"></i> Deskripsi Fasilitas
                    </h3>
                    <p class="text-siptext leading-relaxed text-sm">
                        Ruangan ini merupakan salah satu fasilitas unggulan di lingkungan UPN "Veteran" Jawa Timur yang dirancang untuk mendukung berbagai kegiatan civitas akademika. Dilengkapi dengan fasilitas yang memadai dan aksesibilitas yang mudah untuk kenyamanan pengguna.
                    </p>
                </div>

                @php
                    $target_url = route('login'); // Default url kalau belum login
                    
                    if (Auth::check()) {
                        $role = strtolower(Auth::user()->role ?? '');
                        
                        if ($role === 'admin') {
                            $target_url = route('admin.dashboard');
                        } elseif ($role === 'mahasiswa') {
                            $target_url = route('mahasiswa.dashboard');
                            // Catatan: Kalau mau langsung ke form pinjam, ganti jadi route('mahasiswa.pinjam.form')
                        } elseif ($role === 'dosen' || $role === 'tendik') {
                            $target_url = route('dosen.dashboard');
                        } elseif ($role === 'umum' || $role === 'eksternal') {
                            $target_url = route('eksternal.dashboard');
                        } else {
                            $target_url = url('/dashboard'); // Fallback aman
                        }
                    }
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="#" class="w-full bg-sipdark border border-sipborder hover:border-sipblue hover:text-sipblue text-white font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-2">
                        <i class="far fa-calendar-alt"></i> Lihat Jadwal
                    </a>
                    
                    <a href="{{ $target_url }}" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-4 rounded-2xl shadow-lg shadow-sipblue/30 transition-all flex items-center justify-center gap-2">
                        Pinjam Sekarang <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>