@extends('layout.app')
@section('title', 'Users list')

@section('content')
<style>
    .btn.active {
    background-color: #0d6efd; /* Warna tombol aktif */
    color: white;
    border: 1px solid #0d6efd;
}

</style>
<div class="card py-4 px-2">
    <div class="container mt-3">
        <div class="d-flex g-3">
            <h3 class="text-primary py-2">
                <u><b>Daftar User</b></u>
            </h3>	  
            @if (session()->has("success")) 
            <div class="alert alert-success alert-dismissible ms-auto fade show d-flex align-items-center justify-content-center" 
                style="width: fit-content !important; padding-top: 0.5em !important;padding-bottom: 0.5em !important;" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding-bottom: 5px !important"></button>
            </div>	
            @endif
        </div>
        <br>
        <div class="d-flex g-3">
            <a href="{{ route('new.user') }}" class="btn btn-dark d-flex align-items-center justify-content-center btn-md">
                <i class='bx bxs-user-plus me-2 fs-4'></i>Create User
            </a>
        </div>
        <br>
        <div class="d-flex justify-content-center mb-3">
    <a href="{{ route('users.list', ['status' => 'admin']) }}" class="btn btn-secondary mx-1 {{ $status === 'admin' ? 'active' : '' }}">Admin</a>
    <a href="{{ route('users.list', ['status' => 'guru']) }}" class="btn btn-secondary mx-1 {{ $status === 'guru' ? 'active' : '' }}">Guru</a>
    <a href="{{ route('users.list', ['status' => 'siswa']) }}" class="btn btn-secondary mx-1 {{ $status === 'siswa' ? 'active' : '' }}">Siswa</a>
</div>

        <!-- Tabel Data -->
        <div class="scroll-box mt-4">
            <table class="table table-striped">
            <thead>
    <tr>
        <th scope="col" class="col-1">#</th>
        <th scope="col" class="col-1">Profile</th>
        @if ($status === 'admin')
            <th scope="col" class="col-3">id</th>
            <th scope="col" class="col-3">Name</th>
            <th scope="col" class="col-4">Email</th>
            <th scope="col" class="col-4">status</th>
        @endif
        @if ($status === 'guru')
        <th scope="col" class="col-3">id</th>
            <th scope="col" class="col-3">Name</th>
            <th scope="col" class="col-4">Email</th>
            <th scope="col" class="col-4">mengajar</th>
            <th scope="col" class="col-4">status</th>

        @endif
        @if ($status === 'siswa')
            <th scope="col" class="col-2">id</th>
            <th scope="col" class="col-2">nama</th>
            <th scope="col" class="col-2">kelas</th>
            <th scope="col" class="col-2">status</th>
            <th scope="col" class="col-2">Walas</th>
            <th scope="col" class="col-2">gander</th>
            
        @endif
        <th scope="col" class="col-2 text-center">Actions</th>
    </tr>
</thead>

<tbody>
    @forelse ($users as $user)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
                <div class="user">
                    <img src="{{ $user->getImageURL() }}" alt="profile picture" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                </div>
            </td>
          
                
            @if ($status === 'admin')
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status }}</td>
            @elseif ($status === 'guru')
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->kelas }}</td>
                <td>{{ $user->status }}</td>

            @endif

            @if ($status === 'siswa')
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->status }}</td>
                <td>{{ $user->kelas }}</td>
                <td>{{ $user->walas }}</td>
                <td>{{ $user->gander }}</td>
               


            @endif

            <td>
            <div class="action-btns">
                    <a href="{{ route('edit', $user->id) }}" class="btn btn-dark mx-2">
                        <i class='bx bxs-edit fs-5'></i>
                    </a>
                    <form action="{{ route('delete', ['id' => $user->id, 'status' => $status]) }}" method="post">
    @csrf
    <button class="btn btn-danger mx-2">
        <i class='bx bxs-trash-alt fs-5'></i>
    </button>
</form>

                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">No data available.</td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>

        <div class="mt-2">
            {{ $users->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection
