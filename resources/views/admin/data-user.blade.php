<!-- resources/views/admin/data-user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;    
        }
        .main-body {
            padding: 15px;
        }
        .card {
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
        }
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }
        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }
        .btn-light {
            color: #1a202c;
            background-color: #fff;
            border-color: #cbd5e0;
        }
        .card-footer {
            padding: .5rem 1rem;
            background-color: #fff;
        }
        .navbar-custom {
            background-color: #8B0000;
        }

        .navbar-brand img {
            width: 70px;
        }

        .uploaded-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        table {
            width: 100%;
        }

        table th, table td {
            text-align: center;
        }

        .form-inline .btn-excel {
            margin-left: 10px;
        }
        .alert {
            min-width: 200px; 
            transition: opacity 0.5s ease; 
        }
        .btn-close-sm {
        width: 5px; 
        height: 5px;
        }
        body {
            margin-top: 0;
            padding-top: 0;
        }

        .navbar-custom {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="/images/logo_sasa.png" alt="Sasa Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('karyawan/trashed') ? 'active' : '' }}" href="{{ route('karyawan.trashed') }}">Riwayat Sampah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('data.nomer') }}">Data Nomer</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('data.user') }}">Data User</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }} - {{ Auth::user()->username }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
            <li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container" style="padding-top: 20px; background-color: white; border-radius: 10px;"> 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Data User</h1>
        <form method="GET" action="{{ route('data.user') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari pengguna..." value="{{ request()->input('search') }}" style="width: 200px;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Tipe Pengguna</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->usertype }}</td>
                <td>
                    <a href="#" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">Lihat Detail</a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                        Hapus
                    </button>
                </td>
            </tr>
            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Konfirmasi Penghapusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus pengguna ini?
                            <p><strong>{{ $user->name }}</strong></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="usertype" class="form-label">Tipe Pengguna</label>
                    <input type="text" class="form-control" id="usertype{{ $user->id }}" name="usertype" value="{{ $user->usertype }}" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="password{{ $user->id }}" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password{{ $user->id }}" name="password">
                </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
<script>
    $(document).ready(function() {
        new DataTable('#example');
    });
</script>


</body>
</html>
