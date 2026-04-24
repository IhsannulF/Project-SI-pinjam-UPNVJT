<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas - Admin SI-PINJAM</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-xs font-bold text-siptext uppercase tracking-widest">Panel Administrator</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-home text-lg group-hover:text-sipblue transition-colors"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-external-link-alt text-lg group-hover:text-sipblue transition-colors"></i> Lihat Situs
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.fasilitas') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-building text-lg"></i> Kelola Fasilitas
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group flex-wrap">
                        <i class="fas fa-clipboard-list text-lg group-hover:text-sipblue transition-colors"></i> Antrean Pinjaman
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-users text-lg group-hover:text-sipblue transition-colors"></i> Data Pengguna
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Kelola Fasilitas</h4>
                    <div class="text-sm font-medium text-siptext">Tambah, Edit, dan Blokir Jadwal Fasilitas Kampus.</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                @if(session('success'))
                    <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="space-y-8">
                        
                        <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl">
                            <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-plus-circle text-sipblue text-xl"></i> Tambah Fasilitas</h2>
                            
                            <form method="POST" action="{{ route('admin.fasilitas.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Nama Fasilitas</label>
                                        <input type="text" name="nama" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm">
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Kategori</label>
                                            <select name="kategori" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white appearance-none focus:outline-none focus:border-sipblue transition-all text-sm">
                                                <option value="gsg">GSG</option>
                                                <option value="lab">Lab</option>
                                                <option value="kelas">Kelas</option>
                                                <option value="rapat">Ruang Rapat</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Kapasitas</label>
                                            <input type="number" name="kapasitas" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipblue transition-all text-sm">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Pilih Ikon</label>
                                        <select name="ikon" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm">
                                            <option value="fas fa-building">🏢 Gedung Umum</option>
                                            <option value="fas fa-laptop-code">💻 Lab Komputer</option>
                                            <option value="fas fa-chalkboard-teacher">👨‍🏫 Ruang Kelas</option>
                                            <option value="fas fa-users">👥 Ruang Rapat</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Foto Ruangan</label>
                                        <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-sipblue/10 file:text-sipblue hover:file:bg-sipblue/20 cursor-pointer">
                                    </div>
                                    
                                    <button type="submit" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-sipblue/30 active:scale-95">
                                        Simpan Fasilitas
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-sipred"></div>
                            <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-calendar-times text-sipred text-xl"></i> Tutup/Blokir Jadwal</h2>
                            <form method="POST" action="{{ route('admin.block') }}">
                                @csrf
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Pilih Fasilitas</label>
                                        <select name="id_fasilitas_blokir" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm">
                                            @foreach($q_fasilitas as $f)
                                                <option value="{{ $f->id_fasilitas }}">{{ $f->nama_fasilitas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Mulai</label>
                                            <input type="date" name="tanggal_mulai" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm [&::-webkit-calendar-picker-indicator]:invert">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Selesai</label>
                                            <input type="date" name="tanggal_selesai" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm [&::-webkit-calendar-picker-indicator]:invert">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Alasan</label>
                                        <input type="text" name="keperluan" placeholder="Cth: Maintenance Berkala" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white text-sm">
                                    </div>
                                    <button type="submit" class="w-full bg-sipred hover:bg-red-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-sipred/30 active:scale-95">
                                        Blokir Rentang Tanggal
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl flex flex-col h-[700px]">
                            <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-list text-sipblue text-xl"></i> Daftar Fasilitas</h2>

                            <div class="flex flex-wrap gap-2 mb-6 border-b border-sipborder pb-6">
                                <button class="filter-btn bg-sipblue text-white border border-sipblue px-5 py-2 rounded-full text-xs font-bold transition-all" data-filter="semua">Semua</button>
                                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-5 py-2 rounded-full text-xs font-bold transition-all" data-filter="gsg">GSG</button>
                                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-5 py-2 rounded-full text-xs font-bold transition-all" data-filter="lab">Lab</button>
                                <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white px-5 py-2 rounded-full text-xs font-bold transition-all" data-filter="kelas">Kelas</button>
                            </div>

                            <div class="flex-1 overflow-y-auto pr-3 space-y-3 [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                                @forelse($q_fasilitas as $row)
                                <div class="fasilitas-item flex items-center justify-between p-4 bg-sipbg border border-sipborder rounded-2xl group transition-all hover:border-sipblue/50" data-kategori="{{ $row->kategori }}">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl bg-sipdark border border-sipborder flex items-center justify-center text-sipblue group-hover:bg-sipblue/10 group-hover:scale-110 transition-all">
                                            <i class="{{ $row->ikon }} text-2xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-white">{{ $row->nama_fasilitas }}</div>
                                            <div class="text-xs text-siptext"><i class="fas fa-users mr-1"></i> {{ $row->kapasitas }} Orang</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="bukaModalEdit('{{ $row->id_fasilitas }}', '{{ addslashes($row->nama_fasilitas) }}', '{{ $row->kategori }}', '{{ $row->kapasitas }}', '{{ $row->ikon }}')" class="text-sipblue p-2 hover:scale-110 transition-transform"><i class="fas fa-edit"></i></button>
                                        
                                        <form method="POST" action="{{ route('admin.fasilitas.delete') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="id_hapus" value="{{ $row->id_fasilitas }}">
                                            <button type="button" onclick="konfirmasiHapus(this)" class="text-red-500 p-2 hover:scale-110 transition-transform"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-12 text-siptext">
                                    <i class="fas fa-box-open text-4xl mb-4 opacity-50"></i>
                                    <p>Belum ada data fasilitas.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl">
                            <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-calendar-minus text-siptext text-xl"></i> Jadwal Diblokir Admin</h2>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <tr class="border-b border-sipborder text-siptext text-xs uppercase font-bold tracking-wider">
                                        <th class="pb-4 px-4">Tanggal</th>
                                        <th class="pb-4 px-4">Fasilitas</th>
                                        <th class="pb-4 px-4">Alasan</th>
                                        <th class="pb-4 px-4 text-right">Aksi</th>
                                    </tr>
                                    @forelse($q_blokir as $b)
                                    <tr class="border-b border-sipborder/50 hover:bg-sipbg/50 transition-colors">
                                        <td class="py-4 px-4 text-sm font-bold text-sipred flex items-center gap-2">
                                            <i class="far fa-calendar-times"></i> {{ date('d M Y', strtotime($b->tanggal_pinjam)) }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-300 font-medium">{{ $b->fasilitas->nama_fasilitas }}</td>
                                        <td class="py-4 px-4 text-sm text-siptext">{{ $b->keperluan }}</td>
                                        <td class="py-4 px-4 text-right">
                                            <form method="POST" action="{{ route('admin.unblock') }}">
                                                @csrf
                                                <input type="hidden" name="id_buka_blokir" value="{{ $b->id_peminjaman }}">
                                                <button type="submit" class="inline-flex items-center gap-2 text-sipblue bg-sipblue/10 hover:bg-sipblue hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                                                    <i class="fas fa-lock-open"></i> Buka Blokir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-siptext text-sm">
                                            <i class="fas fa-calendar-check text-2xl mb-2 opacity-50 block"></i> Tidak ada jadwal yang sedang diblokir.
                                        </td>
                                    </tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

    </div>

    <script>
        window.updateFasilitasUrl = "{{ route('admin.fasilitas.update') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    
    <script src="{{ asset('assets/js/admin_fasilitas.js') }}"></script>
</body>
</html>