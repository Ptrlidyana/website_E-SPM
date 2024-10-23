<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Nomer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    table {
      width: 100%;
    }

    table th,
    table td {
      text-align: center;
    }

    .table-container {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      margin-top: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        .nav-link {
        position: relative;
        transition: color 0.3s ease, box-shadow 0.3s ease;
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
    <div class="card">
      <div class="card-body">
        <form action="{{ route('data.import.excel') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-3">
            <label for="file">Pilih File Excel:</label>
            <input type="file" name="file" accept=".xlsx, .xls" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Tambah Import Excel</button>
        </form>
      </div>
    </div>
<!-- Notifikasi untuk validasi -->
@if (session('success'))
<div class="alert alert-success position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
    {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card mt-3">
    <div class="card-body">
        <form action="{{ route('data.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nomer_polisi" class="form-label">Nomer Polisi</label>
                        <input type="text" class="form-control" id="nomer_polisi" name="nomer_polisi" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="text" class="form-control" id="volume" name="volume" required step="0.01" pattern="\d+(\.\d{1,2})?">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nama_sopir" class="form-label">Nama Sopir</label>
                        <input type="text" class="form-control" id="nama_sopir" name="nama_sopir" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <h4 class="mb-3 text-center">Informasi Kendaraan & Sopir</h4>
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>Nomer Polisi</th>
                    <th>Volume</th>
                    <th>Nama Sopir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item) <!-- Ganti dari $data menjadi $datas -->
                    <tr class="text-center">
                        <td>{{ $item->nomer_polisi }}</td>
                        <td>{{ $item->volume }}</td>
                        <td>{{ $item->nama_sopir }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal('{{ $item->id }}', '{{ $item->nomer_polisi }}', '{{ $item->volume }}', '{{ $item->nama_sopir }}')">Edit</button>
                            <form action="{{ route('data.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

  <!-- Modal -->
   <!-- Notifikasi untuk validasi -->
@if(session('status'))
<div class="alert alert-success position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1000;">
    {{ session('status') }}
</div>
@endif

  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
  <div class="modal-body">
  <form id="editForm" method="POST" action="{{ route('data.update', '') }}" onsubmit="event.preventDefault(); submitForm();">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" id="editId">

    <div class="mb-3">
        <label for="editNomerPolisi" class="form-label">Nomer Polisi</label>
        <input type="text" class="form-control" id="editNomerPolisi" name="nomer_polisi" required>
    </div>

    <div class="mb-3">
        <label for="editVolume" class="form-label">Volume</label>
        <input type="decimal" class="form-control" id="editVolume" name="volume" required>
    </div>

    <div class="mb-3">
        <label for="editNamaSopir" class="form-label">Nama Sopir</label>
        <input type="text" class="form-control" id="editNamaSopir" name="nama_sopir" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>


  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });

    function openEditModal(id, nomerPolisi, volume, namaSopir) {
      $('#editId').val(id);
      $('#editNomerPolisi').val(nomerPolisi);
      $('#editVolume').val(volume);
      $('#editNamaSopir').val(namaSopir);
      $('#editModal').modal('show');
    }
    function submitForm() {
    const id = $('#editId').val();
    const formData = {
        nomer_polisi: $('#editNomerPolisi').val(),
        volume: $('#editVolume').val(),
        nama_sopir: $('#editNamaSopir').val(),
        _token: '{{ csrf_token() }}', // Token CSRF
        _method: 'PUT' // Metode PUT untuk update
    };

    $.ajax({
        url: '{{ url("data") }}/' + id,
        type: 'PUT',
        data: formData,
        success: function(response) {
            if (response.success) {
                // Muat ulang halaman untuk menampilkan notifikasi
                location.reload();
            }
        },
        error: function(xhr) {
            // Tampilkan kesalahan jika ada
            const errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function(key, value) {
                    alert(value[0]); // Menampilkan kesalahan
                });
            }
        }
    });
    function confirmDelete() {
        return confirm("Apakah anda yakin untuk menghapus data ini?");
    }
}


  </script>
</body>

</html>


