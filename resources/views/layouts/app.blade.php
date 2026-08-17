<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />

    <!-- Video Player -->
    <link href="{{ asset('video-player.css') }}" rel="stylesheet" type="text/css" />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @filamentStyles

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @livewireStyles
</head>
<body style="background:#0F1319; color:#E4EEF8; font-family:'DM Sans',system-ui,sans-serif;">
    <livewire:nav />
    
    <main>
        {{ $slot }}
    </main>

    <livewire:footer />

    @livewireScripts
    @filamentScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
        document.addEventListener('livewire:navigated', function() {
            lucide.createIcons();
        });
    </script>
    <script src="{{ asset('video-player.js') }}"></script>
</body>
</html>
