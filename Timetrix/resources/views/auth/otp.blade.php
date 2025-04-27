@extends('layouts.app')

@section('content')
    <div class="modal" style="display: flex;">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-icon">
                <img src="{{ asset('favicon/favicon_512x512_Nero_AI_Image_Upscaler_Photo_Face.png') }}"
                     alt="App Logo"
                     class="w-16 h-16 mx-auto rounded-full object-cover border-2 border-gray-200">
            </div>
            <h3 class="modal-title">OTP Verification </h3>
            <p class="modal-message">Enter the 6-digit code sent to your email</p>

            <!-- Messages -->
            <div id="message-container" class="mb-4">
                @if (session('status'))
                    <div class="p-3 bg-green-100 text-green-800 rounded-lg border border-green-200 mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-3 bg-red-100 text-red-800 rounded-lg border border-red-200 mb-3">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('otp.verify') }}" class="mb-4">
                @csrf
                <div class="mb-4">
                    <input type="text"
                           name="otp"
                           id="otp"
                           class="w-full px-4 py-3 text-center text-lg font-mono border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="••••••"
                           maxlength="6"
                           required
                           autofocus>
                </div>

                <button type="submit"
                        class="btn btn-confirm w-full"
                        style="background: #3b82f6; padding: 0.75rem;">
                    Verify Code
                </button>
            </form>

            <!-- Resend Section -->
            <div class="text-sm text-gray-500">
                <p>Didn't receive code?
                    <button id="resend-button"
                            onclick="resendOtp()"
                            class="text-blue-600 font-medium disabled:text-gray-400 disabled:cursor-not-allowed"
                            disabled>
                        Resend OTP
                    </button>
                </p>
                <p id="timer" class="text-xs text-gray-400 mt-1">
                    (Available in <span id="seconds-left">60</span>s)
                </p>
            </div>
        </div>
    </div>

    <script>
        // Timer functionality
        let countdown;
        let timeLeft = 60;
        const resendButton = document.getElementById('resend-button');
        const timerDisplay = document.getElementById('seconds-left');

        function startTimer(seconds = 60) {
            clearInterval(countdown);
            timeLeft = seconds;
            updateTimerDisplay();

            countdown = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    enableResendButton();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            timerDisplay.textContent = timeLeft;
            document.getElementById('timer').style.display = timeLeft > 0 ? 'inline-block' : 'none';
        }

        function enableResendButton() {
            resendButton.disabled = false;
            resendButton.innerHTML = 'Resend OTP';
        }

        // Initial timer start
        startTimer();

        async function resendOtp() {
            if (timeLeft > 0) return;

            const originalText = resendButton.innerHTML;
            try {
                resendButton.disabled = true;
                resendButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600 inline"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending...
                `;

                const response = await fetch('{{ route('otp.resend') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || `HTTP error! status: ${response.status}`);
                }

                showMessage(data.status, 'success');
                startTimer(data.cooldown || 60);

            } catch (error) {
                console.error('Resend error:', error);
                showMessage(error.message, 'error');
                if (error.message.includes('419')) {
                    setTimeout(() => window.location.reload(), 2000);
                }
            } finally {
                resendButton.innerHTML = originalText;
                resendButton.disabled = timeLeft > 0;
            }
        }

        function showMessage(text, type) {
            const container = document.getElementById('message-container');
            container.innerHTML = '';

            const message = document.createElement('div');
            message.className = `p-3 rounded-lg mb-4 text-sm font-medium ${
                type === 'success'
                    ? 'bg-green-100 text-green-800 border border-green-200'
                    : 'bg-red-100 text-red-800 border border-red-200'
            }`;
            message.textContent = text;

            container.appendChild(message);

            setTimeout(() => {
                message.style.transition = 'opacity 0.3s';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 300);
            }, 5000);
        }
    </script>

    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            animation: fadeIn 0.3s forwards;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            transform: translateY(-20px);
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-icon img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: contain;
            border: 2px solid #e5e7eb;
            padding: 2px;
            background: white;
        }

        .modal-title {
            margin: 0 0 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-message {
            color: #6b7280;
            margin: 0 0 1.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
@endsection
