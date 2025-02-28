<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Siswa</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  <link
    href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;700&display=swap"
    rel="stylesheet"
  />
  <link rel="icon" href="{{asset('assets/foto/logo.png')}}">

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
      margin-left: 30px;
      margin-right: 30px;
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
      cursor: pointer; /* Menandakan bahwa elemen dapat di-klik */
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

    .modal-dialog {
      max-width: 700px; /* Sesuaikan lebar modal */
      width: 90%;
    }

    .modal-content {
      min-height: 400px; /* Sesuaikan tinggi modal */
      padding: 20px;
    }

    .modal-header {
      border-bottom: 1px solid #2e2e48;
    }

    .modal-footer {
      border-top: 1px solid #2e2e48;
    }

    .form-control:disabled,
    .form-control[readonly] {
      background-color: #2e2e48;
      color: #8a8a8a;
    }

    th,
    td {
      text-align: center;
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
    <div class="container-fluid">
      <div class="row">
        <!-- Main Content -->
        <main>
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mt-2 mb-3"
          >
            <h2 class="mb-2" style="font-weight: bold;">Dashboard Siswa</h2>
            <!-- Logo ditempatkan di sebelah kanan judul -->
            <div class="d-flex align-items-center">
              <img src="{{asset('assets/foto/logo_6.png')}}" alt="Logo" style="height: 50px;" />
              
              <h2 class="mb-2 ms-2" style="font-weight: bold;">CashZone</h2>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-user-graduate me-4" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">jumlah bayar</h5>
                    <p class="card-text">Rp.{{ number_format($totalTagihan, 0, ',', '.') }}</p>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body">
                  <i class="fa-solid fa-chalkboard-teacher me-4" style="color: #36A2EB;"></i>
                  <div>
                    <h5 class="card-title" style="color:gray;">Total Pemasukan</h5>
                    <p class="card-text">Rp.{{ number_format($totalPemasukanAll, 0, ',', '.') }}</p>


                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4">
  <div class="text-start">
    <div class="card-body d-flex align-items-center gap-2">
      <i class="fa-solid fa-book me-4" style="color: #36A2EB; font-size: 24px;"></i>
      <div>
        <h5 class="card-title" style="color:gray;">Status Pembayaran</h5>
        @if($totalPemasukanAll >= $totalTagihan)
        <span class="badge bg-success">
             Lunas
</span>
          @else
          <span class="badge bg-danger">
            Belum Lunas
</span>
          @endif
      </div>
    </div>
  </div>
</div>

            <!-- Bagian User dengan profile picture placeholder -->
            <div class="col-md-3 mb-4">
              <div class="text-start">
                <div class="card-body"  data-bs-toggle="modal"
                data-bs-target="#profileModal">
                  <!-- Profile picture dengan trigger modal -->
                  <div class="d-flex align-items-center gap-2">
                  <div
                    class="profile-picture" >
                    <img src="{{ $siswa->getImageURL() }}" alt="profile-image" style="width: 50px; height: 50px; border-radius: 50%; object-fit:cover;">
                  </div>
                  
                  <div class="user-info">
                    <h5 class="card-title">
                    @if(session('user') instanceof \App\Models\Siswa)
                        <!-- <i class="fa-solid fa-user-graduate"></i>  Ikon Siswa -->
                        {{ session('user')->name }}
                    @else
                        Nama Tidak Ditemukan
                    @endif
</h5>
                    <p class="card-text">{{ session('status') }}</p>
                  </div>
                  </div>
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
    <h4 class="mb-4">Daftar Tabungan</h4>
    <form action="{{ route('siswa.dashboard') }}" method="GET">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <!-- Dropdown untuk jumlah data per halaman -->
          <select         class="form-select d-inline-block w-auto"
          name="perPage">
      <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
      <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
      <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
    </select>


          <!-- Dropdown untuk filter tanggal: dari tanggal -->
          <input type="date" name="start_date" class="form-control d-inline-block w-auto" value="{{ request('start_date') }}">


          <!-- Dropdown untuk filter tanggal: sampai tanggal -->
          <input type="date" name="end_date" class="form-control d-inline-block w-auto" value="{{ request('end_date') }}">

          <!-- Tombol untuk menerapkan filter -->
          <button type="submit" class="btn btn-primary ms-2">Filter</button>
        </div>
        <div>
          <!-- Tombol untuk membuka modal bayar -->
          <button
            type="button"
            class="btn btn-success"
            data-bs-toggle="modal"
            data-bs-target="#bayarModal"
          >
            Bayar Kunjungan
          </button>
        </div>
      </div>
    </form>

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
            <td>
              <span class="badge bg-success">{{ $tabungan->nama_acara }}</span>
            </td>
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

    <!-- Tampilkan pagination dengan mempertahankan parameter filter -->
    {{ $tabungans->appends(request()->input())->links() }}
  </div>
</div>

    <footer class="text-center text-white mt-4 mb-4">
      <div class="container d-flex justify-content-between" style="max-width: 95%;">
        <span>© 2025</span>
        <span>Created by CashZone</span>
      </div>
    </footer>
  </div>

  <!-- Modal Bayar -->
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="bayarModalLabel">Pembayaran Kunjungan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('approved') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="modal-body">
    <!-- Data login dan data tabungans -->
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
<input type="hidden" name="nisn" value="{{ old('nisn', isset($latestTabungan) ? $latestTabungan->nisn : '') }}">
<input type="hidden" id="old_total_masuk" name="total_masuk"
  value="{{ old('total_masuk', App\Models\Tabungan::where('name', $siswa->name)->sum('total_masuk')) }}">

<!-- <p>Tagihan: {{ old('tagihan', isset($latestTabungan) ? $latestTabungan->tagihan : 0) }}</p> -->

    <!-- Tampilkan tagihan lama sebagai acuan -->


    <!-- Input tagihan baru, akan dihitung otomatis -->
    <div class="mb-3">
  <label for="tagihan" class="form-label">Tagihan Baru</label>
  <input type="text" class="form-control" id="tagihan" name="tagihan" value="0" readonly>
</div>

    <div class="mb-3">
      <label for="tipe_pembayaran" class="form-label">Metode Pembayaran</label>
      <select class="form-select" id="tipe_pembayaran" name="tipe_pembayaran" required>
        <option value="">Pilih Metode</option>
        <option value="cash" {{ old('tipe_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="transfer" {{ old('tipe_pembayaran') == 'transfer' ? 'selected' : '' }}>transfer</option>
      </select>
    </div>

    <div class="mb-3">
  <label for="total_masuk" class="form-label">Total Masuk Baru</label>
  <div class="input-group">
    <span class="input-group-text">Rp</span>
    <input type="text" class="form-control" id="total_masuk" name="total_masuk" placeholder="10.000" required>
  </div>
  <small id="jumlahWarning" class="text-warning d-none">
    Harap pilih metode pembayaran terlebih dahulu!
  </small>
</div>

    <div class="mb-3" id="imageContainer" style="display: none;">
      <label for="image" class="form-label">Upload Bukti Pembayaran</label>
      <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-success">Bayar</button>
  </div>
</form>

    </div>
  </div>
</div>




  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Edit Data Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Arahkan form ke route yang menangani update profil -->
        <form id="profileForm" action="{{ route('siswa.updateProfile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <!-- Foto Profile -->
          <div class="mb-3 text-center">
            <img src="{{ $siswa->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
          </div>
          <div class="mb-3">
            <label for="fotoProfile" class="form-label">Ubah Foto Profile</label>
            <input type="file" class="form-control" id="fotoProfile" name="fotoProfile" accept="image/*">
          </div>
          <!-- Data Profile -->
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
              <option value="Laki-laki" {{ ($siswa->gander == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
              <option value="Perempuan" {{ ($siswa->gander == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
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
document.addEventListener("DOMContentLoaded", function() {
    // Ambil elemen input
    const oldJumlahBayarInput = document.getElementById("old_jumlah_bayar");
    const oldTotalMasukInput = document.getElementById("old_total_masuk");
    const newTotalMasukInput = document.getElementById("total_masuk"); // input untuk Total Masuk Baru
    const tagihanInput    = document.getElementById("tagihan");

    // Fungsi untuk menghitung Tagihan Baru
    function calculateTagihan() {
        // Ambil nilai lama dan bersihkan dari karakter non-numerik
        const oldJumlahBayar = parseFloat(oldJumlahBayarInput.value.replace(/[^0-9.-]+/g, "")) || 0;
        const oldTotalMasuk  = parseFloat(oldTotalMasukInput.value.replace(/[^0-9.-]+/g, "")) || 0;
        const newTotalMasuk  = parseFloat(newTotalMasukInput.value.replace(/[^0-9.-]+/g, "")) || 0;
        
        // Hitung tagihan lama (sebagai acuan) dan tagihan baru
        const currentOutstanding = oldJumlahBayar - oldTotalMasuk;
        const newTagihan = currentOutstanding - newTotalMasuk;
        
        // Tampilkan hasilnya di input Tagihan Baru
        tagihanInput.value = newTagihan;
    }

    // Jalankan fungsi kalkulasi saat user mengetik di input Total Masuk Baru
    newTotalMasukInput.addEventListener("input", calculateTagihan);
});


  document.addEventListener('DOMContentLoaded', function () {
        // Cek apakah ada alert dengan id "success-alert"
        let alertElement = document.getElementById('success-alert');
        
        if (alertElement) {
            // Set timeout untuk menghapus elemen setelah 5 detik (selama animasi selesai)
            setTimeout(function () {
                alertElement.remove();
            }, 3000); // 5 detik setelah animasi selesai
        }
    });
    // Penanganan submit data profile
    document.addEventListener('DOMContentLoaded', function () {
    // Penanganan submit data profile
    document.getElementById("profileForm").addEventListener("submit", function (e) {
        // e.preventDefault(); // Remove or comment out this line to allow form submission

        // Ambil nilai dari form input
        var id = document.getElementById("id").value;
        var namaLengkap = document.getElementById("namaLengkap").value;
        var kelas = document.getElementById("kelas").value;
        var walas = document.getElementById("walas").value;
        var gander = document.getElementById("gander").value;
        var no_telpon = document.getElementById("no_telpon").value;

        // Ambil file foto profile jika ada
        var fotoFile = document.getElementById("fotoProfile").files[0];

        // Contoh: Tampilkan data di console (selanjutnya bisa di proses/simpan sesuai kebutuhan)
        console.log("Data Profile:", { id, namaLengkap, kelas, walas, gander, no_telpon });
        if (fotoFile) {
            console.log("Foto Profile:", fotoFile);
        }

        // Tutup modal setelah submit
        var profileModal = bootstrap.Modal.getInstance(document.getElementById("profileModal"));
        profileModal.hide();
    });

    // Preview foto profile ketika user memilih file baru
    document.getElementById("fotoProfile").addEventListener("change", function (e) {
        var file = e.target.files[0];
        if (file) {
            document.getElementById("previewProfile").src = URL.createObjectURL(file);
        }
    });
});

    document.addEventListener("DOMContentLoaded", function() {
    const metodePembayaran = document.getElementById("tipe_pembayaran");
    const total_masuk = document.getElementById("total_masuk");
    const jumlahWarning = document.getElementById("jumlahWarning");
    const imageContainer = document.getElementById("imageContainer");

    // Event listener untuk perubahan pilihan metode pembayaran
    metodePembayaran.addEventListener("change", function () {
      if (this.value) {
        total_masuk.removeAttribute("readonly");
        total_masuk.placeholder = "Masukkan jumlah pembayaran";
        jumlahWarning.classList.add("d-none");
      } else {
        total_masuk.setAttribute("readonly", true);
        total_masuk.value = "";
        total_masuk.placeholder = "Pilih metode pembayaran dulu";
      }

      if (this.value === "transfer") {
        imageContainer.style.display = "block";
      } else {
        imageContainer.style.display = "none";
      }
    });

 


   
  });
  </script>
</body>
</html>