document.addEventListener("DOMContentLoaded", function () {
    // 1. Inisialisasi Kalender Flatpickr
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d", // Format database
        minDate: "today",    
        altInput: true,      
        altFormat: "d F Y",  // Tampilan user
        disableMobile: "true"
    });

    // 2. Logika Pencarian Fasilitas (Real-time Filter)
    const inputCari = document.getElementById('inputCariFasilitas');
    const semuaKartu = document.querySelectorAll('.kartu-fasilitas');
    const pesanTidakDitemukan = document.getElementById('pesanTidakDitemukan');

    if (inputCari) {
        inputCari.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let adaYangCocok = false;

            semuaKartu.forEach(kartu => {
                // Ambil data nama dari atribut yang sudah kita siapkan di Blade
                const namaFasilitas = kartu.getAttribute('data-nama');
                
                if (namaFasilitas.includes(keyword)) {
                    kartu.style.display = 'block'; // Tampilkan jika cocok
                    adaYangCocok = true;
                } else {
                    kartu.style.display = 'none'; // Sembunyikan jika tidak cocok
                }
            });

            // Tampilkan pesan "Tidak Ditemukan" jika semua kartu tersembunyi
            if (!adaYangCocok && semuaKartu.length > 0) {
                pesanTidakDitemukan.classList.remove('hidden');
            } else {
                pesanTidakDitemukan.classList.add('hidden');
            }
        });
    }
});

// ==========================================
// FUNGSI GLOBAL (Bisa dipanggil dari atribut onclick HTML)
// ==========================================

const modal = document.getElementById('modalFasilitas');
const modalContent = document.getElementById('modalContent');
const inputCari = document.getElementById('inputCariFasilitas'); // Definisi ulang untuk scope global

// Buka Modal
window.bukaModalFasilitas = function() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Reset pencarian setiap kali modal dibuka agar semua kartu muncul lagi
    if(inputCari) {
        inputCari.value = '';
        inputCari.dispatchEvent(new Event('input')); // Memicu event input secara manual
        setTimeout(() => inputCari.focus(), 100); // Fokus otomatis ke kolom pencarian
    }

    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }, 10);
};

// Tutup Modal
window.tutupModalFasilitas = function() {
    modal.classList.add('opacity-0');
    modalContent.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
};

// Proses Pemilihan Fasilitas
window.pilihFasilitas = function(id, nama) {
    document.getElementById('input_id_fasilitas').value = id;
    
    const teks = document.getElementById('teks_fasilitas_terpilih');
    teks.innerText = nama;
    teks.classList.remove('text-gray-400');
    teks.classList.add('text-white', 'font-bold');

    document.getElementById('btnPilihFasilitas').classList.add('border-sipblue', 'bg-sipblue/5');
    document.getElementById('errorFasilitas').classList.add('hidden');

    window.tutupModalFasilitas();
};

// Validasi Form sebelum submit
window.validasiForm = function() {
    const idFasilitas = document.getElementById('input_id_fasilitas').value;
    if (!idFasilitas) {
        document.getElementById('errorFasilitas').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
    }
    return true;
};