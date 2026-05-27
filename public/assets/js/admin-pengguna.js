document.addEventListener('DOMContentLoaded', function() {
    
    const modalUser = document.getElementById('modalTambahUser');
    const modalBoxUser = document.getElementById('modalBoxUser');

    // Fungsi untuk membuka Pop-up
    window.bukaModalUser = function() {
        if (modalUser && modalBoxUser) {
            modalUser.classList.remove('hidden');
            modalUser.classList.add('flex');
            
            // Animasi masuk
            setTimeout(() => {
                modalBoxUser.classList.remove('scale-95', 'opacity-0');
                modalBoxUser.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    };

    // Fungsi untuk menutup Pop-up
    window.tutupModalUser = function() {
        if (modalUser && modalBoxUser) {
            // Animasi keluar
            modalBoxUser.classList.remove('scale-100', 'opacity-100');
            modalBoxUser.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modalUser.classList.add('hidden');
                modalUser.classList.remove('flex');
            }, 300);
        }
    };
});