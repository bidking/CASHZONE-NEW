<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Tabungan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data status dan user dari session
        $status = session('status');
        $user = session('user');
    
        if (!$user) {
            return redirect('/')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }
    
        // Card Pelajar: Hitung seluruh siswa
        $totalPelajar = Siswa::count();
    
        // Card Jumlah Bayar: Jumlahkan kolom total_masuk pada tabel tabungans
        $totalJumlahBayar = Tabungan::sum('total_masuk');
    
        // Bar Chart: Data transaksi per bulan
        $barChartData = Tabungan::selectRaw('MONTH(created_at) as month, SUM(total_masuk) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        // Siapkan data untuk chart
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartValues = array_fill(0, 12, 0); // Inisialisasi array dengan 12 bulan, nilai awal 0
    
        foreach ($barChartData as $data) {
            $monthIndex = $data->month - 1; // Bulan dimulai dari 1 (Jan), array dimulai dari 0
            $chartValues[$monthIndex] = $data->total;
        }
    
        // Doughnut Chart: Distribusi jenis kelamin siswa
        $maleCount   = Siswa::where('gander', 'male')->count();
        $femaleCount = Siswa::where('gander', 'female')->count();
    
        // Kirim data ke view
        return view('admin.dashboard', compact(
            'user',
            'status',
            'totalPelajar',
            'totalJumlahBayar',
            'chartLabels',
            'chartValues',
            'maleCount',
            'femaleCount'
        ));
    }
}