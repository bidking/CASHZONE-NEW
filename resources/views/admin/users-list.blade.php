    @extends('layout.app')
    @section('title', 'Users list')

    @section('content')
    
    <style>

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

.modal-header {
    border-bottom: 1px solid #444;
}

.modal-footer {
    border-top: 1px solid #444;
}

.image-preview {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}
    .btn.active {
        background-color: #0d6efd; /* Warna tombol aktif */
        color: white;
        border: 1px solid #0d6efd;
    }

    table thead th, table tbody tr, table tbody td {
        background-color: #1f2326 !important; /* Set background menjadi putih */
    }

    /* Mengatur warna latar belakang saat hover, jika tidak ingin menggunakan table-dark */
    table tbody tr:hover {
        background-color: #f8f9fa !important; /* Warna terang saat hover */
    }

    .table-container .mt-2 {
        justify-content: center;
    }
    .table-container {
        overflow-x: auto; /* Scroll horizontal */
    }

    .table-container .mt-2 {
        white-space: nowrap; /* Jangan bungkus elemen */
        justify-content: center; /* Posisikan mt-2 di tengah */
    }

    @media (max-width: 570px) {
        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10px;
        }

        .table-responsive {
            margin-bottom: 1rem;
        }

        .card-body i {
            font-size: 1.5rem;
        }
    }

    /* Responsive filter section */
    .filter-section {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .filter-section .form-select, .filter-section .btn {
        min-width: 120px;
    }

    .status-filter .btn {
        margin-right: 0.5rem;
    }

    .status-filter .btn.active {
        background-color: #0d6efd;
        color: white;
    }

</style>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mt-2">
                    <h3 class="mt-3 mb-2 fw-bold" style="color:#657bc1;">Halaman Akun</h3>
                </div>
                @if (session()->has("success")) 
    <div id="success-alert" class="alert alert-success alert-dismissible ms-auto fade show d-flex align-items-center justify-content-center"
        style="width: fit-content !important; padding-top: 0.5em !important; padding-bottom: 0.5em !important; 
               position: fixed; top:15%; right: 10px; z-index: 9999; animation: slideInFromRight 0.5s ease-out, slideOutToRight 2s ease-out 3s;"
        role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding-bottom: 5px !important"></button>
    </div>
@endif  
                @if ($errors->any())
                <p style="color: red;">{{ $errors->first('error') }}</p>
            @endif
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-4">
                        <div class="text-start">
                            <div class="card-body boys-card">
                                <i class="fa-solid fa-mars" style="color: #36A2EB;"></i>
                                <div>
                                    <h5 class="card-title"style="color:gray;">Laki-Laki</h5>
                                    <p class="card-text">{{ $maleCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-start">
                            <div class="card-body girl-card">
                                <i class="fa-solid fa-venus"style="color: #36A2EB;"></i>
                                <div>
                                    <h5 class="card-title"style="color:gray;">Perempuan</h5>
                                    <p class="card-text">{{ $femaleCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>






                <div class="table-container mt-4">
                <div class="card-bodys">
    <h4 class="mb-4">Daftar Pelajar</h4>
    <!-- Filter dan Tombol -->
 
    <div class="container my-4">
  <div class="row align-items-center">
    <!-- Kolom Kiri: Form Pencarian dan Filter -->
    <div class="col-md-8">
      <form action="{{ route('admin.users.list') }}" method="GET" class="w-100">
        @csrf
        <!-- Input Pencarian -->
        <div class="mb-3">
          <input type="text" class="form-control w-100" name="search" 
                 placeholder="Masukkan keyword pencarian..." 
                 value="{{ request('search') }}">
        </div>

        <!-- Filter: Jumlah Data, Filter By, dan Sort -->
        <div class="d-flex gap-1 flex-wrap w-100">
          <!-- Filter Jumlah per Halaman -->
          <select class="form-select d-inline-block w-auto" name="perPage" onchange="this.form.submit()">
            <option value="3" @if(request('perPage') == 3) selected @endif>3</option>
            <option value="5" @if(request('perPage') == 5) selected @endif>5</option>
            <option value="10" @if(request('perPage') == 10) selected @endif>10</option>
            <option value="20" @if(request('perPage') == 20) selected @endif>20</option>
          </select>

          <!-- Filter Berdasarkan Nama atau Identitas -->
          <select class="form-select d-inline-block w-auto" name="filterBy" onchange="this.form.submit()">
            <option value="Nama Lengkap" @if(request('filterBy') == 'Nama Lengkap') selected @endif>
              Nama Lengkap
            </option>
            <option value="Nomor Identitas" @if(request('filterBy') == 'Nomor Identitas') selected @endif>
              Nomor Identitas
            </option>
          </select>

          <!-- Filter Berdasarkan Urutan A-Z / Z-A -->
          <select class="form-select d-inline-block w-auto" name="sort" onchange="this.form.submit()">
            <option value="asc" @if(request('sort') == 'asc') selected @endif>A-Z</option>
            <option value="desc" @if(request('sort') == 'desc') selected @endif>Z-A</option>
          </select>

          <!-- Tombol Reset Filter -->
          <a href="{{ route('admin.users.list', ['status' => $status, 'sort' => request('sort')]) }}" 
             class="btn btn-warning">
            Reset Filter
          </a>
          <a href="{{ route('new.user') }}" class="btn btn-dark">
          <i class='bx bxs-user-plus me-2 fs-4'></i> Create User
        </a>

        </div>
    <!-- Tombol Create User -->
  
        <!-- Hidden Input untuk Status -->
        <input type="hidden" name="status" value="{{ request('status') }}">
      </form>
    </div>

    <!-- Kolom Kanan: Tombol Create User dan Filter Status -->
    <div class="col-md-4">
      <div class=" flex-column flex-md-row align-items-start align-items-md-center gap-2">
    
        <!-- Tombol Filter Status -->
        <div class="d-flex gap-2">
          <a href="{{ route('admin.users.list', ['status' => 'admin', 'sort' => request('sort')]) }}" 
             class="btn btn-secondary {{ $status === 'admin' ? 'active' : '' }}">
            Admin
          </a>
          <a href="{{ route('admin.users.list', ['status' => 'guru', 'sort' => request('sort')]) }}" 
             class="btn btn-secondary {{ $status === 'guru' ? 'active' : '' }}">
            Guru
          </a>
          <a href="{{ route('admin.users.list', ['status' => 'siswa', 'sort' => request('sort')]) }}" 
             class="btn btn-secondary {{ $status === 'siswa' ? 'active' : '' }}">
            Siswa
          </a>
          
        </div>
        <br>
       <!-- Form untuk memilih acara dan download Excel -->
@if ($status === 'siswa')
  <form method="GET" action="{{ route('admin.users.downloadExcel') }}" class="d-inline-block">
    <!-- Kirim parameter status dan sort (jika diperlukan) -->
    <input type="hidden" name="status" value="{{ $status }}">
    <input type="hidden" name="sort" value="{{ request('sort') }}">
    
    <!-- Select untuk memilih acara (diisi dari tabel acara) -->
    <select class="form-select d-inline-block w-auto" name="acara_id">
      <option value="">-- Pilih Acara --</option>
      @foreach($acaras as $acara)
        <option value="{{ $acara->id }}">{{ $acara->nama_acara }}</option>
      @endforeach
    </select>
    
    <!-- Tombol Download Excel -->
    <button type="submit" class="btn btn-success">
      Download Excel
    </button>
  </form>
@endif

      </div>
    </div>
  </div>

 
</div>







 

<br>
        <!-- Tabel -->
     
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Profile</th>
                        @if ($status === 'admin')
                            <th>id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        @elseif ($status === 'guru')
                            <th>nip</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mengajar</th>
                            <th>Status</th>
                        @elseif ($status === 'siswa')
                            <th>nisn</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Walas</th>
                            <th>Gender</th>
                        @endif
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $user->getImageURL() }}" alt="profile picture"
                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            </td>

                            @if ($status === 'admin')
                                <td>{{ $user->id }}</td>
                                <td><span class="badge bg-primary">{{ $user->name }}</span></td>
                                <td><span class="badge bg-success">{{ $user->email }}</span></td>
                                <td><span class="badge bg-warning">{{ $user->status }}</span></td>
                            @elseif ($status === 'guru')
                                <td>{{ $user->id }}</td>
                                <td><span class="badge bg-primary">{{ $user->name }}</span></td>
                                <td><span class="badge bg-success">{{ $user->email }}</span></td>
                                <td><span class="badge bg-info">{{ $user->kelas }}</span></td>
                                <td><span class="badge bg-warning">{{ $user->status }}</span></td>
                            @elseif ($status === 'siswa')
                                <td>{{ $user->id }}</td>
                                <td><span class="badge bg-primary">{{ $user->name }}</span></td>
                                <td><span class="badge bg-info">{{ $user->kelas }}</span></td>
                                <td><span class="badge bg-warning">{{ $user->status }}</span></td>
                                <td>
                @if($user->guru)
                    <span class="badge bg-dark">{{ $user->guru->name }}</span>
                @else
                    <span class="badge bg-secondary">Tidak ada wali kelas</span>
                @endif
            </td>
                                <td><span class="badge bg-secondary">{{ $user->gander }}</span></td>
                            @endif

                            <td>
                            <button type="button" class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->id }}">
        ✏️
    </button>
    <button type="button" class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
        🗑️
    </button>
</td>

<!-- Modal -->
<div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($user->status == 'siswa')
                    Apakah Anda yakin ingin menghapus <strong>{{ $user->name }}</strong> (nisn: <strong>{{ $user->id }}</strong>)?
                @elseif ($user->status == 'guru')
                    Apakah Anda yakin ingin menghapus <strong>{{ $user->name }}</strong> (nip: <strong>{{ $user->id }}</strong>)?
                @else
                    Apakah Anda yakin ingin menghapus <strong>{{ $user->name }}</strong> (ID: <strong>{{ $user->id }}</strong>)?
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('delete', ['id' => $user->id, 'status' => $status]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

                        </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <!-- <div class="mt-2">
            {{ $users->appends(['status' => request('status')])->links('vendor.pagination.custom') }}
        </div> -->
        <div class="mt-2">
    {{ $users->appends(['status' => request('status'), 'sort' => request('sort')])->links('vendor.pagination.custom') }}
</div>

    </div>
</div>



<!-- Modal Edit -->
@foreach ($users as $user)
<div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit {{ ucfirst($status) }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Edit -->
                <form action="{{ route('update', ['id' => $user->id, 'status' => $status]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Form untuk Admin -->
                    @if ($status === 'admin')
                        <div class="mb-3">
                        <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}" required>
                        @error('id')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Profil</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
              <img src="{{ $user->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
                       <p>profil lama</p>
                    </div>
                    <div class="mb-3">
<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
<select class="form-control" name="status" id="status">
<!-- <option value="">Pilih Status</option> -->
<option value="admin">Admin</option>

</select>
@error('status')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
</div>
                    @endif

                    <!-- Form untuk Guru -->
                    @if ($status === 'guru')
                    <div class="mb-3">
                        <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}" required>
                        @error('id')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $user->kelas }}" required>
                        </div>
                        <div class="mb-3">
<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
<select class="form-control" name="status" id="status">
<!-- <option value="">Pilih Status</option> -->
<option value="guru">guru</option>

</select>
@error('status')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
</div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Profil</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
              <img src="{{ $user->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
                       <p>profil lama</p>
                    </div>  
                    @endif

                    <!-- Form untuk Siswa -->
                    @if ($status === 'siswa')
                    <div class="mb-3">
                        <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}" required>
                        @error('id')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                       
   <!-- Dropdown Walas -->
<div class="mb-3">
    <label for="walas-{{ $user->id }}" class="form-label">Walas <span class="text-danger">*</span></label>
    <select class="form-control walas-dropdown" name="walas" id="walas-{{ $user->id }}" required data-user-id="{{ $user->id }}">
        <option value="">Pilih Walas</option>
        @foreach($gurus as $guru)
            <option value="{{ $guru->name }}" data-kelas="{{ $guru->kelas }}" 
                {{ old('walas', $user->walas) == $guru->id ? 'selected' : '' }}>
                {{ $guru->name }}
            </option>
        @endforeach
    </select>
    @error('walas')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Input Kelas -->
<div class="mb-3">
    <label for="kelas-{{ $user->id }}" class="form-label">Kelas <span class="text-danger">*</span></label>
    <input type="text" class="form-control kelas-input" name="kelas" id="kelas-{{ $user->id }}" 
        value="{{ old('kelas', $user->kelas) }}" readonly>
    @error('kelas')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
                        <div class="mb-3">
                            <label for="gander" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="gander" name="gander" required>
                                <option value="male" {{ $user->gander === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ $user->gander === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
<select class="form-control" name="status" id="status">
<!-- <option value="">Pilih Status</option> -->
<option value="siswa">siswa</option>

</select>
@error('status')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
</div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Profil</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
              <img src="{{ $user->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
                       <p>profil lama</p>
                    </div> 
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/driver.js/0.9.8/driver.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/driver.js/0.9.8/driver.min.js"></script>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    // Loop semua modal edit berdasarkan ID unik
    document.querySelectorAll('[id^="editModal-"]').forEach(modal => {
        const userId = modal.id.split('-')[1]; // Pastikan ID sesuai dengan format "editModal-{userId}"

        if (!userId) return; // Cegah error jika userId tidak ditemukan

        const walasDropdown = modal.querySelector(`#walas-${userId}`);
        const kelasInput = modal.querySelector(`#kelas-${userId}`);

        if (!walasDropdown || !kelasInput) return; // Jika elemen tidak ditemukan, keluar dari fungsi

        // Fungsi untuk memperbarui kelas berdasarkan pilihan walas
        const updateKelas = () => {
            const selectedOption = walasDropdown.options[walasDropdown.selectedIndex];
            const kelas = selectedOption?.getAttribute('data-kelas') || '';
            kelasInput.value = kelas;
        };

        // Jalankan update saat dropdown berubah
        walasDropdown.addEventListener('change', updateKelas);

        // Jalankan update saat modal pertama kali dibuka
        modal.addEventListener('show.bs.modal', function () {
            if (walasDropdown.options.length > 0) {
                updateKelas(); // Pastikan hanya dijalankan jika ada opsi dalam dropdown
            }
        });
    });
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

    // Definisikan langkah-langkah tur untuk halaman daftar pengguna
    driver.defineSteps([
      {
        // Header halaman daftar pelajar
        element: '.d-flex.justify-content-between.flex-wrap.flex-md-nowrap.align-items-center.pt-3.pb-2.mt-2',
        popover: {
          title: 'Halaman Daftar Pelajar',
          description: 'Ini adalah header halaman daftar pelajar.',
          position: 'bottom'
        }
      },
      {
        // Notifikasi sukses, jika ada
        element: '#success-alert',
        popover: {
          title: 'Notifikasi Sukses',
          description: 'Pesan notifikasi muncul ketika operasi berhasil.',
          position: 'left'
        }
      },
      {
        // Pesan error (jika ada)
        element: 'p[style*="color: red;"]',
        popover: {
          title: 'Pesan Error',
          description: 'Pesan error yang muncul jika terjadi kesalahan.',
          position: 'bottom'
        }
      },
      {
        // Kartu jumlah Laki-Laki
        element: '.boys-card',
        popover: {
          title: 'Jumlah Laki-Laki',
          description: 'Menampilkan jumlah pelajar laki-laki.',
          position: 'bottom'
        }
      },
      {
        // Kartu jumlah Perempuan
        element: '.girl-card',
        popover: {
          title: 'Jumlah Perempuan',
          description: 'Menampilkan jumlah pelajar perempuan.',
          position: 'bottom'
        }
      },
      {
        // Judul bagian daftar pelajar di dalam card body
        element: '.card-bodys h4.mb-4',
        popover: {
          title: 'Daftar Pelajar',
          description: 'Bagian ini menampilkan daftar pelajar.',
          position: 'bottom'
        }
      },
      {
        // Input pencarian di form filter
        element: 'form[action="{{ route("admin.users.list") }}"] input[name="search"]',
        popover: {
          title: 'Pencarian Pelajar',
          description: 'Masukkan kata kunci untuk mencari pelajar.',
          position: 'bottom'
        }
      },
      {
        // Select jumlah data per halaman (perPage)
        element: 'form[action="{{ route("admin.users.list") }}"] select[name="perPage"]',
        popover: {
          title: 'Jumlah Data Per Halaman',
          description: 'Pilih jumlah data yang ditampilkan per halaman.',
          position: 'bottom'
        }
      },
      {
        // Select filter berdasarkan Nama Lengkap atau Nomor Identitas
        element: 'form[action="{{ route("admin.users.list") }}"] select[name="filterBy"]',
        popover: {
          title: 'Filter Berdasarkan',
          description: 'Pilih filter berdasarkan Nama Lengkap atau Nomor Identitas.',
          position: 'bottom'
        }
      },
      {
        // Select urutan data (sort)
        element: 'form[action="{{ route("admin.users.list") }}"] select[name="sort"]',
        popover: {
          title: 'Urutan Data',
          description: 'Pilih urutan data (A-Z atau Z-A).',
          position: 'bottom'
        }
      },
      {
        // Tombol reset filter
        element: 'form[action="{{ route("admin.users.list") }}"] a.btn.btn-warning',
        popover: {
          title: 'Reset Filter',
          description: 'Klik tombol ini untuk mereset filter pencarian.',
          position: 'bottom'
        }
      },
      {
        // Tombol Create User
        element: 'a.btn.btn-dark',
        popover: {
          title: 'Create User',
          description: 'Klik tombol ini untuk membuat pengguna baru.',
          position: 'bottom'
        }
      },
      {
        // Tombol Filter Status (Admin, Guru, Siswa)
        element: '.d-flex.justify-content-start.gap-2.mb-3',
        popover: {
          title: 'Filter Status',
          description: 'Gunakan tombol filter status untuk memilih kategori pengguna.',
          position: 'bottom'
        }
      },
      {
        // Tabel daftar pelajar
        element: '.table-responsive',
        popover: {
          title: 'Tabel Pelajar',
          description: 'Daftar pelajar ditampilkan di dalam tabel ini.',
          position: 'top'
        }
      }
    ]);

    // Event listener untuk tombol "guide" (misalnya tombol dengan kelas .guide)
    document.querySelector('.guide').addEventListener('click', function () {
      // Scroll ke header halaman agar langkah pertama terlihat dengan baik
      const header = document.querySelector('.d-flex.justify-content-between.flex-wrap.flex-md-nowrap.align-items-center.pt-3.pb-2.mt-2');
      if (header) {
        header.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Beri delay agar animasi scroll selesai sebelum memulai tur
        setTimeout(function() {
          driver.start();
        }, 500);
      } else {
        driver.start();
      }
    });
});
</script>

@endsection
