<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Approved;
use App\Models\Tabungan;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Tampilkan dashboard siswa.
     */
    public function dashboard(Request $request)
    {
        // Ambil data siswa yang sedang login
        $status = session('status');
        $user   = session('user');
    
        if (!$user) {
            return redirect('/')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }
    
        $siswa = $user;
    
        // Query tabungan seperti yang sudah ada
        $query = Tabungan::where('name', $siswa->name);
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate   = $request->input('end_date');
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }
    
        $totalPemasukanAll = $query->sum('total_masuk');
        $queryForPaginate = clone $query;
        $perPage   = $request->input('perPage', 5);
        $tabungans = $queryForPaginate->orderBy('created_at', 'asc')->paginate($perPage);
    
        $latestTabungan = Tabungan::where('name', $siswa->name)
            ->orderBy('created_at', 'desc')
            ->first();
    
        $totalTagihan = $siswa->lastTabungan->jumlah_bayar ?? 0;
        $statusPembayaran = ($totalPemasukanAll >= $totalTagihan) ? 'Lunas' : 'Belum Lunas';
    
        $tabungans->appends($request->all());
    
        // Tambahkan query untuk mengambil data pembayaran yang menunggu persetujuan
        $approvedPayments = \DB::table('approved')
        ->where('name', $siswa->name)
        ->get();
    
        return view('siswa.dashboard', compact(
            'siswa', 
            'tabungans', 
            'totalTagihan', 
            'totalPemasukanAll',  
            'statusPembayaran',
            'latestTabungan',
            'approvedPayments' // Kirimkan data ke view
        ));
    }

    /**
     * Proses pembaruan data profil siswa.
     */
    public function updateProfile(Request $request)
    {
        // Validasi input dari form
        $data = $request->validate([
            'id'          => 'required', // NISN
            'namaLengkap' => 'required',
            'kelas'       => 'required',
            'walas'       => 'required',
            'gander'      => 'required|in:male,female',
            'no_telpon'   => 'nullable|string'
        ]);

        // Ambil data siswa yang sedang login
        $status = session('status');
        $user   = session('user');

        if (!$user) {
            return redirect('/')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Tetapkan $siswa dari $user
        $siswa = $user;

        // Update data pada tabel siswas
        $siswa->id     = $data['id']; // NISN
        $siswa->name   = $data['namaLengkap'];
        $siswa->kelas  = $data['kelas'];
        $siswa->walas  = $data['walas'];
        $siswa->gander = $data['gander'];

        // Handle upload foto profile
        if ($request->hasFile('fotoProfile')) {
            $file = $request->file('fotoProfile');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profile', $filename, 'public');
                $siswa->image = $path;
            }
        }
        $siswa->save();

        // Update data pada tabel tabungans (misalnya menggunakan relasi lastTabungan)
        $tabungan = $siswa->lastTabungan;
        if ($tabungan) {
            $tabungan->no_telpon = $data['no_telpon'];
            $tabungan->nisn      = $data['id'];
            $tabungan->name      = $data['namaLengkap'];
            $tabungan->kelas     = $data['kelas'];
            $tabungan->walas     = $data['walas'];
            $tabungan->gander    = $data['gander'];
            if (isset($siswa->image)) {
                $tabungan->image = $siswa->image;
            }
            $tabungan->save();
        } else {
            // Jika record tabungan belum ada, buat record baru minimal
            Tabungan::create([
                'nisn'      => $data['id'],
                'name'      => $data['namaLengkap'],
                'kelas'     => $data['kelas'],
                'walas'     => $data['walas'],
                'gander'    => $data['gander'],
                'no_telpon' => $data['no_telpon'],
            ]);
        }

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }
}
