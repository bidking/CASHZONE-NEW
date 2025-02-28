<?php
namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    // Menampilkan semua acara dengan filter, pencarian, dan pagination
    public function index(Request $request)
    {
        // Mulai query
        $query = Acara::query();

        if ($request->filled('search')) {
            $query->where('nama_acara', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('order_by')) {
            $sort = $request->filled('sort') ? $request->sort : 'asc';
            $query->orderBy($request->order_by, $sort);
        }

        $perPage = $request->get('per_page', 4);
        $acaras = $query->paginate($perPage);
        
        return view('acara.acara', compact('acaras'));
    }

    // Menampilkan form tambah acara
    public function create()
    {
        return view('acara.create');
    }

    // Menyimpan acara baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_acara'    => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'jumlah_bayar'  => 'required',
        ]);

        // Menghilangkan separator ribuan (titik) dan mengonversi ke tipe integer
        $validated['jumlah_bayar'] = (int) str_replace('.', '', $validated['jumlah_bayar']);

        Acara::create($validated);

        return redirect()->route('acara.acara')
                         ->with('success', 'Acara berhasil ditambahkan!');
    }

    // Menampilkan form edit acara berdasarkan ID
    public function edit($id)
    {
        $acara = Acara::findOrFail($id);
        return view('acara.edit', compact('acara'));
    }

    // Mengupdate acara berdasarkan ID
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_acara'    => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'jumlah_bayar'  => 'required',
        ]);

        $validated['jumlah_bayar'] = (int) str_replace('.', '', $validated['jumlah_bayar']);

        $acara = Acara::findOrFail($id);
        $acara->update($validated);

        return redirect()->route('acara.acara')
                         ->with('success', 'Acara berhasil diperbarui!');
    }

    // Menghapus acara berdasarkan ID
    public function destroy($id)
    {
        $acara = Acara::findOrFail($id);
        $acara->delete();
        
        return redirect()->route('acara.acara')
                         ->with('success', 'Acara berhasil dihapus!');
    }
}
