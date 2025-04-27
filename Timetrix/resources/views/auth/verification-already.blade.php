<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Already Verified</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
<div class="bg-white shadow rounded-xl p-8 max-w-md w-full text-center">
    <div class="text-green-600 mb-4">
        <svg class="w-14 h-14 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <h1 class="text-xl font-bold text-gray-800 mb-2">Email Already Verified</h1>
    <p class="text-gray-600 mb-6">You've already verified your email address.</p>
    <a href="{{ route('login') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm font-medium">
        Go to Login
    </a>
</div>
</body>
</html>
