<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
            background-color: #f0f8f7; /* Light green background */
            font-family: 'Poppins', sans-serif; /* Apply Poppins font */
        }

        /* General Styles for Form Container */
        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff; /* White background */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Label and Input Styles */
        .label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Button Styles */
        .custom-button {
            background-color: #8B0000; /* Dark red button */
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
            background-color: #660000; /* Darker red on hover */
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

        /* Status Message Styling */
        .status-message {
            margin-bottom: 16px;
            font-size: 14px;
            color: #6B7280; /* Gray text */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="status-message">
            "Lupa kata sandi Anda? Tidak masalah. Beritahu kami alamat email Anda, dan kami akan mengirimkan tautan reset kata sandi yang memungkinkan Anda memilih yang baru."
        </div>

        <!-- Form Reset Password -->
        <form method="POST" action="{{ route('password.email') }}">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input id="email" class="input-field" type="email" name="email" required autofocus placeholder="Masukkan email Anda">
                <!-- Placeholder for error messages -->
                <div class="mt-2">
                    <!-- Error message for email -->
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="custom-button">
                    Kirim Tautan Reset Password
                </button>
            </div>
        </form>
    </div>
</body>
</html>
