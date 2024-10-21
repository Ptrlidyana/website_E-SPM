<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .navbar-custom {
            background-color: #8B0000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
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
    </style>
</head>
<body>
    <header class="navbar-custom d-flex justify-content-between align-items-center">
        <img src="/images/logo_sasa.png" alt="Sasa Logo" class="logo">
        <div class="dropdown me-5">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }} - {{ Auth::user()->username }}
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>

                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 shadow-sm rounded-lg">
        <h4 class="header">Dashboard Transportir</h4>

        <form id="form-karyawan" action="{{ route('dashboard.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 col-12">
                    <label for="no_po" class="form-label">Nomer PO:</label>
                    <input type="text" class="form-control" id="no_po" name="no_po" required>
                </div>
                <div class="col-md-6 col-12">
                    <label for="tanggal" class="form-label">Tanggal:</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 col-12">
                    <label for="nomer_polisi" class="form-label">Nomer Polisi:</label>
                    <select id="nomer_polisi" name="nomer_polisi" class="form-select select2" required>
                        <option value="">-- Pilih Nomor Polisi --</option>
                        @foreach($nomerPolisiList as $nomerPolisi)
                            <option value="{{ $nomerPolisi->nomer_polisi }}">{{ $nomerPolisi->nomer_polisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-12">
                    <label for="volume" class="form-label">Volume:</label>
                    <input type="text" class="form-control" id="volume" name="volume" readonly required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 col-12">
                    <label for="nama_transportir" class="form-label">Nama Transportir:</label>
                    <input type="text" class="form-control" id="nama_transportir" name="nama_transportir" required>
                </div>
                <div class="col-md-6 col-12">
                    <label for="nama_user" class="form-label">Nama Sopir:</label>
                    <input type="text" class="form-control" id="nama_user" name="nama_user" readonly required>
                </div>
            </div>
            <div class="mb-3">
                <label for="file_upload" class="form-label">Upload Bukti Timbang:</label>
                <input type="file" class="form-control" id="file_upload" name="file_upload" required>
            </div>
            <div class="mb-3">
                <label for="second_file_upload" class="form-label">Upload Foto Truck:</label>
                <input type="file" class="form-control" id="second_file_upload" name="second_file_upload" required>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#nomer_polisi').select2({
                placeholder: '-- Pilih Nomor Polisi --',
                allowClear: true
            });
        });

        $('#nomer_polisi').change(function() {
    var nomerPolisi = $(this).val();
    if (nomerPolisi) {
        $.ajax({
            url: '/get-volumes/' + nomerPolisi,
            type: 'GET',
            success: function(response) {
                // Set value volume
                if (response.volume) {
                    var volume = parseFloat(response.volume).toFixed(1); 
                    $('#volume').val(volume); 
                } else {
                    $('#volume').val(''); 
                }

                // Set value nama sopir
                if (response.nama_sopir) {
                    $('#nama_user').val(response.nama_sopir); 
                } else {
                    $('#nama_user').val(''); 
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat mengambil data.');
            }
        });
    } else {
        $('#volume').val(''); 
        $('#nama_user').val(''); 
    }
});

    $(document).ready(function() {
        $('#nomer_polisi').select2({
            placeholder: '-- Pilih Nomor Polisi --',
            allowClear: true
        });

        $('#form-karyawan').on('submit', function(e) {
            let valid = true;
            const requiredFields = ['#no_po', '#tanggal', '#nomer_polisi', '#nama_transportir', '#nama_user'];

            requiredFields.forEach(function(selector) {
                const field = $(selector);
                if (field.val() === '' || (field.is('select') && field.val() === null)) {
                    valid = false;
                    field.addClass('is-invalid');
                } else {
                    field.removeClass('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault(); // Mencegah form dari disubmit
                alert('Semua field yang wajib diisi harus diisi.');
            }
        });

        $('#nomer_polisi').change(function() {
            var nomerPolisi = $(this).val();
            if (nomerPolisi) {
                $.ajax({
                    url: '/get-volumes/' + nomerPolisi,
                    type: 'GET',
                    success: function(response) {
                        if (response.volumes.length > 0) {
                            var volume = parseFloat(response.volumes[0]).toFixed(1); 
                            $('#volume').val(volume); 
                        } else {
                            $('#volume').val(''); 
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat mengambil data volume.');
                    }
                });
            } else {
                $('#volume').val(''); 
            }
        });
    });
    </script>
</body>
</html>
