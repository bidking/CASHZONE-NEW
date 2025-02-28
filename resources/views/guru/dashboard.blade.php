<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Walas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="icon" href="{{asset('assets/foto/logo.png')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif;
      color: white;
      background-color: #151521;
    }
    
    .main-content {
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
      padding: 20px;
      color: white;
      background-color: #1e1e2d;
      border-radius: 8px;
    }
    
    .card-bodys {
      align-items: center;
      padding: 20px;
      color: white;
      background-color: #1e1e2d;
      border-radius: 8px;
    }
    
    .card-body i {
      font-size: 30px;
      margin-right: 110px;
    }
        
    .card-body .card-text {
      justify-content: center;
      align-items: center;
      display: flex;
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
    
    /* Hover effects */
    .nav-item:hover i {
      color: black;
    }
    
    .nav-item:hover .nav-link:hover {
      background-color: #435ebe;
      color: black;
      border-radius: 8px;
    }
    
    .nav-link .active {
      color: black;
    }
    
    .row h2 {
      color: #435ebe;
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
    
    /* Style untuk profile picture placeholder berbentuk lingkaran */
    .profile-picture {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #435ebe;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }
    
    .profile-picture i {
      font-size: 24px;
      color: #fff;
      margin: 0;
    }
    
    .user-info {
      display: flex;
      flex-direction: column;
    }

    .card-bodys {
      align-items: center;
      padding: 20px;
      color: white;
      background-color: #1e1e2d;
      border-radius: 8px;
      margin-left: 30px;
      margin-right: 30px;
    }
    .unpaid-item {
      padding: 10px;
      background-color: #2e2e48;
      color: white;
      border-radius: 5px;
      margin-bottom: 8px;
      text-align: center;
    }

    .alert-danger {
      font-weight: bold;
    }

    .btn-primary {
      background-color: #435ebe;
      border: none;
    }

    .btn-primary:hover {
      background-color: #374b9a;
    }
  </style>
</head>
<body>
  <div class="back">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Content -->
        <main>
          <!-- Bagian Header dengan judul dan logo -->
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mt-2 mb-3">
            <h2 class="mb-2" style="font-weight: bold;">Dashboard Walas</h2>
            <!-- Logo ditempatkan di sebelah kanan judul -->
            <div class="d-flex align-items-center">
              <img src="{{ asset('assets/foto/logo_6.png') }}" alt="Logo" style="height: 50px;">
              <h2 class="mb-2 ms-2" style="font-weight: bold;">CashZone</h2>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-user-graduate" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">Pelajar</h5>
                    <p class="card-text">{{ $totalPelajar }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-chalkboard-teacher" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">Kelas</h5>
                    <p class="card-text">{{ $user->kelas ?? 'XII RPL 2' }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-book" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">Jurusan</h5>
                    <p class="card-text">RPL</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Bagian User dengan profile picture placeholder -->
            <div class="col-md-3 mb-4">
  <div class="text-start">
    <div class="card-body d-flex justify-content-between align-items-center">
      <!-- Bagian Profile (Picture dan Info) -->
      <div class="d-flex align-items-center">
        <div class="profile-picture me-3">
          <i class="fa-solid fa-user"></i>
        </div>
        <div class="user-info">
          <h5 class="card-title mb-1">{{ $user->name }}</h5>
          <p class="card-text mb-0">{{ $user->email }}</p>
        </div>
      </div>
      <!-- Tombol Logout -->
      <a class="nav-link p-0" href="{{ url('/logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i>
      </a>
    </div>
  </div>
</div>


          </div>
         
        </main>
      </div>
    </div>
  </div>
  
  <!-- Table Section -->
  <div class="table-container mt-2">
    <div class="card-bodys">
      <h4 class="mb-4">Daftar Pelajar</h4>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <select class="form-select d-inline-block w-auto">
            <option selected>5</option>
            <option>10</option>
            <option>20</option>
          </select>
          <select class="form-select d-inline-block w-auto">
            <option selected>Nama Lengkap</option>
            <option>Nomor Identitas</option>
          </select>
          <select class="form-select d-inline-block w-auto">
            <option selected>A-Z</option>
            <option>Z-A</option>
          </select>
        </div>
        <div>
          <button class="btn btn-warning">Reset Filter</button>
          <button class="btn btn-primary">Menu Filter</button>
        </div>
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" placeholder="Masukan keyword pencarian...">
      </div>
      <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>NISN</th>
              <th>Nama Lengkap</th>
              <th>Kelas</th>
              <th>Gender</th>
              <th>No WA</th>
              <th>Tagihan</th>
              <th>Total Masuk</th>
              <th>Total Biaya</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tabungans as $index => $tabungan)
              <tr>
                <td>{{ $index + 1 }}</td>
                <!-- Jika relasi siswa tersedia, tampilkan data siswa -->
                <td>{{ $tabungan->siswa->nisn ?? '-' }}</td>
                <td>{{ $tabungan->siswa->name ?? $tabungan->name }}</td>
                <td>{{ $tabungan->siswa->kelas ?? '-' }}</td>
                <td>
                  @if(isset($tabungan->siswa->gander))
                    @if($tabungan->siswa->gander == 'male')
                      <span class="badge bg-success">Laki-Laki</span>
                    @else
                      <span class="badge bg-danger">Perempuan</span>
                    @endif
                  @else
                    -
                  @endif
                </td>
                <td>{{ $tabungan->siswa->no_telpon ?? $tabungan->no_telpon }}</td>
                <td>
                  <span class="badge bg-success">
                    Rp.{{ number_format($tabungan->tagihan, 0, ',', '.') }}
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">
                    Rp.{{ number_format($tabungan->total_masuk, 0, ',', '.') }}
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">
                    Rp.{{ number_format($tabungan->jumlah_bayar, 0, ',', '.') }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center">Tidak ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
    </div>
  </div>
 


   <!-- Copyright Section -->
   <footer class="text-center text-white mt-4 mb-4">
    <div class="container d-flex justify-content-between" style="max-width: 95%;">
      <span>© 2025</span>
      <span>Created by CashZone</span>
    </div>
  </footer>
  
  
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</body>
</html>
