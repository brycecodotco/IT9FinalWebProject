<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        
        <!-- Alpine JS for Dropdowns -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Fallback to prevent giant SVGs just in case -->
        <style> svg { max-width: 100%; height: auto; } </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 relative">
        
        <!-- Subtle Premium Gradient Background -->
        <div class="absolute inset-0 z-[-1] bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-100/40 via-slate-50 to-white"></div>
        
        <div class="min-h-screen">
            <!-- Includes the Navigation Bar -->
            @include('layouts.navigation')

            <!-- Main Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
    </body>
</html>