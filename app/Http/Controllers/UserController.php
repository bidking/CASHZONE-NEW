<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Menampilkan daftar pengguna berdasarkan status
//    public function index(Request $request)
// {
//     $status = $request->get('status', 'admin');
//     $query = match ($status) {
//         'admin' => Admin::query(),
//         'guru' => Guru::query(),
//         'siswa' => Siswa::query(),
//         default => Admin::query(),
//     };
//     $gurus = Guru::all(); // Ambil semua data guru
//     $users = $query->paginate(5);
//     $maleCount = Siswa::where('gander', 'male')->count();
//     $femaleCount = Siswa::where('gander', 'female')->count();
//     return view('admin.users-list', compact('users', 'status', 'maleCount', 'femaleCount', 'gurus'));
// }
public function index(Request $request)
{
    // Ambil status dengan default 'admin' jika tidak ada status
    $status = $request->get('status', 'admin');
    
    // Ambil sort, perPage, dan filter lainnya
    $sortOption = $request->get('sort', 'asc');
    $perPage = $request->get('perPage', 3);
    $search = $request->get('search'); // Keyword pencarian
    $filterBy = $request->get('filterBy', 'Nama Lengkap'); // Filter berdasarkan nama atau identitas

    // Tentukan query berdasarkan status
    $query = match ($status) {
        'admin' => Admin::query(),
        'guru' => Guru::query(),
        'siswa' => Siswa::query(),
        default => Admin::query(),
    };

    // Terapkan filter pencarian berdasarkan pilihan filterBy
    if ($search) {
        if ($filterBy == 'Nama Lengkap') {
            $query->where('name', 'like', '%' . $search . '%');
        } elseif ($filterBy == 'Nomor Identitas') {
            $query->where('id', 'like', '%' . $search . '%');
        }
    }

    // Terapkan sorting (asc atau desc) berdasarkan permintaan
    $query->orderBy('name', $sortOption);

    // Ambil data sesuai dengan status dan pagination
    $users = $query->paginate($perPage);
    
    // Data tambahan
    $gurus = Guru::all(); // Ambil semua data guru
    $maleCount = Siswa::where('gander', 'male')->count();
    $femaleCount = Siswa::where('gander', 'female')->count();

    $acaras = \App\Models\Acara::all();
    return view('admin.users-list', compact('users', 'status', 'maleCount', 'femaleCount', 'gurus', 'filterBy', 'search','acaras'));
}


    // Menampilkan form untuk membuat pengguna baru
    public function create(Request $request)
{
    $status = $request->get('status', 'siswa'); 

    // Ambil data guru
    $gurus = Guru::all(['id', 'name', 'kelas']); 

    return view('admin.create-user', compact('status', 'gurus'));
}


    // Menyimpan data pengguna baru
    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();
        switch ($validated['status']) {
            case 'admin':
                if (Admin::where('id', $validated['id'])->exists()) {
                    return redirect()->back()->withErrors(['id' => 'ID sudah terdaftar untuk admin.']);
                }
                if (Admin::where('email', $validated['email'])->exists()) {
                    return redirect()->back()->withErrors(['email' => 'Email sudah terdaftar untuk admin.']);
                }
                break;
            case 'guru':
                if (Guru::where('id', $validated['id'])->exists()) {
                    return redirect()->back()->withErrors(['id' => 'id sudah terdaftar untuk guru.']);
                }
                break;
            case 'siswa':
                if (Siswa::where('id', $validated['id'])->exists()) {
                    return redirect()->back()->withErrors(['id' => 'id sudah terdaftar untuk siswa.']);
                }
                break;
        }
    
        // Simpan gambar profil jika ada
        if ($request->has('image')) {
            $imagePath = $request->file('image')->store('profile', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = null;
        }
        // $validated['tagihan'] = intval($validated['tagihan']);
        // $validated['jumlah_bayar'] = intval($validated['jumlah_bayar'] ?? 0);
        // $validated['total_bayar'] = intval($validated['total_bayar'] ?? 0);
        // Menyimpan data ke tabel yang sesuai berdasarkan status
        switch ($validated['status']) {
            case 'admin':
                Admin::create([
                    'id' => $validated['id'],
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'image' => $validated['image'],
                    'status' => $validated['status'],

                ]);
                break;
            case 'guru':
                Guru::create([
                    'id' => $validated['id'],
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'image' => $validated['image'],
                    'status' => $validated['status'],
                    'kelas' => $validated['kelas'],

                ]);
                break;
                case 'siswa':
                    $guru = Guru::find($validated['walas']);
                    if (!$guru) {
                        return redirect()->back()->withErrors(['walas' => 'Wali kelas tidak ditemukan.']);
                    }
                    Siswa::create([
                        'id' => $validated['id'],
                        'name' => $validated['name'],
                        'password' => Hash::make($validated['password']),
                        'status' => $validated['status'],
                        'kelas' => $validated['kelas'],
                        'walas' => $guru->name, // Simpan nama wali kelas ke database
                        'image' => $validated['image'],
                        'gander' => $validated['gander'],
                    ]);
                    break;
                
        }
    
      // Redirect ke daftar pengguna dengan status yang sesuai
    return redirect()->route('admin.users.list', ['status' => $validated['status']])
    ->with('success', 'User created successfully!');
    }
    

    // Menampilkan form untuk mengedit pengguna
    public function edit($id, $status)
    {
        $user = match ($status) {
            'admin' => Admin::find($id),
            'guru' => Guru::find($id),
            'siswa' => Siswa::find($id),
            default => null,
        };
        
        $gurus = Guru::all(); // Ambil semua data guru
    
        if (!$user) {
            return redirect()->route('admin.users.list')->with('error', 'User tidak ditemukan.');
        }
    
        return view('admin.update-user', [
            'user' => $user,
            'status' => $status,
            'gurus' => $gurus // Pastikan $gurus dikirim
        ]);
    }
    

    public function update(UpdateUserRequest $request, $id, $status)
    {
        $validated = $request->validated();
        $gurus = Guru::all();
        
        // Cari data pengguna berdasarkan status
        $user = match ($validated['status']) {
            'admin' => Admin::findOrFail($id),
            'guru' => Guru::findOrFail($id),
            'siswa' => Siswa::findOrFail($id),
            default => null,
        };
    
        // Jika pengguna tidak ditemukan, kembalikan ke daftar pengguna
        if (!$user) {
            return redirect()->route('admin.users.list')->with('error', 'User tidak ditemukan.');
        }
    
        // Jika password tidak kosong, update password
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            $validated['password'] = $user->password;
        }
    
        // Periksa apakah status 'siswa' dan walas ada dalam request
        if ($status === 'siswa' && isset($validated['walas'])) {
            $user->walas = $validated['walas'];
            $user->kelas = Guru::where('id', $validated['walas'])->value('kelas');
        }
    
        // Update data selain password
        $user->update($validated);
    
        // Jika ada gambar baru, simpan dan hapus gambar lama
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
    
            $imagePath = $request->file('image')->store('profile', 'public');
            $validated['image'] = $imagePath;
            $user->image = $validated['image'];
            $user->save();
        }
    
        // Redirect ke daftar pengguna dengan status yang benar
        return redirect()->route('admin.users.list', ['status' => $status])->with('success', 'User updated successfully!');
    }
    
    // Menghapus pengguna
    public function delete($id)
    {
        $status = request()->get('status');
        if (!$status) {
            return redirect()->route('admin.users.list')->with('error', 'Status tidak ditemukan.');
        }
    
        switch ($status) {
            case 'admin':
                $user = Admin::findOrFail($id);
                break;
            case 'guru':
                $user = Guru::findOrFail($id);
                // Kosongkan nama wali kelas pada siswa-siswa yang terkait
                Siswa::where('walas', $user->name)->update(['walas' => 'WALI KELAS TIDAK DITEMUKAN']);

                break;
            case 'siswa':
                $user = Siswa::findOrFail($id);
                break;
            default:
                return redirect()->route('admin.users.list')->with('error', 'Status tidak valid.');
        }
    
        $user->delete();
    
        return redirect()->route('admin.users.list', ['status' => $status])->with('success', 'User deleted successfully!');
    }
    
    
    
    // app/Http/Controllers/UserController.php

public function fetchUsers(Request $request)
{
    $status = $request->get('status', 'admin');
    $query = match ($status) {
        'admin' => Admin::query(),
        'guru' => Guru::query(),
        'siswa' => Siswa::query(),
        default => Admin::query(),
    };

    $users = $query->paginate(5);

    return response()->json([
        'users' => $users,
        'status' => $status,
    ]);
}

public function downloadExcel(Request $request)
{
    $status     = $request->get('status', 'siswa');
    $sortOption = strtolower($request->get('sort') ?: 'asc');
    if (!in_array($sortOption, ['asc', 'desc'])) {
        $sortOption = 'asc';
    }
    $search   = $request->get('search');
    $filterBy = $request->get('filterBy', 'Nama Lengkap');
    $acaraId  = $request->get('acara_id'); // Ambil ID acara yang dipilih

    // Query berdasarkan status
    $query = match ($status) {
        'admin' => \App\Models\Admin::query(),
        'guru'  => \App\Models\Guru::query(),
        'siswa' => \App\Models\Siswa::query(),
        default => \App\Models\Admin::query(),
    };

    // Terapkan filter pencarian jika ada
    if ($search) {
        if ($filterBy == 'Nama Lengkap') {
            $query->where('name', 'like', '%' . $search . '%');
        } elseif ($filterBy == 'Nomor Identitas') {
            $query->where('id', 'like', '%' . $search . '%');
        }
    }

    // Terapkan sorting dengan nilai valid
    $query->orderBy('name', $sortOption);

    // Ambil seluruh data user sesuai kriteria
    $users = $query->get();

    // Ambil objek Acara berdasarkan ID yang dipilih
    if ($acaraId) {
        $acara = \App\Models\Acara::find($acaraId);
    } else {
        $acara = null; // Jika tidak ada acara yang dipilih
    }

    // Kirim objek Acara ke export class (bukan hanya nama acara)
    return Excel::download(new \App\Exports\UsersExport($users, $acara), 'users.xlsx');
}



}
