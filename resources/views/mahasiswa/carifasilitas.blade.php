@extends('layouts.mahasiswa')

@section('content')
    <div class="flex h-screen w-full">
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Cari Fasilitas Kampus</h4>
                    <div class="text-sm font-medium text-siptext">Cek ketersediaan jadwal fasilitas sebelum melakukan pengajuan peminjaman.</div>
                </div>
                <div>
                    <a href="{{ route('mahasiswa.pinjam.form') }}" class="flex items-center gap-2 bg-sipblue hover:bg-sipbluehover text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-sipblue/30 active:scale-95">
                        <i class="fas fa-calendar-plus"></i> Langsung Pinjam
                    </a>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="bg-sipdark border border-sipborder rounded-3xl p-6 shadow-xl flex flex-col h-[600px] relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
                        
                        <h2 class="text-lg font-bold mb-4 flex items-center gap-3">
                            <i class="fas fa-building text-sipblue"></i> Pilih Fasilitas
                        </h2>
                        <p class="text-xs text-gray-400 mb-4 pb-4 border-b border-gray-700/50">Pilih fasilitas di bawah ini untuk melihat ketersediaan jadwalnya.</p>
                        
                        <div class="mb-4 relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="cariFasilitasInput" placeholder="Cari nama fasilitas..." class="w-full bg-[#0f1115] border border-gray-700 rounded-xl pl-11 pr-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all">
                        </div>
                        
                        <div class="flex-1 overflow-y-auto space-y-3 pr-2 [&::-webkit-scrollbar]:w-[4px] ...
                        <div class="flex-1 overflow-y-auto space-y-3 pr-2 [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full" id="facilityListContainer">
                            @foreach($data_fasilitas as $f)
                                <button type="button" class="w-full text-left p-4 rounded-xl border border-gray-700 bg-[#0f1115] hover:border-sipblue hover:bg-sipblue/10 transition-all group facility-btn" data-id="{{ $f->id_fasilitas }}" data-nama="{{ $f->nama_fasilitas }}">
                                    <div class="font-bold text-white text-sm group-hover:text-sipblue transition-colors facility-name">{{ $f->nama_fasilitas }}</div>
                                    <div class="text-[11px] font-medium text-gray-400 mt-2 flex items-center gap-2">
                                        <span class="bg-gray-800 px-2 py-1 rounded text-gray-300"><i class="fas fa-user-friends mr-1"></i> {{ $f->kapasitas }} Orang</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-sipdark border border-sipborder rounded-3xl p-6 shadow-xl flex flex-col h-[600px] relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent to-[#00AE1C]"></div>

                        <div class="flex justify-between items-center mb-6 bg-[#0f1115] p-3 rounded-2xl border border-gray-700">
                            <button id="prevMonth" class="w-10 h-10 rounded-xl flex items-center justify-center bg-[#1a1d24] border border-gray-600 hover:bg-sipblue hover:border-sipblue hover:text-white transition-all shadow-md active:scale-95">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <h2 id="monthYear" class="text-lg font-bold text-white uppercase tracking-wider">Memuat Kalender...</h2>
                            
                            <button id="nextMonth" class="w-10 h-10 rounded-xl flex items-center justify-center bg-[#1a1d24] border border-gray-600 hover:bg-sipblue hover:border-sipblue hover:text-white transition-all shadow-md active:scale-95">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="flex justify-center gap-8 mb-6 text-xs font-bold text-gray-300 bg-[#16181e] py-2.5 rounded-xl border border-gray-700/50">
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-[#00AE1C] shadow-[0_0_8px_rgba(0,174,28,0.5)]"></span> Tersedia
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-sipred shadow-[0_0_8px_rgba(222,40,40,0.5)]"></span> Penuh / Diblokir
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-2 mb-3 text-center text-[11px] font-bold text-gray-400 uppercase tracking-widest bg-gray-800/30 py-2 rounded-lg">
                            <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div><div>Min</div>
                        </div>

                        <div id="calendarDays" class="grid grid-cols-7 gap-2 flex-1 auto-rows-fr">
                            </div>
                        
                    </div>
                </div>
                
                </div>
        </main>
    </div>

    <div id="jadwal-data" data-booking="{{ json_encode($jadwal_booking) }}" class="hidden"></div>

    <script>
        const jadwalElement = document.getElementById('jadwal-data');
        window.dataJadwalBooking = JSON.parse(jadwalElement.getAttribute('data-booking'));
    </script>
    
    <script src="{{ asset('assets/js/script-jadwal.js') }}"></script>
    <script src="{{ asset('assets/js/script-jadwal.js') }}"></script>
@endsection