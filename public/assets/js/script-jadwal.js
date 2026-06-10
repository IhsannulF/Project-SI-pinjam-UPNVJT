document.addEventListener("DOMContentLoaded", () => {
    // 1. DEKLARASI ELEMEN DOM
    const calendarDays = document.getElementById("calendarDays");
    const monthYearText = document.getElementById("monthYear") || document.getElementById("calendarMonthYear");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    
    const facilityCards = document.querySelectorAll(".facility-btn, .facility-card"); 
    const searchInput = document.getElementById("cariFasilitasInput") || document.getElementById("searchFacility");
    const kategoriSelect = document.getElementById("kategori"); 

    let currentDate = new Date();
    let selectedFacilityId = null; 
    let activeFacilityName = '';

    // 2. TANGKAP DATA DENGAN AMAN DARI BLADE
    let bookedDates = window.dataJadwalBooking || {}; 
    
    if (Object.keys(bookedDates).length === 0) {
        const metaTag = document.getElementById('jadwal-data');
        try {
            if (metaTag) {
                const rawData = metaTag.getAttribute('data-booking');
                bookedDates = rawData ? JSON.parse(rawData) : {};
            }
        } catch (error) {
            console.error("Gagal membaca data jadwal dari Laravel:", error);
            bookedDates = {}; 
        }
    }

    // 3. FUNGSI MENGGAMBAR KALENDER
    function renderCalendar(date) {
        if (!calendarDays) return; 
        
        calendarDays.innerHTML = "";
        
        const year = date.getFullYear();
        const month = date.getMonth();
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        // Update Judul Header Kalender (Responsif Text)
        if (monthYearText) {
            monthYearText.innerHTML = `
                <span class="text-sipblue text-sm md:text-xl uppercase">${activeFacilityName || 'Pilih Fasilitas'}</span> 
                <br> 
                <span class="text-[10px] md:text-xs text-gray-400 uppercase tracking-widest">${monthNames[month]} ${year}</span>
            `;
        }

        let firstDay = new Date(year, month, 1).getDay();
        firstDay = firstDay === 0 ? 6 : firstDay - 1; // Senin = 0

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        today.setHours(0,0,0,0);
        
        const currentFacilityBookings = selectedFacilityId ? (bookedDates[selectedFacilityId] || {}) : {};

        // Buat kotak kosong untuk hari sebelum tanggal 1 (PERBAIKAN: Gunakan aspect-square)
        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.className = "aspect-square rounded-lg md:rounded-xl bg-transparent border border-transparent";
            calendarDays.appendChild(emptyDiv);
        }

        // Buat kotak tanggal (PERBAIKAN: aspect-square dan padding responsif)
        for (let i = 1; i <= daysInMonth; i++) {
            const dayDiv = document.createElement("div");
            // aspect-square menjamin kotak selalu 1:1 presisi kotak sempurna di HP maupun laptop
            dayDiv.className = "relative aspect-square flex flex-col items-center justify-center rounded-lg md:rounded-xl border transition-all cursor-pointer select-none";

            const currentCellDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const isPast = new Date(year, month, i) < today;
            
            let statusHTML = "";
            // Ukuran font angka lebih kecil di HP
            dayDiv.innerHTML = `<span class="font-bold text-xs md:text-sm z-10">${i}</span>`;
            
            if (isPast || !selectedFacilityId) {
                // TANGGAL LEWAT / BELUM PILIH
                dayDiv.classList.add("bg-sipbg/50", "text-gray-600", "border-transparent", "cursor-not-allowed");
            } else {
                if (currentFacilityBookings.hasOwnProperty(currentCellDate)) {
                    // PENUH / BOOKED (MERAH)
                    const alasan = currentFacilityBookings[currentCellDate]; 
                    dayDiv.classList.add("bg-sipred/10", "text-white", "border-sipred/50");
                    // Posisi titik indikator dinaikkan sedikit di HP (bottom-1.5) agar tidak nabrak angka
                    statusHTML = `<span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-sipred absolute bottom-1.5 md:bottom-2 shadow-[0_0_5px_#DE2828]"></span>`;
                    dayDiv.title = "Tidak Tersedia: " + alasan;
                    
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
                                customClass: { popup: 'rounded-3xl border border-gray-700 mx-4', confirmButton: 'rounded-xl font-bold px-8 py-2.5' }
                            });
                        } else {
                            alert("TIDAK TERSEDIA\nAlasan: " + alasan);
                        }
                    });

                } else {
                    // TERSEDIA (HIJAU)
                    dayDiv.classList.add("bg-[#00AE1C]/10", "text-white", "border-[#00AE1C]/50", "hover:bg-[#00AE1C]/20", "hover:scale-105");
                    statusHTML = `<span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-[#00AE1C] absolute bottom-1.5 md:bottom-2 shadow-[0_0_5px_#00AE1C]"></span>`;
                    dayDiv.title = "Tersedia untuk dipinjam";
                    
                    dayDiv.addEventListener('click', () => {
                        window.location.href = `/mahasiswa/form-pinjam`; 
                    });
                }
            }

            // Highlight biru khusus hari ini
            if (year === today.getFullYear() && month === today.getMonth() && i === today.getDate()) {
                // Tambahkan ring-inset agar border tidak merusak dimensi aspect-square
                dayDiv.classList.add("ring-2", "ring-inset", "ring-sipblue");
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
            facilityCards.forEach(c => {
                c.classList.remove("border-sipblue", "bg-sipblue/5", "bg-sipblue/10");
                if(c.classList.contains("facility-btn")) {
                    c.classList.add("border-gray-700", "bg-[#0f1115]");
                } else {
                    c.classList.add("border-sipborder", "bg-sipbg");
                }
            });

            if(this.classList.contains("facility-btn")) {
                this.classList.remove("border-gray-700", "bg-[#0f1115]");
                this.classList.add("border-sipblue", "bg-sipblue/10");
            } else {
                this.classList.remove("border-sipborder", "bg-sipbg");
                this.classList.add("border-sipblue", "bg-sipblue/5");
            }

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
                card.style.display = card.tagName.toLowerCase() === 'button' ? 'block' : 'flex';
                if (!firstVisibleCard) firstVisibleCard = card;
            } else {
                card.style.display = "none";
            }
        });

        if (firstVisibleCard && !firstVisibleCard.classList.contains("border-sipblue")) {
            firstVisibleCard.click();
        }
    }

    if(searchInput) searchInput.addEventListener("input", filterFacilities);
    if(kategoriSelect) kategoriSelect.addEventListener("change", filterFacilities);

    // 7. INISIALISASI AWAL
    if (facilityCards.length > 0) {
        facilityCards[0].click();
    } else {
        renderCalendar(currentDate);
    }
});