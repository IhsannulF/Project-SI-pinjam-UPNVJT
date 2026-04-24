<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $data->nama_fasilitas }} - SI-PINJAM</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
</head>
<body class="bg-sipbg text-white font-sans antialiased pb-20 selection:bg-sipblue selection:text-white">

    <nav class="fixed w-full top-0 z-50 bg-sipbg/90 backdrop-blur-md border-b border-sipborder">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold">SI-PINJAM <span class="text-sipblue">UPNVJT</span></a>
            <a href="{{ url('/') }}" class="text-sm font-semibold text-siptext hover:text-white transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-6 pt-32 max-w-7xl">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <div class="w-full lg:mr-10">
                <div class="rounded-[40px] overflow-hidden shadow-2xl border border-sipborder aspect-[4/3] lg:aspect-video relative group">
                    <img src="{{ $gambar_tampil }}" alt="{{ $data->nama_fasilitas }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute top-6 left-6">
                        <span class="px-5 py-2.5 rounded-full bg-sipblue text-white text-xs font-bold shadow-lg uppercase tracking-wider">
                            {{ $data->kategori }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">{{ $data->nama_fasilitas }}</h1>
                
                <div class="flex items-center gap-8 mb-10 text-siptext">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-users text-sipblue text-xl"></i>
                        <span class="font-semibold text-white text-lg">{{ $data->kapasitas }}</span> Orang
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <span class="font-semibold text-white text-lg">Status: {{ ucfirst($data->status) }}</span>
                    </div>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-3xl p-8 mb-8">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-3">
                        <i class="fas fa-info-circle text-sipblue"></i> Deskripsi Fasilitas
                    </h3>
                    <p class="text-siptext leading-relaxed text-base">
                        Ruangan ini merupakan salah satu fasilitas unggulan di lingkungan UPN "Veteran" Jawa Timur yang dirancang untuk mendukung berbagai kegiatan civitas akademika. Dilengkapi dengan pendingin ruangan, pencahayaan yang optimal, dan aksesibilitas yang mudah.
                    </p>
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <a href="{{ url('jadwal-fasilitas') }}" class="w-full bg-sipdark border-2 border-sipborder hover:border-sipblue text-white font-bold py-10 text-xl rounded-2xl transition-all duration-300 flex items-center justify-center gap-3 hover:-translate-y-1">
                        <i class="far fa-calendar-alt text-2xl"></i> Lihat Jadwal
                    </a>
                    
                    @auth
                        <a href="{{ url('dashboard/'.Auth::user()->role) }}" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-10 text-xl rounded-2xl shadow-xl shadow-sipblue/30 transition-all duration-300 flex items-center justify-center gap-3 hover:-translate-y-1">
                            Pinjam Sekarang <i class="fas fa-arrow-right text-lg mt-1"></i>
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-10 text-xl rounded-2xl shadow-xl shadow-sipblue/30 transition-all duration-300 flex items-center justify-center gap-3 hover:-translate-y-1">
                            Pinjam Sekarang <i class="fas fa-arrow-right text-lg mt-1"></i>
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </main>

</body>
</html>