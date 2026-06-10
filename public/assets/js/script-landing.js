// ==========================================
// 1. AREA OBSERVER (Untuk Header & Smooth Scroll Modern)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    "use strict";

    const header = document.querySelector('.header-area');
    // Jika Anda memakai header dengan class transparan bawaan, sesuaikan pemanggilan di bawah
    // Namun untuk struktur landing page terbaru Anda, header sudah fixed di atas.
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section, div[id="welcome"]'); 

    // A. Efek Sticky Header (Opsional jika Anda ingin efek berubah saat di-scroll)
    if(header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add("header-sticky");
            } else {
                header.classList.remove("header-sticky");
            }
        });
    }

    // B. ScrollSpy (Pendeteksi Halaman yang sedang aktif)
    const observerOptions = {
        root: null,
        rootMargin: '-30% 0px -70% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const activeId = entry.target.getAttribute('id');
                
                // 1. Matikan (redupkan) semua teks menu navbar
                navLinks.forEach(link => {
                    link.classList.remove('text-white', 'font-medium');
                    link.classList.add('text-siptext');
                });
                
                // 2. Nyalakan teks menu yang sesuai
                const activeLink = document.querySelector(`.nav-link[href="#${activeId}"]`);
                if (activeLink) {
                    activeLink.classList.remove('text-siptext');
                    activeLink.classList.add('text-white', 'font-medium');
                }
            }
        });
    }, observerOptions);

    // Pantau setiap bagian halaman yang memiliki ID
    sections.forEach(section => {
        if(section.getAttribute('id')) {
            observer.observe(section);
        }
    });
});
  
// ==========================================
// 2. AREA VANILLA JS (Untuk Auto Scroll Carousel)
// ==========================================
window.addEventListener('load', function() {
    const carousel = document.getElementById('carouselFasilitas');
    
    if (carousel) {
        let isHovering = false;
        let autoScrollInterval;

        // Jeda saat kursor berada di atas carousel (Desktop)
        carousel.addEventListener('mouseenter', () => isHovering = true);
        carousel.addEventListener('mouseleave', () => isHovering = false);

        // Jeda saat disentuh (Mobile/HP)
        carousel.addEventListener('touchstart', () => isHovering = true);
        carousel.addEventListener('touchend', () => {
            setTimeout(() => isHovering = false, 1000);
        });

        function jalankanAutoScroll() {
            // Set interval setiap 2 detik (2000 ms)
            autoScrollInterval = setInterval(() => {
                if (!isHovering) {
                    const kartuPertama = carousel.querySelector('a');
                    
                    if (kartuPertama) {
                        // Lebar kartu + jarak gap Tailwind (24px)
                        const jarakGeser = kartuPertama.offsetWidth + 24; 

                        // Cek apakah scroll sudah mentok di ujung kanan
                        if (Math.ceil(carousel.scrollLeft + carousel.clientWidth) >= carousel.scrollWidth - 10) {
                            // Mentok -> Kembali ke awal
                            carousel.scrollTo({
                                left: 0,
                                behavior: 'smooth'
                            });
                        } else {
                            // Belum mentok -> Geser ke kanan
                            carousel.scrollBy({
                                left: jarakGeser,
                                behavior: 'smooth'
                            });
                        }
                    }
                }
            }, 2000);
        }

        // Eksekusi fungsi
        jalankanAutoScroll();
    }
});

// ==========================================
// 3. FUNGSI MENU MOBILE (Anti-Macet)
// ==========================================
// Menggunakan window. agar pasti bisa dibaca oleh atribut onclick di HTML

window.toggleMobileMenu = function() {
    const mobileMenu = document.getElementById('mobileMenu');
    const ikonBtn = document.getElementById('ikonMobileMenu');
    
    if (mobileMenu.classList.contains('hidden')) {
        // Buka menu
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('flex');
        // Ubah ikon jadi X
        if (ikonBtn) {
            ikonBtn.classList.remove('fa-bars');
            ikonBtn.classList.add('fa-times');
        }
    } else {
        // Tutup menu
        window.tutupMobileMenu();
    }
};

window.tutupMobileMenu = function() {
    const mobileMenu = document.getElementById('mobileMenu');
    const ikonBtn = document.getElementById('ikonMobileMenu');
    
    if (mobileMenu) {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
        
        // Kembalikan ikon jadi garis tiga
        if (ikonBtn) {
            ikonBtn.classList.remove('fa-times');
            ikonBtn.classList.add('fa-bars');
        }
    }
};