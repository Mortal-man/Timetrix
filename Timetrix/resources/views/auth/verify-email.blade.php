<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .state-transition {
            transition: all 0.3s ease;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
<div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 w-full max-w-sm mx-4 text-center">

    <!-- Flash/Session Messages -->
    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-200 rounded px-4 py-2">
            ✅ A new verification link has been sent to your email.
        </div>
    @elseif (session('status') === 'email-verified')
        <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded px-4 py-2">
            🎉 Your email has been verified. Please log in.
        </div>
    @elseif (session('status') === 'already-verified')
        <div class="mb-4 text-sm text-blue-700 bg-blue-100 border border-blue-300 rounded px-4 py-2">
            ℹ️ Your email is already verified. Please proceed to login.
        </div>
    @elseif (session('status'))
        <div class="mb-4 text-sm text-blue-600 bg-blue-100 border border-blue-200 rounded px-4 py-2">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->has('email'))
        <div class="mb-4 text-sm text-red-600 bg-red-100 border border-red-200 rounded px-4 py-2">
            {{ $errors->first('email') }}
        </div>
    @endif

    <!-- State Container -->
    <div class="relative h-40 mb-6">
        <div id="initialState" class="state-transition">
            <div class="mx-auto mb-4 w-14 h-14 text-indigo-500 animate-float">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-xl font-medium text-gray-800 mb-2">Verify Your Email</h1>
            <p class="text-gray-500 text-sm">Check your inbox for the verification link.</p>
        </div>

        <!-- Success State -->
        <div id="successState" class="state-transition absolute inset-0 flex flex-col items-center justify-center opacity-0 pointer-events-none">
            <div class="mb-4 w-14 h-14 text-emerald-500 animate-pulse">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-medium text-gray-800 mb-2">Email Sent!</h1>
            <p class="text-gray-500 text-sm">A new verification link is on its way.</p>
        </div>
    </div>

    <!-- Resend Form & Sign Out -->
    <div class="space-y-3">
        <form id="resendForm">
            @csrf
            <button type="submit"
                    class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors focus:outline-none">
                Not you? Sign out
            </button>
        </form>
    </div>
</div>

<script>
    function showSuccessState() {
        const initialState = document.getElementById('initialState');
        const successState = document.getElementById('successState');

        initialState.classList.add('opacity-0', 'pointer-events-none');
        successState.classList.remove('opacity-0', 'pointer-events-none');

        setTimeout(() => {
            initialState.classList.remove('opacity-0', 'pointer-events-none');
            successState.classList.add('opacity-0', 'pointer-events-none');
        }, 3000);
    }

    document.getElementById('resendForm').addEventListener('submit', async (e) => {
        e.preventDefault(); // Important!

        const form = e.target;
        const button = form.querySelector('button');
        const formData = new FormData(form);

        button.innerHTML = 'Sending...';
        button.disabled = true;

        try {
            const response = await fetch('{{ route('verification.send') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const result = await response.json();

            if (result.status === 'verification-link-sent') {
                showSuccessState();
                Toastify({
                    text: "✅ A new verification link has been sent.",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#10b981"
                }).showToast();
            } else if (result.status === 'already-verified') {
                Toastify({
                    text: "ℹ️ You're already verified. Please log in.",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#3b82f6"
                }).showToast();
            } else {
                Toastify({
                    text: "⚠️ Unexpected response.",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#f59e0b"
                }).showToast();
            }
        } catch (err) {
            Toastify({
                text: "❌ Network error. Please try again.",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#ef4444"
            }).showToast();
        } finally {
            button.innerHTML = 'Resend Verification Email';
            button.disabled = false;
        }
    });
</script>

<!-- Include Toastify for notifications -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
</body>
</html>
