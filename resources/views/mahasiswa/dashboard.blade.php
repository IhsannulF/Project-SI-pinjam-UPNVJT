<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-sm font-medium text-sipblue uppercase tracking-widest">Panel Mahasiswa</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-home text-lg"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.cari_fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-search text-lg group-hover:text-sipblue transition-colors"></i> Cari Fasilitas
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.pinjam.form') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-calendar-plus text-lg group-hover:text-[#00AE1C] transition-colors"></i> Buat Jadwal Pinjam
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-history text-lg group-hover:text-sipblue transition-colors"></i> Riwayat Saya
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
                    <h4 class="text-xl font-bold text-white mb-0.5">Halo, {{ Auth::user()->nama_lengkap }}!</h4>
                    <div class="text-sm font-medium text-siptext">Selamat datang di layanan peminjaman fasilitas kampus.</div>
                </div>
                
                <a href="{{ url('/') }}" class="flex items-center gap-2 bg-sipdark text-white px-5 py-2.5 rounded-xl border border-sipborder hover:border-sipblue hover:bg-sipblue/5 font-semibold text-sm transition-all shadow-md group">
                    <i class="fas fa-external-link-alt text-sipblue group-hover:scale-110 transition-transform"></i> Ke Halaman Utama
                </a>
            </header>

            <div class="flex-1 overflow-y-auto p-8 space-y-6 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                
                @if($pengajuan_terakhir)
                    @php
                        $bgBanner = $pengajuan_terakhir->status == 'pending' ? 'from-yellow-600/20 to-sipbg border-yellow-500/30 border-l-yellow-500' : 
                                    ($pengajuan_terakhir->status == 'disetujui' ? 'from-[#00AE1C]/20 to-sipbg border-[#00AE1C]/30 border-l-[#00AE1C]' : 
                                    'from-sipred/20 to-sipbg border-sipred/30 border-l-sipred');
                        $iconBanner = $pengajuan_terakhir->status == 'pending' ? 'fa-clock text-yellow-500' : 
                                      ($pengajuan_terakhir->status == 'disetujui' ? 'fa-check-circle text-[#00AE1C]' : 
                                      'fa-times-circle text-sipred');
                    @endphp
                    <div class="bg-gradient-to-r {{ $bgBanner }} border border-l-4 rounded-2xl p-6 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                        <div class="relative z-10 flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-[#0f1115]/50 flex items-center justify-center shrink-0 border border-gray-700/50">
                                <i class="fas {{ $iconBanner }} text-3xl"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Pengajuan Terakhir</h5>
                                <p class="text-lg font-bold text-white">
                                    {{ $pengajuan_terakhir->fasilitas->nama_fasilitas ?? 'Fasilitas' }} 
                                    <span class="text-sm font-medium text-gray-400 ml-2">({{ \Carbon\Carbon::parse($pengajuan_terakhir->tanggal_pinjam)->format('d M Y') }})</span>
                                </p>
                            </div>
                        </div>
                        <div class="relative z-10 shrink-0 w-full md:w-auto mt-4 md:mt-0 flex gap-3">
                            <a href="{{ route('mahasiswa.riwayat') }}" class="flex justify-center items-center gap-2 bg-[#1a1d24] hover:bg-gray-800 text-white border border-gray-600 px-6 py-3 rounded-xl font-semibold transition-all">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-sipdark to-sipbg border border-sipborder border-l-4 border-l-sipblue rounded-2xl p-6 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                        <div class="absolute -right-5 -bottom-10 text-sipblue/5 pointer-events-none">
                            <i class="fas fa-calendar-check text-9xl"></i>
                        </div>
                        <div class="relative z-10 flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-sipblue/10 flex items-center justify-center shrink-0">
                                <i class="fas fa-info-circle text-3xl text-sipblue"></i>
                            </div>
                            <div>
                                <h5 class="text-xl font-bold text-white mb-1">Mulai Peminjaman Baru</h5>
                                <p class="text-sm text-siptext font-medium">Anda belum memiliki pengajuan aktif atau riwayat peminjaman saat ini.</p>
                            </div>
                        </div>
                        <div class="relative z-10 shrink-0 w-full md:w-auto mt-4 md:mt-0">
                            <a href="{{ route('mahasiswa.cari_fasilitas') }}" class="flex justify-center items-center gap-2 w-full md:w-auto bg-sipblue hover:bg-sipbluehover text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
                                <i class="fas fa-plus"></i> Cari Fasilitas
                            </a>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="space-y-4">
                        <div class="bg-sipdark border border-sipborder rounded-2xl p-5 flex items-center justify-between shadow-lg">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Menunggu</p>
                                <h3 class="text-2xl font-bold text-yellow-500">{{ $stat_pending }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500 text-xl border border-yellow-500/20">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                        </div>
                        <div class="bg-sipdark border border-sipborder rounded-2xl p-5 flex items-center justify-between shadow-lg">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Disetujui</p>
                                <h3 class="text-2xl font-bold text-[#00AE1C]">{{ $stat_disetujui }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-[#00AE1C]/10 flex items-center justify-center text-[#00AE1C] text-xl border border-[#00AE1C]/20">
                                <i class="fas fa-check-double"></i>
                            </div>
                        </div>
                        <div class="bg-sipdark border border-sipborder rounded-2xl p-5 flex items-center justify-between shadow-lg">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Ditolak</p>
                                <h3 class="text-2xl font-bold text-sipred">{{ $stat_ditolak }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sipred/10 flex items-center justify-center text-sipred text-xl border border-sipred/20">
                                <i class="fas fa-ban"></i>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg flex flex-col">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fas fa-history text-sipblue"></i> Riwayat Terbaru
                            </h2>
                            <a href="{{ route('mahasiswa.riwayat') }}" class="text-xs font-bold text-sipblue hover:text-white transition-colors">Lihat Semua &rarr;</a>
                        </div>
                        
                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <tbody>
                                    @forelse($riwayat_singkat as $item)
                                        <tr class="border-b border-gray-700/50 last:border-0 hover:bg-[#15181f] transition-colors">
                                            <td class="py-3 pr-4">
                                                <div class="font-bold text-sm text-white">{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}</div>
                                                <div class="text-[11px] text-gray-400 mt-0.5"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</div>
                                            </td>
                                            <td class="py-3 text-right">
                                                @if($item->status == 'pending')
                                                    <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Pending</span>
                                                @elseif($item->status == 'disetujui')
                                                    <span class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                                                @elseif($item->status == 'ditolak')
                                                    <span class="bg-sipred/10 text-sipred border border-sipred/20 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-8 text-sm text-gray-500">Belum ada aktivitas peminjaman.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html>