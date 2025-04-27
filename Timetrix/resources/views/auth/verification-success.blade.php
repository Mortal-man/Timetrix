<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verified</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center h-screen">
<div class="bg-white shadow-md rounded-lg p-8 text-center max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-green-600 mb-4">Email Verified Successfully 🎉</h1>
    <p class="text-gray-600 mb-6">Thank you for verifying your email. You can now log in.</p>
    <a href="{{ route('login') }}"
       class="inline-block px-4 py-2 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition">
        Go to Login
    </a>
</div>
</body>
</html>
