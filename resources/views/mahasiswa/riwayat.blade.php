<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - Mahasiswa SI-PINJAM</title>
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
                    <a href="{{ route('mahasiswa.pinjam.form') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-calendar-plus text-lg group-hover:text-[#00AE1C] transition-colors"></i> Buat Jadwal Pinjam
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-history text-lg"></i> Riwayat Saya
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
                    <h4 class="text-xl font-bold text-white mb-0.5">Riwayat Pengajuan</h4>
                    <div class="text-sm font-medium text-siptext">Pantau status persetujuan peminjaman fasilitas Anda di sini.</div>
                </div>
                <div>
                    <a href="{{ route('mahasiswa.pinjam.form') }}" class="flex items-center gap-2 bg-sipblue hover:bg-sipbluehover text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-sipblue/30 active:scale-95">
                        <i class="fas fa-plus"></i> Pinjam Baru
                    </a>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="bg-sipdark border border-sipborder rounded-3xl p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
                    
                    <h2 class="text-lg font-bold mb-6 flex items-center gap-3">
                        <i class="fas fa-clipboard-list text-sipblue"></i> Daftar Riwayat Peminjaman
                    </h2>

                    <div class="overflow-x-auto [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-[#15181f] text-gray-400 text-[10px] uppercase tracking-widest">
                                    <th class="p-4 rounded-tl-xl font-bold border-b border-gray-700/50">Tgl Pengajuan</th>
                                    <th class="p-4 font-bold border-b border-gray-700/50">Nama Peminjam</th>
                                    <th class="p-4 font-bold border-b border-gray-700/50">Fasilitas & Jadwal</th>
                                    <th class="p-4 font-bold border-b border-gray-700/50 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($riwayat as $item)
                                    <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors group">
                                        
                                        <!-- KOLOM TGL PENGAJUAN -->
                                        <td class="py-4 px-6 align-middle">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-[#15181f] border border-gray-700 flex items-center justify-center text-gray-400 shrink-0 shadow-inner">
                                                    <i class="far fa-calendar-alt"></i>
                                                </div>
                                                <div>            
                                                    <div class="text-sm font-bold text-white mb-0.5">
                                                        {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') : \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="p-4 font-medium text-white">
                                            {{ Auth::user()->nama_lengkap ?? 'Mahasiswa' }}
                                        </td>
                                        
                                        <td class="p-4">
                                            <div class="font-bold text-sipblue mb-1">{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Telah Dihapus' }}</div>
                                            <div class="flex items-center gap-2 text-xs text-gray-400 bg-[#16181e] w-fit px-2 py-1 rounded border border-gray-700">
                                                <i class="far fa-calendar-alt text-gray-500"></i>
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('l, d F Y') }}
                                            </div>
                                        </td>
                                        
                                        <td class="py-5 px-4 align-middle text-right">
                                            @if(strtolower($item->status) == 'pending' || strtolower($item->status) == 'menunggu')
                                                <span class="inline-flex items-center gap-1.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-hourglass-half"></i> Menunggu
                                                </span>
                                            @elseif(strtolower($item->status) == 'disetujui')
                                                <span class="inline-flex items-center gap-1.5 bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-check-circle"></i> Disetujui
                                                </span>
                                            @elseif(strtolower($item->status) == 'ditolak')
                                                <span class="inline-flex items-center gap-1.5 bg-sipred/10 text-sipred border border-sipred/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-ban"></i> Ditolak
                                                </span>
                                            @elseif(strtolower($item->status) == 'dibatalkan')
                                                <span class="inline-flex items-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-times-circle"></i> Dibatalkan
                                                </span>
                                            @else
                                                <!-- Fallback jika ada status tidak terduga di database -->
                                                <span class="inline-flex items-center gap-1.5 bg-gray-600/10 text-gray-400 border border-gray-600/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                                    <i class="fas fa-info-circle"></i> {{ $item->status }}
                                                </span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-gray-500">
                                            <div class="text-4xl mb-3"><i class="fas fa-folder-open opacity-50"></i></div>
                                            <p class="text-sm font-medium">Anda belum pernah melakukan pengajuan peminjaman.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>