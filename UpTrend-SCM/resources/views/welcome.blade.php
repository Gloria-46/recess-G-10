<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to UpTrend!</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
            </style>
    </head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl mx-auto bg-white shadow-2xl overflow-hidden flex flex-col md:flex-row">
        <div class="md:w-1/2 h-[32rem] md:h-auto flex items-stretch justify-center bg-gray-100 p-0">
            <img src="/assets/img/clothes-store.jpg" alt="Welcome" class="w-full h-full object-cover rounded-none shadow-2xl border-0">
                </div>
        <div class="md:w-1/2 flex flex-col justify-center items-center p-16">
            <h1 class="text-4xl md:text-5xl font-semibold text-gray-800 mb-6 text-center tracking-tight">Welcome to UpTrend</h1>
            <p class="text-gray-500 mb-12 text-center text-lg font-light">Your one-stop platform for seamless shopping and management. Please choose an option to get started.</p>
            <div class="flex flex-col space-y-6 w-full">
                <a href="{{ route('login') }}" class="w-full text-center px-8 py-4 bg-blue-600 text-white text-xl font-light shadow hover:bg-blue-700 transition">Login</a>
                <a href="/customer/dashboard" class="w-full text-center px-8 py-4 bg-green-500 text-white text-xl font-light shadow hover:bg-green-600 transition">See what we have</a>
                </div>
        </div>
    </div>
    </body>
</html>
