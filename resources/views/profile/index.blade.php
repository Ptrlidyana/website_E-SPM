<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    body {
      margin: 0;
      /* Hapus margin dari body */
      padding: 0;
      /* Hapus padding dari body */
      background-color: #f8f9fa;
      /* Menambahkan latar belakang */
      color: #2e323c;
      height: 100%;
    }

    .container {
      margin-top: 100px;
      /* Beri jarak dari atas agar tidak tertutup header */
    }

    .profile-container {
      max-width: 800px;
      /* Memperbesar lebar maksimum */
      margin: 2rem auto;
      /* Centering the form */
      background-color: #ffffff;
      padding: 1.5rem;
      /* Mengurangi padding */
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
      text-align: center;
      /* Centering the title */
    }

    .form-group label {
      font-weight: bold;
    }

    .alert {
      display: inline-block;
      /* Membuat ukuran tombol sesuai dengan konten */
      padding: 5px 10px;
      /* Menyesuaikan padding */
      margin-bottom: 1rem;
      /* Memberi jarak di bawah notifikasi */
    }

    .navbar-custom {
      background-color: #8B0000;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 1rem;
      position: fixed;
      /* Tetap di bagian atas */
      top: 0;
      /* Tidak ada jarak dari atas */
      width: 100%;
      /* Lebar penuh */
      z-index: 1000;
      /* Tetap di atas konten lainnya */
    }

    .navbar-custom a {
      color: #333;
      margin-right: 20px;
      text-decoration: none;
      font-size: 1rem;
    }

    .navbar-custom a:hover {
      text-decoration: underline;
    }

    .header {
      font-size: 1rem;
      font-weight: 600;
      color: #4a5568;
      margin-bottom: 1rem;
    }

    .logo {
      width: 70px;
      margin-left: 60px;
      margin-right: 20px;
    }

    .nav-link.dropdown-toggle {
      color: white;
    }

    @media (max-width: 768px) {
      .navbar-custom {
        padding: 0.5rem;
      }

      .logo {
        width: 50px;
        margin-left: 10px;
        margin-right: 10px;
      }

      .header {
        font-size: 0.9rem;
      }
    }

    body {
      margin: 0;
      padding-top: 40px;
      color: #2e323c;
      background: #f5f6fa;
      position: relative;
      height: 100%;
    }

    .account-settings .user-profile {
      margin: 0 0 1rem 0;
      padding-bottom: 1rem;
      text-align: center;
    }

    .account-settings .user-profile .user-avatar {
      margin: 0 0 1rem 0;
    }

    .account-settings .user-profile .user-avatar img {
      width: 90px;
      height: 90px;
      -webkit-border-radius: 100px;
      -moz-border-radius: 100px;
      border-radius: 100px;
    }

    .account-settings .user-profile h5.user-name {
      margin: 0 0 0.5rem 0;
    }

    .account-settings .user-profile h6.user-email {
      margin: 0;
      font-size: 0.8rem;
      font-weight: 400;
      color: #9fa8b9;
    }

    .account-settings .about {
      margin: 2rem 0 0 0;
      text-align: center;
    }

    .account-settings .about h5 {
      margin: 0 0 15px 0;
      color: #007ae1;
    }

    .account-settings .about p {
      font-size: 0.825rem;
    }

    .form-control {
      border: 1px solid #cfd1d8;
      -webkit-border-radius: 2px;
      -moz-border-radius: 2px;
      border-radius: 2px;
      font-size: .825rem;
      background: #ffffff;
      color: #2e323c;
    }

    .card {
      background: #ffffff;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      border: 0;
      margin-bottom: 1rem;
    }

    .custom-logo {
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 400px;
      /* Atur ukuran sesuai keinginan */
      height: auto;
      /* Pertahankan proporsi gambar */
    }
  </style>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
  <header class="navbar-custom d-flex justify-content-between align-items-center">
    <div class="d-flex gap-3 justify-content-center align-items-center">
      <img src="/images/logo_sasa.png" alt="Sasa Logo" class="logo">
      <a class="nav-link text-white" href="{{ Auth::user()->usertype == 'admin' ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
    </div>
    <div class="dropdown me-5">
      @auth
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{ Auth::user()->name }} - {{ Auth::user()->username }}
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
          <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            <a class="dropdown-item" href="#"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Log Out
            </a>
          </li>
        </ul>
      @else
        <a class="nav-link" href="{{ route('login') }}">Login</a>
      @endauth
    </div>
  </header>

  <div class="container">
    <div class="row gutters">
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
          <div class="card-body">
            <div class="account-settings">
              <div class="user-profile">
                <div class="user-avatar">
                  <img src="{{ asset('images/logo.jpg') }}" class="logo custom-logo">
                </div>
                <h5 class="user-name">Hallo, Selamat Datang!</h5>
                <div class="about">
                  <h5>Peringatan</h5>
                  <p>Silakan ubah kata sandi Anda untuk memperbarui akses akun Anda dan menjaga keamanan data pribadi
                    Anda.</p>
                </div>
              </div>
              <div class="about">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
          <div class="card-body">
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <h6 class="mb-2 text-primary">Detail Profil</h6>
              </div>
              <!-- Full Name -->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label for="fullName">Nama</label>
                  <input type="text" class="form-control" id="fullName" value="{{ $user->name }}" readonly>
                </div>
              </div>
              <!-- Username -->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" value="{{ $user->username }}" readonly>
                </div>
              </div>
              <!-- Email -->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label for="eMail">Email</label>
                  <input type="email" class="form-control" id="eMail" value="{{ $user->email }}" readonly>
                </div>
              </div>
              <!-- Birth Date -->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label for="birthDate">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="birthDate" value="{{ $user->birth_date }}" readonly>
                </div>
              </div>
            </div>
            <div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h5 style="color: blue; margin-top: 20px;">Ubah Kata Sandi Anda</h5>
    </div>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <!-- Kata Sandi Lama -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="currentPassword">Kata Sandi Lama</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="currentPassword" name="current_password"
                        placeholder="Masukkan kata sandi lama" required>
                    <button type="button" class="btn btn-light" onclick="togglePassword('currentPassword')">
                        <i class="fa fa-eye" id="eye-currentPassword"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Kata Sandi Baru -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="newPassword">Kata Sandi Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="newPassword" name="new_password"
                        placeholder="Masukkan kata sandi baru" required>
                    <button type="button" class="btn btn-light" onclick="togglePassword('newPassword')">
                        <i class="fa fa-eye" id="eye-newPassword"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Konfirmasi Kata Sandi Baru -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation"
                        placeholder="Konfirmasi kata sandi baru" required>
                    <button type="button" class="btn btn-light" onclick="togglePassword('confirmPassword')">
                        <i class="fa fa-eye" id="eye-confirmPassword"></i>
                    </button>
                </div>
            </div>
        </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <button type="submit" class="btn btn-primary mt-3">Ubah Kata Sandi</button>
                </div>
              </form>
            </div>

            <!-- Notifikasi untuk validasi -->
            @if (session('status'))
              <div class="alert alert-success position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
                {{ session('status') }}
              </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
                @foreach ($errors->all() as $error)
                  {{ $error }}<br>
                @endforeach
              </div>
            @endif

            <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword(id) {
        const passwordField = document.getElementById(id);
        const eyeIcon = document.getElementById('eye-' + id);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>