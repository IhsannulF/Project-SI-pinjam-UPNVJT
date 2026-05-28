<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Pinjaman - Admin SI-PINJAM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-SI-Pinjam.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
                
                @if(session('success'))
                    <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-2 max-w-4xl">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- BAGIAN 1: TABEL ANTREAN BARU -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-yellow-500 mb-4 flex items-center gap-2">
                        <i class="fas fa-hourglass-half"></i> Perlu Diproses 
                        <span class="bg-yellow-500 text-sipdark px-2 py-0.5 rounded-md text-xs">{{ $antrean_baru->count() }}</span>
                    </h3>
                    
                    <div class="bg-sipdark border border-yellow-500/30 rounded-2xl shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-transparent"></div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead class="bg-[#1a1d24]">
                                    <tr class="text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-700/50">
                                        <th class="p-4 font-bold">Peminjam</th>
                                        <th class="p-4 font-bold">Fasilitas & Tgl</th>
                                        <th class="p-4 font-bold">Keperluan</th>
                                        <th class="p-4 font-bold text-center">Status</th>
                                        <th class="p-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @forelse($antrean_baru as $item)
                                        <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors">
                                            <td class="p-4">
                                                <div class="font-bold text-white">{{ $item->user->nama_lengkap ?? 'User Dihapus' }}</div>
                                                <div class="text-xs text-sipblue uppercase font-bold">{{ $item->user->role ?? '-' }}</div>
                                            </td>
                                            <td class="p-4">
                                                <div class="font-bold text-gray-200">{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}</div>
                                                <div class="text-xs text-yellow-500 mt-1 flex items-center gap-1.5 font-medium">
                                                    <i class="far fa-calendar-alt"></i> 
                                                    @if($item->tanggal_mulai == $item->tanggal_berakhir)
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} s/d {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="text-xs text-gray-300 max-w-[250px] truncate" title="{{ $item->keperluan }}">{{ $item->keperluan }}</div>
                                            </td>
                                            <td class="p-4 text-center">
                                                <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider shadow-sm animate-pulse"><i class="fas fa-hourglass-half mr-1"></i> Menunggu</span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="button" onclick="konfirmasiSetuju(this)" class="w-8 h-8 rounded-lg bg-[#00AE1C]/10 text-[#00AE1C] hover:bg-[#00AE1C] hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.antrean.status', $item->id_peminjaman) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="button" onclick="konfirmasiTolak(this)" class="w-8 h-8 rounded-lg bg-sipred/10 text-sipred hover:bg-sipred hover:text-white transition-colors flex items-center justify-center shadow-lg" title="Tolak">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-10 text-center text-gray-500">
                                                <i class="fas fa-check-double text-3xl mb-2 text-gray-600"></i>
                                                <p>Hebat! Semua antrean sudah diproses.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: TABEL RIWAYAT PROSES -->
                <div>
                    <h3 class="text-lg font-bold text-gray-400 mb-4 flex items-center gap-2">
                        <i class="fas fa-history"></i> Riwayat Proses
                    </h3>
                    
                    <div class="bg-sipdark border border-sipborder rounded-2xl shadow-xl overflow-hidden opacity-90 hover:opacity-100 transition-opacity">
                        <!-- Scrollable Container untuk Riwayat -->
                        <div class="overflow-x-auto max-h-[350px] overflow-y-auto [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead class="sticky top-0 z-10 bg-[#1a1d24]">
                                    <tr class="text-gray-500 text-[10px] uppercase tracking-widest border-b border-gray-700/50">
                                        <th class="p-4 font-bold">Peminjam</th>
                                        <th class="p-4 font-bold">Fasilitas & Tgl</th>
                                        <th class="p-4 font-bold">Keperluan</th>
                                        <th class="p-4 font-bold text-center">Status</th>
                                        <th class="p-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @forelse($riwayat_proses as $item)
                                        <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
                                            <td class="p-4">
                                                <div class="font-bold text-gray-300">{{ $item->user->nama_lengkap ?? 'User Dihapus' }}</div>
                                            </td>
                                            <td class="p-4">
                                                <div class="font-bold text-gray-400">{{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas Dihapus' }}</div>
                                                <div class="text-[11px] text-gray-500 mt-0.5">
                                                    @if($item->tanggal_mulai == $item->tanggal_berakhir)
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="text-xs text-gray-500 max-w-[200px] truncate" title="{{ $item->keperluan }}">{{ $item->keperluan }}</div>
                                            </td>
                                            <td class="p-4 text-center">
                                                @if($item->status == 'disetujui')
                                                    <span class="text-[#00AE1C] text-[11px] font-bold uppercase tracking-wider"><i class="fas fa-check mr-1"></i> Disetujui</span>
                                                @elseif($item->status == 'ditolak')
                                                    <span class="text-sipred text-[11px] font-bold uppercase tracking-wider"><i class="fas fa-times mr-1"></i> Ditolak</span>
                                                @else
                                                    <span class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center">
                                                <span class="text-[10px] text-gray-600 font-bold uppercase tracking-widest"><i class="fas fa-lock mr-1"></i> Selesai</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-600 text-sm">Belum ada riwayat pemrosesan.</td>
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

    <script src="{{ asset('assets/js/admin-antrean.js') }}"></script>
</body>
</html>