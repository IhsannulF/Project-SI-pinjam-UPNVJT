document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.facility-card');
    const overlay = document.getElementById('overlayPilihFasilitas');

    // ==========================================
    // JURUS ULTIMATE: SEGEL CSS & DETEKSI MANUSIA
    // ==========================================
    
    // 1. Pasang Segel CSS untuk membungkam warna biru secara visual
    const style = document.createElement('style');
    style.innerHTML = `
        /* Selama body masih dikunci, class .active tidak akan mengeluarkan warna biru */
        body.kunci-warna .facility-card.active {
            background-color: #15181f !important;
            border-color: #374151 !important; 
            box-shadow: none !important;
            outline: none !important;
            --tw-ring-color: transparent !important;
            --tw-ring-shadow: 0 0 transparent !important;
        }
    `;
    document.head.appendChild(style);
    
    // Kunci seluruh body sejak halaman pertama kali dimuat
    document.body.classList.add('kunci-warna');

    // 2. Fitur Pencarian Fasilitas di Sidebar Kiri
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchVal = this.value.toLowerCase();
            cards.forEach(card => {
                const name = card.getAttribute('data-nama');
                card.style.display = name.includes(searchVal) ? 'block' : 'none';
            });
        });
    }

    // 3. Fitur Tirai & Penanda Warna (HANYA BEREAKSI JIKA MANUSIA YANG KLIK)
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            
            // e.isTrusted = true berarti ini adalah klik murni dari tangan user!
            // Jika diklik otomatis oleh script, nilainya akan false.
            if (e.isTrusted) {
                
                // Lepaskan segel kunci warna!
                document.body.classList.remove('kunci-warna');
                
                // Hilangkan Tirai
                if (overlay) {
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                    }, 300);
                }

                // Beri warna biru HANYA pada kartu yang diklik manusia
                cards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
});