<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Siswa;
use App\Models\Acara;
use App\Models\Approved;
use App\Http\Requests\TabunganRequest;
use App\Http\Requests\ApprovedRequest; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\TabunganImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class TabunganController extends Controller
{
    /**
     * Tampilkan daftar data tabungan.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $keyword = $request->input('keyword', '');
    
        // Mulai query dasar dengan filter (jika ada)
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
    
        // **Khusus Index:** Hanya ambil record dengan id maksimum per siswa (asumsi record terbaru memiliki id tertinggi)
        $query->whereIn('id', function($subquery) {
            $subquery->selectRaw('MAX(id)')
                     ->from('tabungans')
                     ->groupBy('name');
        });
    
        $tabungans = $query->paginate($perPage);
    
        // Perhitungan data lain (total, minggu, bulan, dsb) bisa tetap sama
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
    
        return view('tabungan.index', compact(
            'tabungans', 
            'totalMasukAll', 
            'totalMinggu', 
            'totalBulan',
            'countRpl1',
            'countRpl2'
        ));
    }
    
    

    /**
     * Tampilkan form untuk membuat data tabungan baru.
     */
    public function create()
    {
        $siswas = Siswa::all();
        $acaras = Acara::all();
        return view('tabungan.create', compact('siswas', 'acaras'));
    }
    
    public function edit(Tabungan $tabungan)
    {
        $siswas = Siswa::all();
        $acaras = Acara::all();
        return view('tabungan.edit', compact('tabungan', 'siswas', 'acaras'));
    }
    
    /**
     * Simpan data tabungan baru ke database.
     */
    public function store(TabunganRequest $request)
    {
        $data = $request->validated();
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                // Pastikan file dipindahkan ke folder 'public/uploads/transfer'
                $destination = public_path('uploads/transfer');
                $file->move($destination, $filename);
                $data['image'] = $filename;
            } else {
                return back()->with('error', 'File tidak valid.');
            }
        }
    
        // Hapus separator titik dan konversi ke integer
        if (isset($data['jumlah_bayar']) && isset($data['total_masuk'])) {
            $jumlahBayar = (int) str_replace('.', '', $data['jumlah_bayar']);
            $totalMasuk  = (int) str_replace('.', '', $data['total_masuk']);
            $data['tagihan'] = $jumlahBayar - $totalMasuk;
    
            // Simpan nilai bersih ke field yang sesuai
            $data['jumlah_bayar'] = $jumlahBayar;
            $data['total_masuk']  = $totalMasuk;
        }
    
        Tabungan::create($data);
    
        return redirect()->route('tabungan.index')
                         ->with('success', 'Data tabungan berhasil disimpan.');
    }
    
    /**
     * Tampilkan form untuk melakukan pembayaran (update data tabungan).
     */
public function bayar()
{
    // Ambil daftar siswa beserta tabungan terakhir
    $siswas = Siswa::all()->map(function ($s) {
        // Cari record tabungan terakhir untuk siswa berdasarkan nama
        $lastTabungan = Tabungan::where('name', $s->name)->orderBy('created_at', 'desc')->first();
        $s->lastTabungan = $lastTabungan;
        // Hitung total kumulatif pembayaran untuk siswa tersebut
        $s->cumulativeTotal = Tabungan::where('name', $s->name)->sum('total_masuk');
        return $s;
    });
    return view('tabungan.bayar', compact('siswas'));
}

    /**
     * Proses pembayaran dan simpan sebagai record baru.
     */
    public function prosesBayar(Request $request)
    {
        $request->validate([
            'tabungan_id'     => 'required|exists:tabungans,id',
            'tambahan'        => 'required|numeric|min:0',
            'tipe_pembayaran' => 'required|in:cash,transfer',
            'image'           => 'nullable'
        ]);
    
        // Ambil data pembayaran sebelumnya sebagai acuan
        $oldPayment = Tabungan::findOrFail($request->tabungan_id);
    
        // Hitung total kumulatif sebelum pembayaran ini
        $totalMasukSebelumnya = Tabungan::where('name', $oldPayment->name)->sum('total_masuk');
        
        // Hitung nilai total_masuk sebagai tambahan (individu) dan tagihan baru
        $newTotalMasuk = $request->tambahan; // Simpan sebagai nilai individu
        $newTotalKumulatif = $totalMasukSebelumnya + $newTotalMasuk;
        $newTagihan = $oldPayment->jumlah_bayar - $newTotalKumulatif;
    
        // Siapkan data untuk record pembayaran baru
        $data = [
            'nisn'           => $oldPayment->nisn,
            'name'           => $oldPayment->name,
            'status'         => $oldPayment->status,
            'kelas'          => $oldPayment->kelas,
            'walas'          => $oldPayment->walas,
            'gander'         => $oldPayment->gander,
            'no_telpon'      => $oldPayment->no_telpon,
            'nama_acara'     => $oldPayment->nama_acara,
            'tanggal_acara'  => $oldPayment->tanggal_acara,
            'jumlah_bayar'   => $oldPayment->jumlah_bayar, // total harus bayar tetap
            'total_masuk'    => $newTotalMasuk,  // simpan nilai individu
            'tagihan'        => $newTagihan,
            'tipe_pembayaran'=> $request->tipe_pembayaran,
        ];
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                // Pastikan file dipindahkan ke folder 'public/uploads/transfer'
                $destination = public_path('uploads/transfer');
                $file->move($destination, $filename);
                $data['image'] = $filename;
            } else {
                return back()->with('error', 'File tidak valid.');
            }
        }
        
    
    
        // Simpan record pembayaran baru
        Tabungan::create($data);
    
        return redirect()->route('tabungan.index')
                         ->with('success', 'Pembayaran berhasil diproses.');
    }
    
    /**
     * Perbarui data tabungan di database.
     */
    public function update(TabunganRequest $request, Tabungan $tabungan)
    {
        $data = $request->validated();

        if (isset($data['jumlah_bayar']) && isset($data['total_masuk'])) {
            $data['tagihan'] = $data['jumlah_bayar'] - $data['total_masuk'];
        }

        $tabungan->update($data);

        return redirect()->route('tabungan.index')
                         ->with('success', 'Data tabungan berhasil diupdate.');
    }

    /**
     * Hapus data tabungan dari database.
     */
    public function destroy(Tabungan $tabungan)
    {
        // Ambil identitas siswa (misalnya menggunakan 'name')
        $studentName = $tabungan->name;
        
        // Hapus semua data tabungan untuk siswa tersebut
        Tabungan::where('name', $studentName)->delete();
    
        return redirect()->route('tabungan.index')
                         ->with('success', 'Data tabungan dan seluruh riwayat pembayaran untuk siswa tersebut berhasil dihapus.');
    }
    
    public function destroyRiwayat($id)
{
    // Cari record berdasarkan id, jika tidak ditemukan akan menghasilkan 404
    $tabungan = Tabungan::findOrFail($id);
    
    // Hapus record tersebut
    $tabungan->delete();
    
    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Data tabungan berhasil dihapus.');
}


    public function downloadPDF(Request $request)
    {
        // Ambil data berdasarkan filter kelas (jika ada)
        $kelas = $request->input('kelas');

        // Query data tabungan
        $query = Tabungan::query();

        if ($kelas) {
            $query->whereHas('siswa', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        $tabungans = $query->get();

        // Data untuk PDF
        $data = [
            'tabungans' => $tabungans,
            'kelas' => $kelas ?: 'Semua Kelas', // Tampilkan "Semua Kelas" jika tidak ada filter
        ];

        // Generate PDF
        $pdf = Pdf::loadView('tabungan.pdf', $data);

        // Download PDF
        return $pdf->download('data_tabungan.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new TabunganImport, $request->file('file'));

        return redirect()->route('tabungan.index')
                         ->with('success', 'Data tabungan berhasil diimpor.');
    }
    public function riwayat(Request $request)
{
    $perPage = $request->input('perPage', 5);
    $keyword = $request->input('keyword', '');

    // Query untuk menampilkan seluruh data tanpa filter distinct
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

    $tabungans = $query->paginate($perPage);

    return view('tabungan.riwayat', compact('tabungans'));
}
// TabunganController.php
public function dashboardSiswa(Request $request)
{
    // Ambil siswa yang sedang login
    $siswa = auth()->user();
    
    // Ambil semua data tabungan siswa tersebut
    $tabungans = Tabungan::where('name', $siswa->name)
        ->orderBy('created_at', 'desc')
        ->get();

    // Hitung total tagihan dan pemasukan
    $totalTagihan = $siswa->lastTabungan->jumlah_bayar ?? 0;
    $totalPemasukan = $tabungans->sum('total_masuk');
    $statusPembayaran = ($totalPemasukan >= $totalTagihan) ? 'Lunas' : 'Belum Lunas';

    return view('siswa.dashboard', compact(
        'siswa',
        'tabungans',
        'totalTagihan',
        'totalPemasukan',
        'statusPembayaran'
    ));
}


public function approved(ApprovedRequest $request)
{

    
    $status = session('status');
    $user   = session('user');

    if (!$user) {
        return redirect('/')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
    }

    // Tetapkan $siswa dari $user
    $siswa = $user;

    // Ambil data yang telah tervalidasi dari request
    $data = $request->validated();

    // Jika terdapat file (bukti pembayaran) maka proses upload dan simpan nama file ke field 'image'
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        if ($file->isValid()) {
            $filename = time() . '_' . $file->getClientOriginalName();
            // Pastikan file dipindahkan ke folder 'public/uploads/transfer'
            $destination = public_path('uploads/transfer');
            $file->move($destination, $filename);
            $data['image'] = $filename;
        } else {
            return back()->with('error', 'File tidak valid.');
        }
    }

    // Jika field total_masuk atau tagihan tidak diisi, kita bisa menetapkan default (sesuaikan logika sesuai kebutuhan)
    $data['total_masuk'] = $data['total_masuk'] ?? 0;
    $data['tagihan'] = $data['tagihan'] ?? $data['jumlah_bayar'];

    // Simpan data ke dalam tabel approved
    Approved::create($data);

    return redirect()->route('siswa.dashboard')
                     ->with('success', 'permintaan pembayaran berhasil,tunggu untuk di setujui.');
}
public function approvedIndex()
{
    $approveds = Approved::orderBy('created_at', 'desc')->get();
    return view('tabungan.approved', compact('approveds'));
}

// Method untuk memproses data approve
public function processApproved($id)
{
    // Ambil data dari tabel approved berdasarkan id
    $approved = Approved::findOrFail($id);

    // Siapkan data untuk record baru di tabel tabungans
    $data = [
        'nisn'            => $approved->nisn,
        'name'            => $approved->name,
        'status'          => $approved->status,
        'kelas'           => $approved->kelas,
        'walas'           => $approved->walas,
        'image'           => $approved->image,
        'gander'          => $approved->gander,
        'no_telpon'       => $approved->no_telpon,
        'nama_acara'      => $approved->nama_acara,
        'tanggal_acara'   => $approved->tanggal_acara,
        'jumlah_bayar'    => $approved->jumlah_bayar,
        'total_masuk'     => $approved->total_masuk,
        'tagihan'         => $approved->tagihan,
        'tipe_pembayaran' => $approved->tipe_pembayaran,
    ];

    // Simpan data ke tabel tabungans
    Tabungan::create($data);

    // Opsional: Hapus data dari tabel approved setelah dipindahkan
    $approved->delete();

    return redirect()->back()->with('success', 'Data berhasil dipindahkan ke Tabungan.');
}
public function rejectApproved($id)
{
    // Ambil data approved berdasarkan id
    $approved = \App\Models\Approved::findOrFail($id);

    // Hapus data approved (menolak pembayaran)
    $approved->delete();

    return redirect()->back()->with('success', 'Pembayaran ditolak dan data dihapus.');
}
}
