<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/users/fetch', [UserController::class, 'fetchUsers'])->name('users.fetch');

// Route untuk Login
Route::get('/', function () {
    if (session()->has('user')) {
        $status = session('status');
        switch ($status) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'guru':
                return redirect('/guru/dashboard');
            case 'siswa':
                return redirect('/siswa/dashboard');
            default:
                return view('login.login');
        }
    }
    return view('login.login'); // Tampilkan halaman login jika belum login
});
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk Admin
Route::middleware('auth.status:admin')->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Pengguna
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.list'); // Daftar pengguna
    Route::get('/admin/users/new', [UserController::class, 'create'])->name('new.user'); // Form tambah pengguna
    Route::post('/admin/users/new/create', [UserController::class, 'store'])->name('new-create'); // Simpan pengguna baru
    Route::get('/admin/users/edit/{id}/{status}', [UserController::class, 'edit'])->name('edit'); // Form edit pengguna
    Route::put('/admin/users/update/{id}/{status}', [UserController::class, 'update'])->name('update'); // Update pengguna
    Route::post('/admin/users/delete/{id}', [UserController::class, 'delete'])->name('delete'); // Hapus pengguna

    // Route untuk manajemen acara
    Route::get('/acara', [AcaraController::class, 'index'])->name('acara.acara');
    Route::get('/acara/create', [AcaraController::class, 'create'])->name('acara.create');
    Route::post('/acara', [AcaraController::class, 'store'])->name('acara.store');
    Route::get('/acara/{acara}/edit', [AcaraController::class, 'edit'])->name('acara.edit');
    Route::put('/acara/{acara}', [AcaraController::class, 'update'])->name('acara.update');
    Route::delete('/acara/{acara}', [AcaraController::class, 'destroy'])->name('acara.destroy');

    // Route untuk Tabungan
    Route::get('/tabungan', [TabunganController::class, 'index'])->name('tabungan.index');
    Route::get('/tabungan/create', [TabunganController::class, 'create'])->name('tabungan.create');
    Route::get('/tabungan/approved', [TabunganController::class, 'approvedIndex'])->name('approved.index');
    Route::post('/tabungan/approved/process/{approved}', [TabunganController::class, 'processApproved'])->name('approved.process');
    Route::post('/tabungan/approved/reject/{approved}', [TabunganController::class, 'rejectApproved'])->name('approved.reject');
    Route::post('/tabungan', [TabunganController::class, 'store'])->name('tabungan.store');
    Route::get('/tabungan/bayar', [TabunganController::class, 'bayar'])->name('tabungan.bayar');
    Route::post('/tabungan/bayar/proses', [TabunganController::class, 'prosesBayar'])->name('tabungan.prosesBayar');
    Route::delete('/tabungan/{tabungan}', [TabunganController::class, 'destroy'])->name('tabungan.destroy');
    Route::delete('/tabungan/riwayat/{id}', [TabunganController::class, 'destroyRiwayat'])
     ->name('tabungan.destroyRiwayat');
    Route::get('/tabungan/download-pdf', [TabunganController::class, 'downloadPDF'])->name('tabungan.download.pdf');
    Route::post('/tabungan/import', [TabunganController::class, 'import'])->name('tabungan.import');
    Route::get('/tabungan/riwayat', [TabunganController::class, 'riwayat'])->name('tabungan.riwayat');
    Route::get('/tabungan/download/pdf', [TabunganController::class, 'downloadPDF'])->name('tabungan.download.pdf');
    Route::get('/admin/users/download-excel', [UserController::class, 'downloadExcel'])
         ->name('admin.users.downloadExcel');
});

// Route untuk Guru 
Route::middleware('auth.status:guru')->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
});

// Route untuk Siswa
Route::middleware('auth.status:siswa')->group(function () {
    // Dashboard siswa dengan data dari SiswaController
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::post('/siswa/update-profile', [SiswaController::class, 'updateProfile'])->name('siswa.updateProfile');
    Route::post('/siswa/approved', [TabunganController::class, 'approved'])->name('approved');
    // Proses update profile siswa
});
