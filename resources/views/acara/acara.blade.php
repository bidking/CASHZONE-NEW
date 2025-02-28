@extends('layout.app')
@section('title', 'acara')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <!-- Tag meta viewport agar responsive di semua device -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Acara</title>
  <style>
    /* --- Style untuk PC --- */
    .main-content {
      margin-left: 250px; /* Offset sidebar */
      max-height: 100vh;
      position: fixed;
      overflow-y: auto;
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
    .card {
      color: black;
      height: auto;
      width: 100%;
      
      background-color: #1e1e2d;
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
    
    /* Hover styling */
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

    /* --- Media Queries untuk Responsiveness --- */
    @media (max-width: 992px) {
      .main-content {
        margin-left: 0;
        position: relative;
      }
      .card {
        height: auto;
      }
      .container {
        margin-left: 15px;
        margin-right: 15px;
      }
    }

    @media (max-width: 768px) {
      .card {
        height: auto;
      }
      .nav-link {
        font-size: 24px;
      }
      .card-body {
        flex-direction: column;
        text-align: center;
      }
      table {
        font-size: 14px;
      }
    }

    @media (max-width: 576px) {
      .nav-link {
        font-size: 20px;
      }
      .container {
        padding: 10px;
      }
    }

    .modal-content {  
      background-color: #1e1e2d !important;
    }
  </style>
</head>
<body>
  <div class="container mt-5 w-100">
    <h2 class="mb-4">Halaman Daftar Acara</h2>
    @if (session()->has("success")) 
    <div id="success-alert" class="alert alert-success alert-dismissible ms-auto fade show d-flex align-items-center justify-content-center"
        style="width: fit-content !important; padding-top: 0.5em !important; padding-bottom: 0.5em !important; 
               position: fixed; top: 15%; right: 10px; z-index: 9999; animation: slideInFromRight 0.5s ease-out, slideOutToRight 2s ease-out 3s;"
        role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding-bottom: 5px !important"></button>
    </div>
@endif  
    <div class="card text-light p-4">
      <div class="d-flex justify-content-between">
      <h4 class="mb-4 fw-bold">Daftar Acara</h4>
      </div>

      <!-- Form filter & pencarian -->
      <form action="{{ route('acara.acara') }}" method="GET">
        <div class="mb-3">
          <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Masukan keyword pencarian...">
        </div>
        <div class="d-flex flex-wrap justify-content-between mb-3">
          <div class="mb-2">
            <!-- Pilihan jumlah data per halaman -->
            <select class="form-select d-inline w-auto" name="per_page" onchange="this.form.submit()">
  <option value="4" {{ request('per_page') == 4 ? 'selected' : '' }}>4</option>
  <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
  <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
</select>

            <!-- Filter berdasarkan kolom (saat ini hanya Nama acara) -->
            <select class="form-select d-inline w-auto" name="order_by">
              <option value="nama_acara" {{ request('order_by') == 'nama_acara' ? 'selected' : '' }}>Nama acara</option>
            </select>
            <!-- Urutan pengurutan (ascending/descending) -->
            <select class="form-select d-inline w-auto" name="sort" onchange="this.form.submit()">
              <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
              <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
            </select>
          </div>
          <div class="mb-2">
            <!-- Tombol Refresh untuk submit form filter -->
            <button type="submit" class="btn btn-secondary">Refresh</button>
            <!-- Tombol Reset Filter; mengarahkan ke route index tanpa parameter -->

            <!-- Tombol untuk menambah data acara -->
            <a href="{{ route('acara.create') }}" class="btn btn-primary">+ Tambah Data</a>
          </div>
        </div>
      </form>
      <!-- Tabel untuk menampilkan data acara tanpa scroll -->
      <table class="table table-dark text-light w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama acara</th>
            <th>Tanggal acara</th>
            <th>jumlah_bayar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($acaras as $acara)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $acara->nama_acara }}</td>
              <td>{{ $acara->tanggal_acara }}</td>
              <td>{{ $acara->jumlah_bayar_formatted }}</td>
              <td>
                <!-- Tombol Edit (memunculkan modal) -->
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $acara->id }}">✏️</button>
                <!-- Tombol Delete -->
                <form action="{{ route('acara.destroy', $acara->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">Tidak ada data acara.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
        {{ $acaras->withQueryString()->links('vendor.pagination.custom')  }}
      </div>
    </div>
  </div>

  <!-- Modal untuk setiap Acara -->
  @foreach ($acaras as $acara)
  <div class="modal fade" id="editModal-{{ $acara->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $acara->id }}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('acara.update', $acara->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel-{{ $acara->id }}">Edit Acara: {{ $acara->nama_acara }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama_acara" class="form-label">Nama Acara</label>
              <input type="text" class="form-control" id="nama_acara" name="nama_acara" value="{{ $acara->nama_acara }}" required>
            </div>
            <div class="mb-3">
              <label for="tanggal_acara" class="form-label">Tanggal Acara</label>
              <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" value="{{ $acara->tanggal_acara }}" required>
            </div>
          </div>
          <div class="mb-3">
    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
    <input type="text" class="form-control @error('jumlah_bayar') is-invalid @enderror" id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar') }}" required>
    @error('jumlah_bayar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Acara</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</body>
</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/driver.js/0.9.8/driver.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/driver.js/0.9.8/driver.min.js"></script>

<script>


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

    // Definisikan langkah-langkah tur
    driver.defineSteps([
      {
        element: 'input[name="search"]',
        popover: {
          title: 'Pencarian Acara',
          description: 'Gunakan kolom ini untuk mencari acara berdasarkan kata kunci.',
          position: 'bottom'
        }
      },
      {
        element: 'select[name="per_page"]',
        popover: {
          title: 'Jumlah Data Per Halaman',
          description: 'Pilih jumlah data yang ingin ditampilkan di setiap halaman.',
          position: 'bottom'
        }
      },
      {
        element: 'select[name="sort"]',
        popover: {
          title: 'Urutan Pengurutan',
          description: 'Pilih urutan pengurutan (A-Z atau Z-A).',
          position: 'bottom'
        }
      },
      {
        element: '.table',
        popover: {
          title: 'Daftar Acara',
          description: 'Tabel ini menampilkan daftar acara. Lakukan aksi edit atau hapus sesuai kebutuhan.',
          position: 'top'
        }
      },
      {
        element: 'a.btn.btn-primary[href="{{ route('acara.create') }}"]',
        popover: {
          title: 'Tambah Acara',
          description: 'Klik tombol ini untuk menambahkan data acara baru.',
          position: 'left'
        }
      }
    ]);

    // Event listener untuk tombol "how to use"
    document.querySelector('.guide').addEventListener('click', function () {
      // Scroll ke elemen input pencarian terlebih dahulu
      const searchInput = document.querySelector('input[name="search"]');
      if (searchInput) {
        searchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Tambahkan delay agar scrolling selesai sebelum driver.start() dipanggil
        setTimeout(function() {
          driver.start(); // Mulai tur setelah scrolling selesai
        }, 500); // delay 500ms (sesuaikan jika perlu)
      } else {
        driver.start();
      }
    });
  });
</script>

@endsection
