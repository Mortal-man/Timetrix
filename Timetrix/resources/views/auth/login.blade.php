<!DOCTYPE html>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/custom_fonts.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
<!-- Include Bootstrap CSS -->

<!-- Include Tempus Dominus CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.0.0-beta1/css/tempus-dominus.min.css">

<!-- Include jQuery (required for Bootstrap JS and Tempus Dominus) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include Tempus Dominus JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.0.0-beta1/js/tempus-dominus.min.js"></script>

<link rel="manifest" href="/images/favicons/site.webmanifest">
<link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<body class="hold-transition login-page">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
        @if (session('status') == 'Your email is already verified. Do you want to go to login page?')
            <br><a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
        @endif
    </div>
@endif

<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <img src="{{URL('favicon/Timetrix.png')}}" alt="">
        </div>
        <div class="back">
            <div class="text">
                <span class="text-1">Complete miles of journey <br> with one step</span>
                <span class="text-2">Let's get started</span>
            </div>
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Login</div>
                <form method="post" action="{{ url('/login') }}">
                    @csrf
                    @error('email')
                    <span class="error invalid-feedback text-error"> <br>{{ $message }}</span>
                    @enderror
                    <div class="input-boxes">
                        <div class="input-box">
                            <div> <i class="fas fa-envelope"></i> </div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required>

                            @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text"><a href="{{ route('password.request') }}">Forgot password?</a></div>
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text sign-up-text">Need help? <label for="flip">Contact Support</label></div>
                    </div>
                </form>
            </div>
            <div class="support-form">
                <div class="title">Contact Support</div>
                <form method="post" action="mailto:ottimanuel714@gmail.com">
                    @csrf
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div> <br/>
                        <div class="input-box">
                            <i class="fas fa-comments"></i>
                            <textarea name="message" placeholder="Enter your message" required></textarea>
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text sign-up-text">Go back to <label for="flip">Login</label></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
