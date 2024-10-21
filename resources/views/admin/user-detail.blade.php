<!-- resources/views/admin/user-detail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Detail User: {{ $user->name }}</h1>
    <p>Username: {{ $user->username }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>User Type: {{ $user->user_type }}</p>
    <a href="{{ route('data.user') }}" class="btn btn-primary">Kembali ke Daftar User</a>
</div>

</body>
</html>
