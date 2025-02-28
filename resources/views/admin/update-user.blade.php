@extends('layout.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <form action="{{ route('update', ['id' => $user->id, 'status' => $status]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @if ($status === 'admin')
        <!-- Admin Form -->
        <div id="adminFields">
            <div class="row">
                <h4>Form Admin</h4>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
    <input type="password" class="form-control" name="password" id="password" 
           placeholder="Leave empty to keep current password" 
           value="{{ old('password') }}">
    @error('password')
        <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
    @enderror
</div>


</div>

                    <div class="col-md-6">
                     <div class="mb-3">
                        <label for="image" class="form-label">Profile picture<span class="text-danger">*</span></label>
                        <div class="update-profile-pic">
                          <input type="file" class="form-control" name="image" id="image" width="50%">
                        </div>

                    </div>
                </div>
                    <div class="col-md-6">
                     <div class="mb-3">
              <img src="{{ $user->getImageURL() }}" alt="profile-image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
                       <p>profil lama</p>
                    </div>
                </div>

               <div class="col-md-6 d-none">

<div class="mb-3">
<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
<select class="form-control" name="status" id="status">
<!-- <option value="">Pilih Status</option> -->
<option value="admin">Admin</option>

</select>
@error('status')
<span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
@enderror
</div>
</div>

            </div>
        </div>
    @elseif ($status === 'guru')
        <!-- Guru Form -->
        <div id="guruFields">
            <div class="row">
                <h5>Form Guru</h5>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
    <div class="mb-3">
        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Leave empty to keep current password">
        @error('password')
            <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
        @enderror
    </div>
</div>
                </div>
            </div>
        </div>
    @elseif ($status === 'siswa')
        <!-- Siswa Form -->
        <div id="siswaFields">
            <div class="row">
                <h5>Form Siswa</h5>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
    <input type="password" class="form-control" name="password" id="password" 
           placeholder="Leave empty to keep current password" 
           value="{{ old('password') ?: '' }}">
    @error('password')
        <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
    @enderror
</div>

</div>
            </div>
        </div>
    @endif

    <button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>


@endsection
