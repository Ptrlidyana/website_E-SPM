<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            font-family: 'Poppins', sans-serif;
        }

        /* General Styles for Form Container */
        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        /* Input Fields Styling */
        input[type="email"],
        input[type="password"],
        input[type="text"] {
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

        /* Button Styles */
        .custom-login-button {
            background-color: #8B0000;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .custom-login-button:hover {
            background-color: #6d0000;
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

        /* Layout for Links */
        .link-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .bottom-text {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
        }

        /* Label Styles */
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        /* Error Message Styling */
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Form Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username Field -->
            <label for="username">Masukkan username Anda :</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Masukkan username">
            <!-- Error message for username -->
            @error('username')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Password Field -->
            <label for="password">Masukkan password Anda :</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password">
            <!-- Error message for password -->
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="link-container">
                <a href="{{ route('password.request') }}">Lupa password?</a>
            </div>

            <!-- Submit Button -->
            <button class="custom-login-button" type="submit">Login</button>

            <!-- Registration Link -->
            <div class="bottom-text">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
            </div>
        </form>
    </div>
</body>

</html>
