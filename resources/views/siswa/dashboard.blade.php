<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Siswa</title>
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
    @keyframes slideInFromRight {
    0% {
        transform: translateX(100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Animasi menghilang ke kanan */
@keyframes slideOutToRight {
    0% {
        transform: translateX(0);
        opacity: 1;
    }
    100% {
        transform: translateX(100%);
        opacity: 0;
    }
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
    .fa-right-from-bracket {
      position: relative;
      z-index: 10000;
    }
    /* From Uiverse.io by R1SH4BH81 */
/* Container */
.container {
  display: grid;
  grid-template-columns: auto;
  gap: 0px;
}

hr {
  height: 1px;
  background-color: #2e2e2e;
  border: none;
}

.card {
  width: 100%;
  background: #1c1c1c;
  box-shadow:
    0px 187px 75px rgba(0, 0, 0, 0.01),
    0px 105px 63px rgba(0, 0, 0, 0.05),
    0px 47px 47px rgba(0, 0, 0, 0.09),
    0px 12px 26px rgba(0, 0, 0, 0.1),
    0px 0px 0px rgba(0, 0, 0, 0.1);
}

.title {
  width: 100%;
  height: 40px;
  position: relative;
  display: flex;
  align-items: center;
  padding-left: 20px;
  border-bottom: 1px solid #2e2e2e;
  font-weight: 700;
  font-size: 11px;
  color: #ffffff;
}

/* Cart */
.cart {
  border-radius: 19px 19px 0px 0px;
}

.cart .steps {
  display: flex;
  flex-direction: column;
  padding: 20px;
}

.cart .steps .step {
  display: grid;
  gap: 10px;
}

.cart .steps .step span {
  font-size: 13px;
  font-weight: 600;
  color: #ffffff;
  margin-bottom: 8px;
  display: block;
}

.cart .steps .step p {
  font-size: 11px;
  font-weight: 600;
  color: #bbbbbb;
}

/* Promo (Total Masuk Baru) */
.promo .input-group {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 10px;
  padding: 0px;
}

.input_field {
  width: 100%;
  height: 36px;
  padding: 0 0 0 12px;
  border-radius: 5px;
  outline: none;
  border: 1px solid #2e2e2e;
  background-color: #333333;
  color: #ffffff;
  transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
}

.input_field:focus {
  border: 1px solid transparent;
  box-shadow: 0px 0px 0px 2px #555555;
  background-color: #333333;
}

.input-group-text {
  height: 36px;
  background: #555555;
  border: 1px solid #2e2e2e;
  border-radius: 5px 0 0 5px;
  color: #ffffff;
  padding: 0 10px;
  display: flex;
  align-items: center;
}

/* Payments */
.payments .details {
  display: grid;
  grid-template-columns: 10fr 1fr;
  padding: 0px;
  gap: 5px;
}

.payments .details span:nth-child(odd) {
  font-size: 12px;
  font-weight: 600;
  color: #ffffff;
}

.payments .details span:nth-child(even) {
  font-size: 13px;
  font-weight: 600;
  color: #bbbbbb;
}

/* Footer */
.modal-footer.footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 10px 10px 20px;
  background-color: #2e2e2e;
}

.checkout-btn {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  width: 150px;
  height: 36px;
  background: #555555;
  border-radius: 7px;
  border: 1px solid #2e2e2e;
  color: #ffffff;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
}

.checkout-btn:hover {
  background-color: #777777;
}
.qr-image {
  width: 100%;
  max-width: 150px; /* Sesuaikan ukuran maksimum sesuai kebutuhan */
  height: auto; /* Menjaga rasio aspek */
  border-radius: 5%; /* Sudut melengkung */
}
.bg-none{
  background-color: transparent;
}
  </style>
</head>
<body>
@if (session()->has("success"))
    <div id="success-alert" class="alert alert-success alert-dismissible ms-auto fade show d-flex align-items-center justify-content-center"
         style="width: fit-content !important; padding: 0.5em; position: fixed; top:15%; right: 10px; z-index: 9999; animation: slideInFromRight 0.5s ease-out, slideOutToRight 2s ease-out 3s;"
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
                    <h5 class="card-title" style="color:gray;">Jumlah Bayar</h5>
                    <p class="card-text">Rp.{{ number_format($totalTagihan, 0, ',', '.') }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-chalkboard-teacher" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">Total Pemasukan</h5>
                    <p class="card-text">Rp.{{ number_format($totalPemasukanAll, 0, ',', '.') }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-book" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">Status Pembayaran</h5>
                    <p class="card-text">
                      @if($totalPemasukanAll >= $totalTagihan)
                        <span class="badge bg-success">Lunas</span>
                      @else
                        <span class="badge bg-danger">Belum Lunas</span>
                      @endif
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Profile Section -->
            <div class="col-12 col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <div class="profile-picture">
                      <img src="{{ $siswa->getImageURL() }}" alt="profile-image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    </div>
                    <div class="user-info">
                      <h5 class="card-title mb-1">
                        @if(session('user') instanceof \App\Models\Siswa)
                          {{ session('user')->name }}
                        @else
                          Nama Tidak Ditemukan
                        @endif
                      </h5>
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
<!-- Daftar Menunggu Persetujuan -->
<!-- Daftar Pembayaran yang Di-Approve -->
<div class="container mt-4">
  <h4>Daftar Pembayaran menunggu persetujuan</h4>
  <div class="row">
    @if($approvedPayments->isNotEmpty())
      @foreach($approvedPayments->take(2) as $payment)
        <div class="col-12 col-md-6 mb-3">
          <div class="card bg-dark text-white">
            <div class="card-body">
              <!-- Baris untuk nama acara -->
              <div class="row mb-2">
                <div class="col-12" style="margin-right:10px;">
                  <p class="card-title mb-0">{{ $payment->nama_acara }}</p>
                </div>
              </div>

              <!-- Baris untuk Jumlah Bayar dan Tagihan -->
              <div class="row mb-2">
                <div class="col-6">
                  <p class="card-text mb-0">
                    Jumlah Bayar: Rp.{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                  </p>
                </div>
                <div class="col-6">
                  <p class="card-text mb-0">
                    Tagihan: Rp.{{ number_format($payment->tagihan, 0, ',', '.') }}
                  </p>
                </div>
              </div>

              <!-- Baris untuk badge dan tanggal -->
              <div class="row">
                <div class="col-6">
                  <p class="card-text mb-0">
                    <span class="badge bg-warning">waiting</span>
                  </p>
                </div>
                <div class="col-6 text-end">
                  <p class="card-text mb-0">
                    <small class="text-white">
                      {{ \Carbon\Carbon::parse($payment->updated_at)->format('d/m/Y H:i:s') }}
                    </small>
                  </p>
                </div>
              </div>
            </div> <!-- /.card-body -->
          </div> <!-- /.card -->
        </div> <!-- /.col -->
      @endforeach
    @else
      <div class="col-12">
        <p>Tidak ada pembayaran yang telah di-approve.</p>
      </div>
    @endif
  </div>
  
  <!-- Tombol trigger modal -->
  <div class="text-center mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approvedPaymentsModal">
      Lihat Semua
    </button>
  </div>
</div>


<!-- Modal untuk menampilkan semua data pembayaran -->
<div class="modal fade" id="approvedPaymentsModal" tabindex="-1" aria-labelledby="approvedPaymentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="approvedPaymentsModalLabel">Semua Pembayaran yang Di-Approve</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            @if($approvedPayments->isNotEmpty())
              @foreach($approvedPayments as $payment)
                <div class="col-12 col-md-6 mb-3">
                  <div class="card bg-secondary text-white">
                    <div class="card-body">
                      
                      <p><h5 class="card-title"style="margin-right:10px;">{{ $payment->nama_acara }}</h5></p>
                      <p class="card-text">Jumlah Bayar: Rp.{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                      <p class="card-text">Jumlah masuk: Rp.{{ number_format($payment->total_masuk, 0, ',', '.') }}</p>
                      <p class="card-text">Tagihan: Rp.{{ number_format($payment->tagihan, 0, ',', '.') }}</p>
                      <p class="card-text"style="margin-right:10px;"><span class="badge bg-warning">waiting</span></p>
                      <p class="card-text">
                        <small class="">
                          {{ \Carbon\Carbon::parse($payment->updated_at)->format('d/m/Y H:i:s') }}
                        </small>
                      </p>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="col-12">
                <p>Tidak ada pembayaran yang telah di-approve.</p>
              </div>
            @endif
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


  <!-- Table Section -->
  <div class="table-container mt-2">
    <div class="card-bodys">
      <h4 class="mb-4">Daftar Tabungan</h4>
      <form action="{{ route('siswa.dashboard') }}" method="GET">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
          <div class="mb-2 mb-md-0">
            <!-- Dropdown untuk jumlah data per halaman -->
            <select class="form-select d-inline-block w-auto" name="perPage">
              <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
              <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
              <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
            </select>
            <!-- Input tanggal filter -->
            <input type="date" name="start_date" class="form-control d-inline-block w-auto" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="form-control d-inline-block w-auto" value="{{ request('end_date') }}">
            <!-- Tombol filter -->
            <button type="submit" class="btn btn-primary ms-2">Filter</button>
          </div>
          <div>
            <!-- Tombol untuk membuka modal bayar -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bayarModal">
              Bayar Kunjungan
            </button>
          </div>
        </div>
      </form>

 


      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>NISN</th>
              <th>Nama Lengkap</th>
              <th>Nama Acara</th>
              <th>Harga Acara</th>
              <th>Tagihan</th>
              <th>Pemasukan</th>
              <th>Tanggal Pembayaran</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tabungans as $tabungan)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tabungan->nisn }}</td>
                <td>{{ $tabungan->name }}</td>
                <td><span class="badge bg-success">{{ $tabungan->nama_acara }}</span></td>
                <td>
                  <span class="badge bg-success">
                    Rp.{{ number_format($tabungan->jumlah_bayar, 0, ',', '.') }}
                  </span>
                </td>
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
                    {{ $tabungan->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      {{ $tabungans->appends(request()->input())->links() }}
    </div>
  </div>

  <footer class="text-center text-white mt-4 mb-4">
    <div class="container d-flex justify-content-between" style="max-width: 95%;">
      <span>© 2025</span>
      <span>Created by CashZone</span>
    </div>
  </footer>

 <!-- Modal Bayar -->
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content bg-none">
      <form action="{{ route('approved') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <!-- Input data yang diperlukan -->
          <input type="hidden" name="nisn" value="{{ old('nisn', isset($tabungan) ? $tabungan->nisn : '') }}">
          <input type="hidden" name="name" value="{{ session('user')->name }}">
          <input type="hidden" name="status" value="{{ old('status', isset($latestTabungan) ? $latestTabungan->status : '') }}">
          <input type="hidden" name="kelas" value="{{ old('kelas', isset($latestTabungan) ? $latestTabungan->kelas : '') }}">
          <input type="hidden" name="walas" value="{{ old('walas', isset($latestTabungan) ? $latestTabungan->walas : '') }}">
          <input type="hidden" name="gander" value="{{ old('gander', isset($latestTabungan) ? $latestTabungan->gander : '') }}">
          <input type="hidden" name="nama_acara" value="{{ old('nama_acara', isset($latestTabungan) ? $latestTabungan->nama_acara : '') }}">
          <input type="hidden" name="no_telpon" value="{{ old('no_telpon', isset($latestTabungan) ? $latestTabungan->no_telpon : '') }}">
          <input type="hidden" id="old_jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar', isset($latestTabungan) ? $latestTabungan->jumlah_bayar : '') }}">
          <input type="hidden" name="tanggal_acara" value="{{ old('tanggal_acara', isset($latestTabungan) ? $latestTabungan->tanggal_acara : '') }}">
          <input type="hidden" id="old_total_masuk" value="{{ old('total_masuk', App\Models\Tabungan::where('name', $siswa->name)->sum('total_masuk')) }}">

          <div class="container w-100">
            <div class="card cart">
            <label class="title d-flex justify-content-between align-items-center">
  PEMBAYARAN KUNJUNGAN  
  <button type="button" class="btn-close btn-close-white  me-3" data-bs-dismiss="modal" aria-label="Close"></button>
</label>

              <div class="steps">
                <div class="step">
                  <!-- Informasi Siswa -->
                  <div class="d-flex gap-3 align-items-center">
    <div class="col-6">
      <span style="font-size:1.5rem;">INFORMASI SISWA</span>
      <p style="font-size:1rem;">Nama: {{ session('user')->name }}</p>
      <p style="font-size:1rem;">Kelas: {{ old('kelas', isset($latestTabungan) ? $latestTabungan->kelas : '') }}</p>
    </div>
    <div class="col-6 text-center d-none" id="qrContainer">
  <img src="{{ asset('assets/foto/qr.jpg') }}" alt="QR Code" class="qr-image">
  <p>maaf tujuan pembayaran baru hanya melalui DANA<br>karena aplikasi masih dalam pengembangan</p>
</div>

  </div>
                  <hr />
                  <!-- Metode Pembayaran -->
                  <div>
                    <span>METODE PEMBAYARAN</span>
                    <select class="form-select" id="tipe_pembayaran" name="tipe_pembayaran" required>
                      <option value="">Pilih Metode</option>
                      <option value="cash" {{ old('tipe_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                      <option value="transfer" {{ old('tipe_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                  </div>
                  <hr />
                  <!-- Total Masuk Baru (menggantikan Promo Code) -->
                  <div class="promo">
                    <span>TOTAL MASUK BARU</span>
                    <div class="input-group">
                      <span class="input-group-text">Rp</span>
                      <input type="text" class="input_field" id="total_masuk" name="total_masuk" placeholder="10.000" required>
                    </div>
                    <small id="jumlahWarning" class="text-warning d-none">
                      Harap pilih metode pembayaran terlebih dahulu!
                    </small>
                  </div>
                  <hr />
                  <!-- Upload Bukti Pembayaran -->
                  <div id="imageContainer" style="display: none;">
                    <span>UPLOAD BUKTI PEMBAYARAN</span>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                  </div>
                  <hr />
                  <!-- Detail Pembayaran -->
                  <div class="payments">
                    <span>DETAIL PEMBAYARAN</span>
                    <div class="details">
                      <span>Tagihan Baru:</span>
                      <span id="tagihan_display">Rp 0</span>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-secondary">Bayar</button>
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
  
  <!-- Modal Profile -->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">Edit Data Profile</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="profileForm" action="{{ route('siswa.updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 text-center">
              <img src="{{ $siswa->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
            </div>
            <div class="mb-3">
              <label for="fotoProfile" class="form-label">Ubah Foto Profile</label>
              <input type="file" class="form-control" id="fotoProfile" name="fotoProfile" accept="image/*">
            </div>
            <div class="mb-3">
              <label for="id" class="form-label">NISN</label>
              <input type="text" class="form-control" id="id" name="id" value="{{ $siswa->id }}" readonly>
            </div>
            <div class="mb-3">
              <label for="namaLengkap" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" value="{{ $siswa->name }}" required>
            </div>
            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas</label>
              <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $siswa->kelas }}" required>
            </div>
            <div class="mb-3">
              <label for="walas" class="form-label">Walas</label>
              <input type="text" class="form-control" id="walas" name="walas" value="{{ $siswa->walas }}" required>
            </div>
            <div class="mb-3">
              <label for="gander" class="form-label">Gander</label>
              <select class="form-select" id="gander" name="gander" required>
                <option value="male" {{ ($siswa->gander == 'male') ? 'selected' : '' }}>laki laki</option>
                <option value="female" {{ ($siswa->gander == 'female') ? 'selected' : '' }}>perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="no_telpon" class="form-label">No. Telp</label>
              <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="{{ $siswa->lastTabungan->no_telpon ?? '' }}">
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

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  <script>
document.addEventListener('DOMContentLoaded', function () {
  // Cek apakah ada alert dengan id "success-alert"
  let alertElement = document.getElementById('success-alert');
  if (alertElement) {
    setTimeout(function () {
      alertElement.remove();
    }, 3000);
  }

  // Elemen-elemen yang diperlukan
  const oldJumlahBayarInput = document.getElementById("old_jumlah_bayar");
  const oldTotalMasukInput = document.getElementById("old_total_masuk");
  const newTotalMasukInput = document.getElementById("total_masuk");
  const tagihanDisplay = document.getElementById("tagihan_display");
  const metodePembayaran = document.getElementById("tipe_pembayaran");
  const jumlahWarning = document.getElementById("jumlahWarning");
  const imageContainer = document.getElementById("imageContainer");
  const qrContainer = document.getElementById("qrContainer"); // pastikan div ini memiliki class d-none di HTML

  function calculateTagihan() {
    const oldJumlahBayar = parseFloat(oldJumlahBayarInput.value.replace(/[^0-9.-]+/g, "")) || 0;
    const oldTotalMasuk = parseFloat(oldTotalMasukInput.value.replace(/[^0-9.-]+/g, "")) || 0;
    const newTotalMasuk = parseFloat(newTotalMasukInput.value.replace(/[^0-9.-]+/g, "")) || 0;
    const currentOutstanding = oldJumlahBayar - oldTotalMasuk;
    const newTagihan = currentOutstanding - newTotalMasuk;
    tagihanDisplay.textContent = "Rp " + newTagihan.toLocaleString();
  }

  newTotalMasukInput.addEventListener("input", calculateTagihan);

  // Hitung tagihan saat modal dibuka
  document.getElementById('bayarModal').addEventListener('shown.bs.modal', function () {
    calculateTagihan();
  });

  // Logika metode pembayaran dan upload bukti + kontrol tampilan QR
  metodePembayaran.addEventListener("change", function () {
    if (this.value) {
      newTotalMasukInput.removeAttribute("readonly");
      newTotalMasukInput.placeholder = "Masukkan jumlah pembayaran";
      jumlahWarning.classList.add("d-none");
    } else {
      newTotalMasukInput.setAttribute("readonly", true);
      newTotalMasukInput.value = "";
      newTotalMasukInput.placeholder = "Pilih metode pembayaran dulu";
      jumlahWarning.classList.remove("d-none");
    }

    if (this.value === "transfer") {
      imageContainer.style.display = "block";
      qrContainer.classList.remove("d-none"); // tampilkan QR container
    } else {
      imageContainer.style.display = "none";
      qrContainer.classList.add("d-none"); // sembunyikan QR container
    }
  });

  // Logika lainnya untuk form profil
  document.getElementById("profileForm").addEventListener("submit", function (e) {
    console.log("Data Profile:", {
      id: document.getElementById("id").value,
      namaLengkap: document.getElementById("namaLengkap").value,
      kelas: document.getElementById("kelas").value,
      walas: document.getElementById("walas").value,
      gander: document.getElementById("gander").value,
      no_telpon: document.getElementById("no_telpon").value
    });
    var profileModal = bootstrap.Modal.getInstance(document.getElementById("profileModal"));
    profileModal.hide();
  });

  document.getElementById("fotoProfile").addEventListener("change", function (e) {
    var file = e.target.files[0];
    if (file) {
      document.getElementById("previewProfile").src = URL.createObjectURL(file);
    }
  });
});


  </script>
</body>
</html>
