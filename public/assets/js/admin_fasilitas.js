// ==========================================
// FUNGSI GLOBAL (Dapat dipanggil dari HTML onclick)
// ==========================================

// 1. Konfirmasi Hapus Fasilitas
window.konfirmasiHapus = function(button) {
    Swal.fire({
        title: 'Hapus Fasilitas?',
        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DE2828',
        confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#16181e',
        color: '#fff',
        customClass: {
            confirmButton: 'rounded-xl font-bold px-6 py-2.5',
            cancelButton: 'rounded-xl font-bold px-6 py-2.5',
            popup: 'rounded-3xl border border-gray-700 mx-4' // Tambahan mx-4 agar rapi di HP
        }
    }).then((result) => {
        if (result.isConfirmed) button.closest('form').submit();
    });
};

// 2. Buka Modal Edit Fasilitas
window.bukaModalEdit = function(id, nama, kategori, kapasitas, harga, ikon) {
    Swal.fire({
        title: 'Edit Fasilitas',
        background: '#16181e',
        color: '#fff',
        width: '600px',
        html: `
            <form id="formEdit" method="POST" action="${window.updateFasilitasUrl}" enctype="multipart/form-data" class="text-left space-y-4 md:space-y-5 mt-4">
                <input type="hidden" name="_token" value="${window.csrfToken}">
                <input type="hidden" name="id_edit" value="${id}">
                
                <div>
                    <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Nama Fasilitas</label>
                    <input type="text" name="nama" value="${nama}" required class="w-full bg-[#2d3240] border border-gray-600 rounded-xl px-4 py-2.5 md:py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kategori</label>
                        <select name="kategori" required class="w-full bg-[#2d3240] border border-gray-600 rounded-xl px-4 py-2.5 md:py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                            <option value="gsg" ${kategori.toLowerCase() == 'gsg' ? 'selected' : ''}>GSG</option>
                            <option value="lab" ${kategori.toLowerCase() == 'lab' ? 'selected' : ''}>Lab</option>
                            <option value="kelas" ${kategori.toLowerCase() == 'kelas' ? 'selected' : ''}>Kelas</option>
                            <option value="rapat" ${kategori.toLowerCase() == 'rapat' ? 'selected' : ''}>Ruang Rapat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kapasitas</label>
                        <div class="relative">
                            <input type="number" name="kapasitas" value="${kapasitas}" required class="w-full bg-[#2d3240] border border-gray-600 rounded-xl pl-4 pr-12 py-2.5 md:py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] md:text-xs font-bold">Orang</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Harga Sewa / Hari</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] md:text-xs font-bold">Rp</span>
                            <input type="number" name="harga_per_hari" value="${harga}" required class="w-full bg-[#2d3240] border border-gray-600 rounded-xl pl-10 pr-4 py-2.5 md:py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pilih Ikon</label>
                        <select name="ikon" required class="w-full bg-[#2d3240] border border-gray-600 rounded-xl px-4 py-2.5 md:py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                            <option value="fas fa-building" ${ikon == 'fas fa-building' ? 'selected' : ''}>🏢 Gedung Umum</option>
                            <option value="fas fa-laptop-code" ${ikon == 'fas fa-laptop-code' ? 'selected' : ''}>💻 Lab Komputer</option>
                            <option value="fas fa-chalkboard-teacher" ${ikon == 'fas fa-chalkboard-teacher' ? 'selected' : ''}>👨‍🏫 Ruang Kelas</option>
                            <option value="fas fa-users" ${ikon == 'fas fa-users' ? 'selected' : ''}>👥 Ruang Rapat</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Ganti Foto (Opsional)</label>
                    <div class="relative bg-[#2d3240] border border-dashed border-gray-500 hover:border-[#009EF7] rounded-xl p-2 md:p-3 transition-all">
                        <input type="file" name="foto_baru" class="w-full text-sm text-gray-400 file:cursor-pointer file:mr-4 file:py-2 md:file:py-2.5 file:px-4 md:file:px-5 file:rounded-lg file:border-0 file:text-[10px] md:file:text-xs file:font-bold file:bg-[#009EF7]/10 file:text-[#009EF7] hover:file:bg-[#009EF7] hover:file:text-white transition-all">
                    </div>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save mr-1"></i> Simpan',
        confirmButtonColor: '#009EF7',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#3f4254',
        customClass: {
            confirmButton: 'rounded-xl font-bold px-5 py-2.5 md:px-6 md:py-2.5 text-sm',
            cancelButton: 'rounded-xl font-bold px-5 py-2.5 md:px-6 md:py-2.5 text-sm',
            popup: 'rounded-3xl border border-gray-700 mx-4'
        },
        preConfirm: () => {
            document.getElementById('formEdit').submit();
        }
    });
};

// 3. Konfirmasi Buka Blokir
window.konfirmasiBukaBlokir = function(button) {
    Swal.fire({
        title: 'Buka Blokir Jadwal?',
        text: "Fasilitas ini akan kembali tersedia untuk dipinjam pada tanggal tersebut.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#009EF7',
        confirmButtonText: '<i class="fas fa-lock-open mr-1"></i> Ya, Buka!',
        cancelButtonText: 'Batal',
        background: '#16181e',
        color: '#fff',
        customClass: {
            confirmButton: 'rounded-xl font-bold px-6 py-2.5',
            cancelButton: 'rounded-xl font-bold px-6 py-2.5',
            popup: 'rounded-3xl border border-gray-700 mx-4'
        }
    }).then((result) => {
        if (result.isConfirmed) button.closest('form').submit();
    });
};

// 4. Modal Pilih Fasilitas Blokir
window.bukaModalFasilitasBlokir = function() {
    const modalBlokir = document.getElementById('modalFasilitasBlokir');
    const modalBoxBlokir = document.getElementById('modalBoxFasilitasBlokir');
    const searchInputBlokir = document.getElementById('searchFasilitasBlokir');
    
    if (modalBlokir && modalBoxBlokir) {
        modalBlokir.classList.remove('hidden');
        modalBlokir.classList.add('flex');
        setTimeout(() => {
            modalBoxBlokir.classList.remove('scale-95', 'opacity-0');
            modalBoxBlokir.classList.add('scale-100', 'opacity-100');
            if(searchInputBlokir) searchInputBlokir.focus();
        }, 10);
    }
};

window.tutupModalFasilitasBlokir = function() {
    const modalBlokir = document.getElementById('modalFasilitasBlokir');
    const modalBoxBlokir = document.getElementById('modalBoxFasilitasBlokir');
    
    if (modalBlokir && modalBoxBlokir) {
        modalBoxBlokir.classList.remove('scale-100', 'opacity-100');
        modalBoxBlokir.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modalBlokir.classList.add('hidden');
            modalBlokir.classList.remove('flex');
        }, 300);
    }
};

window.pilihFasilitasBlokir = function(id, nama) {
    document.getElementById('input_id_fasilitas_blokir').value = id;
    document.getElementById('textFasilitasTerpilihBlokir').innerHTML = `<i class="fas fa-check-circle mr-2 md:mr-3 text-sipred text-base md:text-lg shadow-[0_0_10px_rgba(222,40,40,0.3)] rounded-full shrink-0"></i> <span class="text-white font-bold text-xs md:text-sm truncate">${nama}</span>`;
    document.getElementById('btnPilihFasilitasBlokir').classList.add('border-sipred', 'bg-sipred/5');
    tutupModalFasilitasBlokir();
};

// ==========================================
// EVENT LISTENER (DOM)
// ==========================================
document.addEventListener('DOMContentLoaded', () => {

    // A. Filter Kategori
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-sipblue', 'text-white', 'border-sipblue');
                b.classList.add('bg-sipbg', 'text-siptext', 'border-sipborder');
            });
            btn.classList.remove('bg-sipbg', 'text-siptext');
            btn.classList.add('bg-sipblue', 'text-white', 'border-sipblue');

            document.querySelectorAll('.fasilitas-item').forEach(item => {
                item.style.display = (filter === 'semua' || item.dataset.kategori === filter) ? 'flex' : 'none';
            });
        });
    });

    // B. Form Tambah Fasilitas
    const formTambah = document.getElementById('formTambahFasilitas');
    if (formTambah) {
        formTambah.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Fasilitas Baru?',
                text: "Pastikan nama dan kapasitas sudah benar.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#009EF7',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Periksa Lagi',
                background: '#16181e', color: '#fff',
                customClass: { confirmButton: 'rounded-xl font-bold text-sm', cancelButton: 'rounded-xl font-bold text-sm', popup: 'rounded-3xl border border-gray-700 mx-4' }
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    }

    // C. Form Blokir Jadwal
    const formBlokir = document.getElementById('formBlokirJadwal');
    const inputFasilitasBlokir = document.getElementById('input_id_fasilitas_blokir');
    
    if (formBlokir) {
        formBlokir.addEventListener('submit', function(e) {
            e.preventDefault();
            if(!inputFasilitasBlokir || !inputFasilitasBlokir.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Fasilitas!',
                    text: 'Silakan klik tombol pencarian untuk memilih fasilitas yang ingin diblokir.',
                    background: '#16181e', color: '#fff', confirmButtonColor: '#DE2828',
                    customClass: { popup: 'rounded-3xl border border-gray-700 mx-4', confirmButton: 'rounded-xl font-bold' }
                });
                return;
            }
            Swal.fire({
                title: 'Blokir Rentang Tanggal Ini?',
                text: "Pengguna tidak akan bisa meminjam fasilitas ini di tanggal yang dipilih.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DE2828',
                confirmButtonText: '<i class="fas fa-ban mr-1"></i> Ya, Blokir',
                cancelButtonText: 'Batal',
                background: '#16181e', color: '#fff',
                customClass: { confirmButton: 'rounded-xl font-bold text-sm', cancelButton: 'rounded-xl font-bold text-sm', popup: 'rounded-3xl border border-gray-700 mx-4' }
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    }

    // D. Pencarian Tabel Blokir
    const searchBlokir = document.getElementById('searchBlokir');
    const filterKategoriBlokir = document.getElementById('filterKategoriBlokir');
    const blokirRows = document.querySelectorAll('.blokir-row');

    function jalankanFilterBlokir() {
        if (!searchBlokir) return;
        const keyword = searchBlokir.value.toLowerCase();
        const kategori = filterKategoriBlokir ? filterKategoriBlokir.value.toLowerCase() : 'semua';

        blokirRows.forEach(row => {
            const nama = row.getAttribute('data-nama') || '';
            const kat = row.getAttribute('data-kategori') || '';
            const textMatch = nama.includes(keyword);
            const catMatch = kategori === 'semua' || kat === kategori;
            row.style.display = (textMatch && catMatch) ? '' : 'none'; 
        });
    }

    if (searchBlokir) searchBlokir.addEventListener('keyup', jalankanFilterBlokir);
    if (filterKategoriBlokir) filterKategoriBlokir.addEventListener('change', jalankanFilterBlokir);

    // E. Pencarian Modal Fasilitas
    const searchInputModal = document.getElementById('searchFasilitasBlokir');
    if (searchInputModal) {
        searchInputModal.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            const groups = document.querySelectorAll('.kategori-group-blokir');
            let anyVisible = false;

            groups.forEach(group => {
                const items = group.querySelectorAll('.fasilitas-item-blokir');
                let hasVisibleItem = false;

                items.forEach(item => {
                    const name = item.querySelector('.fasilitas-name-blokir').textContent.toLowerCase();
                    if (name.includes(keyword)) {
                        item.style.display = 'block';
                        hasVisibleItem = true;
                        anyVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
                group.style.display = hasVisibleItem ? 'block' : 'none';
            });
            const noResult = document.getElementById('noResultFasilitasBlokir');
            if(noResult) noResult.style.display = anyVisible ? 'none' : 'flex';
        });
    }

    // --- INISIALISASI FLATPICKR (PERBAIKAN) ---
    // Pastikan disableMobile berupa nilai boolean, bukan string "true"
    if (typeof flatpickr !== "undefined") {
        flatpickr(".datepicker-custom", {
            locale: "id",          
            dateFormat: "Y-m-d",   
            minDate: "today",      
            disableMobile: true    
        });
    } else {
        console.error("Flatpickr library belum termuat dengan benar!");
    }
});

// ==========================================
// POP-UP ATUR JADWAL BLOKIR (EDIT RENTANG)
// ==========================================
window.bukaModalEditRentang = function(idFasilitas, namaFasilitas, btnElement) {
    const dataJson = btnElement.getAttribute('data-dates');
    let blockedData = [];
    try { blockedData = JSON.parse(dataJson); } catch (e) { console.error("Gagal membaca data", e); }

    let datesHtml = '';
    if (blockedData.length > 0) {
        const groupedByReason = {};
        
        blockedData.forEach(item => {
            if (!groupedByReason[item.alasan]) groupedByReason[item.alasan] = [];
            groupedByReason[item.alasan].push(item.tanggal_mulai); 
        });

        const formatDate = (dStr) => new Date(dStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

        let listHtml = '';
        for (const [alasan, datesStr] of Object.entries(groupedByReason)) {
            datesStr.sort(); 
            let dates = datesStr.map(d => new Date(d));
            
            let ranges = [];
            let start = dates[0], prev = dates[0];

            for (let i = 1; i < dates.length; i++) {
                let current = dates[i];
                let diffDays = Math.round((current - prev) / (1000 * 60 * 60 * 24));

                if (diffDays === 1) {
                    prev = current;
                } else {
                    ranges.push(start.getTime() === prev.getTime() 
                        ? formatDate(start) 
                        : `${formatDate(start)} s/d ${formatDate(prev)}`);
                    start = prev = current;
                }
            }
            ranges.push(start.getTime() === prev.getTime() 
                ? formatDate(start) 
                : `${formatDate(start)} s/d ${formatDate(prev)}`);

            const badges = ranges.map(rangeText => `<span class="bg-sipred/20 text-sipred border border-sipred/30 px-2.5 py-1 md:px-3 md:py-1.5 rounded-md text-[10px] md:text-xs font-bold inline-flex items-center shadow-sm whitespace-nowrap mb-1"><i class="far fa-calendar-alt mr-1.5"></i> ${rangeText}</span>`).join(' ');

            listHtml += `
                <div class="mb-3 last:mb-0 border-b border-gray-700/50 pb-3 last:border-0 last:pb-0">
                    <div class="text-[10px] md:text-[11px] font-bold text-gray-300 mb-2 flex items-start gap-2">
                        <i class="fas fa-thumbtack text-sipred mt-0.5"></i> <span>${alasan}</span>
                    </div>
                    <div class="flex flex-wrap gap-1 md:gap-2 pl-4 md:pl-5">${badges}</div>
                </div>
            `;
        }

        datesHtml = `
            <div class="mt-4 mb-2">
                <label class="block text-[10px] md:text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Riwayat & Alasan Blokir:</label>
                <div class="bg-[#0f1115] border border-gray-700 rounded-xl p-3 max-h-32 md:max-h-40 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-600 [&::-webkit-scrollbar-thumb]:rounded-full text-left">
                    ${listHtml}
                </div>
            </div>
        `;
    }

    Swal.fire({
        title: 'Atur & Buka Jadwal',
        html: `
            <div class="text-left space-y-4 mt-4">
                <div class="bg-[#16181e] border border-gray-600 rounded-xl p-3 md:p-4 flex items-center gap-3 shadow-lg">
                    <div class="bg-sipblue/10 w-10 h-10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fas fa-building text-[#009EF7] text-base md:text-lg"></i>
                    </div>
                    <div class="truncate">
                        <div class="text-[9px] md:text-[10px] text-gray-400 font-bold tracking-widest uppercase">Fasilitas Terpilih</div>
                        <div class="text-white font-bold text-xs md:text-sm truncate">${namaFasilitas}</div>
                    </div>
                </div>
                
                ${datesHtml}
                
                <div class="mt-4 border-t border-gray-700 pt-4">
                    <p class="text-[10px] md:text-xs text-gray-400 mb-3">Tentukan rentang tanggal untuk <b>menghapus blokir spesifik</b>:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                        <div>
                            <label class="block text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dari Tanggal</label>
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" id="swal-mulai" placeholder="Pilih Tanggal" class="w-full bg-[#16181e] border border-gray-600 rounded-xl pl-10 pr-3 py-2 md:py-2.5 text-white text-xs md:text-sm focus:outline-none focus:border-[#009EF7] transition-all cursor-pointer">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Sampai Tanggal</label>
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" id="swal-akhir" placeholder="Pilih Tanggal" class="w-full bg-[#16181e] border border-gray-600 rounded-xl pl-10 pr-3 py-2 md:py-2.5 text-white text-xs md:text-sm focus:outline-none focus:border-[#009EF7] transition-all cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `,
        background: '#1e2128', 
        color: '#fff', 
        showCancelButton: true, 
        showDenyButton: true, // MENAMBAHKAN TOMBOL KETIGA
        confirmButtonColor: '#009EF7',
        denyButtonColor: '#DE2828', // Warna merah terang
        confirmButtonText: '<i class="fas fa-calendar-check mr-1.5"></i> Buka Rentang',
        denyButtonText: '<i class="fas fa-trash-alt mr-1.5"></i> Buka Semua',
        cancelButtonText: 'Batal',
        customClass: { 
            popup: 'rounded-3xl border border-gray-700 mx-4', 
            confirmButton: 'text-[10px] md:text-xs font-bold rounded-xl px-3 md:px-4 py-2 md:py-2.5', 
            denyButton: 'text-[10px] md:text-xs font-bold rounded-xl px-3 md:px-4 py-2 md:py-2.5', 
            cancelButton: 'text-[10px] md:text-xs font-bold rounded-xl px-3 md:px-4 py-2 md:py-2.5' 
        },
        
        didOpen: () => {
            if (typeof flatpickr !== "undefined") {
                flatpickr("#swal-mulai", { locale: "id", dateFormat: "Y-m-d", disableMobile: true });
                flatpickr("#swal-akhir", { locale: "id", dateFormat: "Y-m-d", disableMobile: true });
            }
        },
        
        preConfirm: () => {
            const mulai = document.getElementById('swal-mulai').value;
            const akhir = document.getElementById('swal-akhir').value;

            if (!mulai || !akhir) { Swal.showValidationMessage('Semua tanggal wajib diisi!'); return false; }
            if (mulai > akhir) { Swal.showValidationMessage('Tanggal mulai tidak boleh melebihi tanggal akhir!'); return false; }
            return { mulai, akhir };
        }
    }).then((result) => {
        // 1. Jika menekan tombol Biru (Buka rentang yang diketik)
        if (result.isConfirmed) {
            document.getElementById('unblock_id_fasilitas').value = idFasilitas;
            document.getElementById('unblock_tanggal_mulai').value = result.value.mulai;
            document.getElementById('unblock_tanggal_berakhir').value = result.value.akhir;
            document.getElementById('formUnblockRange').submit();
        } 
        // 2. Jika menekan tombol Merah (Buka / Hapus Semua Blokir)
        else if (result.isDenied) {
            Swal.fire({
                title: 'Buka Semua Blokir?',
                text: "Seluruh riwayat blokir untuk fasilitas ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DE2828',
                confirmButtonText: 'Ya, Eksekusi!',
                cancelButtonText: 'Batal',
                background: '#16181e', color: '#fff',
                customClass: { popup: 'rounded-3xl border border-gray-700 mx-4', confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold' }
            }).then((confirmRes) => {
                if (confirmRes.isConfirmed) {
                    // Cari tanggal terkecil dan terbesar secara otomatis
                    let allDates = [];
                    blockedData.forEach(item => {
                        allDates.push(new Date(item.tanggal_mulai));
                        allDates.push(new Date(item.tanggal_berakhir));
                    });
                    
                    let formatYMD = (d) => {
                        let year = d.getFullYear();
                        let month = String(d.getMonth() + 1).padStart(2, '0');
                        let day = String(d.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    };
                    
                    let minDate = formatYMD(new Date(Math.min.apply(null, allDates)));
                    let maxDate = formatYMD(new Date(Math.max.apply(null, allDates)));

                    document.getElementById('unblock_id_fasilitas').value = idFasilitas;
                    document.getElementById('unblock_tanggal_mulai').value = minDate;
                    document.getElementById('unblock_tanggal_berakhir').value = maxDate;
                    document.getElementById('formUnblockRange').submit();
                }
            });
        }
    });
};