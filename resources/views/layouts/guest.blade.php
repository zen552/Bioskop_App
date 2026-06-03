<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            
            /* Overriding Breeze component styles inside the cinema auth card */
            .auth-card input[type="text"],
            .auth-card input[type="email"],
            .auth-card input[type="password"] {
                background-color: #0f0f13 !important;
                border-color: rgba(255, 255, 255, 0.1) !important;
                color: #ffffff !important;
                border-radius: 0.75rem !important; /* rounded-xl */
                font-size: 0.875rem !important;
                padding-top: 0.625rem !important;
                padding-bottom: 0.625rem !important;
            }
            .auth-card input[type="text"]:focus,
            .auth-card input[type="email"]:focus,
            .auth-card input[type="password"]:focus {
                border-color: #6366f1 !important; /* indigo-500 */
                box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important;
            }
            .auth-card label {
                color: #d1d5db !important; /* text-gray-300 */
                font-weight: 500 !important;
                font-size: 0.75rem !important;
                letter-spacing: 0.05em !important;
                text-transform: uppercase !important;
            }
            .auth-card button[type="submit"] {
                background-color: #4f46e5 !important; /* indigo-600 */
                color: #ffffff !important;
                border-radius: 9999px !important; /* rounded-full */
                font-weight: 600 !important;
                text-transform: none !important;
                letter-spacing: normal !important;
                font-size: 0.875rem !important;
                padding: 0.75rem 1.5rem !important;
                width: 100% !important;
                justify-content: center !important;
                transition: all 0.2s ease-in-out !important;
                border: none !important;
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3) !important;
            }
            .auth-card button[type="submit"]:hover {
                background-color: #6366f1 !important; /* indigo-500 */
                transform: translateY(-1px) !important;
                box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4) !important;
            }
            .auth-card a {
                color: #818cf8 !important; /* indigo-400 */
                text-decoration: none !important;
                transition: color 0.15s ease !important;
            }
            .auth-card a:hover {
                color: #a5b4fc !important; /* indigo-300 */
            }
            .auth-card .text-red-600 {
                color: #f87171 !important; /* red-400 */
            }
            .auth-card .text-green-600 {
                color: #34d399 !important; /* emerald-400 */
            }
        </style>
    </head>
    <body class="font-sans text-gray-100 antialiased bg-[#0f0f13] min-h-screen relative overflow-x-hidden">
        <!-- Ambient Glowing Lights -->
        <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-indigo-500/10 blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-amber-500/5 blur-[120px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 px-4">
            <!-- Brand Logo -->
            <div class="mb-6">
                <a href="/" class="text-3xl font-extrabold tracking-tight text-white hover:opacity-90 transition">
                    <span class="text-indigo-400">Bioskop</span>Ku
                </a>
            </div>

            <!-- Glassmorphism Card -->
            <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-[#16161d]/75 border border-white/5 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
