// ==========================================
// LOGIKA RIWAYAT PENGAJUAN DOSEN
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Fitur Konfirmasi Pembatalan Reservasi (SweetAlert2)
    const btnBatal = document.querySelectorAll('.btn-batal-dosen');
    
    if (btnBatal.length > 0) {
        btnBatal.forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Batalkan Reservasi?',
                    text: "Jadwal fasilitas ini akan dikosongkan kembali. Anda yakin?",
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
                });
            });
        });
    }
});