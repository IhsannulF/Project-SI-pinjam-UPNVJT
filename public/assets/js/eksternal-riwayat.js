function bukaModalBayar(btnElement) {
    // 1. Ambil data dengan aman dari atribut tombol yang diklik
    const id = btnElement.getAttribute('data-id');
    const fasilitas = btnElement.getAttribute('data-fasilitas');
    const lamaHari = btnElement.getAttribute('data-lama');
    const hargaPerHari = btnElement.getAttribute('data-harga');
    const totalBiaya = btnElement.getAttribute('data-total');

    // 2. Format uang Rupiah (pastikan di-convert ke Integer dulu)
    const formatRupiah = (angka) => {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(parseInt(angka));
    };

    // 3. Isi data ke dalam tulisan di Modal
    document.getElementById('bayar_id_peminjaman').value = id;
    document.getElementById('bayar_fasilitas').innerText = fasilitas;
    document.getElementById('bayar_lama').innerText = lamaHari + ' Hari';
    document.getElementById('bayar_harga').innerText = formatRupiah(hargaPerHari);
    document.getElementById('bayar_total').innerText = formatRupiah(totalBiaya);
    
    // 4. Tampilkan Modal dengan animasi
    const modal = document.getElementById('modalBayar');
    const modalContent = document.getElementById('modalBayarContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
    }, 10);
}

function tutupModalBayar() {
    const modal = document.getElementById('modalBayar');
    const modalContent = document.getElementById('modalBayarContent');
    
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}