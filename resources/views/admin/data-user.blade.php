<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            background-color: #e2e8f0;    
        }
        .navbar-custom {
            background-color: #8B0000;
            margin-bottom: 0;
        }
        .navbar-brand img {
            width: 70px;
        }
        .uploaded-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        table th, table td {
            text-align: center;
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
        .nav-link:hover {
          color: #f8f9fa;
          box-shadow: 0 4px 2px -2px rgba(255, 255, 255, 0.8);
        }
        .navbar-nav .nav-item .nav-link.active {
          color: #f8f9fa;
          box-shadow: 0 4px 2px -2px rgba(255, 255, 255, 1); 
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
                <a class="nav-link text-white {{ request()->routeIs('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('karyawan/trashed') ? 'active' : '' }}" href="{{ route('karyawan.trashed') }}">Riwayat Sampah</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('data.nomer') ? 'active' : '' }}" href="{{ route('data.nomer') }}">Data Nomer</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('data.user') ? 'active' : '' }}" href="{{ route('data.user') }}">Data User</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
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
@if (session('success'))
    <div class="alert alert-success position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
        Selamat, data telah diperbarui!
    </div>
@endif

<div class="container mt-4 p-4 bg-white rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Data User</h1>
        <form method="GET" action="{{ route('data.user') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari pengguna..." value="{{ request()->input('search') }}" style="width: 200px;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
    <table id="userTable" class="table table-bordered">
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
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit Data Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name{{ $user->id }}" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email{{ $user->id }}" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usertype{{ $user->id }}" class="form-label">Tipe Pengguna</label>
                                        <input type="text" class="form-control" id="usertype{{ $user->id }}" name="usertype" value="{{ $user->usertype }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                      <label for="password{{ $user->id }}" class="form-label">Password Baru</label>
                                      <div class="input-group">
                                          <input type="password" class="form-control" id="password{{ $user->id }}" name="password">
                                          <span class="input-group-text">
                                              <i class="bi bi-eye-slash" id="togglePassword{{ $user->id }}" style="cursor: pointer;"></i>
                                          </span>
                                      </div>
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
                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Konfirmasi Penghapusan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus pengguna ini? <p><strong>{{ $user->name }}</strong></p>
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
                <!-- End Modal Delete -->
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pageLength": 10
            });
        });

    document.querySelectorAll('[id^=togglePassword]').forEach(item => {
        item.addEventListener('click', function () {
            let userId = this.id.replace('togglePassword', '');
            let passwordField = document.getElementById('password' + userId);
            let icon = this;
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordField.type = "password";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
</body>
</html>
