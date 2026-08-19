<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ $metaDescription ?? 'Grand Horizon Hotel & Suites — Experience luxury redefined. Premium accommodations, world-class amenities, and unforgettable moments await.' }}">

    <title>{{ $title ?? 'Grand Horizon Hotel & Suites' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Dark Mode Initializer -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            --hotel-navy: #0f172a;
            --hotel-navy-light: #1e293b;
            --hotel-gold: #d4a853;
            --hotel-gold-light: #e8c878;
            --hotel-gold-dark: #b8922f;
            --hotel-cream: #faf7f2;
            --hotel-cream-dark: #f0ebe3;
            --hotel-slate: #64748b;
            --hotel-bg: #faf7f2;
            --hotel-card: #ffffff;
            --hotel-card-subtle: #f8fafc;
            --hotel-border: #e2e8f0;
            --hotel-text: #334155;
            --hotel-heading: #0f172a;
            --hotel-subtext: #64748b;
        }

        .dark {
            --hotel-bg: #090d16;
            --hotel-card: #111827;
            --hotel-card-subtle: #1a2234;
            --hotel-border: rgba(212, 168, 83, 0.18);
            --hotel-text: #cbd5e1;
            --hotel-heading: #f8fafc;
            --hotel-subtext: #94a3b8;
        }

        .font-playfair {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-inter {
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Fade-in animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 168, 83, 0.15);
        }

        /* Gold gradient text */
        .text-gradient-gold {
            background: linear-gradient(135deg, #d4a853, #e8c878, #d4a853);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Gold border shimmer */
        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .border-shimmer {
            border-image: linear-gradient(90deg, transparent, #d4a853, transparent) 1;
            animation: shimmer 3s ease-in-out infinite;
            background-size: 200% auto;
        }

        /* Parallax */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media (max-width: 768px) {
            .parallax-bg {
                background-attachment: scroll;
            }
        }
    </style>
</head>

<body class="font-inter antialiased transition-colors duration-300" style="color: var(--hotel-text); background-color: var(--hotel-bg);">
    {{ $slot }}

    @livewireScripts
</body>

</html>