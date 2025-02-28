@extends('layout.app')

{{-- Jika layout.app belum memuat style tambahan, Anda bisa menambahkannya di sini --}}

@section('content')
<style>
  .card {
    color: black;
    height: 75vh;
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
    color: #435ebe;
    font-weight: bold;
    font-size: 30px;
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
  th, td {
    text-align: center;
  }
  .table-responsive {
    max-height: 450px; /* Atur tinggi maksimal sesuai kebutuhan */
    overflow-y: auto;
  }

  /* Responsive Views */
  @media only screen and (max-width: 768px) {
    .desktop-view { display: none; }
    .mobile-view { display: block; }
  }
  @media only screen and (min-width: 769px) {
    .desktop-view { display: block; }
    .mobile-view { display: none; }
  }

  /* Tambahan styling untuk mobile card (sesuaikan kebutuhan) */
  .mobile-card {
    background-color: #1e1e2d;
    color: white;
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 15px;
  }
  .mobile-card h5 {
    margin-bottom: 10px;
    font-weight: bold;
  }
  .mobile-card p {
    margin: 0 0 5px 0;
  }
</style>
<body>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
            </div>
        </div>
    </div>
</div>
  <!-- Main Content -->
  <div class="container mt-5">
    <h2 class="mb-4">Halaman Approve</h2>

    <!-- Tampilan Desktop (Table) -->
    <div class="desktop-view">
      <div class="card text-light p-4">
        <h4 class="mb-4 fw-bold">Daftar Approve</h4>
        <div class="table-responsive">
          <table class="table table-dark table-striped text-light">
            <thead>
              <tr>
                <th>#</th>
                <th>NISN</th>
                <th>Nama Panjang</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jumlah Pembayaran</th>
                <th>Total Masuk</th>
                <th>tagihan</th>
                <th>tanggal permintaan</th>
                <th>Bukti</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($approveds as $approved)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $approved->nisn }}</td>
                  <td>{{ $approved->name }}</td>
                  <td>{{ $approved->kelas }}</td>
                  <td>{{ \Carbon\Carbon::parse($approved->tanggal_acara)->format('d/m/Y') }}</td>
                  <td>Rp.{{ number_format($approved->jumlah_bayar, 0, ',', '.') }}</td>
                  <td>Rp.{{ number_format($approved->total_masuk, 0, ',', '.') }}</td>
                  <td>Rp.{{ number_format($approved->tagihan, 0, ',', '.') }}</td>
                  <td>{{ $approved->created_at }}</td>

                  <td>
                    @if ($approved->tipe_pembayaran === 'cash')
                      <span>Pembayaran Cash <br>(Tidak Perlu Memberikan Bukti)</span>
                    @else
                    <a href="#"
            data-bs-toggle="modal"
            data-bs-target="#imageModal"
            data-image="{{ asset('uploads/transfer/' . $approved->image) }}">
            <img src="{{ asset('uploads/transfer/' . $approved->image) }}" alt="Bukti Pembayaran" style="width:100px; height:100px;">
            </a>
                    @endif
                  </td>
                  <td>
                    <!-- Tombol Approve Trigger Modal -->
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $approved->id }}">
                      <i class="fas fa-check"></i>
                    </button>

                    <!-- Modal Approve -->
                    <div class="modal fade" id="approveModal{{ $approved->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $approved->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                          <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel{{ $approved->id }}">Setujui Pembayaran?</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menyetujui pembayaran dari <strong>{{ $approved->name }}</strong>?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('approved.process', $approved->id) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="btn btn-success">Ya, Setujui</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Tombol Reject Trigger Modal -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $approved->id }}">
                      <i class="fas fa-times"></i>
                    </button>

                    <!-- Modal Reject -->
                    <div class="modal fade" id="rejectModal{{ $approved->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $approved->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                          <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel{{ $approved->id }}">Tolak Pembayaran</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menolak pembayaran dan menghapus data dari <strong>{{ $approved->name }}</strong>?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('approved.reject', $approved->id) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9">Data tidak ditemukan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Tampilan Mobile (List Card) -->
    <div class="mobile-view">
      @forelse ($approveds as $approved)
        <div class="mobile-card">
          <h5>{{ $approved->name }}</h5>
          <p><strong>NISN:</strong> {{ $approved->nisn }}</p>
          <p><strong>Kelas:</strong> {{ $approved->kelas }}</p>
          <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($approved->tanggal_acara)->format('d/m/Y') }}</p>
          <p><strong>Jumlah Pembayaran:</strong> Rp.{{ number_format($approved->jumlah_bayar, 0, ',', '.') }}</p>
          <p><strong>Total Masuk:</strong> Rp.{{ number_format($approved->total_masuk, 0, ',', '.') }}</p>
          <p><strong>Total tagihan:</strong> Rp.{{ number_format($approved->tagihan, 0, ',', '.') }}</p>
          <p>
            <strong>Bukti:</strong>
            @if ($approved->tipe_pembayaran === 'cash')
              <span>Pembayaran Cash <br>(Tidak Perlu Memberikan Bukti)</span>
            @else
            <a href="#"
            data-bs-toggle="modal"
            data-bs-target="#imageModal"
            data-image="{{ asset('uploads/transfer/' . $approved->image) }}">
            <img src="{{ asset('uploads/transfer/' . $approved->image) }}" alt="Bukti Pembayaran" style="width:100px">
            </a>
            @endif
          </p>
          <div class="mt-2">
            <!-- Tombol Approve -->
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModalMobile{{ $approved->id }}">
              <i class="fas fa-check"></i> Approve
            </button>
            <!-- Tombol Reject -->
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModalMobile{{ $approved->id }}">
              <i class="fas fa-times"></i> Reject
            </button>
          </div>
        </div>

        <!-- Modal Approve Mobile -->
        <div class="modal fade" id="approveModalMobile{{ $approved->id }}" tabindex="-1" aria-labelledby="approveModalLabelMobile{{ $approved->id }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
              <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabelMobile{{ $approved->id }}">Setujui Pembayaran?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Apakah Anda yakin ingin menyetujui pembayaran dari <strong>{{ $approved->name }}</strong>?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('approved.process', $approved->id) }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-success">Ya, Setujui</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Reject Mobile -->
        <div class="modal fade" id="rejectModalMobile{{ $approved->id }}" tabindex="-1" aria-labelledby="rejectModalLabelMobile{{ $approved->id }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
              <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabelMobile{{ $approved->id }}">Tolak Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Apakah Anda yakin ingin menolak pembayaran dan menghapus data dari <strong>{{ $approved->name }}</strong>?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('approved.reject', $approved->id) }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-danger">Ya, Tolak</button>
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
  </script>
@endsection
