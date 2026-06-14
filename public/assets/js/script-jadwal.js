document.addEventListener("DOMContentLoaded", () => {
    // 1. DEKLARASI ELEMEN DOM
    const calendarDays = document.getElementById("calendarDays");
    const monthYearText = document.getElementById("calendarMonthYear") || document.getElementById("monthYear");
    const judulFasilitasHeader = document.getElementById("namaFasilitasJudul"); // Dipisah agar lebih spesifik
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    
    const facilityCards = document.querySelectorAll(".facility-btn, .facility-card"); 
    const searchInput = document.getElementById("cariFasilitasInput") || document.getElementById("searchFacility");
    const kategoriSelect = document.getElementById("kategori"); 

    let currentDate = new Date();
    // Jika window.selectedFasilitasId sudah diset dari luar, pakai itu. Jika belum, null.
    let selectedFacilityId = window.selectedFasilitasId || null; 
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

    // 3. FUNGSI MENGGAMBAR KALENDER (Di-export ke window agar bisa dipanggil dari luar)
    window.renderCalendar = function(date = currentDate) {
        if (!calendarDays) return; 
        
        calendarDays.innerHTML = "";
        
        const year = date.getFullYear();
        const month = date.getMonth();
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        // Update Judul Header Kalender (Disesuaikan agar tidak merusak tag HTML asli)
        if (judulFasilitasHeader && activeFacilityName) {
            judulFasilitasHeader.innerText = activeFacilityName.toUpperCase();
        }
        if (monthYearText) {
            monthYearText.innerText = `${monthNames[month]} ${year}`;
        }

        let firstDay = new Date(year, month, 1).getDay();
        firstDay = firstDay === 0 ? 6 : firstDay - 1; // Senin = 0

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        today.setHours(0,0,0,0);
        
        // Pastikan membaca dari variabel global jika ada
        const idToCheck = window.selectedFasilitasId || selectedFacilityId;
        const currentFacilityBookings = idToCheck ? (bookedDates[idToCheck] || {}) : {};

        // Buat kotak kosong untuk hari sebelum tanggal 1 
        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.className = "aspect-square rounded-lg md:rounded-xl bg-transparent border border-transparent";
            calendarDays.appendChild(emptyDiv);
        }

        // Buat kotak tanggal 
        for (let i = 1; i <= daysInMonth; i++) {
            const dayDiv = document.createElement("div");
            // aspect-square menjamin kotak selalu 1:1 presisi kotak sempurna di HP maupun laptop
            dayDiv.className = "relative aspect-square flex flex-col items-center justify-center rounded-lg md:rounded-xl border transition-all cursor-pointer select-none";

            const currentCellDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const isPast = new Date(year, month, i) < today;
            
            let statusHTML = "";
            dayDiv.innerHTML = `<span class="font-bold text-xs md:text-sm z-10">${i}</span>`;
            
            if (isPast || !idToCheck) {
                // TANGGAL LEWAT / BELUM PILIH
                dayDiv.classList.add("bg-sipbg/50", "text-gray-600", "border-transparent", "cursor-not-allowed");
            } else {
                // CEK APAKAH TANGGAL INI ADA DI DATABASE
                if (currentFacilityBookings.hasOwnProperty(currentCellDate)) {
                    
                    const alasan = currentFacilityBookings[currentCellDate]; 

                    // PENUH / BOOKED (MERAH)
                    dayDiv.classList.add("bg-sipred/10", "text-white", "border-sipred/50");
                    statusHTML = `<span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-sipred absolute bottom-1.5 md:bottom-2 shadow-[0_0_5px_#DE2828]"></span>`;
                    dayDiv.title = "Tidak Tersedia: " + alasan;
                    
                    // POP-UP SWEETALERT KUSTOM
                    dayDiv.addEventListener('click', (e) => {
                        e.stopPropagation(); 
                        if(typeof Swal !== 'undefined') {
                            const bulanTahunEl = document.getElementById('calendarMonthYear') || document.getElementById('monthYear');
                            const bulanTahun = bulanTahunEl ? bulanTahunEl.innerText : '';

                            Swal.fire({
                                title: 'Jadwal Penuh!',
                                html: `
                                    <div class="text-sm text-gray-400 mt-1 mb-5">Tanggal <b class="text-white">${i} ${bulanTahun}</b> sudah tidak tersedia.</div>
                                    
                                    <div class="bg-[#15181f] border border-gray-700 rounded-xl p-4 text-left shadow-inner relative overflow-hidden">
                                        <div class="absolute left-0 top-0 w-1 h-full bg-sipred"></div>
                                        <div class="text-[10px] font-bold text-sipred uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                            <i class="fas fa-info-circle"></i> Keterangan / Alasan
                                        </div>
                                        <div class="text-white text-sm leading-relaxed font-medium">
                                            "${alasan}"
                                        </div>
                                    </div>
                                `,
                                icon: 'warning',
                                iconColor: '#DE2828',
                                background: '#1a1d24',
                                color: '#fff',
                                confirmButtonColor: '#009EF7',
                                confirmButtonText: '<i class="fas fa-check mr-1.5"></i> Mengerti',
                                customClass: {
                                    popup: 'rounded-3xl border border-gray-700 shadow-2xl mx-4',
                                    confirmButton: 'rounded-xl font-bold px-8 py-2.5 text-sm active:scale-95 transition-all'
                                }
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
                    
                    // Lempar ke form pinjam dengan data tersimpan di LocalStorage jika tanggal kosong diklik
                    dayDiv.addEventListener('click', () => {
                        if (idToCheck && activeFacilityName) {
                            localStorage.setItem('tempSelectedFasilitasId', idToCheck);
                            localStorage.setItem('tempSelectedFasilitasName', activeFacilityName);
                            localStorage.setItem('tempSelectedDate', currentCellDate);
                        }
                        
                        // Perbaikan rute: Ambil dari base URL agar dinamis
                        const baseUrl = window.location.origin;
                        if (window.location.pathname.includes('/dosen/')) {
                             window.location.href = `${baseUrl}/dosen/reservasi`; 
                        } else {
                             window.location.href = `${baseUrl}/mahasiswa/form-pinjam`; 
                        }
                    });
                }
            }

            // Highlight biru khusus hari ini
            if (year === today.getFullYear() && month === today.getMonth() && i === today.getDate()) {
                dayDiv.classList.add("ring-2", "ring-inset", "ring-sipblue");
            }

            dayDiv.innerHTML += statusHTML;
            calendarDays.appendChild(dayDiv);
        }
    }; // Akhir dari window.renderCalendar

    // Simpan referensi bulan/tahun aktif ke window untuk diakses script lain
    window.currentMonth = currentDate;
    window.currentYear = currentDate;

    // 4. NAVIGASI BULAN
    if(prevMonthBtn) {
        prevMonthBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            window.currentMonth = currentDate;
            window.renderCalendar(currentDate);
        });
    }

    if(nextMonthBtn) {
        nextMonthBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            window.currentMonth = currentDate;
            window.renderCalendar(currentDate);
        });
    }

    // 5. EFEK KLIK PADA KARTU FASILITAS (Fallback jika tidak ada script eksternal)
    // Script eksternal (seperti mahasiswa-fasilitas.js) bisa me-override fungsi ini
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
            window.selectedFasilitasId = selectedFacilityId; // Update global state
            
            activeFacilityName = this.getAttribute("data-nama") || this.querySelector(".facility-name, h3").textContent;
            window.renderCalendar(currentDate);
        });
    });

    // 6. FITUR PENCARIAN & FILTER KATEGORI (Fallback)
    window.filterFacilities = function() {
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
    };

    if(searchInput && !document.getElementById('overlayPilihFasilitas')) {
        // Hanya pasang listener jika tidak ada overlay animasi (artinya bukan halaman mahasiswa)
        searchInput.addEventListener("input", window.filterFacilities);
    }
    if(kategoriSelect) kategoriSelect.addEventListener("change", window.filterFacilities);

    // 7. INISIALISASI AWAL
    if (facilityCards.length > 0 && !document.getElementById('overlayPilihFasilitas')) {
        // Klik otomatis kartu pertama hanya jika tidak ada overlay
        facilityCards[0].click();
    } else {
        window.renderCalendar(currentDate);
    }
});