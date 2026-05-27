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
            popup: 'rounded-3xl border border-gray-700'
        }
    }).then((result) => {
        if (result.isConfirmed) button.closest('form').submit();
    });
};

// 2. Buka Modal Edit Fasilitas
window.bukaModalEdit = function(id, nama, kategori, kapasitas, ikon) {
    Swal.fire({
        title: 'Edit Fasilitas',
        background: '#16181e',
        color: '#fff',
        width: '600px',
        html: `
            <form id="formEdit" method="POST" action="${window.updateFasilitasUrl}" enctype="multipart/form-data" class="text-left space-y-5 mt-4">
                <input type="hidden" name="_token" value="${window.csrfToken}">
                <input type="hidden" name="id_edit" value="${id}">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Nama Fasilitas</label>
                    <input type="text" name="nama" value="${nama}" class="w-full bg-[#2d3240] border border-gray-600 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kategori</label>
                        <select name="kategori" class="w-full bg-[#2d3240] border border-gray-600 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                            <option value="gsg" ${kategori == 'gsg' ? 'selected' : ''}>GSG</option>
                            <option value="lab" ${kategori == 'lab' ? 'selected' : ''}>Lab</option>
                            <option value="kelas" ${kategori == 'kelas' ? 'selected' : ''}>Kelas</option>
                            <option value="rapat" ${kategori == 'rapat' ? 'selected' : ''}>Ruang Rapat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kapasitas</label>
                        <input type="number" name="kapasitas" value="${kapasitas}" class="w-full bg-[#2d3240] border border-gray-600 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#009EF7] transition-all text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Ganti Foto (Opsional)</label>
                    <div class="relative bg-[#2d3240] border border-dashed border-gray-500 hover:border-[#009EF7] rounded-xl p-3 transition-all">
                        <input type="file" name="foto_baru" class="w-full text-sm text-gray-400 file:cursor-pointer file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#009EF7]/10 file:text-[#009EF7] hover:file:bg-[#009EF7] hover:file:text-white transition-all">
                    </div>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save mr-1"></i> Simpan Perubahan',
        confirmButtonColor: '#009EF7',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#3f4254',
        customClass: {
            confirmButton: 'rounded-xl font-bold px-6 py-2.5',
            cancelButton: 'rounded-xl font-bold px-6 py-2.5',
            popup: 'rounded-3xl border border-gray-700'
        },
        preConfirm: () => document.getElementById('formEdit').submit()
    });
};

// 3. Konfirmasi Buka Blokir (Unblock)
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
            popup: 'rounded-3xl border border-gray-700'
        }
    }).then((result) => {
        if (result.isConfirmed) button.closest('form').submit();
    });
};

// 4. Fungsi Pop-up Pilih Fasilitas (Untuk Blokir)
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
    document.getElementById('textFasilitasTerpilihBlokir').innerHTML = `<i class="fas fa-check-circle mr-3 text-sipred text-lg shadow-[0_0_10px_rgba(222,40,40,0.3)] rounded-full"></i> <span class="text-white font-bold text-sm">${nama}</span>`;
    document.getElementById('btnPilihFasilitasBlokir').classList.add('border-sipred', 'bg-sipred/5');
    tutupModalFasilitasBlokir();
};

// ==========================================
// EVENT LISTENER KETIKA HALAMAN DIMUAT (DOM)
// ==========================================
document.addEventListener('DOMContentLoaded', () => {

    // --- A. Filter Tombol Kategori Fasilitas ---
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

    // --- B. Konfirmasi Form Tambah Fasilitas ---
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
                customClass: { confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold', popup: 'rounded-3xl border border-gray-700' }
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    }

    // --- C. Validasi & Konfirmasi Form Blokir Jadwal ---
    const formBlokir = document.getElementById('formBlokirJadwal');
    const inputFasilitasBlokir = document.getElementById('input_id_fasilitas_blokir');
    
    if (formBlokir) {
        formBlokir.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi: Cek apakah fasilitas sudah dipilih dari Modal Pop-up
            if(!inputFasilitasBlokir || !inputFasilitasBlokir.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Fasilitas!',
                    text: 'Silakan klik tombol pencarian untuk memilih fasilitas yang ingin diblokir.',
                    background: '#16181e', color: '#fff', confirmButtonColor: '#DE2828',
                    customClass: { popup: 'rounded-3xl border border-gray-700', confirmButton: 'rounded-xl font-bold' }
                });
                return;
            }

            // Jika sudah dipilih, tampilkan konfirmasi
            Swal.fire({
                title: 'Blokir Rentang Tanggal Ini?',
                text: "Pengguna tidak akan bisa meminjam fasilitas ini di tanggal yang dipilih.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DE2828',
                confirmButtonText: '<i class="fas fa-ban mr-1"></i> Ya, Blokir',
                cancelButtonText: 'Batal',
                background: '#16181e', color: '#fff',
                customClass: { confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold', popup: 'rounded-3xl border border-gray-700' }
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    }

    // --- D. Pencarian & Filter Tabel Daftar Blokir ---
    const searchBlokir = document.getElementById('searchBlokir');
    const filterKategoriBlokir = document.getElementById('filterKategoriBlokir');
    const blokirRows = document.querySelectorAll('.blokir-row');

    function jalankanFilterBlokir() {
        if (!searchBlokir) return;
        const keyword = searchBlokir.value.toLowerCase();
        const kategori = filterKategoriBlokir ? filterKategoriBlokir.value.toLowerCase() : 'semua';

        blokirRows.forEach(row => {
            const nama = row.getAttribute('data-nama') || '';
            const alasan = row.getAttribute('data-alasan') || '';
            const kat = row.getAttribute('data-kategori') || '';

            const textMatch = nama.includes(keyword) || alasan.includes(keyword);
            const catMatch = kategori === 'semua' || kat === kategori;

            row.style.display = (textMatch && catMatch) ? '' : 'none'; 
        });
        
        if(typeof updateBulkUI === 'function') updateBulkUI();
    }

    if (searchBlokir) searchBlokir.addEventListener('keyup', jalankanFilterBlokir);
    if (filterKategoriBlokir) filterKategoriBlokir.addEventListener('change', jalankanFilterBlokir);

    // --- E. Fitur Pencarian di dalam Modal Pop-up Fasilitas ---
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

    // --- Inisialisasi Kalender Flatpickr ---
    flatpickr(".datepicker-custom", {
        locale: "id",          // Menggunakan bahasa Indonesia (Senin, Selasa, dst)
        dateFormat: "Y-m-d",   // Format yang diterima oleh database Laravel
        minDate: "today",      // Mencegah Admin memblokir tanggal di masa lalu
        disableMobile: "true"  // Memaksa kalender dark mode tetap muncul di HP
    });
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
            groupedByReason[item.alasan].push(item.tanggal);
        });

        const formatDate = (dStr) => new Date(dStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

        let listHtml = '';
        for (const [alasan, dates] of Object.entries(groupedByReason)) {
            dates.sort();
            let ranges = [];
            let start = dates[0], prev = dates[0];

            for (let i = 1; i < dates.length; i++) {
                let current = dates[i];
                let diffDays = Math.round(Math.abs(new Date(current) - new Date(prev)) / (1000 * 60 * 60 * 24));

                if (diffDays === 1) {
                    prev = current;
                } else {
                    ranges.push(start === prev ? formatDate(start) : `${formatDate(start)} s/d ${formatDate(prev)}`);
                    start = prev = current;
                }
            }
            ranges.push(start === prev ? formatDate(start) : `${formatDate(start)} s/d ${formatDate(prev)}`);

            const badges = ranges.map(rangeText => `<span class="bg-sipred/20 text-sipred border border-sipred/30 px-3 py-1.5 rounded-md text-xs font-bold inline-flex items-center shadow-sm"><i class="far fa-calendar-alt mr-1.5"></i> ${rangeText}</span>`).join(' ');

            listHtml += `
                <div class="mb-3 last:mb-0 border-b border-gray-700/50 pb-3 last:border-0 last:pb-0">
                    <div class="text-[11px] font-bold text-gray-300 mb-2 flex items-center gap-2">
                        <i class="fas fa-thumbtack text-sipred"></i> <span>${alasan}</span>
                    </div>
                    <div class="flex flex-wrap gap-2 pl-5">${badges}</div>
                </div>
            `;
        }

        datesHtml = `
            <div class="mt-4 mb-2">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Riwayat & Alasan Blokir:</label>
                <div class="bg-[#0f1115] border border-gray-700 rounded-xl p-3 max-h-40 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-600 [&::-webkit-scrollbar-thumb]:rounded-full text-left">
                    ${listHtml}
                </div>
            </div>
        `;
    }

    Swal.fire({
        title: 'Atur & Buka Jadwal',
        html: `
            <div class="text-left space-y-4 mt-4">
                
                <div class="bg-[#16181e] border border-gray-600 rounded-xl p-4 flex items-center gap-3 shadow-lg">
                    <div class="bg-sipblue/10 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-[#009EF7] text-lg"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-400 font-bold tracking-widest uppercase">Fasilitas Terpilih</div>
                        <div class="text-white font-bold text-sm">${namaFasilitas}</div>
                    </div>
                </div>
                
                ${datesHtml}
                
                <div class="mt-4 border-t border-gray-700 pt-4">
                    <p class="text-xs text-gray-400 mb-3">Tentukan rentang tanggal di bawah ini untuk <b>menghapus status blokir</b>:</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dari Tanggal</label>
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" id="swal-mulai" placeholder="Pilih Tanggal" class="w-full bg-[#16181e] border border-gray-600 rounded-xl pl-11 pr-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#009EF7] transition-all cursor-pointer">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Sampai Tanggal</label>
                            <div class="relative">
                                <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                                <input type="text" id="swal-akhir" placeholder="Pilih Tanggal" class="w-full bg-[#16181e] border border-gray-600 rounded-xl pl-11 pr-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#009EF7] transition-all cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `,
        background: '#1e2128', 
        color: '#fff', 
        showCancelButton: true, 
        confirmButtonColor: '#009EF7',
        confirmButtonText: '<i class="fas fa-unlock mr-2"></i> Buka Rentang Tanggal Ini',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-3xl border border-gray-700', confirmButton: 'text-sm font-bold', cancelButton: 'text-sm font-bold' },
        
        // --- TRIGGER FLATPICKR ---
        didOpen: () => {
            flatpickr("#swal-mulai", {
                locale: "id",
                dateFormat: "Y-m-d",
                disableMobile: "true"
            });
            flatpickr("#swal-akhir", {
                locale: "id",
                dateFormat: "Y-m-d",
                disableMobile: "true"
            });
        },
        
        // --- VALIDASI SEBELUM SUBMIT ---
        preConfirm: () => {
            const mulai = document.getElementById('swal-mulai').value;
            const akhir = document.getElementById('swal-akhir').value;

            if (!mulai || !akhir) { Swal.showValidationMessage('Semua tanggal wajib diisi!'); return false; }
            if (mulai > akhir) { Swal.showValidationMessage('Tanggal mulai tidak boleh melebihi tanggal akhir!'); return false; }
            return { mulai, akhir };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('unblock_id_fasilitas').value = idFasilitas;
            document.getElementById('unblock_tanggal_mulai').value = result.value.mulai;
            document.getElementById('unblock_tanggal_berakhir').value = result.value.akhir;
            document.getElementById('formUnblockRange').submit();
        }
    });
};