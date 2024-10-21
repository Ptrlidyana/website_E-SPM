<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Sampah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.min.css">

    <style>
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
    <div class="container mt-4">
        <h3>Riwayat Sampah</h3>

            <table id="trashedTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sopir</th>
                        <th>Nomer Polisi</th>
                        <th>Volume</th>
                        <th>Nama Transportir</th>
                        <th>Tanggal</th>
                        <th>Foto Timbangan</th>
                        <th>Foto Truck</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawans as $key => $karyawan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $karyawan->nama_user }}</td>
                        <td>{{ $karyawan->nomer_polisi }}</td>
                        <td>{{ $karyawan->volume }}</td>
                        <td>{{ $karyawan->nama_transportir }}</td>
                        <td>{{ $karyawan->tanggal }}</td>
                        <td>
                            @if($karyawan->file_upload)
                                <a href="{{ asset('storage/' . $karyawan->file_upload) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $karyawan->file_upload) }}" class="uploaded-image" alt="File Upload">
                                </a>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>
                            @if($karyawan->second_file_upload)
                                <a href="{{ asset('storage/' . $karyawan->second_file_upload) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $karyawan->second_file_upload) }}" class="uploaded-image" alt="Second File Upload">
                                </a>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('karyawan.restore', $karyawan->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
                            <form action="{{ route('karyawan.permanentlyDelete', $karyawan->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            $('#trashedTable').DataTable();
            $('#selectAll').on('click', function() {
                $('.select-item').prop('checked', this.checked);
                toggleDeleteButton();
            });
            $('.select-item').on('change', function() {
                toggleDeleteButton();
            });
            function toggleDeleteButton() {
                if ($('.select-item:checked').length > 0) {
                    $('#deleteSelected').prop('disabled', false);
                } else {
                    $('#deleteSelected').prop('disabled', true);
                }
            }
        });
    </script>

</body>
</html>
