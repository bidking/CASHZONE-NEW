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

        $guruKelas = $user->kelas ?? '12 rpl 1';

        if (!$user || !$user->kelas) {
            return redirect('/')->withErrors(['error' => 'Data kelas tidak ditemukan.']);
        }

        // Data untuk card
        $totalPelajar = Siswa::where('kelas', $user->kelas)->count();
        $totalJumlahBayar = Tabungan::sum('total_masuk');
        $barChartData = Tabungan::selectRaw('MONTH(created_at) as month, SUM(total_masuk) as total')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartValues = array_fill(0, 12, 0);
        foreach ($barChartData as $data) {
            $monthIndex = $data->month - 1;
            $chartValues[$monthIndex] = $data->total;
        }
        $maleCount = Siswa::where('gander', 'male')->count();
        $femaleCount = Siswa::where('gander', 'female')->count();

        // Pencarian, pagination, dan filter tambahan
        $perPage = $request->input('perPage', 5);
        $keyword = $request->input('keyword', '');
        $sortBy = $request->input('sortBy', 'name');
        $order = $request->input('order', 'asc');

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

        $query->whereHas('siswa', function ($q) use ($guruKelas) {
            $q->where('kelas', $guruKelas);
        });

        $query->whereIn('id', function($subquery) {
            $subquery->selectRaw('MAX(id)')
                     ->from('tabungans')
                     ->groupBy('name');
        });
        

        $query->orderBy($sortBy, $order);

        $tabungans = $query->paginate($perPage);

        $totalMasukAll = Tabungan::all()->sum('total_masuk');
        $totalMinggu = Tabungan::whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->sum('total_masuk');
        $totalBulan = Tabungan::whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->sum('total_masuk');

        $countRpl1 = Siswa::where('kelas', '12 rpl 1')->count();
        $countRpl2 = Siswa::where('kelas', '12 rpl 2')->count();

        // Jika di view kamu ingin menggunakan variabel $guru, kamu bisa mengassign seperti berikut:
        $guru = $user; // karena data guru tersimpan di session sebagai $user

        return view('guru.dashboard', compact(
            'user',
            'guru',
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
            'countRpl2',
            'perPage',
            'keyword',
            'sortBy',
            'order'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kelas' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        $guru = Guru::findOrFail($request->id);
    
        $guru->name  = $request->name;
        $guru->email = $request->email;
        $guru->kelas = $request->kelas;
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $guru->image = $filename;
        }
    
        $guru->save();
    
        // Perbarui data guru di session agar tampilannya langsung terupdate
        session()->put('user', $guru);
    
        return redirect()->back()->with('success', 'Profile guru berhasil diperbarui.');
    }
    
}
