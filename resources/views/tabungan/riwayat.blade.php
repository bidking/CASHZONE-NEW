@extends('layout.app')

@section('content')
<!-- Modal Bukti Pembayaran -->
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

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteForm" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content bg-dark text-white">
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
    <!-- Filter & Fungsi -->
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

        <!-- Pengaturan Jumlah Data per Halaman & Pencarian -->
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

    <!-- Tampilan Desktop: Tabel (hanya untuk layar md ke atas) -->
    <div class="table-responsive mt-4 d-none d-md-block">
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
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
                            <span class="">{{ $tabungan->no_telpon }}</span>
                        </a>
                    </td>
                    <td><span class="">{{ $tabungan->acara->nama_acara ?? 'Data Acara telah dihapus' }}</span></td>
                    <td>{{ $tabungan->acara->tanggal_acara ?? '-' }}</td>
                    <td>
                        <span class="badge bg-danger">
                            {{ isset($tabungan->acara->jumlah_bayar) ? number_format($tabungan->acara->jumlah_bayar, 0, ',', '.') : '-' }}
                        </span>
                    </td>
                    <td><span class="badge bg-success">{{ number_format($tabungan->total_masuk, 0, ',', '.') }}</span></td>
                    <td><span class="badge bg-warning">{{ number_format($tabungan->tagihan, 0, ',', '.') }}</span></td>
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
                                <span class="badge bg-secondary">Tidak ada bukti transfer</span>
                            @endif
                        @else
                            <span class="badge bg-success">Pembayaran cash <br>(tidak perlu bukti)</span>
                        @endif
                    </td>
                    <td><span class="">{{ $tabungan->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</span></td>
                    <td>
                        <button type="button"
                                class="btn btn-delete btn-sm bg-danger"
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
        <!-- Pagination -->
        <div class="d-flex justify-content-end">
            {{ $tabungans->links('vendor.pagination.custom') }}
        </div>
    </div>

 <!-- Tampilan Mobile (List Card) -->
<div class="mobile-view mt-4 d-md-none">
  @forelse ($tabungans as $tabungan)
    <div class="mobile-card mt-3" style="border:1px solid white; border-radius:10px; padding: 10px;">
      <!-- Baris 1: Nama -->
      <div class="row mb-2">
        <div class="col-4"><strong>Nama:</strong></div>
        <div class="col-8">
          <span class="badge bg-primary">{{ $tabungan->name }}</span>
        </div>
      </div>
      <!-- Baris 2: ID -->
      <div class="row mb-2">
        <div class="col-4"><strong>ID:</strong></div>
        <div class="col-8">
          <span class="badge bg-secondary">{{ $loop->iteration }}</span>
        </div>
      </div>
      <!-- Baris 3: No Telpon -->
      <div class="row mb-2">
        <div class="col-4"><strong>No Telpon:</strong></div>
        <div class="col-8">
          <a href="https://wa.me/{{ $tabungan->whatsapp_number }}" target="_blank">
            <span class="badge bg-info">{{ $tabungan->no_telpon }}</span>
          </a>
        </div>
      </div>
      <!-- Baris 4: Nama Acara -->
      <div class="row mb-2">
        <div class="col-4"><strong>Nama Acara:</strong></div>
        <div class="col-8">
          <span class="badge bg-primary">
            {{ $tabungan->acara->nama_acara ?? 'Data Acara telah dihapus' }}
          </span>
        </div>
      </div>
      <!-- Baris 5: Tanggal Acara -->
      <div class="row mb-2">
        <div class="col-4"><strong>Tanggal Acara:</strong></div>
        <div class="col-8">
          <span class="badge bg-light">
            {{ $tabungan->acara->tanggal_acara ?? '-' }}
          </span>
        </div>
      </div>
      <!-- Baris 6: Jumlah Bayar -->
      <div class="row mb-2">
        <div class="col-4"><strong>Jumlah Bayar:</strong></div>
        <div class="col-8">
          <span class="badge bg-success">
            {{ isset($tabungan->acara->jumlah_bayar) ? number_format($tabungan->acara->jumlah_bayar, 0, ',', '.') : '-' }}
          </span>
        </div>
      </div>
      <!-- Baris 7: Total Masuk -->
      <div class="row mb-2">
        <div class="col-4"><strong>Total Masuk:</strong></div>
        <div class="col-8">
          <span class="badge bg-warning">
            {{ number_format($tabungan->total_masuk, 0, ',', '.') }}
          </span>
        </div>
      </div>
      <!-- Baris 8: Tagihan -->
      <div class="row mb-2">
        <div class="col-4"><strong>Tagihan:</strong></div>
        <div class="col-8">
          <span class="badge bg-danger">
            {{ number_format($tabungan->tagihan, 0, ',', '.') }}
          </span>
        </div>
      </div>
      <!-- Baris 9: Tanggal -->
      <div class="row mb-2">
        <div class="col-4"><strong>Tanggal:</strong></div>
        <div class="col-8">
          <span class="badge bg-secondary">
            {{ $tabungan->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
          </span>
        </div>
      </div>
      <!-- Baris 10: Bukti -->
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
            <span class="badge bg-success">Pembayaran cash <br> (tidak perlu bukti)</span>
          @endif
        </div>
      </div>
      <!-- Tombol Delete -->
      <div class="mt-2">
        <button type="button" class="btn btn-delete btn-sm bg-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tabungan->id }}" data-url="{{ route('tabungan.destroyRiwayat', $tabungan->id) }}" data-name="{{ $tabungan->name }}">
          <i class="fas fa-trash"></i> Delete
        </button>
      </div>
    </div>

    <!-- Modal Delete Mobile -->
    <div class="modal fade" id="deleteModal{{ $tabungan->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tabungan->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel{{ $tabungan->id }}">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Yakin ingin menghapus data dari <strong>{{ $tabungan->name }}</strong>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <form action="{{ route('tabungan.destroyRiwayat', $tabungan->id) }}" method="POST" style="display: inline;">
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

  <!-- Pagination pada tampilan mobile -->
  <div class="d-flex justify-content-center">
    {{ $tabungans->links() }}
  </div>
</div>


<script>
    // Modal untuk bukti pembayaran
    var imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        var triggerElement = event.relatedTarget;
        var imageSrc = triggerElement.getAttribute('data-image');
        var modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
    });

    // Modal untuk konfirmasi delete
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
