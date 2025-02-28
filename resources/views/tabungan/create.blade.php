@extends('layout.app')

@section('content')
<style>
    body {
        background-color: #151521;
    }
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
    .text-center {
        text-align: center;
        margin-bottom: 1rem;
        color: #fff;
    }
    .btn-primary {
        background-color: #0676ea;
        border-color: #0676ea;
    }
    .btn-primary:hover {
        background-color: #70777c;
        border-color: #70777c;
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
    .row {
        margin: 0 -0.5rem;
    }
    .col-md-6 {
        padding: 0 0.5rem;
    }
    /* Field untuk bukti pembayaran, tampil jika tipe pembayaran = tranfer */
    #buktiPembayaranContainer {
        display: none;
    }
    /* Hidden input untuk data auto-populasi */
    .hidden-field {
        display: none;
    }
</style>

<div class="register-container">
    <!-- Kolom Ilustrasi -->
    <div class="illustration">
        <img src="{{ asset('assets/foto/ilus_4.png') }}" alt="Illustration">
    </div>
    
    <!-- Kolom Form -->
    <div class="form-section">
        <h2 class="text-center">Tambah Data Tabungan</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('tabungan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Kolom Kiri: 4 Field -->
                <div class="col-md-6">
                    <!-- Field 1: Pilih Siswa -->
                    <div class="mb-3">
                        <label class="form-label" for="siswaSelect">Pilih Siswa</label>
                        <select name="name" id="siswaSelect" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->name }}" 
                                    data-nisn="{{ $siswa->id }}"
                                    data-status="{{ $siswa->status }}"
                                    data-kelas="{{ $siswa->kelas }}"
                                    data-walas="{{ $siswa->walas }}"
                                    data-gander="{{ $siswa->gander }}"
                                    data-telpon="{{ $siswa->no_telpon }}">
                                    {{ $siswa->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Field 2: Pilih Acara -->
                    <div class="mb-3">
                        <label class="form-label" for="acaraSelect">Nama Acara</label>
                        <select name="nama_acara" id="acaraSelect" class="form-control">
                            <option value="">-- Pilih Acara --</option>
                            @foreach($acaras as $acara)
                                <option value="{{ $acara->nama_acara }}"
                                    data-tanggal="{{ $acara->tanggal_acara }}"
                                    data-jumlah="{{ $acara->jumlah_bayar }}">
                                    {{ $acara->nama_acara }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Field 3: Tanggal Acara -->
                    <div class="mb-3">
                        <label class="form-label" for="tanggal_acara">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" class="form-control">
                    </div>
                    
                    <!-- Field 4: Jumlah Bayar -->
                    <div class="mb-3">
                        <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                        <input type="text" step="0.01" name="jumlah_bayar" id="jumlah_bayar" class="form-control" placeholder="Masukkan Jumlah Bayar">
                    </div>
                </div>
                
                <!-- Kolom Kanan: 3 Field -->
                <div class="col-md-6">
                    <!-- Field 1: Tipe Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label" for="tipe_pembayaran">Tipe Pembayaran</label>
                        <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-control">
                            <option value="">-- Pilih Tipe Pembayaran --</option>
                            <option value="cash">Cash</option>
                            <option value="tranfer">Tranfer</option>
                        </select>
                    </div>
                    
                    <!-- Field 2: Total Masuk -->
                    <div class="mb-3">
                        <label class="form-label" for="total_masuk">Total Masuk</label>
                        <input type="text" step="0.01" name="total_masuk" id="total_masuk" class="form-control" placeholder="Masukkan Total Masuk">
                    </div>
                    
                    <!-- Field 3: Tagihan (readonly) -->
                    <div class="mb-3">
                        <label class="form-label" for="tagihan">Tagihan (Jumlah Bayar - Total Masuk)</label>
                        <input type="text" step="0.01" name="tagihan" id="tagihan" class="form-control" readonly placeholder="Tagihan">
                    </div>
                    
                    <!-- Field tambahan: Bukti Pembayaran (tampil jika tipe = tranfer) -->
                    <div class="mb-3" id="buktiPembayaranContainer">
                        <label class="form-label" for="image">Bukti Pembayaran</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            
            <!-- Field No Telpon (selesai, full width) -->
            <div class="mb-3">
                <label class="form-label" for="no_telpon">No Telpon</label>
                <input type="text" name="no_telpon" id="no_telpon" class="form-control" placeholder="Masukkan No Telpon">
            </div>
            
            <!-- Hidden Input untuk auto-populasi data dari dropdown Siswa -->
            <input type="hidden" name="nisn" id="nisn">
            <input type="hidden" name="status" id="status">
            <input type="hidden" name="kelas" id="kelas">
            <input type="hidden" name="walas" id="walas">
            <input type="hidden" name="gander" id="gander">
            
            <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
        </form>
    </div>
</div>

<script>
    // Auto-populasi data siswa ketika dropdown Siswa berubah
    document.getElementById('siswaSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('nisn').value = selectedOption.getAttribute('data-nisn') || '';
        document.getElementById('status').value = selectedOption.getAttribute('data-status') || '';
        document.getElementById('kelas').value = selectedOption.getAttribute('data-kelas') || '';
        document.getElementById('walas').value = selectedOption.getAttribute('data-walas') || '';
        document.getElementById('gander').value = selectedOption.getAttribute('data-gander') || '';
    });

    // Fungsi untuk memformat angka ke format rupiah (contoh: 1000000 -> "1.000.000")
    function formatRupiah(angka) {
        if (angka === null || angka === undefined || angka === '') return '';
        var number_string = angka.toString();
        return number_string.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Fungsi untuk menghapus separator dan mengonversi string ke angka
    function parseRupiah(formatted) {
        if (formatted === null || formatted === undefined || formatted === '') return 0;
        return parseInt(formatted.replace(/\./g, ''), 10);
    }

    // Saat dropdown Acara berubah, auto-populasi tanggal_acara dan jumlah_bayar
    document.getElementById('acaraSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        // Isi tanggal_acara dari data atribut
        var tanggalAcara = selectedOption.getAttribute('data-tanggal') || '';
        document.getElementById('tanggal_acara').value = tanggalAcara;
        
        // Format dan isi jumlah_bayar
        var dataJumlah = selectedOption.getAttribute('data-jumlah') || '';
        var formattedJumlah = formatRupiah(dataJumlah);
        document.getElementById('jumlah_bayar').value = formattedJumlah;
        
        calculateTagihan();
    });

    // Fungsi untuk menghitung tagihan (jumlah_bayar - total_masuk)
    function calculateTagihan() {
        var jumlahBayar = parseRupiah(document.getElementById('jumlah_bayar').value);
        var totalMasuk = parseRupiah(document.getElementById('total_masuk').value);
        var tagihan = jumlahBayar - totalMasuk;
        document.getElementById('tagihan').value = formatRupiah(tagihan);
    }

    // Event listener untuk memformat input jumlah_bayar dan menghitung tagihan
    document.getElementById('jumlah_bayar').addEventListener('input', function() {
        var clean = this.value.replace(/\D/g, '');
        this.value = formatRupiah(clean);
        calculateTagihan();
    });

    // Event listener untuk memformat input total_masuk dan menghitung tagihan
    document.getElementById('total_masuk').addEventListener('input', function() {
        var clean = this.value.replace(/\D/g, '');
        this.value = formatRupiah(clean);
        calculateTagihan();
    });

    // Tampilkan atau sembunyikan field Bukti Pembayaran berdasarkan Tipe Pembayaran
    document.getElementById('tipe_pembayaran').addEventListener('change', function() {
        var selectedValue = this.value.toLowerCase();
        var buktiContainer = document.getElementById('buktiPembayaranContainer');
        if (selectedValue === 'tranfer') {
            buktiContainer.style.display = 'block';
        } else {
            buktiContainer.style.display = 'none';
        }
    });
</script>
@endsection
