<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Jadwal Fasilitas - SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite('resources/css/app.css')
</head>

<body class="bg-sipbg text-white font-sans antialiased relative selection:bg-sipblue selection:text-white pb-20 overflow-x-hidden">

    <div class="fixed top-[-10%] right-[-5%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] rounded-full bg-sipblue/10 blur-[90px] md:blur-[120px] -z-10 pointer-events-none"></div>

    <header class="fixed w-full top-0 z-50 bg-sipbg/90 backdrop-blur-md border-b border-sipborder">
        <div class="w-full px-4 md:px-12 lg:px-20">
            <div class="flex justify-between items-center h-16 md:h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg md:text-xl font-bold tracking-wide">
                    SI-PINJAM <span class="text-sipblue hidden sm:inline">UPNVJT</span>
                </a>
                <a href="{{ url('/') }}" class="text-xs md:text-sm font-semibold text-siptext hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> <span class="hidden sm:inline">Kembali ke Beranda</span><span class="sm:hidden">Kembali</span>
                </a>
            </div>
        </div>
    </header>

    <div class="w-full px-4 md:px-12 lg:px-20 pt-32 md:pt-40 max-w-[1600px] mx-auto relative z-10">
        
        <div class="bg-sipdark/80 backdrop-blur-xl border border-sipborder rounded-3xl md:rounded-full p-3 md:p-2.5 flex flex-col md:flex-row items-center justify-between shadow-2xl max-w-4xl mx-auto mb-8 md:mb-12 gap-3 md:gap-0">
            
            <div class="flex-1 w-full px-4 md:px-6 py-2 border-b md:border-b-0 md:border-r border-sipborder">
                <label class="block text-[10px] md:text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Fasilitas</label>
                <input type="text" placeholder="Cari gedung atau lab..." id="searchFacility" 
                    class="w-full bg-transparent border-none text-white focus:outline-none placeholder-gray-600 font-medium text-sm md:text-base">
            </div>
            
            <div class="flex-1 w-full px-4 md:px-6 py-2 relative">
                <label class="block text-[10px] md:text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kategori</label>
                <select id="kategori" class="w-full bg-transparent border-none text-white focus:outline-none font-medium appearance-none cursor-pointer text-sm md:text-base">
                    <option value="semua" class="bg-sipdark">Semua Kategori</option>
                    <option value="gsg" class="bg-sipdark">Gedung Serba Guna</option>
                    <option value="lab" class="bg-sipdark">Laboratorium</option>
                    <option value="kelas" class="bg-sipdark">Ruang Kelas</option>
                    <option value="rapat" class="bg-sipdark">Ruang Rapat</option>
                </select>
                <i class="fas fa-chevron-down absolute right-6 top-1/2 mt-1 md:mt-2 text-xs text-gray-500 pointer-events-none"></i>
            </div>
            
            <div class="w-full md:w-auto mt-1 md:mt-0 pl-0 md:pl-2">
                <button class="w-full md:w-auto bg-sipblue hover:bg-sipbluehover text-white px-8 py-3 md:py-3.5 rounded-xl md:rounded-full font-bold transition-all shadow-lg shadow-sipblue/30 flex items-center justify-center gap-2 active:scale-95 text-sm md:text-base">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            
            <div class="w-full lg:w-1/3">
                <div class="bg-sipdark border border-sipborder rounded-3xl p-5 md:p-6 shadow-xl h-[400px] lg:h-[650px] flex flex-col">
                    <h4 class="text-lg md:text-xl font-bold text-white mb-4 md:mb-6 flex items-center gap-3">
                        <i class="fas fa-building text-sipblue"></i> Daftar Fasilitas
                    </h4>
                    
                    <div class="flex-1 overflow-y-auto pr-2 md:pr-3 space-y-3 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-siptext">
                        
                        @if($data_fasilitas->count() > 0)
                            @foreach($data_fasilitas as $row)
                                <div class="facility-card group flex items-center p-3 md:p-4 rounded-2xl border border-sipborder bg-sipbg hover:border-sipblue hover:bg-sipblue/5 cursor-pointer transition-all duration-300" 
                                     data-id="{{ $row->id_fasilitas }}"
                                     data-nama="{{ strtolower($row->nama_fasilitas) }}"
                                     data-kategori="{{ strtolower($row->kategori) }}">
                                     
                                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-sipblue/10 text-sipblue flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                        <i class="{{ $row->ikon }} text-xl md:text-2xl"></i>
                                    </div>
                                    <div class="ml-3 md:ml-4">
                                        <h5 class="text-white font-bold text-sm md:text-base mb-0.5 md:mb-1 group-hover:text-sipblue transition-colors">{{ $row->nama_fasilitas }}</h5>
                                        <p class="text-siptext text-xs md:text-sm font-medium"><i class="fas fa-users mr-1 opacity-70"></i> {{ $row->kapasitas }} Orang</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-10 text-siptext">
                                <i class="fas fa-box-open text-3xl md:text-4xl mb-3 opacity-50"></i>
                                <p class="text-sm md:text-base">Belum ada data fasilitas.</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3">
                <div class="bg-sipdark border border-sipborder rounded-3xl p-5 md:p-8 shadow-xl h-full flex flex-col">
                    
                    <div class="flex justify-between items-center w-full mb-6 md:mb-8">
                        <button id="prevMonth" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center text-siptext hover:text-white hover:bg-sipborder rounded-full transition-all bg-sipbg border border-sipborder">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <h3 id="calendarMonthYear" class="text-base md:text-2xl font-extrabold text-white tracking-wide m-0 uppercase text-center leading-relaxed px-2">
                            PILIH FASILITAS
                        </h3>

                        <button id="nextMonth" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center text-siptext hover:text-white hover:bg-sipborder rounded-full transition-all bg-sipbg border border-sipborder">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4 md:gap-8 mb-6 md:mb-8 border-b border-sipborder pb-4 md:pb-6">
                        <div class="flex items-center gap-2 text-xs md:text-sm font-medium text-gray-300">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-[#00AE1C] shadow-[0_0_8px_#00AE1C]"></span> Tersedia
                        </div>
                        <div class="flex items-center gap-2 text-xs md:text-sm font-medium text-gray-300">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-sipred shadow-[0_0_8px_#DE2828]"></span> Penuh / Booking
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 md:gap-2 mb-2">
                        @php $hari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
                        @foreach($hari as $h)
                            <div class='text-center text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest py-1 md:py-2'>{{ $h }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1 md:gap-2 flex-1 content-start" id="calendarDays">
                        </div>

                    <div class="mt-6 md:mt-8 pt-5 md:pt-6 border-t border-sipborder flex justify-center lg:justify-end">
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ url('admin/fasilitas') }}" class="w-full sm:w-auto bg-sipred hover:bg-red-700 text-white px-6 md:px-8 py-3 md:py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipred/30 flex items-center justify-center gap-2 text-sm md:text-base">
                                    <i class="fas fa-edit"></i> Edit Jadwal
                                </a>
                            @else
                                <a href="{{ url('dashboard/'.Auth::user()->role) }}" class="w-full sm:w-auto bg-[#00AE1C] hover:bg-green-700 text-white px-6 md:px-8 py-3 md:py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 text-sm md:text-base">
                                    <i class="fas fa-calendar-check"></i> Ajukan Peminjaman
                                </a>
                            @endif
                        @else
                            <a href="{{ url('login') }}" class="w-full sm:w-auto bg-[#00AE1C] hover:bg-green-700 text-white px-6 md:px-8 py-3 md:py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 text-sm md:text-base">
                                <i class="fas fa-calendar-check"></i> Ajukan Peminjaman
                            </a>
                        @endauth
                    </div>

                </div>
            </div>

        </div>
    </div>

   <meta id="jadwal-data" data-booking='{!! json_encode($jadwal_booking ?? (object)[]) !!}'>

    <script src="{{ asset('assets/js/script-jadwal.js') }}"></script>
</body>
</html>