// File: public/assets/js/eksternal-detail-fasilitas.js

function bukaModalFasilitas(element) {
    // 1. Ambil data dari atribut kartu yang diklik
    const nama = element.getAttribute('data-nama');
    const kategori = element.getAttribute('data-kategori');
    const kapasitas = element.getAttribute('data-kapasitas');
    const harga = element.getAttribute('data-harga');
    const status = element.getAttribute('data-status');
    const gambar = element.getAttribute('data-gambar');

    // 2. Suntikkan data ke elemen di dalam Modal
    document.getElementById('mdl_nama').innerText = nama;
    document.getElementById('mdl_kategori').innerText = kategori;
    document.getElementById('mdl_kapasitas').innerText = kapasitas;
    document.getElementById('mdl_harga').innerText = harga;
    document.getElementById('mdl_gambar').src = gambar;

    // 3. Logika Warna Status (Tersedia / Tidak)
    const badgeStatus = document.getElementById('mdl_status');
    if (status === 'tersedia') {
        badgeStatus.innerText = 'Tersedia';
        badgeStatus.className = 'px-3 py-1 rounded-lg text-[#00AE1C] bg-[#00AE1C]/10 border border-[#00AE1C]/20 text-[10px] font-bold shadow-lg uppercase tracking-widest';
    } else {
        badgeStatus.innerText = status;
        badgeStatus.className = 'px-3 py-1 rounded-lg text-sipred bg-sipred/10 border border-sipred/20 text-[10px] font-bold shadow-lg uppercase tracking-widest';
    }
    
    // 4. Tampilkan Modal dengan Animasi Smooth
    const modal = document.getElementById('modalDetailFasilitas');
    const modalContent = document.getElementById('modalDetailContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
    }, 10);
}

function tutupModalFasilitas() {
    const modal = document.getElementById('modalDetailFasilitas');
    const modalContent = document.getElementById('modalDetailContent');
    
    // Tarik modal mengecil perlahan
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300); // Sinkron dengan durasi transisi tailwind
}