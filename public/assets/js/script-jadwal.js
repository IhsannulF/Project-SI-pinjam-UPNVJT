document.addEventListener("DOMContentLoaded", () => {
    // 1. DEKLARASI ELEMEN DOM (Disertai fallback jika elemen lama/baru berbeda)
    const calendarDays = document.getElementById("calendarDays");
    const monthYearText = document.getElementById("monthYear") || document.getElementById("calendarMonthYear");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    
    // Sesuaikan penangkap elemen: Gunakan .facility-btn (dari HTML baru) atau .facility-card (HTML lama)
    const facilityCards = document.querySelectorAll(".facility-btn, .facility-card"); 
    
    const searchInput = document.getElementById("cariFasilitasInput") || document.getElementById("searchFacility");
    const kategoriSelect = document.getElementById("kategori"); // Ini mungkin null jika tidak ada dropdown kategori

    let currentDate = new Date();
    let selectedFacilityId = null; 
    let activeFacilityName = '';

    // 2. TANGKAP DATA DENGAN AMAN DARI BLADE
    let bookedDates = window.dataJadwalBooking || {}; // Cara dari file HTML baru
    
    // Fallback cara lama (menggunakan meta tag)
    if (Object.keys(bookedDates).length === 0) {
        const metaTag = document.getElementById('jadwal-data');
        try {
            if (metaTag) {
                const rawData = metaTag.getAttribute('data-booking');
                bookedDates = rawData ? JSON.parse(rawData) : {};
                console.log("Data Booking diambil via metaTag:", bookedDates);
            }
        } catch (error) {
            console.error("Gagal membaca data jadwal dari Laravel:", error);
            bookedDates = {}; 
        }
    }

    // 3. FUNGSI MENGGAMBAR KALENDER
    function renderCalendar(date) {
        if (!calendarDays) return; // Mencegah error jika elemen tidak ada
        
        calendarDays.innerHTML = "";
        
        const year = date.getFullYear();
        const month = date.getMonth();
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        // Update Judul Header Kalender (Gabungan tampilan lama & baru)
        if (monthYearText) {
            monthYearText.innerHTML = `<span class="text-sipblue">${activeFacilityName || 'Pilih Fasilitas'}</span> <br> <span class="text-xs text-gray-400">${monthNames[month]} ${year}</span>`;
        }

        let firstDay = new Date(year, month, 1).getDay();
        firstDay = firstDay === 0 ? 6 : firstDay - 1; // Senin = 0

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        today.setHours(0,0,0,0);
        
        // Ambil daftar tanggal merah khusus untuk fasilitas yang sedang dipilih
        const currentFacilityBookings = selectedFacilityId ? (bookedDates[selectedFacilityId] || {}) : {};

        // Buat kotak kosong untuk hari sebelum tanggal 1
        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.className = "h-12 md:h-16 rounded-xl bg-transparent border border-transparent";
            calendarDays.appendChild(emptyDiv);
        }

        // Buat kotak tanggal
        for (let i = 1; i <= daysInMonth; i++) {
            const dayDiv = document.createElement("div");
            dayDiv.className = "relative h-12 md:h-16 flex flex-col items-center justify-center p-2 rounded-xl border transition-all cursor-pointer select-none";

            // Format tanggal (YYYY-MM-DD) agar cocok dengan database Laravel
            const currentCellDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const isPast = new Date(year, month, i) < today;
            
            // Cek status booking
            let statusHTML = "";
            dayDiv.innerHTML = `<span class="font-bold text-sm z-10">${i}</span>`;
            
            if (isPast || !selectedFacilityId) {
                // TANGGAL SUDAH LEWAT atau BELUM PILIH FASILITAS
                dayDiv.classList.add("bg-sipbg/50", "text-gray-600", "border-transparent", "cursor-not-allowed");
            } else {
                // CEK APAKAH TANGGAL INI ADA DI DATABASE
                if (currentFacilityBookings.hasOwnProperty(currentCellDate)) {
                    
                    // Ambil alasan dari database
                    const alasan = currentFacilityBookings[currentCellDate]; 

                    // PENUH / BOOKED (MERAH)
                    dayDiv.classList.add("bg-sipred/10", "text-white", "border-sipred/50");
                    statusHTML = `<span class="w-1.5 h-1.5 rounded-full bg-sipred absolute bottom-2 shadow-[0_0_5px_#DE2828]"></span>`;
                    
                    dayDiv.title = "Tidak Tersedia: " + alasan;
                    
                    // POP-UP SWEETALERT BARU YANG KEREN
                    dayDiv.addEventListener('click', () => {
                        if(typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Fasilitas Tidak Tersedia',
                                html: `
                                    <div class="text-sm text-gray-300 mt-2">Mohon maaf, fasilitas pada tanggal ini tidak dapat dipinjam.</div>
                                    <div class="mt-4 bg-[#0f1115] border border-gray-700 p-4 rounded-xl text-left">
                                        <div class="text-[10px] font-bold text-sipred tracking-widest uppercase mb-1">Keterangan / Alasan:</div>
                                        <div class="text-white font-medium">"${alasan}"</div>
                                    </div>
                                `,
                                icon: 'error',
                                background: '#16181e', color: '#fff', confirmButtonColor: '#DE2828', confirmButtonText: 'Tutup',
                                customClass: { popup: 'rounded-3xl border border-gray-700', confirmButton: 'rounded-xl font-bold px-8 py-2.5' }
                            });
                        } else {
                            alert("TIDAK TERSEDIA\nAlasan: " + alasan);
                        }
                    });

                } else {
                    // TERSEDIA (HIJAU)
                    dayDiv.classList.add("bg-[#00AE1C]/10", "text-white", "border-[#00AE1C]/50", "hover:bg-[#00AE1C]/20", "hover:scale-105");
                    statusHTML = `<span class="w-1.5 h-1.5 rounded-full bg-[#00AE1C] absolute bottom-2 shadow-[0_0_5px_#00AE1C]"></span>`;
                    dayDiv.title = "Tersedia untuk dipinjam";
                    
                    // Lempar ke form pinjam jika tanggal kosong diklik
                    dayDiv.addEventListener('click', () => {
                        window.location.href = `/mahasiswa/form-pinjam`; 
                    });
                }
            }

            // Highlight biru khusus hari ini
            if (year === today.getFullYear() && month === today.getMonth() && i === today.getDate()) {
                dayDiv.classList.add("ring-2", "ring-sipblue");
            }

            dayDiv.innerHTML += statusHTML;
            calendarDays.appendChild(dayDiv);
        }
    }

    // 4. NAVIGASI BULAN
    if(prevMonthBtn) {
        prevMonthBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });
    }

    if(nextMonthBtn) {
        nextMonthBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });
    }

    // 5. EFEK KLIK PADA KARTU FASILITAS
    facilityCards.forEach(card => {
        card.addEventListener("click", function() {
            // Hapus efek aktif dari semua kartu (mendukung class lama dan baru)
            facilityCards.forEach(c => {
                c.classList.remove("border-sipblue", "bg-sipblue/5", "bg-sipblue/10");
                if(c.classList.contains("facility-btn")) {
                    c.classList.add("border-gray-700", "bg-[#0f1115]");
                } else {
                    c.classList.add("border-sipborder", "bg-sipbg");
                }
            });

            // Berikan efek aktif ke kartu yang diklik
            if(this.classList.contains("facility-btn")) {
                this.classList.remove("border-gray-700", "bg-[#0f1115]");
                this.classList.add("border-sipblue", "bg-sipblue/10");
            } else {
                this.classList.remove("border-sipborder", "bg-sipbg");
                this.classList.add("border-sipblue", "bg-sipblue/5");
            }

            // SIMPAN ID DAN PERBARUI KALENDER SECARA INSTAN!
            selectedFacilityId = this.getAttribute("data-id");
            activeFacilityName = this.getAttribute("data-nama") || this.querySelector(".facility-name, h3").textContent;
            renderCalendar(currentDate);
        });
    });

    // 6. FITUR PENCARIAN & FILTER KATEGORI
    function filterFacilities() {
        if(!searchInput) return;
        
        const searchTerm = searchInput.value.toLowerCase();
        const categoryTerm = kategoriSelect ? kategoriSelect.value.toLowerCase() : "semua";
        let firstVisibleCard = null;

        facilityCards.forEach(card => {
            const nameEl = card.querySelector(".facility-name, h3");
            const name = nameEl ? nameEl.textContent.toLowerCase() : (card.getAttribute("data-nama") || "").toLowerCase();
            const category = (card.getAttribute("data-kategori") || "").toLowerCase();
            
            const matchName = name.includes(searchTerm);
            const matchCategory = categoryTerm === "semua" || category === categoryTerm;

            if (matchName && matchCategory) {
                // Gunakan display block untuk HTML baru (button), flex untuk HTML lama (div)
                card.style.display = card.tagName.toLowerCase() === 'button' ? 'block' : 'flex';
                if (!firstVisibleCard) firstVisibleCard = card;
            } else {
                card.style.display = "none";
            }
        });

        // Otomatis klik kartu teratas hasil pencarian
        if (firstVisibleCard && !firstVisibleCard.classList.contains("border-sipblue")) {
            firstVisibleCard.click();
        }
    }

    if(searchInput) searchInput.addEventListener("input", filterFacilities);
    if(kategoriSelect) kategoriSelect.addEventListener("change", filterFacilities);

    // 7. INISIALISASI AWAL
    if (facilityCards.length > 0) {
        facilityCards[0].click(); // Klik kartu pertama agar kalender langsung tergambar
    } else {
        renderCalendar(currentDate);
    }
});