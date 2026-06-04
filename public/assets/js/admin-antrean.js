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
        if (confirm("Setujui pengajuan ini?")) button.closest('form').submit();
    }
};

// Fungsi Pop-up Tolak
window.konfirmasiTolak = function(button) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Tolak Pengajuan?',
            text: "Jadwal ini akan dibatalkan dan peminjam akan menerima status penolakan.",
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
        if (confirm("Tolak pengajuan ini?")) button.closest('form').submit();
    }
}; // <-- INI PENUTUP YANG HILANG SEBELUMNYA


// ==========================================
// LOGIKA KELOLA ANTREAN & RIWAYAT (ADMIN)
// ==========================================

// 1. Fungsi Buka Modal Edit Tanggal
window.bukaModalEdit = function(button) {
    const id = button.getAttribute('data-id');
    const tglMulai = button.getAttribute('data-mulai');
    const tglBerakhir = button.getAttribute('data-akhir');
    const nama = button.getAttribute('data-nama');
    const fasilitas = button.getAttribute('data-fasilitas');

    const modal = document.getElementById('modalEditJadwal');
    const content = document.getElementById('modalEditContent');
    const form = document.getElementById('formEditJadwal');

    if (modal && content && form) {
        form.action = `/admin/antrean/${id}`;

        document.getElementById('editNama').innerText = nama;
        document.getElementById('editFasilitas').innerText = fasilitas;
        
        document.getElementById('editTglMulai').value = tglMulai.split(' ')[0];
        document.getElementById('editTglBerakhir').value = tglBerakhir.split(' ')[0];

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }
};

// 2. Fungsi Tutup Modal Edit
window.tutupModalEdit = function() {
    const modal = document.getElementById('modalEditJadwal');
    const content = document.getElementById('modalEditContent');

    if (modal && content) {
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
};

// 3. Peringatan Batalkan Jadwal (SweetAlert2)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-batal-riwayat').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Batalkan Jadwal?',
                text: "Status pengajuan ini akan diubah menjadi 'Dibatalkan' dan kalender akan kembali kosong.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DE2828',
                cancelButtonColor: '#374151',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali',
                background: '#15181f',
                color: '#fff',
                customClass: {
                    popup: 'rounded-3xl border border-gray-700 shadow-2xl',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
});

// Menampilkan pop-up review tagihan
function bukaModalTagihan(btnElement) {
    const url = btnElement.getAttribute('data-url');
    const nama = btnElement.getAttribute('data-nama');
    const fasilitas = btnElement.getAttribute('data-fasilitas');
    const lamaHari = btnElement.getAttribute('data-lama');
    const hargaPerHari = btnElement.getAttribute('data-harga');
    const totalBiaya = btnElement.getAttribute('data-total');

    const formatRupiah = (angka) => {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(parseInt(angka));
    };

    // Mengisi data ke tulisan di modal
    document.getElementById('tagihan_nama').innerText = nama;
    document.getElementById('tagihan_fasilitas').innerText = fasilitas;
    document.getElementById('tagihan_lama').innerText = lamaHari + ' Hari';
    document.getElementById('tagihan_harga').innerText = formatRupiah(hargaPerHari);
    document.getElementById('tagihan_total').innerText = formatRupiah(totalBiaya);
    
    // Set URL tujuan form secara dinamis
    document.getElementById('formTerbitkanTagihan').action = url;

    const modal = document.getElementById('modalTagihan');
    const modalContent = document.getElementById('modalTagihanContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
    }, 10);
}

// Menutup pop-up tagihan
function tutupModalTagihan() {
    const modal = document.getElementById('modalTagihan');
    const modalContent = document.getElementById('modalTagihanContent');
    
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}