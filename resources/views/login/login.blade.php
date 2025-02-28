<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Kunjungan Industri</title>
    <link rel="icon" href="{{ asset('assets/foto/logo.png') }}" />
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        background: linear-gradient(to right, #1e1e2d, #151521);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
      }
      .container {
        display: flex;
        flex-direction: column; /* Default untuk mobile */
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 1250px; /* Batas maksimal untuk PC */
      }
      .image-section {
        background: url('{{ asset('assets/foto/mountain_3.jpg') }}') no-repeat center;
        background-size: cover;
        height: 300px; /* Ukuran lebih kecil untuk mobile */
        width: 100%; /* Lebar penuh pada mobile */
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .form-section {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%; /* Lebar penuh pada mobile */
      }
      .form-section .logo {
        text-align: center;
        margin-top: -40px;
      }
      .form-section h2 {
        color: #005aa7;
        font-weight: bold;
        font-size: 40px;
        text-align: center;
      }
      .btn-custom {
        background: #005aa7;
        color: white;
      }
      .btn-custom:hover {
        background: #003973;
        color: white;
      }

      /* Media Query untuk Tablet dan PC (min-width: 768px) */
      @media (min-width: 768px) {
        .container {
          flex-direction: row; /* Berdampingan untuk PC */
          height: 600px; /* Tinggi tetap seperti desain PC */
        }
        .image-section {
          width: 700px; /* Lebar tetap seperti desain PC */
          height: 100%; /* Mengisi tinggi kontainer */
          margin-left: -20px;
        }
        .form-section {
          width: 50%; /* Lebar form pada PC */
          padding: 40px;
          margin-left: 10px;
        }
        .form-section h2 {
          font-size: 36px;
        }
      }

      /* Media Query untuk Mobile (max-width: 767px) */
      @media (max-width: 767px) {
        .image-section {
          display: none; /* Sembunyikan gambar pada mobile */
          height: 200px; /* Ukuran gambar lebih kecil pada mobile */
        }
        
        .form-section {
          height: 100vh; /* Tinggi penuh pada mobile */
          padding: 10px; /* Padding lebih kecil pada mobile */
        }
        .form-section h2 {
          font-size: 28px; /* Judul lebih kecil pada mobile */
        }
        .form-section .logo img {
          max-width: 50px; /* Logo lebih kecil pada mobile */
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="image-section"></div>
      <div class="form-section">
        <!-- Logo -->
        <div class="logo">
          <img src="{{ asset('assets/foto/logo_6.png') }}" alt="Logo" style="max-width: 60px" />
        </div>
        <h2>LOGIN!</h2>
        <p class="text-center text-muted">
          Selamat Datang Di Website Kunjungan Industri.
        </p>
        <form action="{{ route('login.post') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="id" class="form-label">ID/NISN</label>
            <input
              type="text"
              name="id"
              class="form-control"
              id="id"
              placeholder="Enter ID/NISN"
              required
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input
                type="password"
                name="password"
                class="form-control"
                id="password"
                placeholder="Enter password"
                required
              />
              <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">👁</span>
            </div>
          </div>
          <div class="mb-3 form-check">
            <input
              type="checkbox"
              class="form-check-input"
              id="remember"
              name="remember"
            />
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
          <button type="submit" class="btn btn-custom w-100">NEXT →</button>
        </form>
        @if ($errors->any())
          <p style="color: red;">{{ $errors->first('error') }}</p>
        @endif
      </div>
    </div>

    <script>
      function togglePassword() {
        const passwordInput = document.getElementById('password');
        const currentType = passwordInput.getAttribute('type');
        passwordInput.setAttribute('type', currentType === 'password' ? 'text' : 'password');
      }
    </script>
  </body>
</html>
