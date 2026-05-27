<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Pinjaman - Admin SI-PINJAM</title>
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
                <p class="text-xs font-bold text-sipblue uppercase tracking-widest">Panel Administrator</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="{{ url('admin/dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-home text-lg group-hover:text-sipblue transition-colors"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-building text-lg group-hover:text-sipblue transition-colors"></i> Kelola Fasilitas
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.antrean') }}" class="flex items-center justify-between px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <div class="flex items-center gap-4"><i class="fas fa-clipboard-list text-lg"></i> Antrean Pinjaman</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-users text-lg group-hover:text-sipblue transition-colors"></i> Data Pengguna
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-external-link-alt text-lg group-hover:text-sipblue transition-colors"></i> Lihat Situs
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
                    <h4 class="text-xl font-bold text-white mb-0.5">Kelola Antrean Pinjaman</h4>
                    <div class="text-sm font-medium text-siptext">Tinjau dan proses pengajuan peminjaman fasilitas.</div>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-400"><i class="far fa-calendar-alt mr-2"></i>{{ date('d M Y') }}</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-transparent"></div>
                    
                    @if(session('success'))
                        <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto overflow-y-auto max-h-[480px] pr-2 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <!-- TAMBAHKAN CLASS STICKY & BG COLOR DI THEAD -->
                            <thead class="sticky top-0 z-10 bg-[#1a1d24]">
                                <tr class="bg-[#15181f] text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-700/50">
                                    <th class="p-4 rounded-tl-xl font-bold">Peminjam</th>
                                    <th class="p-4 font-bold">Fasilitas & Tgl</th>
                                    <th class="p-4 font-bold">Keperluan</th>
                                    <th class="p-4 font-bold text-center">Status</th>
                                    <th class="p-4 font-bold text-center rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($peminjaman as $item)
                                    <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors">
                                        <td class="p-4">
                                            <div class="font-bold text-white">{{ $item->user->nama_lengkap ?? 'User Dihapus' }}</div>
                                            <div class="text-xs text-sipblue uppercase font-bold">{{ $item->user->role ?? '-' }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-bold text-gray-200">{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}</div>
                                            <div class="text-xs text-gray-400 mt-1"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="text-xs text-gray-300 max-w-[250px] truncate" title="{{ $item->keperluan }}">
                                                {{ $item->keperluan }}
                                            </div>
                                        </td>
                                        <td class="p-4 text-center">
                                            @if($item->status == 'pending')
                                                <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider">Pending</span>
                                            @elseif($item->status == 'disetujui')
                                                <span class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider">Disetujui</span>
                                            @elseif($item->status == 'ditolak')
                                                <span class="bg-sipred/10 text-sipred border border-sipred/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-center">
                                            @if($item->status == 'pending')
                                                <div class="flex items-center justify-center gap-2">
                                                    <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" onclick="return confirm('Setujui pengajuan ini?')" class="w-8 h-8 rounded-lg bg-[#00AE1C]/10 text-[#00AE1C] hover:bg-[#00AE1C] hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" onclick="return confirm('Tolak pengajuan ini?')" class="w-8 h-8 rounded-lg bg-sipred/10 text-sipred hover:bg-sipred hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Tolak">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest"><i class="fas fa-lock mr-1"></i> Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-500">Belum ada antrean pengajuan peminjaman.</td>
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