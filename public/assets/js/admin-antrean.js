// ==========================================
// LOGIKA POP-UP ANTREAN PINJAMAN (SWEETALERT2)
// ==========================================

// Fungsi Pop-up Setujui
window.konfirmasiSetuju = function(button) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Setujui Pengajuan?',
            text: "Fasilitas akan resmi dipinjamkan dan kalender akan diblokir untuk user lain pada tanggal tersebut.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00AE1C', // Warna Hijau
            cancelButtonColor: '#3f4254',
            confirmButtonText: '<i class="fas fa-check-circle mr-1"></i> Ya, Setujui!',
            cancelButtonText: 'Batal',
            background: '#16181e',
            color: '#fff',
            customClass: {
                popup: 'rounded-3xl border border-gray-700 shadow-2xl',
                confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    } else {
        // Fallback jika CDN SweetAlert gagal dimuat
        if (confirm("Setujui pengajuan ini?")) button.closest('form').submit();
    }
};

// Fungsi Pop-up Tolak
window.konfirmasiTolak = function(button) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Tolak Pengajuan?',
            text: "Jadwal ini akan dibatalkan dan Mahasiswa akan menerima status penolakan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DE2828', // Warna Merah
            cancelButtonColor: '#3f4254',
            confirmButtonText: '<i class="fas fa-times-circle mr-1"></i> Ya, Tolak!',
            cancelButtonText: 'Batal',
            background: '#16181e',
            color: '#fff',
            customClass: {
                popup: 'rounded-3xl border border-gray-700 shadow-2xl',
                confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    } else {
        // Fallback jika CDN SweetAlert gagal dimuat
        if (confirm("Tolak pengajuan ini?")) button.closest('form').submit();
    }
};