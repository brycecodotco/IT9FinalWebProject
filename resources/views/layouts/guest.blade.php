<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased relative selection:bg-indigo-500 selection:text-white">

    <!-- Stunning Full-Screen Library Background with Dark/Blur Overlay -->
    <div class="fixed inset-0 z-[-1]">
        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
            alt="Library Background" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gray-900/75 backdrop-blur-sm"></div>
    </div>

    <!-- Centered Container for the Login Card -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">

        <!-- The Glassmorphism Login Card -->
        <div
            class="w-full sm:max-w-md bg-white/95 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20">
            {{ $slot }}
        </div>

        <!-- Footer text -->
        <div class="mt-8 text-center text-gray-300 text-sm">
            &copy; {{ date('Y') }} Web-Based Library Management System.
        </div>
    </div>
</body>

</html>