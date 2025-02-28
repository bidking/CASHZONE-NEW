<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Tabungan;
use App\Http\Requests\TabunganRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\TabunganImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $status = session('status');
        $user   = session('user');

        if (!$user) {
            return redirect('/')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Misalnya, guru yang login (Joko) mengajar kelas 12 rpl 1.
        // Jika properti kelas tersimpan di $user, Anda bisa menggunakan:
        $guruKelas = $user->kelas ?? '12 rpl 1';

        // Data untuk card
        $totalPelajar    = Siswa::count();
        $totalJumlahBayar = Tabungan::sum('total_masuk');
        $barChartData    = Tabungan::selectRaw('MONTH(created_at) as month, SUM(total_masuk) as total')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();
        $chartLabels     = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartValues     = array_fill(0, 12, 0);
        foreach ($barChartData as $data) {
            $monthIndex = $data->month - 1;
            $chartValues[$monthIndex] = $data->total;
        }
        $maleCount   = Siswa::where('gander', 'male')->count();
        $femaleCount = Siswa::where('gander', 'female')->count();

        // Pencarian, pagination, dan filter tambahan
        $perPage = $request->input('perPage', 5);
        $keyword = $request->input('keyword', '');
    
        $query = Tabungan::query();
    
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('total_masuk', 'like', "%$keyword%")
                  ->orWhere('tagihan', 'like', "%$keyword%");
            });
        }
    
        if ($request->filled('tipe_pembayaran')) {
            $query->where('tipe_pembayaran', $request->input('tipe_pembayaran'));
        }
    
        // **Filter khusus untuk guru:** Hanya ambil data siswa dari kelas yang diajarkan
        $query->whereHas('siswa', function ($q) use ($guruKelas) {
            $q->where('kelas', $guruKelas);
        });
    
        // Hanya ambil record terbaru per siswa (jika diperlukan)
        $query->whereIn('id', function($subquery) {
            $subquery->selectRaw('MAX(id)')
                     ->from('tabungans')
                     ->groupBy('name');
        });
    
        $tabungans = $query->paginate($perPage);
    
        $totalMasukAll = Tabungan::all()->sum('total_masuk');
        $totalMinggu   = Tabungan::whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->sum('total_masuk');
        $totalBulan    = Tabungan::whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->sum('total_masuk');
        
        $countRpl1 = Siswa::where('kelas', '12 rpl 1')->count();
        $countRpl2 = Siswa::where('kelas', '12 rpl 2')->count();
    
        return view('guru.dashboard', compact(
            'user',
            'status',
            'totalPelajar',
            'totalJumlahBayar',
            'chartLabels',
            'chartValues',
            'maleCount',
            'femaleCount',
            'tabungans', 
            'totalMasukAll', 
            'totalMinggu', 
            'totalBulan',
            'countRpl1',
            'countRpl2'
        ));
    }
}
