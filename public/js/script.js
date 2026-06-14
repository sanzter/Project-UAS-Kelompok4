let grades = JSON.parse(localStorage.getItem('grades')) || [];

let myChart = null;

// Logika Navigasi Halaman
function showSection(sectionId) {
    // Sembunyikan semua bagian (section)
    document.querySelectorAll('main section').forEach(s => s.classList.add('hidden'));
    
    // Tampilkan bagian yang dituju
    const targetSection = document.getElementById('section-' + sectionId);
    if (targetSection) targetSection.classList.remove('hidden');
    
    // Perbarui judul di header sesuai menu yang dipilih
    const titles = { 
        home: 'Beranda', 
        count: 'Input Nilai', 
        list: 'Daftar Nilai', 
        graphic: 'Analitik Performa',
        classroom: 'Kelas'
    };
    document.getElementById('section-title').innerText = titles[sectionId] || 'Dashboard';
    
    // Perbarui status aktif pada menu sidebar
    document.querySelectorAll('.sidebar-item').forEach(btn => btn.classList.remove('active'));
    const navBtn = document.getElementById('nav-' + sectionId);
    if (navBtn) navBtn.classList.add('active');

    // Jalankan fungsi pembaruan data sesuai bagian yang dibuka
    if(sectionId === 'graphic') {
        renderChart();
        updateInsights();
    }
    if(sectionId === 'home') updateStats();
    if(sectionId === 'list') renderTable();
    if(sectionId === 'classroom') renderClassrooms();
}

// Logika Menampilkan Data Kelas 
function renderClassrooms() {
    const subjects = ["Mathematics", "Physic", "Calculus", "Science", "History", "English", "Biology"];
    const grid = document.getElementById('classroom-grid');
    if (!grid) return;

    grid.innerHTML = subjects.map(sub => {
        const prefix = sub.charAt(0).toUpperCase();
        let roomsHtml = "";
        
        // Membuat 5 kelas contoh untuk setiap mata pelajaran
        for (let i = 1; i <= 5; i++) {
            const roomCode = `${prefix}0${i}`;
            const floor = Math.floor(Math.random() * 5) + 1;
            const students = Math.floor(Math.random() * 20) + 10; 
            
            roomsHtml += `
                <div class="p-3 bg-cyan-50 rounded-lg border border-cyan-100 mb-2">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-cyan-700">${roomCode}</span>
                        <span class="text-xs font-medium bg-white px-2 py-0.5 rounded-full text-cyan-600 border border-cyan-100">Lantai ${floor}</span>
                    </div>
                    <div class="flex items-center text-xs text-gray-500">
                        <i class="fas fa-user-friends mr-1.5 text-cyan-400"></i>
                        <span>${students} Siswa terdaftar</span>
                    </div>
                </div>
            `;
        }

        return `
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-lg bg-cyan-600 flex items-center justify-center text-white mr-3 shadow-sm">
                        <i class="fas fa-school"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">${sub}</h4>
                </div>
                <div class="space-y-1">
                    ${roomsHtml}
                </div>
            </div>
        `;
    }).join('');
}

// Login & Logout
document.getElementById('login-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const user = document.getElementById('username').value;
    const pass = document.getElementById('password').value;

    // cek usn dan pw
    if (user === "Deception" && pass === "zhangebet") {
        document.getElementById('display-user').innerText = user;
        document.getElementById('login-page').classList.add('hidden');
        document.getElementById('dashboard-page').classList.remove('hidden');
        updateStats();
    } else {
        alert("Username atau Password Salah! Akses Ditolak.");
        document.getElementById('password').value = "";
    }
});

function logout() {
    document.getElementById('login-page').classList.remove('hidden');
    document.getElementById('dashboard-page').classList.add('hidden');
    document.getElementById('login-form').reset();
}

// input nilai
document.getElementById('grade-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const newGrade = {
        id: Date.now(), // Menggunakan timestamp sebagai ID unik
        name: document.getElementById('student-name').value,
        subject: document.getElementById('subject').value,
        value: parseInt(document.getElementById('grade-value').value)
    };
    
    grades.push(newGrade);
    
    // Simpan ke localStorage agar data tidak hilang saat halaman di-refresh
    localStorage.setItem('grades', JSON.stringify(grades));
    
    e.target.reset(); // Kosongkan formulir setelah simpan
    alert('Nilai berhasil ditambahkan!');
    showSection('list'); // Pindah ke halaman daftar nilai
});

// Logika Menghapus Data Nilai
function deleteGrade(id) {
    if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        // Filter daftar untuk membuang data dengan ID yang dipilih
        grades = grades.filter(g => g.id !== id);
        localStorage.setItem('grades', JSON.stringify(grades));
        renderTable();
        updateStats();
    }
}

// Logika Menampilkan Tabel Data
function renderTable() {
    const tbody = document.getElementById('grade-table-body');
    if (!tbody) return;
    
    if (grades.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="px-8 py-10 text-center text-gray-400">Belum ada data nilai.</td></tr>`;
        return;
    }
    
    tbody.innerHTML = grades.map(g => `
        <tr class="hover:bg-cyan-50 transition">
            <td class="px-6 py-4 font-medium text-gray-800">${g.name}</td>
            <td class="px-6 py-4 text-gray-600">${g.subject}</td>
            <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-full text-sm font-semibold ${g.value >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}">
                    ${g.value}
                </span>
            </td>
            <td class="px-6 py-4 text-right">
                <button onclick="deleteGrade(${g.id})" class="text-red-500 hover:text-red-700 font-medium">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </td>
        </tr>
    `).join('');
}

// Logika Memperbarui Statistik di Beranda
function updateStats() {
    const totalEl = document.getElementById('stat-total');
    const avgEl = document.getElementById('stat-avg');
    const topEl = document.getElementById('stat-top');

    if (grades.length === 0) {
        if(totalEl) totalEl.innerText = '0';
        if(avgEl) avgEl.innerText = '0';
        if(topEl) topEl.innerText = '0';
        return;
    }

    // Hitung rata-rata dan nilai tertinggi
    const avg = (grades.reduce((sum, g) => sum + g.value, 0) / grades.length).toFixed(1);
    const top = Math.max(...grades.map(g => g.value));
    
    if(totalEl) totalEl.innerText = grades.length;
    if(avgEl) avgEl.innerText = avg;
    if(topEl) topEl.innerText = top;
}

// Logika Memperbarui Wawasan (Insights) di Bagian Grafik
function updateInsights() {
    const subjectContainer = document.getElementById('subject-list');
    const topSubEl = document.getElementById('insight-top-subject');
    const totalInsEl = document.getElementById('insight-total');
    const statusInsEl = document.getElementById('insight-status');

    if (grades.length === 0) {
        if (subjectContainer) subjectContainer.innerHTML = '<p class="text-gray-400 text-sm">Belum ada data untuk dianalisis.</p>';
        if(topSubEl) topSubEl.innerText = '-';
        if(totalInsEl) totalInsEl.innerText = '0';
        if(statusInsEl) statusInsEl.innerText = '-';
        return;
    }

    // Hitung distribusi mata pelajaran
    const subjects = {};
    grades.forEach(g => subjects[g.subject] = (subjects[g.subject] || 0) + 1);
    
    if (subjectContainer) {
        subjectContainer.innerHTML = Object.entries(subjects).map(([name, count]) => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">${name}</span>
                <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-2 py-1 rounded-full">${count} Entri</span>
            </div>
        `).join('');
    }

    // Ringkasan Wawasan
    const sortedSubjects = Object.entries(subjects).sort((a,b) => b[1] - a[1]);
    const topSubject = sortedSubjects[0][0];
    
    if(topSubEl) topSubEl.innerText = `Mata pelajaran yang paling banyak dicatat adalah ${topSubject}.`;
    if(totalInsEl) totalInsEl.innerText = `Anda telah mengelola ${grades.length} rekam data siswa.`;
    
    const avg = grades.reduce((sum, g) => sum + g.value, 0) / grades.length;
    if(statusInsEl) statusInsEl.innerText = avg >= 75 ? 'Performa keseluruhan Sangat Baik.' : 'Performa membutuhkan peningkatan.';
}

// Logika Menampilkan Grafik Bar menggunakan Chart.js
function renderChart() {
    const canvas = document.getElementById('gradeChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    if (myChart) myChart.destroy(); // Hapus grafik lama sebelum membuat yang baru

    if (grades.length === 0) {
        // Tampilkan pesan jika data kosong
        ctx.font = "16px Inter";
        ctx.fillStyle = "#94a3b8";
        ctx.textAlign = "center";
        ctx.fillText("Belum ada data untuk ditampilkan di grafik", canvas.width/2, canvas.height/2);
        return;
    }

    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: grades.map(g => g.name),
            datasets: [{
                label: 'Nilai',
                data: grades.map(g => g.value),
                backgroundColor: '#06b6d4',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        }
    });
}

// Inisialisasi saat halaman dimuat
window.onload = () => {
    updateStats();
};

// USERNAME: Deception
// Password: zhangebet