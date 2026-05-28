<x-guest-layout>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/" class="flex flex-col items-center space-y-2 space-x-0">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-auto">
                <span
                    class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-400 dark:to-indigo-500 bg-clip-text text-transparent">
                    KOMPAS KARIR
                </span>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-slate-800 shadow-2xl overflow-hidden sm:rounded-2xl border dark:border-slate-700">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang Kembali</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Login untuk melanjutkan perjalanan karir Anda</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full pr-12 px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                            placeholder="••••••••">

                        <button type="button" id="toggle-password"
                            class="absolute top-1/2 right-3 -translate-y-1/2 flex items-center justify-center w-9 h-9 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full transition-all duration-200"
                            aria-label="Show password" aria-pressed="false">
                            <span class="relative w-5 h-5 flex items-center justify-center">
                                <!-- eye (show) -->
                                <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor"
                                    class="w-5 h-5 absolute transition-all duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- eye-off (hide) -->
                                <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor"
                                    class="w-5 h-5 absolute transition-all duration-300 opacity-0 scale-75">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.963 9.963 0 014.575-5.783" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.88 9.88a3 3 0 004.243 4.243" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.73 5.08A10.05 10.05 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.963 9.963 0 01-3.13 4.643" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                    Login
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-slate-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white dark:bg-slate-800 text-gray-500 dark:text-gray-400">Atau</span>
                </div>
            </div>

            <!-- Google Login -->
            <div class="space-y-3">
                <a href="{{ route('auth.google') }}"
                    class="w-full flex items-center justify-center py-3 px-4 border border-gray-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12-4.53z"
                            fill="#EA4335" />
                    </svg>
                    Lanjutkan dengan Google
                </a>
            </div>

            <!-- Quick Login (Demo) -->
            <div class="mt-8 border-t border-gray-100 dark:border-slate-700 pt-6">
                <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4 text-center">
                    Akses Cepat (Demo)
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" 
                        onclick="fillLogin('admin@kompaskarir.id', 'password')"
                        class="flex items-center p-3 text-left border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:border-blue-200 dark:hover:border-blue-500/50 transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">Admin</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate mt-0.5">Portal Admin</p>
                        </div>
                    </button>

                    <button type="button" 
                        onclick="fillLogin('budi@seeker.com', 'password')"
                        class="flex items-center p-3 text-left border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-200 dark:hover:border-emerald-500/50 transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/50 transition-colors">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">Pencari Kerja</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate mt-0.5">Budi Seeker</p>
                        </div>
                    </button>

                    <button type="button" 
                        onclick="fillLogin('hrd@techcorp.com', 'password')"
                        class="flex items-center p-3 text-left border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:border-indigo-200 dark:hover:border-indigo-500/50 transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/50 transition-colors">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">Industri</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate mt-0.5">HRD Tech Corp</p>
                        </div>
                    </button>

                    <button type="button" 
                        onclick="fillLogin('info@univdigital.ac.id', 'password')"
                        class="flex items-center p-3 text-left border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-amber-50 dark:hover:bg-amber-900/30 hover:border-amber-200 dark:hover:border-amber-500/50 transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/50 rounded-lg group-hover:bg-amber-200 dark:group-hover:bg-amber-800/50 transition-colors">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">Pendidikan</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate mt-0.5">Univ Digital</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                        Daftar Gratis
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="mt-8 text-center">
            <a href="/" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">← Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        function fillLogin(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            emailInput.value = email;
            passwordInput.value = password;
            
            // Visual feedback
            emailInput.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
            passwordInput.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
            
            setTimeout(() => {
                emailInput.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                passwordInput.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
            }, 1000);

            emailInput.focus();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('toggle-password');
            const iconEye = document.getElementById('icon-eye');
            const iconEyeOff = document.getElementById('icon-eye-off');

            if (!passwordInput || !toggleBtn) return;

            toggleBtn.addEventListener('click', () => {
                const isPasswordHidden = passwordInput.type === 'password';
                passwordInput.type = isPasswordHidden ? 'text' : 'password';

                // Update accessibility attributes
                toggleBtn.setAttribute('aria-pressed', String(!isPasswordHidden));
                toggleBtn.setAttribute('aria-label', isPasswordHidden ? 'Hide password' : 'Show password');

                // Update visual feedback
                if (isPasswordHidden) {
                    toggleBtn.classList.add('text-blue-600', 'bg-blue-50');
                    toggleBtn.classList.remove('text-gray-400');

                    iconEye.classList.add('opacity-0', 'scale-75');
                    iconEyeOff.classList.remove('opacity-0', 'scale-75');
                } else {
                    toggleBtn.classList.remove('text-blue-600', 'bg-blue-50');
                    toggleBtn.classList.add('text-gray-400');

                    iconEye.classList.remove('opacity-0', 'scale-75');
                    iconEyeOff.classList.add('opacity-0', 'scale-75');
                }
            });
        });
    </script>
</x-guest-layout>
