<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Timetrix</title>

    <!-- Stylesheets -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom_fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body class="hold-transition login-page">
<div class="container">
    <div class="cover">
        <div class="front">
            <img src="{{ URL('favicon/Timetrix.png') }}" alt="Timetrix Logo">
        </div>
    </div>

    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Reset Password</div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="input-boxes">
                        <!-- Email -->
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" value="{{ old('email', $request->email) }}"
                                   placeholder="Email" class="form-control @error('email') is-invalid @enderror" required autofocus>
                            @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="New Password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="button input-box">
                            <input type="submit" value="Reset Password">
                        </div>

                        <div class="text sign-up-text">Go back to <a href="{{ route('login') }}">Login</a></div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</body>
</html>
