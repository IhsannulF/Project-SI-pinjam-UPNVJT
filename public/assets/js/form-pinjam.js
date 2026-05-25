document.addEventListener('DOMContentLoaded', function() {
    
    // === DEKLARASI VARIABEL ===
    const modalFasilitas = document.getElementById('modalFasilitas');
    const modalBox = document.getElementById('modalBox');
    const searchInput = document.getElementById('searchFasilitas');
    const inputIdFasilitas = document.getElementById('input_id_fasilitas');
    const btnText = document.getElementById('textFasilitasTerpilih');
    const formPinjam = document.getElementById('formPinjam');

    // === FUNGSI BUKA/TUTUP POP-UP ===
    // (Jadikan global dengan window. agar bisa dipanggil dari onclick di HTML)
    window.bukaModalFasilitas = function() {
        modalFasilitas.classList.remove('hidden');
        modalFasilitas.classList.add('flex');
        
        // Animasi masuk
        setTimeout(() => {
            modalFasilitas.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
            searchInput.focus(); // Langsung fokus ke kolom pencarian
        }, 10);
        
        searchInput.value = ''; 
        filterFasilitas(); // Reset pencarian
    };

    window.tutupModalFasilitas = function() {
        // Animasi keluar
        modalFasilitas.classList.add('opacity-0');
        modalBox.classList.remove('scale-100');
        modalBox.classList.add('scale-95');
        
        setTimeout(() => {
            modalFasilitas.classList.add('hidden');
            modalFasilitas.classList.remove('flex');
        }, 300);
    };

    window.pilihFasilitas = function(id, nama) {
        inputIdFasilitas.value = id;
        btnText.innerHTML = `<i class="fas fa-check-circle mr-3 text-[#00AE1C] text-lg shadow-[0_0_10px_rgba(0,174,28,0.3)] rounded-full"></i> <span class="text-white font-bold text-sm">${nama}</span>`;
        document.getElementById('btnPilihFasilitas').classList.add('border-sipblue', 'bg-sipblue/5');
        tutupModalFasilitas();
    };

    // === FITUR PENCARIAN CERDAS ===
    if (searchInput) {
        searchInput.addEventListener('input', filterFasilitas);
    }

    function filterFasilitas() {
        const keyword = searchInput.value.toLowerCase();
        const groups = document.querySelectorAll('.kategori-group');
        let anyVisible = false;

        groups.forEach(group => {
            const items = group.querySelectorAll('.fasilitas-item');
            let hasVisibleItem = false;

            items.forEach(item => {
                const name = item.querySelector('.fasilitas-name').textContent.toLowerCase();
                if (name.includes(keyword)) {
                    item.style.display = 'block';
                    hasVisibleItem = true;
                    anyVisible = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Sembunyikan judul kategori jika tidak ada fasilitas yang cocok
            group.style.display = hasVisibleItem ? 'block' : 'none';
        });

        const noResult = document.getElementById('noResultFasilitas');
        if (noResult) {
            noResult.style.display = anyVisible ? 'none' : 'flex';
        }
    }

    // === VALIDASI FORM SEBELUM SUBMIT ===
    if (formPinjam) {
        formPinjam.addEventListener('submit', function(e) {
            // Cek apakah fasilitas sudah dipilih (input hidden tidak kosong)
            if(!inputIdFasilitas.value) {
                e.preventDefault(); // Cegah form terkirim ke server
                Swal.fire({
                    icon: 'warning',
                    title: 'Fasilitas Belum Dipilih',
                    text: 'Silakan klik tombol "Cari & Pilih Fasilitas" terlebih dahulu!',
                    background: '#16181e',
                    color: '#fff',
                    confirmButtonColor: '#009EF7',
                    customClass: { popup: 'rounded-3xl border border-gray-700' }
                });
                return;
            }

            // Ubah tombol jadi status loading
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memvalidasi Sistem...';
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });
    }
});