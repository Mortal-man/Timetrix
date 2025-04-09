<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetrix</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #0d1117; /* Dark theme */
            color: #e0e0e0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }
        header {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }
        .logo {
            width: 160px;
        }
        .nav-links a {
            margin: 0 15px;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 1rem;
            background: #1f6feb;
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }
        .nav-links a:hover {
            background: #1a4fcb;
        }
        .hero {
            max-width: 800px;
            background: linear-gradient(135deg, rgba(45, 156, 219, 0.15), rgba(45, 156, 219, 0.25));
            border-radius: 12px;
            padding: 50px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.6);
            text-align: center;
            margin-top: 40px;
        }
        .hero h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #fff;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 25px;
            color: #b0b0b0;
        }
        .resources {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .resources a {
            padding: 12px 25px;
            border-radius: 8px;
            background: #ff9800;
            color: #121212;
            font-size: 1rem;
            text-decoration: none;
            transition: 0.3s;
        }
        .resources a:hover {
            background: #e68a00;
        }
        footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>
<body>

<header>
    <!-- Add the logo here -->
    <img class="logo" src="{{ asset('favicon/favicon_512x512_Nero_AI_Image_Upscaler_Photo_Face-Photoroom.png') }}" alt="Timetrix Logo">
    <nav class="nav-links">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </nav>
</header>

<main class="hero">
    <h1>Welcome to Timetrix</h1>
    <p>Timetrix helps you generate organized and efficient timetables with ease. Whether for schools, colleges, or personal schedules, our tool makes scheduling seamless.</p>
    <div class="resources">
        <a href="#">Documentations</a>
        <a href="#">Tutorials</a>
        <a href="#">Community</a>
    </div>
</main>

<footer>
    Timetrix v1.0.0 | © 2025 Timetrix Inc.
</footer>

</body>
</html>
