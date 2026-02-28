<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            primary: '#4f46e5', // indigo-600
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50 selection:bg-indigo-500 selection:text-white">
        
        <!-- Abstract Background Shapes -->
        <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-50 via-white to-white"></div>
        <div class="fixed top-0 right-0 -translate-y-12 translate-x-1/3 w-[800px] h-[800px] opacity-30 rounded-full bg-gradient-to-tr from-indigo-200 to-purple-100 blur-3xl -z-10 pointer-events-none"></div>
        <div class="fixed bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[600px] h-[600px] opacity-40 rounded-full bg-gradient-to-tr from-cyan-100 to-indigo-100 blur-3xl -z-10 pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-bold text-3xl shadow-xl shadow-indigo-600/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-slate-800">Perpus<span class="text-indigo-600">Digital</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white/80 backdrop-blur-xl shadow-2xl shadow-slate-200/50 border border-white/50 overflow-hidden sm:rounded-3xl relative z-10">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-sm text-slate-500 hover:text-slate-700 transition">&copy; {{ date('Y') }} Sistem Perpustakaan Digital</p>
        </div>
    </body>
</html>
