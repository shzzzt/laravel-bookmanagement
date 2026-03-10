<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PageTurner Bookstore')</title>
    
    <!-- JetBrains Mono Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-blue': '#A7C7E7',
                        'pastel-yellow': '#FFFAA0',
                        'soft-blue': '#C5E0FF',
                        'soft-yellow': '#FFFCC9',
                        'accent-blue': '#7EA8D9',
                        'accent-yellow': '#FFE87C',
                        'yellow' :'#ffd724',
                    },
                    fontFamily: {
                        'mono': ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="font-mono bg-gradient-to-br from-pastel-blue/50 to-pastel-yellow/60 min-h-screen">
    <!-- Navigation -->
    @include('partials.navigation')
    
    <!-- Flash Messages -->
    @include('partials.flash-messages')
    
    <!-- Page Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Scripts -->
    <script>
        // Simple fade-in animation
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('opacity-0');
            setTimeout(() => {
                document.body.classList.remove('opacity-0');
                document.body.classList.add('transition-opacity', 'duration-500', 'ease-in-out');
            }, 100);
        });
    </script>
    
    @stack('scripts')
</body>
</html>