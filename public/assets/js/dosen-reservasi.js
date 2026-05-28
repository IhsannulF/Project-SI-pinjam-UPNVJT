// ==========================================
// 1. Inisialisasi Datepicker (Flatpickr)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    
    let endPicker; // Deklarasi di luar agar bisa diakses startPicker

    // Konfigurasi Tanggal Berakhir (dibuat lebih dulu)
    if (document.getElementById("tgl_berakhir")) {
        endPicker = flatpickr("#tgl_berakhir", {
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            locale: "id",
            minDate: "today"
        });
    }

    // Konfigurasi Tanggal Mulai
    if (document.getElementById("tgl_mulai")) {
        flatpickr("#tgl_mulai", {
            altInput: true,
            altFormat: "d F Y", // Format yang terlihat user (12 Mei 2026)
            dateFormat: "Y-m-d", // Format untuk Database
            locale: "id", // Bahasa Indonesia
            minDate: "today", // Tidak bisa pilih tanggal kemarin
            onChange: function(selectedDates, dateStr, instance) {
                // Kunci batas minimal tanggal berakhir agar tidak mendahului tanggal mulai
                if(endPicker) {
                    endPicker.set("minDate", dateStr);
                }
            }
        });
    }

    // Pasang Event Listener untuk Filter Pencarian Modal
    const cariInput = document.getElementById('cariFasilitasModal');
    const filterKat = document.getElementById('filterKategoriModal');
    
    if(cariInput && filterKat) {
        cariInput.addEventListener('input', saringFasilitas);
        filterKat.addEventListener('change', saringFasilitas);
    }
});


// ==========================================
// 2. Logika Modal Pop-Up Fasilitas
// ==========================================

function bukaModalFasilitas() {
    const modal = document.getElementById('modalFasilitas');
    const modalContent = document.getElementById('modalContent');
    
    if(modal && modalContent) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Delay untuk efek animasi fade-in & scale-up
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }
}

function tutupModalFasilitas() {
    const modal = document.getElementById('modalFasilitas');
    const modalContent = document.getElementById('modalContent');
    
    if(modal && modalContent) {
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
}

function pilihFasilitas(id, nama, kategori) {
    const inputHidden = document.getElementById('inputHiddenFasilitas');
    const tampilanTeks = document.getElementById('tampilanFasilitas');
    
    if(inputHidden && tampilanTeks) {
        // Isi input hidden untuk dikirim ke backend
        inputHidden.value = id;
        
        // Ubah tampilan UI
        tampilanTeks.innerHTML = `<span class="text-white font-bold text-base">${nama} <span class="text-yellow-500 text-xs ml-1 font-medium bg-yellow-500/10 px-2 py-0.5 rounded-md">${kategori}</span></span>`;
        
        // Tutup modal
        tutupModalFasilitas();
    }
}

function saringFasilitas() {
    const cariInput = document.getElementById('cariFasilitasModal');
    const filterKat = document.getElementById('filterKategoriModal');
    const items = document.querySelectorAll('.fasilitas-item');
    const pesanKosong = document.getElementById('pesanKosong');

    const keyword = cariInput.value.toLowerCase();
    const kategori = filterKat.value.toLowerCase();
    let adaHasil = false;

    items.forEach(item => {
        const namaItem = item.getAttribute('data-nama');
        const katItem = item.getAttribute('data-kategori');
        
        const cocokKata = namaItem.includes(keyword);
        const cocokKategori = (kategori === 'semua' || katItem.includes(kategori));

        if (cocokKata && cocokKategori) {
            item.style.display = 'block';
            adaHasil = true;
        } else {
            item.style.display = 'none';
        }
    });

    // Tampilkan pesan "Fasilitas tidak ditemukan" jika kosong
    if (pesanKosong) {
        pesanKosong.style.display = adaHasil ? 'none' : 'block';
    }
}


// ==========================================
// 3. Validasi Form Sebelum Submit
// ==========================================
function validasiSubmit() {
    const inputHidden = document.getElementById('inputHiddenFasilitas');
    
    if(!inputHidden.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Fasilitas Kosong',
            text: 'Silakan pilih fasilitas dari katalog terlebih dahulu.',
            background: '#15181f',
            color: '#fff',
            confirmButtonColor: '#eab308'
        });
        return;
    }
    
    // Submit form secara native jika fasilitas sudah terisi
    document.getElementById('formReservasi').submit();
}