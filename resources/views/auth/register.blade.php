<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    /* General Styles for Body */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f8f7;
      /* Light green background */
      font-family: 'Poppins', sans-serif;
      /* Apply Poppins font */
    }

    /* General Styles for Form Container */
    .container {
      max-width: 400px;
      width: 100%;
      padding: 20px;
      background-color: #ffffff;
      /* White background */
      border: 1px solid #ccc;
      /* Light gray border */
      border-radius: 8px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Input Fields Styling */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input::placeholder {
      color: #a9a9a9;
    }

    /* Error Message Styling */
    .error-message {
      color: red;
      font-size: 12px;
      margin-top: 5px;
    }

    /* Label Styles */
    .label-text {
      margin-bottom: 8px;
      display: block;
      font-size: 14px;
      color: #333;
    }

    /* Button Styles */
    .custom-button {
      background-color: #8B0000;
      /* Dark red button */
      color: white;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .custom-button:hover {
      background-color: #660000;
      /* Darker red on hover */
    }

    /* Link Styling */
    a {
      color: black;
      text-decoration: underline;
      font-size: 14px;
    }

    a:hover {
      text-decoration: underline;
    }

    /* Layout for Links and Submit Button */
    .link-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center">Registrasi</h2>
    <form method="POST" action="{{ route('register') }}">
      <!-- CSRF Token -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <!-- Name -->
      <div class="mb-4">
        <label for="name" class="label-text">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
          placeholder="Masukkan nama Anda">
        <!-- Error message for name -->
        @error('name')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Email Address -->
      <div class="mb-4">
        <label for="email" class="label-text">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
          placeholder="Masukkan email Anda">
        <!-- Error message for email -->
        @error('email')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Tanggal Lahir -->
      <div class="mb-4">
        <label for="birth_date" class="label-text">Tanggal Lahir</label>
        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required
          placeholder="Masukkan Tanggal lahir anda Anda">
        <!-- Error message for birth_date -->
        @error('birth_date')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="label-text">Password</label>
        <input id="password" type="password" name="password" required autocomplete="new-password"
          placeholder="Masukkan password">
        <!-- Error message for password -->
        @error('password')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="mb-4">
        <label for="password_confirmation" class="label-text">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
          autocomplete="new-password" placeholder="Konfirmasi password">
        <!-- Error message for password confirmation -->
        @error('password_confirmation')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Login Link -->
      <div>
        <a href="{{ route('login') }}">Sudah terdaftar?</a>
      </div>

      <!-- Links and Submit Button -->
      <div class="link-container">
        <!-- Submit Button -->
        <button type="submit" class="custom-button">Daftar</button>
      </div>
    </form>
  </div>
</body>

</html>