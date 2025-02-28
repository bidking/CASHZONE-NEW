@extends('layout.app')
@section('title', 'dashboard')

@section('content')
<style>
    body {
        font-family: 'Lato', sans-serif;
        color: white;
        background-color: #151521;
    }

    .main-content {
        margin-left: 250px; /* Offset the width of the sidebar */
        max-height: 100vh;
        position: fixed;
        overflow-y: auto;
    }

    .card {
        color: black;
    }

    .card-body {
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Rata kiri pada layar besar (PC) */
        padding: 20px;
        color: white; /* Sesuaikan dengan desain Anda */
        background-color: #1e1e2d; /* Sesuaikan dengan desain Anda */
        border-radius: 8px;
    }
    .card-bodys {
        position: relative;
    width: 100%;
    height: auto;
        align-items: center;
        padding: 20px;
        color: white;
        background-color: #1e1e2d;
        border-radius: 8px;
    }
   
    .card-body i {
        font-size: 30px;
        margin-right: 15px;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

    .card-text {
        font-size: 16px;
        margin: 0;
    }
    .nav-link {
        font-size: 29px;
        color: #435ebe;
    }
    .btn-toggle {
        background-color: #2e2e48;
        color: #fff;
    }
    
    /* Change icon color to gray on hover */
    .nav-item:hover i {
        color: black; /* Gray color on hover */
    }

    /* Change the whole list item color to gray on hover */
    .nav-item:hover .nav-link:hover {
        background-color: #435ebe; /* Light gray background on hover */
        color: black; /* Change text color to gray on hover */
        border-radius: 8px; /* Optional: Add rounded corners */
    }

    /* Change the text color of the "Kas" menu item to blue on hover */
    .nav-link .active {
        color: black; /* Text color changes to blue */
    }

    /* Change background color of "Kas" menu item on hover */
    .row h2 {
        color: #657bc1;
        font-weight: bold;
        font-size: 30px;
    }
    .back {
        background-color: #151521;
        padding: 20px;
        position: relative;
    }
    .container-fluid {
        background-color: #151521;
        border-radius: 25px;
    }

    /* Responsif untuk mobile */
    @media (max-width: 767px) {
        .main-content {
            margin-left: 0; /* Hilangkan margin kiri pada mobile */
        }
        .col-md-3, .col-md-8, .col-md-4 {
            width: 100%; /* Elemen mengambil lebar penuh pada mobile */
        }
        #transactionChart {
        height: 300px !important; /* Tinggi lebih besar di mobile */
    }
    .card-body {
            flex-direction: column; /* Ikon di atas, teks di bawah */
            justify-content: center; /* Pusatkan konten secara horizontal */
            text-align: center; /* Pusatkan teks */
        }
        .card-body i {
            margin-right: 0; /* Hilangkan margin kanan ikon */
            margin-bottom: 10px; /* Beri jarak bawah antara ikon dan teks */
        }
        .card-body > div {
            display: flex;
            flex-direction: column;
            align-items: center; /* Pusatkan teks di bawah ikon */
        }
    }

    /* Memperbesar gender chart pada PC */
    @media (min-width: 768px) {
        .col-md-4 {
            flex: 0 0 33.333333%; /* Gender chart lebih besar */
            max-width: 33.333333%;
        }
        #transactionChart {
        height: 400px !important; /* Tinggi untuk PC, sesuaikan sesuai kebutuhan */
    }
    }
</style>
</head>
<body>
    <div class="back">
        <div class="container-fluid">
            <div class="row">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
                    <h3 class="mt-3 mb-2">Dashboard</h3>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="text-start">
                        <div class="card-body">
    <i class="fa-solid fa-user-graduate"></i>
    <div>
        <h5 class="card-title">Pelajar</h5>
        <p class="card-text">{{ $totalPelajar }}</p>
    </div>
</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <i class="fa-solid fa-chalkboard-teacher"></i>
                                <div>
                                    <h5 class="card-title">Kelas</h5>
                                    <p class="card-text">4</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <i class="fa-solid fa-book"></i>
                                <div>
                                    <h5 class="card-title">Jurusan</h5>
                                    <p class="card-text">3</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <div class="user">
                                    <h5 class="card-title">
                                        @if($user instanceof \App\Models\Admin)
                                            <i class="fa-solid fa-user-shield"></i>  <!-- Ikon Admin -->
                                            {{ $user->name }}
                                        @elseif($user instanceof \App\Models\Guru)
                                            <i class="fa-solid fa-chalkboard-teacher"></i>  <!-- Ikon Guru -->
                                            {{ $user->name }}
                                        @elseif($user instanceof \App\Models\Siswa)
                                            <i class="fa-solid fa-user-graduate"></i>  <!-- Ikon Siswa -->
                                            {{ $user->name }}
                                        @else
                                            Nama Tidak Ditemukan
                                        @endif
                                    </h5>
                                    <p class="card-text">{{ $status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row">
                <div class="col-md-8">
    <div class="mb-4">
        <div class="card-bodys">
            <h5 class="card-title mb-3" style="font-size:20px;">Total Transaksi Tahun Ini</h5>
            <input type="number" class="form-control mb-3" placeholder="Isi Tahun" value="2025">
            <canvas id="transactionChart"></canvas>
        </div>
    </div>
</div>
                    <div class="col-md-4"> <!-- Ubah dari col-md-3 menjadi col-md-4 -->
                        <div class="mb-4">
                            <div class="card-bodys">
                                <h5 class="card-title mb-2 text-center" style="font-size:20px;">Pelajar Jenis Kelamin</h5>
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/driver.js/0.9.8/driver.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/driver.js/0.9.8/driver.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
    const ctx1 = document.getElementById('transactionChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Total Transaksi',
            data: @json($chartValues),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Ubah ke false agar tinggi bisa diatur
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
        const ctx2 = document.getElementById('genderChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Gender',
                    data: [{{ $maleCount }}, {{ $femaleCount }}],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        formatter: (value, context) => {
                            const dataset = context.chart.data.datasets[0];
                            const total = dataset.data.reduce((acc, val) => acc + val, 0);
                            const percentage = ((value / total) * 100).toFixed(1) + '%';
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        anchor: 'center',
                        align: 'center'
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        document.addEventListener('DOMContentLoaded', function () {
            const driver = new Driver({
                animate: true,
                opacity: 0.75,
                padding: 10,
                allowClose: false,
                overlayClickNext: true,
                doneBtnText: 'Selesai',
                closeBtnText: 'Tutup',
                nextBtnText: 'Selanjutnya'
            });

            // Definisikan langkah-langkah tur untuk dashboard
            driver.defineSteps([
                {
                    element: '.d-flex.justify-content-between.flex-wrap.flex-md-nowrap.align-items-center.pt-3.pb-2 h3',
                    popover: {
                        title: 'Dashboard Header',
                        description: 'Ini adalah header Dashboard yang menampilkan judul halaman.',
                        position: 'bottom'
                    }
                },
                {
                    element: '.row.justify-content-center > .col-md-3:nth-child(1) .card-body',
                    popover: {
                        title: 'Total Pelajar',
                        description: 'Menampilkan total jumlah pelajar.',
                        position: 'top'
                    }
                },
                {
                    element: '.row.justify-content-center > .col-md-3:nth-child(2) .card-body',
                    popover: {
                        title: 'Total Kelas',
                        description: 'Menampilkan jumlah kelas yang ada.',
                        position: 'top'
                    }
                },
                {
                    element: '.row.justify-content-center > .col-md-3:nth-child(3) .card-body',
                    popover: {
                        title: 'Total Jurusan',
                        description: 'Menampilkan jumlah jurusan.',
                        position: 'top'
                    }
                },
                {
                    element: '.row.justify-content-center > .col-md-3:nth-child(4) .card-body',
                    popover: {
                        title: 'User Info',
                        description: 'Menampilkan informasi user yang sedang login.',
                        position: 'top'
                    }
                },
                {
                    element: '.col-md-8 .card-bodys', // Sesuaikan selector dengan kolom baru
                    popover: {
                        title: 'Total Transaksi Tahun Ini',
                        description: 'Grafik ini menampilkan total transaksi pada tahun berjalan.',
                        position: 'bottom'
                    }
                },
                {
                    element: '.col-md-4 .card-bodys', // Sesuaikan selector dengan kolom baru
                    popover: {
                        title: 'Pelajar Jenis Kelamin',
                        description: 'Grafik ini menampilkan perbandingan jumlah pelajar berdasarkan jenis kelamin.',
                        position: 'left'
                    }
                }
            ]);

            // Mulai tur saat tombol dengan kelas .guide diklik
            document.querySelector('.guide').addEventListener('click', function () {
                const header = document.querySelector('.d-flex.justify-content-between.flex-wrap.flex-md-nowrap.align-items-center.pt-3.pb-2');
                if (header) {
                    header.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(function () {
                        driver.start();
                    }, 500);
                } else {
                    driver.start();
                }
            });
        });
    </script>
@endsection