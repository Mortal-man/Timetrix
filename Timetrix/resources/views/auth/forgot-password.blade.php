<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Timetrix</title>

    <!-- Core Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom_fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;600;800&display=swap" rel="stylesheet">

    <!-- Plugins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.0.0-beta1/css/tempus-dominus.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.0.0-beta1/js/tempus-dominus.min.js"></script>

    <!-- Favicon -->
    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>

<body class="hold-transition login-page">
<div class="container">
    <!-- Logo -->
    <div class="cover">
        <div class="front">
            <img src="{{URL('favicon/Timetrix.png')}}" alt="Timetrix Logo">
        </div>
    </div>

    <!-- Form Box -->
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Forgot Password</div>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Forgot your password? No problem. Just let us know your email and we’ll send a reset link.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-boxes">
                        <!-- Email Field -->
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                        </div>
                        @error('email')
                        <span class="error invalid-feedback d-block text-error">{{ $message }}</span>
                        @enderror

                        <!-- Submit Button -->
                        <div class="button input-box">
                            <input type="submit" value="Send Reset Link">
                        </div>

                        <!-- Back to login -->
                        <div class="text sign-up-text">
                            Remembered? <a href="{{ route('login') }}"><label>Back to Login</label></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
