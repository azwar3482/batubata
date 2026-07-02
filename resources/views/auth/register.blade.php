<x-guest-layout>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 relative">

        <!-- Dark Mode Toggle -->
        <button type="button" id="theme-toggle"
            class="absolute top-4 right-4 p-2.5 rounded-full bg-white dark:bg-slate-700 shadow-md border border-gray-200 dark:border-slate-600 hover:scale-110 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
            aria-label="Toggle dark mode">
            <!-- Sun icon -->
            <svg id="theme-toggle-light-icon" class="w-5 h-5 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <!-- Moon icon -->
            <svg id="theme-toggle-dark-icon" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <!-- Logo -->
        <div class="mb-8">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-auto dark:bg-white dark:p-1.5 dark:rounded-xl">
                <span
                    class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-400 dark:to-indigo-500 bg-clip-text text-transparent">KOMPASKARIR</span>
            </a>
        </div>

        <div class="w-full sm:max-w-lg mt-6 px-6 py-8 bg-white dark:bg-slate-800 shadow-2xl overflow-hidden sm:rounded-2xl border dark:border-slate-700">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.create_new_account') }}</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">{{ __('messages.join_platform') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                            {{ __('messages.full_name') }}
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autofocus autocomplete="name"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                            placeholder="John Doe">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                            Email Address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

                    <!-- Role Selection -->
                    <div class="md:col-span-2">
                        <div class="flex items-center justify-between mb-2">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('messages.register_as') }}
                            </label>
                            <button type="button" id="start-role-tour"
                                class="animate-pulse flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 rounded-full transition-colors border border-blue-200 dark:border-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.role_explanation') }}
                            </button>
                        </div>
                        <select id="role" name="role" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('role') border-red-500 @enderror">
                            <option value="">-- {{ __('messages.choose_your_role') }} --</option>
                            <option value="job_seeker" {{ old('role') === 'job_seeker' ? 'selected' : '' }}>👤 {{ __('messages.job_seeker_role') }}</option>
                            <option value="industry" {{ old('role') === 'industry' ? 'selected' : '' }}>🏢 {{ __('messages.industry_role') }}</option>
                            <option value="education" {{ old('role') === 'education' ? 'selected' : '' }}>🎓 {{ __('messages.education_role') }}</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>⚙️ {{ __('messages.admin_role') }}</option>
                        </select>
                        @error('role')
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
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition pr-10 @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                <svg id="password-eye" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="password-eye-slash" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
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

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                            {{ __('messages.confirm_password') }}
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition pr-10">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                <svg id="password_confirmation-eye" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="password_confirmation-eye-slash" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <p id="password-match-error" class="mt-2 text-sm text-red-600 hidden items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.password_mismatch') }}
                        </p>
                        <p id="password-match-success" class="mt-2 text-sm text-green-600 hidden items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('messages.password_match') }}
                        </p>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="mt-6">
                    <label class="flex items-start">
                        <input id="terms" type="checkbox" name="terms" required
                            class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-blue-600 shadow-sm focus:ring-blue-500 mt-1 transition-colors">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                            {{ __('messages.i_agree_terms') }}
                            <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium underline">{{ __('messages.terms_conditions') }}</a>,
                            <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium underline">{{ __('messages.privacy_policy') }}</a>,
                            {{ __('messages.data_processing_consent') }}
                        </span>
                    </label>
                    @error('terms')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                        {{ __('messages.create_free_account') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </form>

                <!-- Google Register -->
                <div class="mt-6">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-slate-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white dark:bg-slate-800 text-gray-500 dark:text-gray-400">{{ __('messages.or_register_with') }}</span>
                        </div>
                    </div>

                    <button type="button" onclick="registerWithGoogle()"
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
                        {{ __('messages.register_with_google') }}
                    </button>
                </div>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    {{ __('messages.already_have_account') }}
                    <a href="{{ route('login') }}"
                        class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                        {{ __('messages.login_here') }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="mt-8 text-center">
            <a href="/" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">← {{ __('messages.back_to_home') }}</a>
        </div>
    </div>

    <script>
        function initThemeToggle() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');

            if (!themeToggleBtn) return;

            function updateIcons() {
                const isDark = document.documentElement.classList.contains('dark');
                lightIcon.classList.toggle('hidden', !isDark);
                darkIcon.classList.toggle('hidden', isDark);
            }

            updateIcons();

            themeToggleBtn.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
                updateIcons();
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initThemeToggle();

            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const errorText = document.getElementById('password-match-error');
            const successText = document.getElementById('password-match-success');
            const submitBtn = document.querySelector('button[type="submit"]');

            function validatePasswordMatch() {
                if (!confirmPassword.value) {
                    errorText.classList.add('hidden');
                    errorText.classList.remove('flex');
                    successText.classList.add('hidden');
                    successText.classList.remove('flex');
                    confirmPassword.classList.remove('border-red-500', 'border-green-500');
                    return;
                }

                if (password.value !== confirmPassword.value) {
                    errorText.classList.remove('hidden');
                    errorText.classList.add('flex');
                    successText.classList.add('hidden');
                    successText.classList.remove('flex');
                    confirmPassword.classList.add('border-red-500');
                    confirmPassword.classList.remove('border-green-500');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    errorText.classList.add('hidden');
                    errorText.classList.remove('flex');
                    successText.classList.remove('hidden');
                    successText.classList.add('flex');
                    confirmPassword.classList.remove('border-red-500');
                    confirmPassword.classList.add('border-green-500');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            password.addEventListener('input', validatePasswordMatch);
            confirmPassword.addEventListener('input', validatePasswordMatch);

            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (password.value !== confirmPassword.value) {
                        e.preventDefault();
                        validatePasswordMatch(); // Tampilkan error
                    }
                });
            }
        });

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId + '-eye');
            const eyeSlashIcon = document.getElementById(inputId + '-eye-slash');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        function registerWithGoogle() {
            const role = document.getElementById('role');
            if (!role || !role.value) {
                alert('{{ __("messages.select_role_first") }}');
                return;
            }

            const terms = document.getElementById('terms');
            if (terms && !terms.checked) {
                alert('{{ __("messages.agree_terms_first") }}');
                terms.focus();
                terms.classList.add('ring-2', 'ring-red-500', 'border-red-500');
                setTimeout(() => terms.classList.remove('ring-2', 'ring-red-500', 'border-red-500'), 2000);
                return;
            }

            window.location.href = "{{ route('auth.google') }}?role=" + role.value;
        }
    </script>

    <!-- Driver.js for Tour -->
    @vite(['resources/js/driver.js'])

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const startRoleTourBtn = document.getElementById('start-role-tour');
            if (startRoleTourBtn) {
                startRoleTourBtn.addEventListener('click', () => {
                    const roleSelect = document.getElementById('role');
                    const originalValue = roleSelect.value;
                    const roleValues = ['', 'job_seeker', 'industry', 'education', 'admin'];

                    const steps = [
                        {
                            element: '#role',
                            popover: {
                                title: '{{ __("messages.role_explanation") }}',
                                description: 'Platform ini melayani berbagai jenis pengguna. Mari kita pelajari perbedaan masing-masing peran agar Anda tidak salah pilih!',
                                side: "top",
                                align: 'start'
                            }
                        },
                        {
                            element: '#role',
                            popover: {
                                title: '{{ __("messages.job_seeker_role") }}',
                                description: '<b>Untuk Individu:</b> Pilih ini jika Anda ingin mencari lowongan kerja, mengikuti tes asesmen keahlian, dan melamar pekerjaan ke berbagai perusahaan impian Anda.',
                                side: "top",
                                align: 'start'
                            }
                        },
                        {
                            element: '#role',
                            popover: {
                                title: '{{ __("messages.industry_role") }}',
                                description: '<b>Untuk Rekruter/HRD:</b> Pilih ini jika Anda mewakili perusahaan yang ingin memasang iklan lowongan, menyeleksi kandidat, dan melihat skor analisis keahlian pelamar.',
                                side: "top",
                                align: 'start'
                            }
                        },
                        {
                            element: '#role',
                            popover: {
                                title: '{{ __("messages.education_role") }}',
                                description: '<b>Untuk Universitas/Sekolah:</b> Pilih ini jika Anda dari pihak akademis yang ingin memantau keterserapan kerja alumni dan melihat tren keahlian yang sedang dicari industri.',
                                side: "top",
                                align: 'start'
                            }
                        },
                        {
                            element: '#role',
                            popover: {
                                title: '{{ __("messages.admin_role") }}',
                                description: '<b>Untuk Pengelola Sistem:</b> Ini adalah akun khusus untuk mengatur master data sistem, melihat laporan keseluruhan, dan mengawasi jalannya platform.',
                                side: "top",
                                align: 'start'
                            }
                        }
                    ];

                    steps.forEach((step, i) => {
                        step.onHighlightStarted = () => {
                            roleSelect.value = roleValues[i];
                            roleSelect.dispatchEvent(new Event('change'));
                            roleSelect.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
                        };
                    });

                    window.createTour(steps, {
                        onDestroyed: () => {
                            roleSelect.value = originalValue;
                            roleSelect.dispatchEvent(new Event('change'));
                            roleSelect.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                        }
                    }).drive();
                });
            }
        });
    </script>
    <style>
        /* Driver.js Custom Styling - consistent with login page */
        .driverjs-theme {
            font-family: inherit;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        .driver-popover-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1f2937; /* text-gray-900 */
        }
        .driver-popover-description {
            font-size: 13.5px;
            line-height: 1.5;
            color: #4b5563; /* text-gray-600 */
        }
        .driver-popover-description b {
            color: #1f2937;
        }
        .driver-popover-footer {
            margin-top: 12px;
        }
        .driver-popover-progress-text {
            font-size: 12px;
            color: #6b7280;
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            html.dark .driverjs-theme {
                background-color: #1e293b; /* bg-slate-800 */
                color: #e2e8f0;
            }
            html.dark .driver-popover-title {
                color: #f8fafc;
            }
            html.dark .driver-popover-description {
                color: #cbd5e1; /* text-slate-300 */
            }
            html.dark .driver-popover-description b {
                color: #f8fafc;
            }
            html.dark .driver-popover-progress-text {
                color: #94a3b8;
            }
            html.dark .driver-popover-footer .driver-popover-btn {
                background-color: #334155;
                color: #f8fafc;
                border: 1px solid #475569;
                text-shadow: none;
            }
            html.dark .driver-popover-footer .driver-popover-btn:hover {
                background-color: #475569;
            }
            html.dark .driver-popover-arrow {
                border-color: #1e293b;
            }
        }
    </style>
</x-guest-layout>
