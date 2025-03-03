@extends('layout.app')
@section('title', 'Create User')

@section('content')
<style>
    /* Custom Styles */
    .register-container {
        width: 100%;
        background: #1e1e1e;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .illustration {
        width: 100%;
        margin-bottom: 20px;
    }

    .illustration img {
        width: 100%;
    }

    .form-section {
        width: 100%;
    }

    .btn-register {
        background-color: #0676ea;
        color: #fff;
    }

    .btn-register:hover {
        background-color: #70777c;
        color: #fff;
    }

    .form-control {
        background-color: #333;
        color: #fff;
        border: 1px solid #555;
    }

    .form-control::placeholder {
        color: #bbb;
    }

    .social-links a {
        margin: 0 10px;
        color: #6a0dad;
        text-decoration: none;
    }

    .btn-active {
        background-color: blue !important;
        color: white !important;
    }

    /* Media Queries for Mobile */
    @media (min-width: 768px) {
        .register-container {
            flex-direction: row;
            padding: 30px;
        }

        .illustration {
            width: 63%;
            margin-right: 50px;
            margin-left: -50px;
            margin-bottom: 0;
        }

        .form-section {
            width: 55%;
        }
    }
    .guide{
        display:none;
    }
</style>

<div class="register-container">
    <div class="illustration">
        <img src="{{asset('assets/foto/ilus_4.png')}}" alt="Illustration">
    </div>

    <div class="form-section">
        <h2 class="text-center">Create account</h2>
        <form enctype="multipart/form-data" action="{{ route('new-create') }}" method="POST" id="userForm">
            @csrf
            <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type', 'admin') }}">

            <!-- User Type Buttons -->
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" data-user-type="admin" onclick="setUserType('admin')">Admin</button>
                <button type="button" class="btn btn-secondary" data-user-type="guru" onclick="setUserType('guru')">Guru</button>
                <button type="button" class="btn btn-secondary" data-user-type="siswa" onclick="setUserType('siswa')">Siswa</button>
            </div>

            <!-- Admin Fields -->
            @if(old('user_type', 'admin') === 'admin')
            <div id="adminFields">
                <div class="row">
                    <h4>form admmin</h4>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id" class="form-label">Full id <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="id" id="id" value="{{ old('id') }}">
                            @error('id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Picture <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="image">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Pilih Status</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('status')
                                <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @elseif(old('user_type', 'guru') === 'guru')
                <!-- Guru Fields -->
                <div id="guruFields">
                    <div class="row">
                        <h5>form guru</h5>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id" class="form-label">Full id <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="id" id="id" value="{{ old('id') }}">
                                @error('id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Picture <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="image" id="image">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Pilih Status</option>
                                    <option value="guru">Guru</option>
                                </select>
                                @error('status')
                                    <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kelas" class="form-label">kelas <span class="text-danger">*</span></label>
                                <select class="form-control" name="kelas" id="kelas">
                                    <option value="">Pilih kelas</option>
                                    <option value="12 rpl 1">12 rpl 1</option>
                                    <option value="12 rpl 2">12 rpl 2</option>
                                </select>
                                @error('kelas')
                                    <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(old('user_type', 'siswa') === 'siswa')
                <!-- Siswa Fields -->
                <div id="siswaFields">
                    <div class="row">
                        <h5>Form Siswa</h5>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id" class="form-label">Full id <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="id" id="id" value="{{ old('id') }}">
                                @error('id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">full name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">password  <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" required>
                                    <option value="siswa" {{ old('status') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                </select>
                                @error('status')
                                    <span class="text-danger d-block mt-2 ft-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="walas" class="form-label">Walas <span class="text-danger">*</span></label>
                                <select class="form-control" name="walas" id="walas" required>
                                    <option value="">Pilih Walas</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}" data-kelas="{{ $guru->kelas }}">
                                            {{ $guru->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('walas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kelas" id="kelas" readonly>
                                @error('kelas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Picture <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="image" id="image">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gander" class="form-label">gander <span class="text-danger">*</span></label>
                                <select class="form-control" name="gander" id="gander">
                                    <option value="">Pilih gander</option>
                                    <option value="male" {{ old('gander') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gander') === 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gander')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-secondary mt-2">add acount</button>
            <a href="{{ route('admin.users.list') }}" class="btn btn-secondary mt-2">Kembali</a>
        </form>
    </div>
</div>

<script>
    function setUserType(userType) {
        // Set hidden input untuk user_type
        document.getElementById('user_type').value = userType;

        // Hapus kelas aktif dari semua tombol
        const buttons = document.querySelectorAll('[data-user-type]');
        buttons.forEach(button => button.classList.remove('btn-active'));

        // Tambahkan kelas aktif ke tombol yang dipilih
        const activeButton = document.querySelector(`[data-user-type="${userType}"]`);
        if (activeButton) {
            activeButton.classList.add('btn-active');
        }

        // Submit form (opsional, jika diperlukan langsung submit)
        document.getElementById('userForm').submit();
    }

    // Atur tombol aktif saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const userType = document.getElementById('user_type').value;
        const activeButton = document.querySelector(`[data-user-type="${userType}"]`);
        if (activeButton) {
            activeButton.classList.add('btn-active');
        }
    });

    document.getElementById('walas').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const kelas = selectedOption.getAttribute('data-kelas');
        document.getElementById('kelas').value = kelas || '';
    });
</script>

@endsection