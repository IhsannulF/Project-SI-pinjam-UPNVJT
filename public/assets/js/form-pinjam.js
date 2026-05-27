document.addEventListener('DOMContentLoaded', function() {
    
    // === DEKLARASI VARIABEL ===
    const modalFasilitas = document.getElementById('modalFasilitas');
    const modalBox = document.getElementById('modalBox');
    const searchInput = document.getElementById('searchFasilitas');
    const inputIdFasilitas = document.getElementById('input_id_fasilitas');
    const btnText = document.getElementById('textFasilitasTerpilih');
    const formPinjam = document.getElementById('formPinjam');

    // === MENGHIDUPKAN KALENDER FLATPICKR ===
    // (Pindahkan langsung ke sini tanpa dibungkus DOMContentLoaded lagi)
    flatpickr(".datepicker-mahasiswa", {
        locale: "id",
        dateFormat: "Y-m-d",
        minDate: "today", 
        disableMobile: "true"
    });

    // === FUNGSI BUKA/TUTUP POP-UP ===
    window.bukaModalFasilitas = function() {
        modalFasilitas.classList.remove('hidden');
        modalFasilitas.classList.add('flex');
        
        setTimeout(() => {
            modalFasilitas.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
            if(searchInput) searchInput.focus();
        }, 10);
        
        if(searchInput) {
            searchInput.value = ''; 
            filterFasilitas(); 
        }
    };

    window.tutupModalFasilitas = function() {
        modalFasilitas.classList.add('opacity-0');
        modalBox.classList.remove('scale-100');
        modalBox.classList.add('scale-95');
        
        setTimeout(() => {
            modalFasilitas.classList.add('hidden');
            modalFasilitas.classList.remove('flex');
        }, 300);
    };

    window.pilihFasilitas = function(id, nama) {
        if(inputIdFasilitas) inputIdFasilitas.value = id;
        if(btnText) btnText.innerHTML = `<i class="fas fa-check-circle mr-3 text-[#00AE1C] text-lg shadow-[0_0_10px_rgba(0,174,28,0.3)] rounded-full"></i> <span class="text-white font-bold text-sm">${nama}</span>`;
        const btnPilih = document.getElementById('btnPilihFasilitas');
        if(btnPilih) btnPilih.classList.add('border-sipblue', 'bg-sipblue/5');
        tutupModalFasilitas();
    };

    // === FITUR PENCARIAN CERDAS ===
    if (searchInput) {
        searchInput.addEventListener('input', filterFasilitas);
    }

    function filterFasilitas() {
        if(!searchInput) return;
        const keyword = searchInput.value.toLowerCase();
        const groups = document.querySelectorAll('.kategori-group');
        let anyVisible = false;

        groups.forEach(group => {
            const items = group.querySelectorAll('.fasilitas-item');
            let hasVisibleItem = false;

            items.forEach(item => {
                const nameElem = item.querySelector('.fasilitas-name');
                if (nameElem) {
                    const name = nameElem.textContent.toLowerCase();
                    if (name.includes(keyword)) {
                        item.style.display = 'block';
                        hasVisibleItem = true;
                        anyVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                }
            });

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
            if(inputIdFasilitas && !inputIdFasilitas.value) {
                e.preventDefault(); 
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

            const btn = document.getElementById('btnSubmit');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memvalidasi Sistem...';
                btn.classList.add('opacity-70', 'cursor-not-allowed');
            }
        });
    }
});