@extends('layout.app')

{{-- Jika layout.app belum memuat style tambahan, Anda bisa menambahkannya di sini --}}

@section('content')
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

<!-- Contoh modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteForm" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus data <span id="deleteName"></span>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>




<div class="container my-3">
    <!-- Baris Filter & Fungsi -->
    <h2>Riwayat Tabungan</h2>
    <div class="row g-3">
        <!-- Filter Tipe Pembayaran -->
        <div class="col-12 col-md-4">
            <form method="GET" action="{{ route('tabungan.riwayat') }}" class="d-flex align-items-center">
                <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-select me-3">
                    <option value="">Filter Tipe Pembayaran</option>
                    <option value="cash" @if(request('tipe_pembayaran')=='cash') selected @endif>Cash</option>
                    <option value="transfer" @if(request('tipe_pembayaran')=='transfer') selected @endif>Transfer</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Pengaturan Jumlah Data per Halaman & Pencarian Keyword -->
        <div class="col-12 col-md-4">
            <form method="GET" action="{{ route('tabungan.riwayat') }}" class="d-flex align-items-center">
                <select class="form-select w-auto" name="perPage">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                </select>
                <input type="text" class="form-control ms-3" name="keyword" placeholder="Masukan keyword pencarian..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary ms-3">Cari</button>
            </form>
        </div>

        <!-- Unduh Data PDF Berdasarkan Kelas -->
        <div class="col-12 col-md-4">
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
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive mt-4">
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>No Telpon</th>
                    <th>Nama Acara</th>
                    <th>Tanggal Acara</th>
                    <th>Jumlah Bayar</th>
                    <th>Total Masuk</th>
                    <th>Tagihan</th>
                    <th>Bukti</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tabungans as $tabungan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tabungan->name }}</td>
                        <td>
                            <a href="https://wa.me/{{ $tabungan->whatsapp_number }}" target="_blank">
                                {{ $tabungan->no_telpon }}
                            </a>
                        </td>
                        <td>{{ $tabungan->acara->nama_acara ?? 'Data Acara telah dihapus' }}</td>
                        <td>{{ $tabungan->acara->tanggal_acara ?? '-' }}</td>
                        <td>
                            {{ isset($tabungan->acara->jumlah_bayar) ? number_format($tabungan->acara->jumlah_bayar, 0, ',', '.') : '-' }}
                        </td>
                        <td>{{ number_format($tabungan->total_masuk, 0, ',', '.') }}</td>
                        <td>{{ number_format($tabungan->tagihan, 0, ',', '.') }}</td>
                        <td>
                            @if($tabungan->tipe_pembayaran == 'transfer')
                                @if($tabungan->image)
                                    <a href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#imageModal"
                                       data-image="{{ asset('uploads/transfer/' . $tabungan->image) }}">
                                        <img src="{{ asset('uploads/transfer/' . $tabungan->image) }}" alt="Bukti Pembayaran" style="width:100px">
                                    </a>
                                @else
                                    Tidak ada bukti transfer
                                @endif
                            @else
                                Pembayaran cash (tidak perlu bukti)
                            @endif
                        </td>
                        <td>{{ $tabungan->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <button class="btn btn-edit btn-sm">✏</button>
                            <button type="button"
        class="btn btn-delete btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-url="{{ route('tabungan.destroyRiwayat', $tabungan->id) }}"
        data-name="{{ $tabungan->name }}">
    🗑
</button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tampilkan Pagination jika ada -->
        <div class="d-flex justify-content-end">
            {{ $tabungans->links() }}
        </div>
    </div>
</div>


<script>
    
    var imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        // Dapatkan elemen yang memicu modal
        var triggerElement = event.relatedTarget;
        // Ambil URL gambar dari data attribute
        var imageSrc = triggerElement.getAttribute('data-image');
        // Set URL tersebut ke elemen <img> di modal
        var modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
    });


     // Mengisi form delete dengan URL dan nama data
  var deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var url = button.getAttribute('data-url');
      var name = button.getAttribute('data-name');
      
      var form = document.getElementById('deleteForm');
      form.action = url;
      document.getElementById('deleteName').textContent = name;
  });
</script>
@endsection