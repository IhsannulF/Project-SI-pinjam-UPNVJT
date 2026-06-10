@extends('layouts.admin')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 md:mb-8">
    <div>
        <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Manajemen Pengguna</h2>
        <div class="text-xs md:text-sm font-medium text-siptext">Kelola data seluruh civitas akademika dan eksternal.</div>
    </div>
    <div class="hidden md:block">
        <span class="text-sm font-medium text-gray-400 bg-sipdark px-4 py-2 rounded-lg border border-sipborder">
            <i class="far fa-calendar-alt mr-2"></i>{{ date('d M Y') }}
        </span>
    </div>
</div>

@if(session('success'))
    <div class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 text-xs md:text-sm font-bold flex items-center gap-2 max-w-4xl">
        <i class="fas fa-check-circle text-base"></i> {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-sipred/10 text-sipred border border-sipred/30 px-4 py-3 rounded-xl mb-6 text-xs md:text-sm font-bold flex flex-col gap-1 max-w-4xl">
        @foreach ($errors->all() as $error)
            <span><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</span>
        @endforeach
    </div>
@endif

<div class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl p-5 md:p-6 shadow-xl relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sipblue to-transparent"></div>
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5 md:mb-6">
        <h2 class="text-base md:text-lg font-bold text-white flex items-center gap-2 md:gap-3">
            <i class="fas fa-address-book text-sipblue"></i> Daftar Pengguna Sistem
        </h2>
        <button onclick="bukaModalUser()" class="w-full sm:w-auto bg-sipblue hover:bg-sipbluehover text-white px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-sipblue/20 flex items-center justify-center gap-2 active:scale-95">
            <i class="fas fa-user-plus"></i> Tambah User
        </button>
    </div>

    <div class="overflow-x-auto overflow-y-auto max-h-[400px] md:max-h-[480px] pr-2 [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar]:h-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-500">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[600px]">
            <thead class="sticky top-0 z-10 bg-[#1a1d24]">
                <tr class="bg-[#15181f] text-gray-400 text-[10px] md:text-xs uppercase tracking-widest border-b border-gray-700/50">
                    <th class="p-3 md:p-4 rounded-tl-xl font-bold">Nama Lengkap</th>
                    <th class="p-3 md:p-4 font-bold">Email Akun</th>
                    <th class="p-3 md:p-4 font-bold text-center rounded-tr-xl">Hak Akses (Role)</th>
                </tr>
            </thead>
            <tbody class="text-xs md:text-sm">
                @foreach($users as $u)
                    <tr class="border-b border-gray-700/50 hover:bg-sipblue/5 transition-colors">
                        <td class="p-3 md:p-4">
                            <div class="font-bold text-white">{{ $u->nama_lengkap }}</div>
                            <div class="text-[10px] md:text-[11px] text-gray-500 font-medium mt-0.5">ID Pengguna: #{{ $u->id_user ?? $u->id }}</div>
                        </td>
                        <td class="p-3 md:p-4 text-gray-300 truncate max-w-[200px]" title="{{ $u->email }}">
                            <i class="fas fa-envelope text-gray-500 mr-1.5 text-xs"></i> {{ $u->email }}
                        </td>
                        <td class="p-3 md:p-4 text-center">
                            @if($u->role == 'admin')
                                <span class="bg-purple-500/10 text-purple-400 border border-purple-500/20 px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider shadow-sm"><i class="fas fa-crown mr-1"></i> Admin</span>
                            @elseif($u->role == 'dosen')
                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider"><i class="fas fa-chalkboard-teacher mr-1"></i> Dosen</span>
                            @elseif($u->role == 'mahasiswa')
                                <span class="bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/20 px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider"><i class="fas fa-user-graduate mr-1"></i> Mahasiswa</span>
                            @else
                                <span class="bg-gray-500/10 text-gray-400 border border-gray-500/20 px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider"><i class="fas fa-user mr-1"></i> Eksternal</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambahUser" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm transition-opacity" onclick="tutupModalUser()"></div>
    
    <div id="modalBoxUser" class="bg-sipdark border border-sipborder rounded-2xl md:rounded-3xl w-full max-w-md relative z-10 shadow-2xl scale-95 opacity-0 transition-all duration-300 overflow-hidden flex flex-col max-h-[90vh]">
        
        <div class="p-5 md:p-6 border-b border-sipborder flex justify-between items-center bg-[#15181f] shrink-0">
            <h3 class="text-base md:text-lg font-bold text-white"><i class="fas fa-user-plus text-sipblue mr-2"></i> Pengguna Baru</h3>
            <button type="button" onclick="tutupModalUser()" class="text-gray-400 hover:text-white transition-colors focus:outline-none w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-800">
                <i class="fas fa-times text-lg md:text-xl"></i>
            </button>
        </div>

        <div class="overflow-y-auto [&::-webkit-scrollbar]:w-[4px] md:[&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-700 [&::-webkit-scrollbar-thumb]:rounded-full p-5 md:p-6">
            <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-4 md:space-y-5">
                @csrf
                
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Nama Lengkap <span class="text-sipred">*</span></label>
                    <input type="text" name="nama_lengkap" required placeholder="Contoh: Ihsanul Fikri" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all">
                </div>
                
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">NPM / NIP / NIK <span class="text-sipred">*</span></label>
                    <input type="text" name="identitas" required placeholder="Masukkan Nomor Identitas" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all">
                </div>
                
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Email / Username <span class="text-sipred">*</span></label>
                    <input type="email" name="email" required placeholder="email@domain.com" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all">
                </div>
                
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Password <span class="text-sipred">*</span></label>
                    <input type="password" name="password" required minlength="8" placeholder="Minimal 8 Karakter" class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all">
                </div>
                
                <div>
                    <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 md:mb-2">Hak Akses (Role) <span class="text-sipred">*</span></label>
                    <div class="relative">
                        <select name="role" required class="w-full bg-[#0f1115] border border-gray-700 rounded-xl px-4 py-2.5 md:py-3 text-white text-xs md:text-sm focus:outline-none focus:border-sipblue transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>-- Pilih Role Pengguna --</option>
                            <option value="mahasiswa">Mahasiswa / UKM</option>
                            <option value="dosen">Dosen / Tendik</option>
                            <option value="umum">Umum / Eksternal</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="tutupModalUser()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-gray-600 text-gray-300 hover:bg-gray-800 transition-colors text-xs md:text-sm font-bold">Batal</button>
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-sipblue hover:bg-sipbluehover text-white transition-colors text-xs md:text-sm font-bold shadow-lg shadow-sipblue/20 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/admin-pengguna.js') }}"></script>
@endsection