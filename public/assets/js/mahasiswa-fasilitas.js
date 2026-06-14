document.addEventListener('DOMContentLoaded', function() {
    const facilityBtns = document.querySelectorAll('.facility-btn');
    const overlay = document.getElementById('overlayPilihFasilitas');
    const searchInput = document.getElementById('cariFasilitasInput');

    // Fitur Pencarian Fasilitas (Ketik dan Cari)
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            facilityBtns.forEach(btn => {
                const name = btn.getAttribute('data-nama').toLowerCase();
                if (name.includes(keyword)) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        });
    }

    // Sembunyikan Overlay Gelap saat fasilitas ditekan
    facilityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (overlay) {
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    overlay.classList.remove('flex');
                }, 300);
            }
        });
    });
});