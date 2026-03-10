<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PageTurner Bookstore') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
                        'yellow': '#ffd724',
                    },
                    fontFamily: {
                        'mono': ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
</head>

<body class="font-mono text-gray-800 antialiased bg-gradient-to-br from-pastel-blue/50 to-pastel-yellow/60 min-h-screen">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
        <div class="w-full sm:max-w-md bg-white/95 backdrop-blur-sm border border-pastel-blue/40 shadow-lg rounded-2xl px-6 py-6">
            {{ $slot }}
        </div>
    </div>
</body>

</html>