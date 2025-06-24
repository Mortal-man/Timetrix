<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Timetrix</title>

    <!-- Stylesheets -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom_fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <script>
        // Validate name - no numbers or special characters
        function validateForm() {
            var name = document.forms["registerForm"]["name"].value;
            var email = document.forms["registerForm"]["email"].value;
            var password = document.forms["registerForm"]["password"].value;
            var password_confirmation = document.forms["registerForm"]["password_confirmation"].value;
            var agreeTerms = document.getElementById('agreeTerms').checked;

            var namePattern = /^[A-Za-z\s]+$/; // Only letters and spaces
            if (!namePattern.test(name)) {
                alert("Name should only contain letters and spaces.");
                return false;
            }

            // Validate email format (you can rely on HTML5 email validation)
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Validate passwords match
            if (password !== password_confirmation) {
                alert("Passwords do not match.");
                return false;
            }

            // Ensure terms are agreed to
            if (!agreeTerms) {
                alert("You must agree to the terms and conditions.");
                return false;
            }

            return true; // If all validations pass
        }
    </script>
</head>
<body class="hold-transition register-page">

<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <img src="{{URL('favicon/Timetrix.png')}}" alt="Logo">
        </div>
        <div class="back">
            <div class="text">
                <span class="text-1">Join us and start your journey!</span>
                <span class="text-2">Let's get started</span>
            </div>
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Register</div>
                <form name="registerForm" method="post" action="{{ route('register') }}" onsubmit="return validateForm()">
                    @csrf
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Retype password" class="form-control" required>
                        </div>
                        <div class="text">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">I agree to the <a href="#">terms</a></label>
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Register">
                        </div>
                        <div class="text sign-up-text">Already have an account? <a href="{{ route('login') }}">Login</a></div>
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
                        </div>
                        <div class="input-box">
                            <i class="fas fa-comments"></i>
                            <textarea name="message" placeholder="Enter your message" required></textarea>
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text sign-up-text">Go back to <label for="flip">Register</label></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
