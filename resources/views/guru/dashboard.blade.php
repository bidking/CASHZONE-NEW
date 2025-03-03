<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wali Kelas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="icon" href="{{ asset('assets/foto/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif;
      color: white;
      background-color: #151521;
      margin: 0;
      padding: 0;
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
    
    .card, .card-body, .card-bodys {
      border: none;
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
      display: flex;
      flex-direction: column;
      align-items: stretch;
      padding: 20px;
      color: white;
      background-color: #1e1e2d;
      border-radius: 8px;
      margin: 15px;
    }
    
    .card-body i {
      font-size: 30px;
      margin-right: 20px;
    }
    
    .card-body .card-text {
      display: flex;
      justify-content: center;
      align-items: center;
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
    
    /* Profile picture styling */
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
    }
    
    .user-info {
      display: flex;
      flex-direction: column;
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .card-body {
        flex-direction: row;
        padding: 15px;
      }
      .card-body i {
        font-size: 24px;
        margin-right: 10px;
      }
      .row h2 {
        font-size: 24px;
      }
    }
    
    @media (max-width: 576px) {
      .card-body {
        flex-direction: column;
        text-align: center;
      }
      .card-body i {
        margin-right: 0;
        margin-bottom: 10px;
      }
      .profile-picture {
        width: 40px;
        height: 40px;
      }
      .nav-link {
        font-size: 24px;
      }
    }
    .fa-right-from-bracket{
      position: relative;
      z-index: 10000;
    }
  </style>
</head>
<body>
@if (session()->has("success")) 
    <div id="success-alert" class="alert alert-success alert-dismissible ms-auto fade show d-flex align-items-center justify-content-center"
        style="width: fit-content !important; padding-top: 0.5em !important; padding-bottom: 0.5em !important; 
               position: fixed; top:15%; right: 10px; z-index: 9999; animation: slideInFromRight 0.5s ease-out, slideOutToRight 2s ease-out 3s;"
        role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding-bottom: 5px !important"></button>
    </div>
@endif 
  <div class="back">
    <div class="container-fluid p-3">
      <div class="row">
        <!-- Main Content -->
        <main>
          <!-- Header Section -->
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mt-2 mb-3">
            <h2 class="mb-2" style="font-weight: bold;">Dashboard Walas</h2>
            <div class="d-flex align-items-center">
              <img src="{{ asset('assets/foto/logo_6.png') }}" alt="Logo" style="height: 50px;">
              <h2 class="mb-2 ms-2" style="font-weight: bold;">CashZone</h2>
            </div>
          </div>
          <!-- Card Section -->
          <div class="row justify-content-center">
            <div class="col-12 col-md-3 mb-4">
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
            <div class="col-12 col-md-3 mb-4">
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
            <div class="col-12 col-md-3 mb-4">
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
<!-- Profile Section -->
<div class="col-12 col-md-3 mb-4" >
  <div class="text-start">
    <div class="card-body d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#profileModal">
         <div
                    class="profile-picture" >
                    <img src="{{ $guru->getImageURL() }}" alt="profile-image" style="width: 50px; height: 50px; border-radius: 50%; object-fit:cover;">
                  </div>
              <div class="user-info">
                <h5 class="card-title mb-1">  @if(session('user') instanceof \App\Models\Guru)
                              <!-- <i class="fa-solid fa-user-graduate"></i>  Ikon Siswa -->
                              {{ session('user')->name }}
                          @else
                              Nama Tidak Ditemukan
                          @endif</h5>
                          <p class="card-text">{{ session('status') }}</p>
        </div>
      </div>
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
  
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Edit Data Profile Guru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Arahkan form ke route yang menangani update profil guru -->
        <form id="profileForm" action="{{ route('guru.updateProfile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <!-- Foto Profile -->
          <div class="mb-3 text-center">
            <img src="{{ $guru->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Ubah Foto Profile</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
          </div>
          <!-- Data Profile -->
          <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="text" class="form-control" id="id" name="id" value="{{ $guru->id }}" readonly>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $guru->name }}" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $guru->email }}" required>
          </div>
          <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $guru->kelas }}" required>
          </div>
          <!-- Field status misalnya hanya ditampilkan (tidak dapat diubah) -->
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="{{ $guru->status }}" readonly>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



  
  <!-- Table Section -->
  <div class="table-container mt-2 container-fluid">
    <div class="card-bodys">
      <h4 class="mb-4">Daftar Pelajar</h4>
      <form method="GET" action="{{ route('guru.dashboard') }}">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="mb-2">
                    <select name="perPage" class="form-select d-inline-block w-auto">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    </select>
                    <select name="sortBy" class="form-select d-inline-block w-auto">
                        <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nama Lengkap</option>
                    </select>
                    <select name="order" class="form-select d-inline-block w-auto">
                        <option value="asc" {{ $order == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ $order == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    <a href="{{ route('guru.dashboard') }}" class="btn btn-warning">Reset Filter</a>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" name="keyword" class="form-control" placeholder="Masukan keyword pencarian..." value="{{ $keyword }}">
            </div>
        </form>
      <div class="table-responsive">
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
                <td>{{ $tabungan->siswa->id ?? '-' }}</td>
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
                <td> <a href="https://wa.me/{{ $tabungan->whatsapp_number }}" target="_blank">
                        {{ $tabungan->no_telpon }}
                    </a></td>
                <td>
                  <span class="badge bg-success">
                    Rp.{{ number_format($tabungan->tagihan, 0, ',', '.') }}
                  </span>
                </td>
                <td>
                <span class="badge bg-success">
            Rp.{{ number_format(\App\Models\Tabungan::where('name', $tabungan->name)->sum('total_masuk'), 0, ',', '.') }}
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
  </div>
  
  <!-- Copyright Section -->
  <footer class="text-center text-white mt-4 mb-4">
    <div class="container d-flex justify-content-between flex-wrap" style="max-width: 95%;">
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
