<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Perpustakaan Digital</title>
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
<body class="font-sans antialiased text-gray-900 bg-slate-50 selection:bg-indigo-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-600/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">Perpus<span class="text-indigo-600">Digital</span></span>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        @php
                            $dashboardRoute = 'user.beranda';
                            if(auth()->user()->role == 'admin') $dashboardRoute = 'admin.dashboard';
                            if(auth()->user()->role == 'petugas') $dashboardRoute = 'petugas.dashboard';
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all bg-indigo-600 rounded-full hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-600/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 transition-all hover:text-indigo-600">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all bg-indigo-600 rounded-full hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-600/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                Daftar Sekarang
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Abstract Background Shapes -->
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-50 via-white to-white"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[800px] h-[800px] opacity-30 rounded-full bg-gradient-to-tr from-indigo-200 to-purple-100 blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[600px] h-[600px] opacity-40 rounded-full bg-gradient-to-tr from-cyan-100 to-indigo-100 blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 text-sm font-medium mb-8 border border-indigo-100 shadow-sm animate-fade-in-up">
                    <span class="flex w-2 h-2 rounded-full bg-indigo-600 mr-2 animate-pulse"></span>
                    Sistem Perpustakaan Masa Kini
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-8 leading-[1.1]">
                    Jelajahi Dunia Lewat <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Satu Ketukan</span>
                </h1>
                <p class="mt-6 text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Akses ribuan koleksi buku digital, pinjam dengan mudah, dan nikmati pengalaman membaca yang tak terbatas. Semua dalam satu platform perpustakaan modern.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    @guest
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white transition-all bg-indigo-600 rounded-full hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-600/30 hover:-translate-y-1">
                            Mulai Keanggotaan
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                        <a href="#fitur" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-slate-700 transition-all bg-white border border-slate-200 rounded-full hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm">
                            Pelajari Fitur
                        </a>
                    @else
                        <a href="{{ route($dashboardRoute) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white transition-all bg-indigo-600 rounded-full hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-600/30 hover:-translate-y-1">
                            Lanjutkan Membaca
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </a>
                    @endguest
                </div>
            </div>

            <!-- Stats/Image Mockup Area -->
            <div class="mt-20 relative max-w-5xl mx-auto">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-50 relative top-20 z-10"></div>
                <!-- Browser Mockup -->
                <div class="relative rounded-2xl bg-slate-800/5 ring-1 ring-slate-900/10 shadow-2xl overflow-hidden backdrop-blur-sm transform hover:-translate-y-2 transition-transform duration-500">
                    <div class="flex items-center px-4 py-3 bg-slate-900/5 border-b border-slate-900/10 flex-col sm:flex-row gap-2">
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="w-full sm:w-1/2 mx-auto bg-white/50 rounded-md h-6 px-4 flex items-center shadow-inner">
                            <span class="text-xs text-slate-500 font-mono">https://perpus-1.test</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-4 sm:p-10 aspect-square sm:aspect-video flex relative overflow-hidden">
                        <!-- Simulated App Content -->
                        <div class="w-full flex gap-6 opacity-80">
                            <!-- Sidebar -->
                            <div class="hidden sm:block w-48 bg-white rounded-xl shadow-sm border border-slate-100 p-4 shrink-0">
                                <div class="w-24 h-4 bg-slate-200 rounded mb-8"></div>
                                <div class="space-y-4">
                                    <div class="w-full h-8 bg-indigo-50 rounded"></div>
                                    <div class="w-3/4 h-8 bg-slate-100 rounded"></div>
                                    <div class="w-5/6 h-8 bg-slate-100 rounded"></div>
                                </div>
                            </div>
                            <!-- Main Content Grid -->
                            <div class="flex-1 flex flex-col gap-6 w-full">
                                <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-slate-100 shrink-0">
                                    <div class="w-32 sm:w-48 h-8 bg-slate-100 rounded-full"></div>
                                    <div class="w-10 h-10 bg-slate-200 rounded-full shrink-0"></div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <!-- Book Card Skeletons -->
                                    <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                                        <div class="w-full aspect-[3/4] bg-slate-200 rounded-lg mb-3"></div>
                                        <div class="w-3/4 h-3 bg-slate-200 rounded mb-2"></div>
                                        <div class="w-1/2 h-2 bg-slate-100 rounded"></div>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                                        <div class="w-full aspect-[3/4] bg-indigo-100 rounded-lg mb-3 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-indigo-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <div class="w-3/4 h-3 bg-indigo-200 rounded mb-2"></div>
                                        <div class="w-1/2 h-2 bg-indigo-100 rounded"></div>
                                    </div>
                                    <div class="hidden md:block bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                                        <div class="w-full aspect-[3/4] bg-slate-200 rounded-lg mb-3"></div>
                                        <div class="w-3/4 h-3 bg-slate-200 rounded mb-2"></div>
                                        <div class="w-1/2 h-2 bg-slate-100 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="absolute bottom-6 sm:bottom-10 right-6 sm:right-10 bg-white/95 backdrop-blur rounded-2xl shadow-xl p-4 border border-white/20 animate-bounce cursor-default max-w-[200px] sm:max-w-none">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 shrink-0 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-800 truncate">Pinjaman Disetujui</p>
                                    <p class="text-xs text-slate-500 truncate">Buku siap dibaca!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <h2 class="text-indigo-600 font-semibold tracking-wide uppercase text-sm mb-3">Platform Modern</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Membaca Jadi Lebih Menyenangkan</h3>
                <p class="text-lg text-slate-600">Nikmati berbagai fitur yang dirancang khusus untuk kenyamanan Anda dalam menjelajahi dan meminjam buku favorit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50 transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Koleksi Lengkap</h4>
                    <p class="text-slate-600 leading-relaxed">Ratusan judul buku fiksi, non-fiksi, hingga jurnal akademik tersedia dalam katalog digital yang selalu kami perbarui.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50 transition-all duration-300">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Peminjaman Mudah</h4>
                    <p class="text-slate-600 leading-relaxed">Sistem persetujuan yang cepat dan efisien. Pinjam kapan saja dengan durasi hingga 14 hari tanpa proses yang rumit.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50 transition-all duration-300">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Koleksi Pribadi</h4>
                    <p class="text-slate-600 leading-relaxed">Simpan buku impian Anda ke dalam daftar keinginan. Tinggalkan ulasan untuk membantu pembaca lain menemukan buku yang bagus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 w-[500px] h-[500px] rounded-full bg-indigo-500/30 blur-[100px] z-0"></div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Siap Memulai Petualangan Membaca?</h2>
            <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto opacity-90">Bergabunglah dengan ribuan pembaca setia lainnya dan dapatkan akses eksklusif ke berbagai literatur unggulan.</p>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-slate-900 transition-all bg-white rounded-full hover:bg-indigo-50 hover:shadow-xl hover:shadow-white/20 hover:-translate-y-1">
                    Buat Akun Gratis Sekarang
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="font-bold text-xl text-white">Perpus<span class="text-indigo-400">Digital</span></span>
                </div>
                <!-- Links -->
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <a href="#" class="hover:text-white transition-colors">Tentang Kami</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Kontak</a>
                </div>
                <div class="text-sm">
                    &copy; {{ date('Y') }} Perpus Digital. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Animations CSS & Nav Script -->
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        // Navbar blur on scroll
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-sm');
                navbar.classList.replace('bg-white/80', 'bg-white/95');
            } else {
                navbar.classList.remove('shadow-sm');
                navbar.classList.replace('bg-white/95', 'bg-white/80');
            }
        });
    </script>
</body>
</html>
