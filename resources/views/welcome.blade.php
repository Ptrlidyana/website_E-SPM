<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SPM | Sasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Header Styling */
        header {
            background-color: #8B0000;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            height: 40px;
        }

        header nav {
            display: flex;
            gap: 20px;
        }

        header nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        main {
            height: 100vh;
            background-image: url('/images/mesin.jpg'); /* Replace with your background image */
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
        }

        /* Centered content */
        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 2;
        }

        .content h1 {
            font-size: 3.5em;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 1.2em;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .content button {
            background-color: #FF1493; /* Hot pink */
            border: none;
            padding: 15px 30px;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .content button:hover {
            background-color: #ff007f;
        }

        /* Navigation Arrows */
        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 2em;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 3;
        }

        .arrow-left {
            left: 20px;
        }

        .arrow-right {
            right: 20px;
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <img src="/images/logo_sasa.png" alt="Sasa Logo" class="logo">
        @if (Route::has('login'))
        <nav class="-mx-3 flex flex-1 justify-end">
            @auth
            <a href="{{ url('/dashboard') }}"
                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-gray-300 focus:outline-none focus-visible:ring-white">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}"
                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-gray-300 focus:outline-none focus-visible:ring-white">
                Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-gray-300 focus:outline-none focus-visible:ring-white">
                Register
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <!-- Main Content Section -->
    <main>
        <div class="overlay"></div>
        <div class="content">
            <h1>PT SASA INTI GENDING</h1>
            <p>Pupuk organik cair yang merupakan limbah hasil pengolahan Sipramin, yaitu hasil samping dari proses pembuatan Monosodium Gluamat (MSG).</p>
        </div>

        <!-- Navigation Arrows -->
        <div class="arrow arrow-left">&#8249;</div>
        <div class="arrow arrow-right">&#8250;</div>
    </main>

</body>

</html>
