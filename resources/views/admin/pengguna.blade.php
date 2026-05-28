<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Admin SI-PINJAM</title>
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
                    <a href="{{ route('admin.antrean') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-clipboard-list text-lg group-hover:text-sipblue transition-colors"></i> Antrean Pinjaman
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-users text-lg"></i> Data Pengguna
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

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Manajemen Pengguna</h4>
                    <div class="text-sm font-medium text-siptext">Kelola data seluruh civitas akademika dan eksternal.</div>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-400"><i class="far fa-calendar-alt mr-2"></i>{{ date('d M Y') }}</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 relative">
                
                <!-- Alert Validasi Error / Sukses -->
                @if(session('success'))
                    <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-sipred/10 text-sipred border border-sipred/30 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex flex-col gap-1">
                        @foreach ($errors->all() as $error)
                            <span><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- KOTAK TABEL PENGGUNA -->
                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-white flex items-center gap-3">
                            <i class="fas fa-address-book text-sipblue"></i> Daftar Pengguna Sistem
                        </h2>
                        <!-- UBAH: Tambahkan onclick ke tombol ini -->
                        <button onclick="bukaModalUser()" class="bg-sipblue hover:bg-sipbluehover text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-sipblue/20 flex items-center gap-2 active:scale-95">
                            <i class="fas fa-user-plus"></i> Tambah User
                        </button>
                    </div>

                    <div class="overflow-x-auto overflow-y-auto max-h-[480px] pr-2 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead class="sticky top-0 z-10 bg-[#1a1d24]">
                                <tr class="bg-[#15181f] text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-700/50">
                                    <th class="p-4 rounded-tl-xl font-bold">Nama Lengkap</th>
                                    <th class="p-4 font-bold">Email Akun</th>
                                    <th class="p-4 font-bold text-center rounded-tr-xl">Hak Akses (Role)</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($users as $u)
                                    <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors">
                                        <td class="p-4">
                                            <div class="font-bold text-white">{{ $u->nama_lengkap }}</div>
                                            <div class="text-[11px] text-gray-500 font-medium">ID Pengguna: #{{ $u->id_user ?? $u->id }}</div>
                                        </td>
                                        <td class="p-4 text-gray-300">
                                            <i class="fas fa-envelope text-gray-500 mr-2 text-xs"></i> {{ $u->email }}
                                        </td>
                                        <td class="p-4 text-center">
                                            @if($u->role == 'admin')
                                                <span class="bg-purple-500/10 text-purple-400 border border-purple-500/20 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider shadow-sm"><i class="fas fa-crown mr-1"></i> Admin</span>
                                            @elseif($u->role == 'dosen')
                                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider"><i class="fas fa-chalkboard-teacher mr-1"></i> Dosen</span>
                                            @elseif($u->role == 'mahasiswa')
                                                <span class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider"><i class="fas fa-user-graduate mr-1"></i> Mahasiswa</span>
                                            @else
                                                <span class="bg-gray-500/10 text-gray-400 border border-gray-500/20 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider"><i class="fas fa-user mr-1"></i> Eksternal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

        <!-- ============================================== -->
        <!-- POP-UP MODAL TAMBAH USER -->
        <!-- ============================================== -->
        <div id="modalTambahUser" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <!-- Background Hitam Transparan -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="tutupModalUser()"></div>
            
            <!-- Kotak Form -->
            <div id="modalBoxUser" class="bg-sipdark border border-sipborder rounded-3xl w-full max-w-md relative z-10 shadow-2xl scale-95 opacity-0 transition-all duration-300 overflow-hidden">
                
                <!-- Header Modal -->
                <div class="p-6 border-b border-sipborder flex justify-between items-center bg-[#15181f]">
                    <h3 class="text-lg font-bold text-white"><i class="fas fa-user-plus text-sipblue mr-2"></i> Pengguna Baru</h3>
                    <button type="button" onclick="tutupModalUser()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Form Isi -->
                <form action="{{ route('admin.pengguna.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-sipred">*</span></label>
                        <input type="text" name="nama_lengkap" required placeholder="Contoh: Ihsanul Fikri" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">NPM / NIP / NIK <span class="text-sipred">*</span></label>
                        <input type="text" name="identitas" required placeholder="Masukkan Nomor Identitas" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email / Username <span class="text-sipred">*</span></label>
                        <input type="email" name="email" required placeholder="email@domain.com" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Password <span class="text-sipred">*</span></label>
                        <input type="password" name="password" required minlength="8" placeholder="Minimal 8 Karakter" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Hak Akses (Role) <span class="text-sipred">*</span></label>
                        <div class="relative">
                            <select name="role" required class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-sipblue transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Role Pengguna --</option>
                                <option value="mahasiswa">Mahasiswa / UKM</option>
                                <option value="dosen">Dosen / Tendik</option>
                                <option value="umum">Umum / Eksternal</option>
                                <option value="admin">Administrator</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none text-xs"></i>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <button type="button" onclick="tutupModalUser()" class="px-5 py-2.5 rounded-xl border border-gray-600 text-gray-300 hover:bg-gray-800 transition-colors text-sm font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-sipblue hover:bg-sipbluehover text-white transition-colors text-sm font-bold shadow-lg shadow-sipblue/20 flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- ============================================== -->

    </div>

    <script src="{{ asset('assets/js/admin-pengguna.js') }}"></script>

</body>
</html>
    </div>

</body>
</html>