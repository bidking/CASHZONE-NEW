@extends('layout.app')

@section('content')
<style>
    /* Style dari desain */
    .register-container {
        width: 100%;
        background-color: #1e1e2d;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .illustration {
        width: 50%;
    }
    .illustration img {
        width: 100%;
    }
    .form-section {
        width: 45%;
    }
    .btn-register {
        background-color: #0676ea;
        color: #fff;
    }
    .btn-register:hover {
        background-color: #70777c;
        color: #fff;    
    }
    .form-control {
        background-color: #333;
        color: #fff;
        border: 1px solid #555;
    }
    .form-control::placeholder {
        color: #bbb;
    }
    .mb-3 {
        margin-bottom: 1rem;
    }
    .text-center {
        text-align: center;
        margin-bottom: 1rem;
    }
    /* Field yang tidak ingin ditampilkan */
    .no {
        display: none;
    }
    /* Field untuk bukti pembayaran, muncul jika tipe = transfer */
    #buktiPembayaranContainer {
        display: none;
    }
</style>

<div class="register-container">
    <!-- Kolom ilustrasi -->
    <div class="illustration">
        <img src="{{ asset('assets/foto/ilus_4.png') }}" alt="Illustration">
    </div>
  
    <!-- Kolom form -->
    <div class="form-section">
        <h2 class="text-center">Halaman Bayar</h2>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Form dengan 2 kolom: kolom kiri (4 field) dan kolom kanan (3 field) -->
        <form action="{{ route('tabungan.prosesBayar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Kolom kiri: 4 field -->
                <div class="col-md-6">
                    <!-- Field 1: Nama Siswa (Dropdown) -->
                    <div class="mb-3">
                        <label class="form-label" for="siswaSelect">Nama Siswa</label>
                        <select name="name" id="siswaSelect" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                @if($siswa->lastTabungan)
                                    <option value="{{ $siswa->name }}"
                                        data-nisn="{{ $siswa->id }}"
                                        data-status="{{ $siswa->status }}"
                                        data-kelas="{{ $siswa->kelas }}"
                                        data-walas="{{ $siswa->walas }}"
                                        data-gander="{{ $siswa->gander }}"
                                        data-nama_acara="{{ $siswa->lastTabungan->nama_acara }}"
                                        data-tanggal_acara="{{ $siswa->lastTabungan->tanggal_acara }}"
                                        data-jumlah_bayar="{{ $siswa->lastTabungan->jumlah_bayar }}"
                                        data-no_telpon="{{ $siswa->lastTabungan->no_telpon }}"
                                        data-total_masuk="{{ $siswa->lastTabungan->total_masuk }}"
                                        data-cumulative_total="{{ $siswa->cumulativeTotal }}"
                                        data-tagihan="{{ $siswa->lastTabungan->tagihan }}"
                                        data-tabungan_id="{{ $siswa->lastTabungan->id }}">
                                        {{ $siswa->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <!-- Field 2: Nama Acara -->
                    <div class="mb-3">
                        <label class="form-label" for="nama_acara">Nama Acara</label>
                        <input type="text" name="nama_acara" id="nama_acara" class="form-control" readonly>
                    </div>
                    <!-- Field 3: Tanggal Acara -->
                    <div class="mb-3">
                        <label class="form-label" for="tanggal_acara">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" class="form-control" readonly>
                    </div>
                    <!-- Field 4: Jumlah Bayar -->
                    <div class="mb-3">
                        <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                        <input type="text" class="form-control" 
                               id="jumlah_bayar" 
                               name="jumlah_bayar" 
                               value="{{ number_format(old('jumlah_bayar'), 0, ',', '.') }}" 
                               readonly>
                    </div>
                </div>
                <!-- Kolom kanan: 3 field -->
                <div class="col-md-6">
                    <!-- Field 1: Tipe Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label" for="tipe_pembayaran">Tipe Pembayaran</label>
                        <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-control">
                            <option value="">-- Pilih Tipe Pembayaran --</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">transfer</option>
                        </select>
                    </div>
                    <!-- Field 2: No Telpon -->
                    <div class="mb-3">
                        <label class="form-label" for="no_telpon">No Telpon</label>
                        <input type="text" name="no_telpon" id="no_telpon" class="form-control" readonly>
                    </div>
                    <!-- Field 3: Tambahan Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label" for="tambahan">Tambahan Pembayaran</label>
                        <input type="number" step="0.01" name="tambahan" id="tambahan" class="form-control" required>
                    </div>
                    <!-- Jika tipe pembayaran transfer, tampilkan field Bukti Pembayaran (opsional) -->
                    <div class="mb-3" id="buktiPembayaranContainer">
                        <label class="form-label" for="image">Bukti Pembayaran</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Field auto-populasi (disembunyikan) -->
            <input type="hidden" name="nisn" id="nisn">
            <input type="hidden" name="status" id="status">
            <input type="hidden" name="kelas" id="kelas">
            <input type="hidden" name="walas" id="walas">
            <input type="hidden" name="gander" id="gander">
            <input type="hidden" name="current_total_masuk" id="current_total_masuk">
            <input type="hidden" name="current_tagihan" id="current_tagihan">
            <input type="hidden" name="tabungan_id" id="tabungan_id">
            <input type="hidden" name="total_masuk" id="new_total_masuk">
            <input type="hidden" name="tagihan" id="new_tagihan">
            
            <button type="submit" class="btn btn-register w-100">Bayar</button>
        </form>
    </div>
</div>

<script>
    function removeNonNumeric(value) {
        return value.replace(/\D/g, '');
    }

    function formatRupiah(value) {
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.getElementById('jumlah_bayar').addEventListener('input', function() {
        let numericValue = removeNonNumeric(this.value);
        this.value = numericValue ? formatRupiah(numericValue) : "";
    });

    // Auto-populasi field ketika memilih siswa
    document.getElementById('siswaSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('nisn').value = selectedOption.getAttribute('data-nisn') || '';
        document.getElementById('status').value = selectedOption.getAttribute('data-status') || '';
        document.getElementById('kelas').value = selectedOption.getAttribute('data-kelas') || '';
        document.getElementById('walas').value = selectedOption.getAttribute('data-walas') || '';
        document.getElementById('gander').value = selectedOption.getAttribute('data-gander') || '';
        document.getElementById('nama_acara').value = selectedOption.getAttribute('data-nama_acara') || '';
        document.getElementById('tanggal_acara').value = selectedOption.getAttribute('data-tanggal_acara') || '';
        document.getElementById('jumlah_bayar').value = selectedOption.getAttribute('data-jumlah_bayar') || '';
        document.getElementById('no_telpon').value = selectedOption.getAttribute('data-no_telpon') || '';
        document.getElementById('current_total_masuk').value = selectedOption.getAttribute('data-cumulative_total') || 0;
        document.getElementById('current_tagihan').value = selectedOption.getAttribute('data-tagihan') || 0;
        document.getElementById('tabungan_id').value = selectedOption.getAttribute('data-tabungan_id') || '';

        // Reset nilai tambahan dan perhitungan baru
        document.getElementById('tambahan').value = '';
        document.getElementById('new_total_masuk').value = '';
        document.getElementById('new_tagihan').value = '';
    });

    // Hitung total pembayaran dan tagihan baru saat input tambahan
    document.getElementById('tambahan').addEventListener('input', function() {
        var currentTotal = parseFloat(document.getElementById('current_total_masuk').value) || 0;
        var jumlahBayar = parseFloat(document.getElementById('jumlah_bayar').value) || 0;
        var tambahan = parseFloat(this.value) || 0;
        
        var newTotal = currentTotal + tambahan;
        var newTagihan = jumlahBayar - newTotal;
        
        document.getElementById('new_total_masuk').value = newTotal;
        document.getElementById('new_tagihan').value = newTagihan;
    });

    // Tampilkan atau sembunyikan bukti pembayaran berdasarkan tipe pembayaran
    document.getElementById('tipe_pembayaran').addEventListener('change', function() {
        var selectedValue = this.value.toLowerCase();
        var buktiContainer = document.getElementById('buktiPembayaranContainer');
        if (selectedValue === 'transfer') {
            buktiContainer.style.display = 'block';
        } else {
            buktiContainer.style.display = 'none';
        }
    });
</script>
@endsection
