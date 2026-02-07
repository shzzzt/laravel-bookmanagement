<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PageTurner Bookstore')</title>
    
    <!-- JetBrains Mono Font -->
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'JetBrains Mono', monospace;
        }
        
        :root {
            --pastel-blue: #A8D8EA;
            --pastel-blue-dark: #7EC8E3;
            --pastel-yellow: #FFD89B;
            --pastel-yellow-dark: #FFCC7A;
            --light-bg: #FAFBFC;
            --white: #FFFFFF;
            --dark-text: #2C3E50;
            --light-text: #5A6C7D;
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
        }
        
        .btn-primary {
            background-color: var(--pastel-blue);
            color: var(--dark-text);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: var(--pastel-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(168, 216, 234, 0.3);
        }
        
        .btn-secondary {
            background-color: var(--pastel-yellow);
            color: var(--dark-text);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background-color: var(--pastel-yellow-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 216, 155, 0.3);
        }
        
        .card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(168, 216, 234, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 8px 24px rgba(168, 216, 234, 0.2);
            transform: translateY(-4px);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-yellow) 100%);
            color: var(--dark-text);
        }
        
        .badge-blue {
            background-color: rgba(168, 216, 234, 0.2);
            color: var(--pastel-blue-dark);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-yellow {
            background-color: rgba(255, 216, 155, 0.2);
            color: var(--pastel-yellow-dark);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select,
        textarea {
            border: 2px solid var(--pastel-blue);
            border-radius: 8px;
            padding: 10px 14px;
            font-family: 'JetBrains Mono', monospace;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--pastel-blue-dark);
            box-shadow: 0 0 0 3px rgba(168, 216, 234, 0.1);
        }
        
        .star-yellow {
            color: var(--pastel-yellow-dark);
        }
        
        .star-empty {
            color: #E0E0E0;
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        @include('partials.navigation')
        
        @hasSection('header')
            <header class="gradient-header shadow-md">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif
        
        @include('partials.flash-messages')
        
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
        
        @include('partials.footer')
    </div>
    
    @stack('scripts')
</body>
</html>