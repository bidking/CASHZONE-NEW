@extends('layout.app')

@section('content')
<style>

    .card{
        
        background-color: #1e1e2d;  
    }

    .guide{
        display:none;
    }
</style>
<div class="container mt-5 ">
    <h2 class="mb-4">Tambah Acara Baru</h2>
    <div class="card text-light p-4">
        <form action="{{ route('acara.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_acara" class="form-label">Nama Acara</label>
                <input type="text" class="form-control @error('nama_acara') is-invalid @enderror" id="nama_acara" name="nama_acara" placeholder="Masukkan nama acara" value="{{ old('nama_acara') }}" required>
                @error('nama_acara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_acara" class="form-label">Tanggal Acara</label>
                <input type="date" class="form-control @error('tanggal_acara') is-invalid @enderror" id="tanggal_acara" name="tanggal_acara" value="{{ old('tanggal_acara') }}" required>
                @error('tanggal_acara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
    <input type="text" class="form-control @error('jumlah_bayar') is-invalid @enderror" id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar') }}" required>
    @error('jumlah_bayar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('acara.acara') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
  // Fungsi untuk menghapus karakter non-digit
  function removeNonNumeric(value) {
    return value.replace(/\D/g, '');
  }

  // Fungsi untuk menambahkan separator ribuan
  function formatRupiah(value) {
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  // Event listener untuk memformat input secara real-time
  document.getElementById('jumlah_bayar').addEventListener('input', function() {
    // Hapus semua karakter non-digit
    let numericValue = removeNonNumeric(this.value);
    // Jika input tidak kosong, format ulang
    this.value = numericValue ? formatRupiah(numericValue) : "";
  });
</script>

@endsection
