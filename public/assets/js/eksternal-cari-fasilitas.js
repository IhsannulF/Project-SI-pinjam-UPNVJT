document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Ambil data event dari elemen HTML (Jembatan Data Clean Code)
    const dataContainer = document.getElementById('data-kalender');
    let rawEvents = [];
    
    if (dataContainer) {
        try {
            rawEvents = JSON.parse(dataContainer.getAttribute('data-events'));
        } catch (error) {
            console.error("Gagal mem-parsing data kalender:", error);
        }
    }

    let calendar;

    // 2. Inisialisasi Kalender (Awalnya kosong, menunggu user memilih fasilitas)
    const calendarEl = document.getElementById('calendar');
    
    if (calendarEl) {
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            locale: 'id',
            height: '100%',
            events: [] // Sengaja dikosongkan di awal
        });
        calendar.render();
    }

    // 3. Logika Fitur Pencarian Fasilitas (Kolom Kiri)
    const inputCari = document.getElementById('cariFasilitasInput');
    const semuaKartu = document.querySelectorAll('.kartu-fasilitas');
    
    if (inputCari) {
        inputCari.addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            semuaKartu.forEach(kartu => {
                const nama = kartu.getAttribute('data-nama');
                if(nama.includes(keyword)) {
                    kartu.style.display = 'flex'; 
                } else {
                    kartu.style.display = 'none'; 
                }
            });
        });
    }

    // 4. Fungsi Mengklik Fasilitas 
    window.pilihFasilitasKalender = function(elemen, idFasilitas, namaFasilitas) {
        semuaKartu.forEach(k => {
            k.classList.remove('border-sipblue', 'bg-sipblue/5');
            k.querySelector('.icon-bg').classList.remove('text-sipblue', 'bg-sipblue/10');
            k.querySelector('.nama-teks').classList.remove('text-sipblue');
        });

        elemen.classList.add('border-sipblue', 'bg-sipblue/5');
        elemen.querySelector('.icon-bg').classList.add('text-sipblue', 'bg-sipblue/10');
        elemen.querySelector('.nama-teks').classList.add('text-sipblue');

        const overlay = document.getElementById('overlayPilih');
        if (overlay) {
            overlay.classList.add('hidden');
        }

        document.getElementById('judulKalender').innerText = 'Jadwal ' + namaFasilitas;
        document.getElementById('subjudulKalender').innerText = 'Menampilkan ketersediaan jadwal untuk fasilitas ini.';

        const btnPesan = document.getElementById('btnPesanSekarang');
        if (btnPesan) {
            btnPesan.classList.remove('hidden');
            btnPesan.classList.add('flex');
        }

        // Filter jadwal ke kalender
        if (calendar) {
            const filteredEvents = rawEvents.filter(event => event.resourceId == idFasilitas);
            calendar.removeAllEventSources();
            calendar.addEventSource(filteredEvents);
        }
    };
});