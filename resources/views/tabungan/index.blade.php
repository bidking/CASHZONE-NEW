@extends('layout.app')

{{-- Jika layout.app belum memuat style tambahan, Anda bisa menambahkannya di sini --}}

@section('content')
<style>
    .main-content {
        margin-left: 250px; /* Offset the width of the sidebar */
        max-height: 100vh;
        position: fixed;
        overflow-y: auto;
    }

    .card {
        color: black;
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

    .card-body {
        display: flex;
        align-items: center;
        padding: 20px;
        color: white;
        background-color: #1e1e2d;
        border-radius: 8px;
        height: 115px;
    }
    .card-bodys{
        align-items: center;
        padding: 20px;
        color: white;
        background-color: #1e1e2d;
        border-radius: 8px;
    }

    .card-body i {
        font-size: 30px;
        margin-right: 180px;
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
    
    /* Change icon color to gray on hover */
    .nav-item:hover i {
        color:  black;
    }

    /* Change the whole list item color to gray on hover */
    .nav-item:hover .nav-link:hover {
        background-color: #435ebe;
        color: black;
        border-radius: 8px;
    }

    .nav-link .active {
        color: black;
    }

    .row h2{
        color: #657bc1;
        font-weight: bold;
        font-size: 30px;
    }
    .back{
        background-color: #151521;
        padding: 20px;
        position: relative;
    }
    .container-fluid{
        background-color: #151521;
        border-radius: 25px;
    }
    .table-container {
      background-color: #1e1e2d;
      padding: 20px;
      border-radius: 8px;
    }
    .btn-edit {
      background-color: #28a745;
      color: white;
      border: none;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
      border: none;
    }
    .btn-filter, .btn-add, .btn-reset, .btn-refresh {
      margin-right: 10px;
    }
    .badge-admin {
      background-color: #007bff;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
    }
    .form-select, .form-control {
      background-color: white;
      color: black;
      border: none;
    }
    .form-select:focus, .form-control:focus {
      box-shadow: none;
      border-color: #6c757d;
    }
    .table-dark {
      color: #dee2e6;
    }
    .table-dark thead th {
      border-bottom: 1px solid #495057;
    }
    .modal-content {  
      background-color: #1e1e2d !important;
    }
    @media (max-width: 768px) {
  .table-responsive {
    display: none;
  }
}

</style>


            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data <strong id="modalName"></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Detail Data -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="detailModalLabel">Detail Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nama:</strong> <span id="modalName"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Kelas:</strong> <span id="modalKelas"></span></p>
        <p><strong>Wali Kelas:</strong> <span id="modalWalas"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal untuk menampilkan gambar yang diperbesar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
            </div>
        </div>
    </div>
</div>

           
                <!-- Header Halaman -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mt-2">
                    <h2 class="mt-3 mb-2 fw-bold">Halaman Daftar Tabungan</h2>
                </div>
                @if (session()->has("success")) 
    <div id="success-alert" class="alert alert-success alert-dismissible ms-auto fade show d-flex align-items-center justify-content-center"
        style="width: fit-content !important; padding-top: 0.5em !important; padding-bottom: 0.5em !important; 
               position: fixed; top: 15%; right: 10px; z-index: 9999; animation: slideInFromRight 0.5s ease-out, slideOutToRight 2s ease-out 3s;"
        role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding-bottom: 5px !important"></button>
    </div>
@endif  
                <!-- Section Card (Contoh: Total Minggu/Bulan) -->
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x" style="color: #36A2EB;"></i>
                                <div>
                                    <h5 class="card-title" style="color:gray;">Total Minggu ini</h5>
                                    <p class="card-text mt-1 fw-bold" style="color: #36A2EB; font-size: 17px;">
                                Rp. {{ number_format($totalMinggu, 0, ',', '.') }}
                            </p>
                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x" style="color: #36A2EB;"></i>
                                <div>
                                    <h5 class="card-title" style="color:gray;">Total Bulan ini</h5>
                                    <p class="card-text mt-1 fw-bold" style="color: #36A2EB; font-size: 17px;">
                                Rp. {{ number_format($totalBulan, 0, ',', '.') }}
                            </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x" style="color: #36A2EB;"></i>
                                <div>
                                    <h5 class="card-title" style="color:gray;"> 12 rpl 1</h5>
                                    <p class="card-text mt-1 fw-bold" style="color: #36A2EB; font-size: 17px;">
                                    {{ $countRpl1 }}
                            </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="text-start">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x" style="color: #36A2EB;"></i>
                                <div>
                                    <h5 class="card-title" style="color:gray;">12 rpl 2</h5>
                                    <p class="card-text mt-1 fw-bold" style="color: #36A2EB; font-size: 17px;">
                                    {{ $countRpl2}}
                            </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Tambahkan card tambahan jika diperlukan --}}
                </div>

          <!-- Section Table dengan Filter -->
<div class="table-container">
    <h4 class="mb-4 mt-2">Daftar Data Tabungan</h4>

    <!-- Baris Pencarian dan Tombol Aksi -->
    <div class="row align-items-center mb-3">
        <!-- Form Pencarian -->
        <div class="col-md-6 mb-2">
            <form method="GET" action="{{ route('tabungan.index') }}" class="d-flex align-items-center">
                <select class="form-select w-auto" name="perPage">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                </select>
                <input type="text" class="form-control ms-3" name="keyword" placeholder="Masukan keyword pencarian..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary ms-3">Cari</button>
            </form>
        </div>

        <!-- Tombol Aksi -->
        <div class="col-md-6 text-md-end">
            <a href="{{ route('tabungan.bayar') }}" class="btn btn-primary me-2">Bayar</a>
            <a href="{{ route('tabungan.create') }}" class="btn btn-primary me-2">Tambah Data</a>
            <a href="{{ route('tabungan.index') }}" class="btn btn-secondary">Refresh</a>
        </div>
    </div>

    <!-- Baris Download dan Import -->
    <div class="filter row align-items-center mb-3 ">
        <!-- Form Download PDF -->
        <div class="col-md-6 mb-2 unduh">
            <form method="GET" action="{{ route('tabungan.download.pdf') }}" class="d-flex align-items-center">
                <select name="kelas" id="kelas" class="form-select me-3">
                    <option value="">Download ?</option>
                    <option value="">Semua Kelas</option>
                    <option value="12 rpl 1">12 RPL 1</option>
                    <option value="12 rpl 2">12 RPL 2</option>
                </select>
                <button type="submit" class="btn btn-warning btn-reset text-dark">Unduh</button>
            </form>
        </div>

        <!-- Form Import Data -->
        <div class="col-md-6 text-md-end import">
            <form method="POST" action="{{ route('tabungan.import') }}" enctype="multipart/form-data" class="d-flex align-items-center justify-content-md-end">
                @csrf
                <input type="file" name="file" class="form-control me-3" required>
                <button type="submit" class="btn btn-success">Import</button>
            </form>
        </div>

       <!-- Filter Tipe Pembayaran -->
    <div class="col-md-4 tipebay">
        <form method="GET" action="{{ route('tabungan.index') }}" class="d-flex align-items-center">
            <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-select me-3">
                <option value="">Semua Tipe</option>
                <option value="cash" @if(request('tipe_pembayaran')=='cash') selected @endif>Cash</option>
                <option value="tranfer" @if(request('tipe_pembayaran')=='tranfer') selected @endif>Transfer</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
</div>

<br>
                    <!-- {{-- Tampilkan pesan sukses jika ada --}} -->
                    
<div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <!-- <th>Status</th>
                                <th>Kelas</th>
                                <th>Wali Kelas</th> -->
                                <th>No Telpon</th>
                                <th>Nama Acara</th>
                                <th>Tanggal Acara</th>
                                <th>Jumlah Bayar</th>
                                <th>Total Masuk</th>
                                <th>Tagihan</th>
                                <th>tgl</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
        @foreach($tabungans as $tabungan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><span class="badge bg-dark text-white">     
                    <a href="#"
                       data-bs-toggle="modal"
                       data-bs-target="#detailModal"
                       data-name="{{ $tabungan->name }}"
                       data-status="{{ $tabungan->status }}"
                       data-kelas="{{ $tabungan->kelas }}"
                       data-walas="{{ $tabungan->walas }}">
                        {{ $tabungan->name }}
                    </a>
</span>
                </td>
                <td>
                    <a href="https://wa.me/{{ $tabungan->whatsapp_number }}" target="_blank">
                        {{ $tabungan->no_telpon }}
                    </a>
                </td>
                <td ><span class="badge bg-primary"> {{ $tabungan->acara->nama_acara ?? 'Data Acara telah dihapus' }} </span></td>
                <td><span class="badge bg-primary"> {{ $tabungan->acara->tanggal_acara ?? '-' }} </span></td>
                <td><span class="badge bg-danger">   {{ isset($tabungan->acara->jumlah_bayar) ? number_format($tabungan->acara->jumlah_bayar, 0, ',', '.') : '-' }} </span> </td>
                <!-- <td>{{ $tabungan->total_masuk }}</td> -->
                <td><span class="badge bg-success"> {{ number_format(App\Models\Tabungan::where('name', $tabungan->name)->sum('total_masuk'), 0, ',', '.') }} </span></td>

<td><span class="badge bg-warning">  
    @php
        // Ambil jumlah bayar dari relasi acara, jika ada
        $jumlahBayar = isset($tabungan->acara->jumlah_bayar) ? $tabungan->acara->jumlah_bayar : 0;
        // Hitung total masuk kumulatif berdasarkan nama siswa
        $totalMasuk = App\Models\Tabungan::where('name', $tabungan->name)->sum('total_masuk');
        // Hitung tagihan sebagai selisih antara jumlah bayar dan total masuk
        $tagihan = $jumlahBayar - $totalMasuk;
    @endphp
    {{ number_format($tagihan, 0, ',', '.') }}
    </span>
</td>

               

                                    <td>{{ $tabungan->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</td>

                                    <td>
                                        <button class="btn btn-edit btn-sm">✏</button>
                                        <button type="button"
                                                class="btn btn-delete btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-url="{{ route('tabungan.destroy', $tabungan->id) }}"
                                                data-name="{{ $tabungan->name }}">
                                            🗑
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                          <div class="mt-2">
                          {{ $tabungans->links('vendor.pagination.custom') }}
</div>
                </div>
            </main>
        </div>
    </div>
</div>


<!-- Tampilan Mobile (Card View) -->
<div class="mobile-view d-block d-md-none mt-4">
  @forelse ($tabungans as $tabungan)
    <div class="mobile-card" style="border:1px solid white; border-radius:10px; padding:10px; margin-bottom:15px;">
      <div class="row mb-2">
        <div class="col-4"><strong>Nama:</strong></div>
        <div class="col-8">
          <span class="badge bg-dark text-white">{{ $tabungan->name }}</span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>ID:</strong></div>
        <div class="col-8">
          <span class="badge bg-secondary">{{ $loop->iteration }}</span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>No Telpon:</strong></div>
        <div class="col-8">
          <a href="https://wa.me/{{ $tabungan->whatsapp_number }}" target="_blank">
            <span class="badge bg-info">{{ $tabungan->no_telpon }}</span>
          </a>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Nama Acara:</strong></div>
        <div class="col-8">
          <span class="badge bg-primary">
            {{ $tabungan->acara->nama_acara ?? 'Data Acara telah dihapus' }}
          </span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Tanggal Acara:</strong></div>
        <div class="col-8">
          <span class="badge bg-light">
            {{ $tabungan->acara->tanggal_acara ?? '-' }}
          </span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Jumlah Bayar:</strong></div>
        <div class="col-8">
          <span class="badge bg-success">
            {{ isset($tabungan->acara->jumlah_bayar) ? number_format($tabungan->acara->jumlah_bayar, 0, ',', '.') : '-' }}
          </span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Total Masuk:</strong></div>
        <div class="col-8">
          <span class="badge bg-warning">
            {{ number_format($tabungan->total_masuk, 0, ',', '.') }}
          </span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Tagihan:</strong></div>
        <div class="col-8">
          <span class="badge bg-danger">
            {{ number_format($tabungan->tagihan, 0, ',', '.') }}
          </span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Tanggal:</strong></div>
        <div class="col-8">
          <span class="badge bg-secondary">
            {{ $tabungan->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
          </span>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4"><strong>Bukti:</strong></div>
        <div class="col-8">
          @if($tabungan->tipe_pembayaran == 'transfer')
            @if($tabungan->image)
              <a href="#"
                 data-bs-toggle="modal"
                 data-bs-target="#imageModal"
                 data-image="{{ asset('uploads/transfer/' . $tabungan->image) }}">
                <img src="{{ asset('uploads/transfer/' . $tabungan->image) }}" alt="Bukti Pembayaran" style="width:100px">
              </a>
            @else
              <span class="badge bg-secondary">Tidak ada bukti transfer</span>
            @endif
          @else
            <span class="badge bg-success">Pembayaran cash <br>(tidak perlu bukti)</span>
          @endif
        </div>
      </div>
      <!-- Tombol Aksi -->
      <div class="mt-2">
        <button class="btn btn-edit btn-sm">
          <i class="fas fa-edit"></i> Edit
        </button>
        <button type="button" class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tabungan->id }}" data-url="{{ route('tabungan.destroy', $tabungan->id) }}" data-name="{{ $tabungan->name }}">
          <i class="fas fa-trash"></i> Delete
        </button>
      </div>
    </div>

    <!-- Modal Delete Mobile (gunakan modal delete yang sama dengan tampilan desktop jika diperlukan) -->
    <div class="modal fade" id="deleteModal{{ $tabungan->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tabungan->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel{{ $tabungan->id }}">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            Yakin ingin menghapus data dari <strong>{{ $tabungan->name }}</strong>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <form action="{{ route('tabungan.destroy', $tabungan->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="mobile-card">
      Data tidak ditemukan.
    </div>
  @endforelse

  <!-- Pagination untuk tampilan mobile -->
  <div class="d-flex justify-content-center">
    {{ $tabungans->links() }}
  </div>
</div>

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
    var deleteModal = document.getElementById('deleteModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        // Tombol yang memicu modal
        var button = event.relatedTarget;
        
        // Ambil data URL dan nama dari atribut data-bs-*
        var url = button.getAttribute('data-url');
        var name = button.getAttribute('data-name');
        
        // Update konten modal dengan nama data yang akan dihapus
        var modalName = deleteModal.querySelector('#modalName');
        modalName.textContent = name;
        
        // Set action form delete dengan URL yang benar
        var deleteForm = deleteModal.querySelector('#deleteForm');
        deleteForm.action = url;
    });
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
            // Header Halaman
            element: '.d-flex.justify-content-between.flex-wrap.flex-md-nowrap.align-items-center.pt-3.pb-2.mt-2',
            popover: {
                title: 'Header Halaman',
                description: 'Ini adalah header halaman Daftar Tabungan.',
                position: 'bottom'
            }
        },
        {
            // Notifikasi Sukses (jika ada)
            element: '.alert.alert-success',
            popover: {
                title: 'Pesan Sukses',
                description: 'Pesan notifikasi muncul ketika operasi berhasil.',
                position: 'left'
            }
        },
        {
            // Informasi Ringkasan Tabungan (card)
            element: '.row.justify-content-center',
            popover: {
                title: 'Ringkasan Tabungan',
                description: 'Menampilkan total tabungan untuk minggu ini, bulan ini, serta data berdasarkan kelas.',
                position: 'bottom'
            }
        },
        {
            // Judul Daftar Data Tabungan
            element: '.table-container h4',
            popover: {
                title: 'Daftar Data Tabungan',
                description: 'Bagian ini menampilkan data tabungan secara rinci.',
                position: 'bottom'
            }
        },
        {
            // Form Pencarian dan Filter
            element: 'form[action="{{ route("tabungan.index") }}"]',
            popover: {
                title: 'Filter Pencarian',
                description: 'Gunakan form ini untuk mencari data tabungan berdasarkan keyword dan mengatur tampilan per halaman.',
                position: 'bottom'
            }
        },
        {
            // Tombol Aksi (Bayar, Tambah Data, Refresh)
            element: '.row.align-items-center.mb-3 .col-md-6.text-md-end ',
            popover: {
                title: 'Tombol Aksi',
                description: 'Tombol untuk melakukan aksi seperti pembayaran, penambahan data, dan refresh tampilan.',
                position: 'left'
            }
        },
        {
            // Baris Download dan Import
            element: '.filter',
            popover: {
                title: 'Download & Import',
                description: 'Gunakan fitur ini untuk mengunduh data dalam format PDF atau mengimport data tabungan.',
                position: 'bottom'
            }
        },
        {
            // Baris Download dan Import
            element: '.tipebay',
            popover: {
                title: 'filter tipe pembayaran',
                description: 'Gunakan fitur ini untuk men filter siapa saja yang bayar cash atau transfer.',
                position: 'bottom'
            }
        },
        {
            // Tabel Data Tabungan
            element: 'table.table',
            popover: {
                title: 'Tabel Data Tabungan',
                description: 'Tabel ini menampilkan data tabungan secara rinci, termasuk informasi acara dan tagihan.',
                position: 'top'
            }
        }
    ]);

    // Memulai tur saat tombol dengan kelas .guide diklik
    document.querySelector('.guide').addEventListener('click', function () {
        // Scroll ke header agar langkah pertama terlihat jelas
        
        const header = document.querySelector('.d-flex.justify-content-between.flex-wrap.flex-md-nowrap.align-items-center.pt-3.pb-2.mt-2');
        if (header) {
            header.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(function () {
                driver.start();
            }, 500); // delay 500ms untuk memastikan scroll selesai
        } else {
            driver.start();
        }
    });
});

var detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        // 'event.relatedTarget' adalah elemen yang memicu modal (link yang diklik)
        var triggerLink = event.relatedTarget;
        
        // Ambil data dari data attributes
        var name   = triggerLink.getAttribute('data-name');
        var status = triggerLink.getAttribute('data-status');
        var kelas  = triggerLink.getAttribute('data-kelas');
        var walas  = triggerLink.getAttribute('data-walas');
        
        // Isi konten modal dengan data yang diambil
        document.getElementById('modalName').textContent   = name;
        document.getElementById('modalStatus').textContent = status;
        document.getElementById('modalKelas').textContent  = kelas;
        document.getElementById('modalWalas').textContent  = walas;
    });


</script>

@endsection
