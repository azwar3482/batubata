<x-app-layout>
    <!-- Quill Editor -->
    @include('partials.quill-styles')
    <style>
.ql-toolbar.ql-snow { border-color: #e5e7eb; border-radius: 0.5rem 0.5rem 0 0; background: #f9fafb; }
.ql-container.ql-snow { border-color: #e5e7eb; border-radius: 0 0 0.5rem 0.5rem; min-height: 150px; font-size: 0.875rem; }
.ql-editor { min-height: 150px; }
.dark .ql-toolbar.ql-snow { background: #1e293b; border-color: #334155; }
.dark .ql-toolbar.ql-snow .ql-stroke { stroke: #cbd5e1; }
.dark .ql-toolbar.ql-snow .ql-fill { fill: #cbd5e1; }
.dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
.dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
.dark .ql-toolbar.ql-snow .ql-active .ql-stroke { stroke: #3b82f6; }
.dark .ql-toolbar.ql-snow .ql-active .ql-fill { fill: #3b82f6; }
.dark .ql-container.ql-snow { background: #1e293b; border-color: #334155; color: #f8fafc; }
.dark .ql-editor.ql-blank::before { color: #64748b; }
.dark .ql-snow .ql-picker { color: #cbd5e1; }
.dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #334155; }
.ql-snow .ql-tooltip { z-index: 50; }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-8" x-data="{ activeTab: 'tes' }" x-cloak>
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ __('messages.tpa_test_management') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('messages.manage_tpa_send_invitations') }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('industry.tpa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2 shadow-sm transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('messages.create_new_test') }}
                </a>
            </div>
        </div>

        {{-- ============ INFORMASI CARD ============ --}}
        <div class="mb-8 bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg shadow-purple-500/20 relative overflow-hidden border border-white/10">
            <!-- Decorative background shapes -->
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
            <div class="absolute bottom-0 right-20 -mb-10 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-50"></div>

            <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center md:items-start">
                <div class="flex-shrink-0 w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-inner">
                    <svg class="w-8 h-8 text-purple-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-2 tracking-tight text-white">{{ __('messages.centralized_candidate_evaluation') }}</h2>
                    <p class="text-purple-100 mb-5 text-sm leading-relaxed max-w-3xl">
                        Saring {{ __('messages.candidates') }} terbaik menggunakan Tes Potensi Akademik (TPA). Buat kustomisasi bobot soal, durasi, serta skor kelulusan yang spesifik untuk setiap lowongan Anda. Sistem akan otomatis memproses dan memberikan rekomendasi kelulusan.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 text-xs font-medium bg-black/20 backdrop-blur-sm px-3.5 py-2 rounded-xl border border-white/10 shadow-sm transition-transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.auto_grading') }}
                        </div>
                        <div class="flex items-center gap-2 text-xs font-medium bg-black/20 backdrop-blur-sm px-3.5 py-2 rounded-xl border border-white/10 shadow-sm transition-transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('messages.send_mass_invitations') }}
                        </div>
                        <div class="flex items-center gap-2 text-xs font-medium bg-black/20 backdrop-blur-sm px-3.5 py-2 rounded-xl border border-white/10 shadow-sm transition-transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('messages.customize_question_composition') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif
        @if(session('invite_errors') && count(session('invite_errors')) > 0)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach(session('invite_errors') as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- NAVIGATION TABS --}}
        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <button @click="activeTab = 'tes'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'tes', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tes' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('messages.my_tpa_tests') }}
                </button>
                <button @click="activeTab = 'kirim'"
                    :class="{ 'border-purple-500 text-purple-600': activeTab === 'kirim', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'kirim' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    {{ __('messages.send_invitation') }}
                </button>
                <button @click="activeTab = 'riwayat'"
                    :class="{ 'border-green-500 text-green-600': activeTab === 'riwayat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'riwayat' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('messages.invitation_history') }}
                </button>
            </nav>
        </div>

        {{-- TAB CONTENT: TES TPA SAYA --}}
        <div x-show="activeTab === 'tes'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            @if($tests->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-12 text-center mb-6 border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('messages.no_tpa_tests_yet') }}</h3>
                <p class="text-gray-500 mb-4">Buat tes baru untuk mulai menggunakan fitur TPA pada proses seleksi Anda.</p>
                <a href="{{ route('industry.tpa.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg font-medium transition-colors">
                    {{ __('messages.create_test_now') }}
                </a>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gray-50 border-b flex items-center justify-between">
                    <h2 class="font-bold text-lg text-gray-800">{{ __('messages.tpa_test_list') }}</h2>
                    <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold">{{ $tests->count() }} Tes</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.title') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.vacancy') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.question_detail') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($tests as $test)
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $test->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ __('messages.passing_grade') }} {{ $test->passing_score }}%</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($test->jobListing)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $test->jobListing->title }}
                                    </div>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-purple-600 bg-purple-50 px-2 py-1 rounded-md text-xs font-medium">
                                        {{ __('messages.global_template') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center text-sm">
                                        <span class="font-medium text-gray-700">{{ $test->total_questions }} Soal</span>
                                        <span class="text-xs text-gray-500 mt-0.5"><i class="far fa-clock mr-1"></i>{{ $test->time_limit_minutes }} {{ __('messages.minutes') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($test->is_active)
                                    <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-medium border border-green-200">{{ __('messages.active') }}</span>
                                    @else
                                    <span class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-medium border border-gray-200">{{ __('messages.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('industry.tpa.edit', $test) }}" class="text-blue-600 hover:text-blue-800 transition-colors p-1" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('industry.tpa.destroy', $test) }}" method="POST" onsubmit="return confirm('Hapus tes ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors p-1" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- TAB CONTENT: KIRIM UNDANGAN TPA --}}
        <div x-show="activeTab === 'kirim'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100" x-data="bulkInvite()">
                <div class="px-6 py-5 bg-gradient-to-r from-purple-600 to-indigo-700 text-white flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Pilih Kandidat & {{ __('messages.send_invitation') }}
                        </h2>
                        <p class="text-sm opacity-90 mt-1">{{ __('messages.invite_candidates_passed_doc_selection') }}</p>
                    </div>
                </div>

                <div class="p-6">
                    {{-- TIPE TPA --}}
                    <div class="mb-6 bg-gray-50 dark:bg-slate-800/50 p-5 rounded-xl border border-gray-200 dark:border-slate-700">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-slate-200 mb-3">1. {{ __('messages.select_tpa_test_type') }}</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative cursor-pointer" @click="tpaType = 'online'">
                                <input type="radio" name="tpa_type" value="online" x-model="tpaType" class="sr-only">
                                <div class="p-4 border-2 rounded-xl transition-all"
                                     :class="tpaType === 'online' ? 'border-purple-500 bg-purple-50 dark:border-purple-400 dark:bg-purple-900/40' : 'border-gray-200 dark:border-slate-700 hover:border-gray-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800'">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 dark:text-slate-200">{{ __('messages.online_test') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-slate-400">{{ __('messages.candidate_works_in_browser') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer" @click="tpaType = 'offline'">
                                <input type="radio" name="tpa_type" value="offline" x-model="tpaType" class="sr-only">
                                <div class="p-4 border-2 rounded-xl transition-all"
                                     :class="tpaType === 'offline' ? 'border-amber-500 bg-amber-50 dark:border-amber-400 dark:bg-amber-900/40' : 'border-gray-200 dark:border-slate-700 hover:border-gray-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800'">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 dark:text-slate-200">{{ __('messages.offline_test') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-slate-400">{{ __('messages.candidate_comes_to_location') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- PILIH TES (hanya untuk online) --}}
                    <div x-show="tpaType === 'online'" x-transition class="mb-6 bg-purple-50 dark:bg-purple-900/10 p-5 rounded-xl border border-purple-100 dark:border-purple-900/30">
                        <label class="block text-sm font-semibold text-purple-900 dark:text-purple-300 mb-2">2. {{ __('messages.select_tpa_test_to_use') }}</label>
                        <select x-model="selectedTest" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm">
                            <option value="">-- Silakan Pilih Tes TPA --</option>
                            @foreach($tests as $test)
                            <option value="{{ $test->id }}">{{ $test->title }} &mdash; {{ $test->total_questions }} soal ({{ $test->time_limit_minutes }} {{ __('messages.minutes') }}) | Passing: {{ $test->passing_score }}%</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- FORM OFFLINE --}}
                    <div x-show="tpaType === 'offline'" x-transition class="mb-6">
                        <form id="offlineForm" action="{{ route('industry.tpa.bulk-invite-offline') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tpa_test_id" value="">
                            <template x-for="id in selectedApplications" :key="id">
                                <input type="hidden" name="application_ids[]" :value="id">
                            </template>

                            <div class="bg-amber-50 dark:bg-amber-900/10 p-5 rounded-xl border border-amber-200 dark:border-amber-900/30">
                                <h3 class="font-semibold text-amber-900 dark:text-amber-300 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Detail {{ __('messages.offline_test') }}
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.test_title') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="offline_title" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-amber-500 focus:border-amber-500"
                                            placeholder="Contoh: Tes TPA Offline - Web Developer" value="Tes TPA Offline">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.test_instructions') }} <span class="text-red-500">*</span></label>
                                        <input id="offline_instructions" type="hidden" name="offline_instructions">
                                        <div id="quill-offline_instructions"></div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal & Waktu <span class="text-red-500">*</span></label>
                                            <input type="datetime-local" name="offline_scheduled_at" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-amber-500 focus:border-amber-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.test_location') }} <span class="text-red-500">*</span></label>
                                            <input type="text" name="offline_location" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-amber-500 focus:border-amber-500"
                                                placeholder="Contoh: Kantor Pusat, Lt. 3, Ruang HRD">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.pic_responsible_person') }}</label>
                                            <input type="text" name="offline_contact_person" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-amber-500 focus:border-amber-500"
                                                placeholder="Nama PIC">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.pic_phone_number') }}</label>
                                            <input type="text" name="offline_contact_phone" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-amber-500 focus:border-amber-500"
                                                placeholder="08xxxxxxxxxx">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Passing Score (%)</label>
                                        <input type="number" name="offline_passing_score" value="60" min="0" max="100"
                                            class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-amber-500 focus:border-amber-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.additional_notes') }}</label>
                                        <input id="offline_notes" type="hidden" name="offline_notes">
                                        <div id="quill-offline_notes"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @php
                    $user = auth()->user();
                    $jobIds = \App\Models\JobListing::where('user_id', $user->id)->pluck('id');
                    $jobs = \App\Models\JobListing::whereIn('id', $jobIds)->where('is_active', true)->get();
                    $hasCandidates = false;

                    // {{ __('messages.filter') }} jobs that actually have candidates
                    $jobsWithCandidates = [];
                    foreach($jobs as $job) {
                    $count = \App\Models\UserJobApplication::where('job_listing_id', $job->id)
                    ->where('status', '!=', 'rejected')
                    ->where('tpa_status', 'not_required')
                    ->count();
                    if ($count > 0) {
                    $jobsWithCandidates[] = $job;
                    }
                    }
                    @endphp

                    {{-- DAFTAR KANDIDAT PER LOWONGAN --}}
                    <div class="mb-4 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-slate-200">
                            <span x-show="tpaType === 'online'">3.</span>
                            <span x-show="tpaType === 'offline'">2.</span>
                            {{ __('messages.select_candidates_per_vacancy') }}
                        </label>
                        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                            <div class="relative w-full sm:w-64">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" x-model="searchQuery" placeholder="Cari nama, email, ID..." class="w-full pl-9 pr-3 py-2 border border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm text-sm">
                            </div>
                            <div class="w-full sm:w-64">
                                <select x-model="selectedJob" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm text-sm">
                                    <option value="all">{{ __('messages.all_vacancies') }}</option>
                                    @foreach($jobsWithCandidates as $job)
                                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($jobs as $job)
                        @php
                        $applications = \App\Models\UserJobApplication::where('job_listing_id', $job->id)
                        ->where('status', '!=', 'rejected')
                        ->where('tpa_status', 'not_required')
                        ->with('user')
                        ->get();
                        @endphp

                        @if($applications->count() > 0)
                        @php $hasCandidates = true; @endphp
                        <div x-show="selectedJob === 'all' || selectedJob == {{ $job->id }}" x-transition class="border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm transition-shadow hover:shadow-md bg-white dark:bg-slate-800">
                            <div class="px-5 py-4 bg-gray-50 dark:bg-slate-800/50 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-slate-200 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $job->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">{{ $applications->count() }} {{ __('messages.candidates') }} belum menerima undangan TPA</p>
                                </div>
                                <button type="button" @click="toggleAll({{ $job->id }})"
                                    class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-purple-900/30 font-medium px-3 py-1.5 rounded-lg transition-colors border border-transparent hover:border-purple-200 dark:hover:border-purple-800">
                                    {{ __('messages.select_all') }}
                                </button>
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-slate-700 max-h-80 overflow-y-auto">
                                @foreach($applications as $app)
                                <label x-show="searchQuery === '' || '{{ strtolower(addslashes($app->user->name)) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower(addslashes($app->user->email)) }}'.includes(searchQuery.toLowerCase()) || '{{ $app->user->id }}'.includes(searchQuery)"
                                    class="flex items-start gap-4 px-5 py-4 hover:bg-indigo-50/30 dark:hover:bg-slate-700/50 cursor-pointer transition-colors group">
                                    <div class="mt-1">
                                        <input type="checkbox" value="{{ $app->id }}"
                                            x-model="selectedApplications"
                                            class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-800 text-purple-600 focus:ring-purple-500 job-{{ $job->id }} w-5 h-5 cursor-pointer">
                                    </div>
                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="col-span-1 md:col-span-1">
                                            <div class="font-medium text-gray-900 dark:text-slate-200 group-hover:text-purple-700 dark:group-hover:text-purple-400 transition-colors">{{ $app->user->name }}</div>
                                            <div class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Sistem ID: {{ $app->user->id }}</div>
                                        </div>
                                        <div class="col-span-1 md:col-span-2">
                                            <div class="text-sm text-gray-600 dark:text-slate-400 flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $app->user->email }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-slate-500 mt-1 flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                {{ $app->user->phone ?? 'Tidak ada nomor telepon' }}
                                            </div>
                                        </div>
                                        <div class="col-span-1 md:text-right">
                                            @if($app->matching_percentage)
                                            <span class="inline-flex items-center px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-semibold border border-green-200 dark:border-green-800">
                                                Match: {{ $app->matching_percentage }}%
                                            </span>
                                            @endif
                                            <div class="text-xs text-gray-400 dark:text-slate-500 mt-2">
                                                {{ __('messages.applied') }} {{ $app->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @if(!$hasCandidates)
                        <div class="text-center py-10 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-dashed border-gray-300 dark:border-slate-700">
                            <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-slate-400 font-medium">{{ __('messages.no_candidates_available_to_invite') }}</p>
                            <p class="text-sm text-gray-400 dark:text-slate-500 mt-1">{{ __('messages.candidates_will_appear_after_applying') }}</p>
                        </div>
                        @endif
                    </div>

                    {{-- TOMBOL KIRIM --}}
                    <div class="mt-8 pt-5 border-t border-gray-200 dark:border-slate-700">
                        {{-- TIPE TPA --}}


                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-slate-400 bg-gray-50 dark:bg-slate-800 px-4 py-2 rounded-lg inline-block mb-4 md:mb-0 border border-gray-200 dark:border-slate-700">
                                {{ __('messages.total_selected') }} <span x-text="selectedApplications.length" class="font-bold text-purple-700 dark:text-purple-400 text-base">0</span> {{ __('messages.candidates') }}
                            </div>
                            <div class="flex gap-3">
                                {{-- Tombol Online --}}
                                <button type="button" x-show="tpaType === 'online'" @click="sendBulkInvite()"
                                    :disabled="selectedApplications.length === 0 || !selectedTest"
                                    class="bg-purple-600 hover:bg-purple-700 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed text-white px-8 py-3 rounded-xl font-semibold shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    {{ __('messages.send_invitation') }} Online
                                </button>
                                {{-- Tombol Offline --}}
                                <button type="button" x-show="tpaType === 'offline'" @click="sendBulkInviteOffline()"
                                    :disabled="selectedApplications.length === 0"
                                    class="bg-amber-600 hover:bg-amber-700 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed text-white px-8 py-3 rounded-xl font-semibold shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    {{ __('messages.send_invitation') }} Offline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM SUBMIT ONLINE (HIDDEN) --}}
                <form x-ref="bulkForm" action="{{ route('industry.tpa.bulk-invite') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="tpa_test_id" x-model="selectedTest">
                    <template x-for="id in selectedApplications" :key="id">
                        <input type="hidden" name="application_ids[]" :value="id">
                    </template>
                </form>
            </div>
        </div>

        {{-- TAB CONTENT: RIWAYAT UNDANGAN TERKIRIM --}}
        <div x-show="activeTab === 'riwayat'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            @php
            $user = auth()->user();
            $query = \App\Models\TpaTestSession::whereHas('tpaTest', function($q) use ($user) {
            $q->where('created_by', $user->id);
            })->with(['user', 'tpaTest', 'jobApplication.jobListing', 'result']);

            // {{ __('messages.filter') }}: Kandidat (nama/email)
            if (request('search')) {
            $query->whereHas('user', function($q) {
            $q->where('name', 'like', '%' . request('search') . '%')
            ->orWhere('email', 'like', '%' . request('search') . '%');
            });
            }

            // {{ __('messages.filter') }}: Tes TPA
            if (request('test_id')) {
            $query->where('tpa_test_id', request('test_id'));
            }

            // {{ __('messages.filter') }}: Status
            if (request('status')) {
            $query->where('status', request('status'));
            }

            // {{ __('messages.filter') }}: Lowongan
            if (request('job_id')) {
            $query->whereHas('jobApplication', function($q) {
            $q->where('job_listing_id', request('job_id'));
            });
            }

            // {{ __('messages.filter') }}: Hasil (lulus/tidak)
            if (request('passed') === '1') {
            $query->whereHas('result', function($q) {
            $q->where('is_passed', true);
            });
            } elseif (request('passed') === '0') {
            $query->whereHas('result', function($q) {
            $q->where('is_passed', false);
            });
            }

            $sentSessions = $query->latest()->paginate(15)->withQueryString();

            // Data untuk filter dropdowns
            $tpaTests = \App\Models\TpaTest::where('created_by', $user->id)->get();
            $jobIds = \App\Models\JobListing::where('user_id', $user->id)->pluck('id');
            $jobs = \App\Models\JobListing::whereIn('id', $jobIds)->get();
            @endphp

            {{-- FILTER SECTION --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-4">
                <form method="GET" class="p-4">
                    <input type="hidden" name="tab" value="riwayat">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        {{-- Search Kandidat --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Cari Kandidat</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama atau email..."
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        {{-- {{ __('messages.filter') }} Tes --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tes TPA</label>
                            <select name="test_id" class="w-full border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                                <option value="">{{ __('messages.all_tests') }}</option>
                                @foreach($tpaTests as $test)
                                <option value="{{ $test->id }}" {{ request('test_id') == $test->id ? 'selected' : '' }}>
                                    {{ $test->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- {{ __('messages.filter') }} Status --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('messages.status') }}</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                                <option value="">{{ __('messages.all_statuses') }}</option>
                                <option value="invited" {{ request('status') === 'invited' ? 'selected' : '' }}>{{ __('messages.invited') }}</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>{{ __('messages.in_progress') }}</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>

                        {{-- {{ __('messages.filter') }} Lowongan --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('messages.vacancy') }}</label>
                            <select name="job_id" class="w-full border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                                <option value="">{{ __('messages.all_vacancies') }}</option>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- {{ __('messages.filter') }} Hasil --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Hasil Tes</label>
                            <select name="passed" class="w-full border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Semua</option>
                                <option value="1" {{ request('passed') === '1' ? 'selected' : '' }}>{{ __('messages.passed') }}</option>
                                <option value="0" {{ request('passed') === '0' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-3">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            {{ __('messages.filter') }}
                        </button>
                        <a href="{{ route('industry.tpa.index') }}?tab=riwayat" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                            Reset
                        </a>
                        <div class="flex-1"></div>
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg">
                            Total: <span class="font-bold text-gray-700">{{ $sentSessions->total() }}</span> data
                        </div>
                    </div>
                </form>
            </div>

            @if($sentSessions->count() > 0)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gray-50 border-b flex justify-between items-center">
                    <h2 class="font-bold text-lg text-gray-800">{{ __('messages.invitation_history') }} TPA</h2>
                    <div class="text-sm text-gray-500">{{ __('messages.showing_test_results_and_latest_status') }}</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.candidate_info') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tes & Lowongan</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.score_result') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.deadline') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($sentSessions as $session)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $session->user->name ?? 'Kandidat Dihapus' }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $session->user->email ?? '-' }}</div>
                                    <div class="text-[10px] text-gray-400 mt-1 uppercase">ID Sesi: #{{ $session->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-800">{{ $session->tpaTest->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $session->jobApplication->jobListing->title ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($session->status === 'invited')
                                    <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-medium border border-yellow-200">{{ __('messages.invited') }}</span>
                                    @elseif($session->status === 'in_progress')
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium border border-blue-200">{{ __('messages.in_progress') }}</span>
                                    @elseif($session->status === 'completed')
                                    <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-medium border border-green-200">{{ __('messages.completed') }}</span>
                                    @elseif($session->status === 'expired')
                                    <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-medium border border-red-200">Expired</span>
                                    @else
                                    <span class="px-3 py-1 bg-gray-50 text-gray-700 rounded-full text-xs font-medium border border-gray-200">{{ ucfirst($session->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($session->result)
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-bold {{ $session->result->is_passed ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $session->result->total_score }}%
                                        </span>
                                        @if($session->result->is_passed)
                                        <span class="text-[10px] uppercase font-bold text-green-600 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg> Lulus
                                        </span>
                                        @else
                                        <span class="text-[10px] uppercase font-bold text-red-600 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg> Gagal
                                        </span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-gray-400 font-medium">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    @if($session->expires_at)
                                    <div class="font-medium text-gray-700">{{ $session->expires_at->format('d M Y') }}</div>
                                    <div class="text-xs">{{ $session->expires_at->format('H:i') }} WIB</div>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        @if($session->status === 'completed')
                                        <a href="{{ url('industry/tpa/results/' . $session->id) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors border border-blue-200 hover:border-blue-300 inline-flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ __('messages.result_detail') }}
                                        </a>
                                        @endif

                                        @if(in_array($session->status, ['expired', 'completed', 'failed']))
                                        @php
                                        $application = $session->jobApplication;
                                        $hasActiveSession = $application ? \App\Models\TpaTestSession::where('job_application_id', $application->id)
                                        ->whereIn('status', ['invited', 'in_progress'])
                                        ->exists() : false;
                                        @endphp
                                        @if($application && !$hasActiveSession)
                                        <form action="{{ route('industry.tpa.invite', $session->tpaTest) }}" method="POST" onsubmit="return confirm('Kirim ulang undangan TPA ke {{ $session->user->name ?? '{{ __('messages.candidates') }}' }}?')">
                                            @csrf
                                            <input type="hidden" name="application_id" value="{{ $application->id }}">
                                            <button type="submit" class="text-purple-600 hover:text-purple-800 hover:bg-purple-50 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors border border-purple-200 hover:border-purple-300 inline-flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                {{ __('messages.re_invite') }}
                                            </button>
                                        </form>
                                        @endif
                                        @endif

                                        @if($session->status !== 'completed' && !in_array($session->status, ['expired', 'failed']))
                                        <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($sentSessions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $sentSessions->links() }}
                </div>
                @endif
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('messages.no_invitations_sent_yet') }}</h3>
                <p class="text-gray-500">Anda belum mengirimkan undangan tes TPA ke {{ __('messages.candidates') }} mana pun.</p>
                <button @click="activeTab = 'kirim'" class="mt-4 inline-flex items-center px-4 py-2 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-lg font-medium transition-colors">
                    {{ __('messages.send_invitation') }} Sekarang
                </button>
            </div>
            @endif
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        function bulkInvite() {
            return {
                selectedTest: '',
                selectedJob: 'all',
                searchQuery: '',
                selectedApplications: [],
                tpaType: 'online',
                toggleAll(jobId) {
                    const checkboxes = document.querySelectorAll('.job-' + jobId);
                    const allChecked = Array.from(checkboxes).every(cb => this.selectedApplications.includes(cb.value));

                    checkboxes.forEach(cb => {
                        if (allChecked) {
                            this.selectedApplications = this.selectedApplications.filter(id => id !== cb.value);
                        } else {
                            if (!this.selectedApplications.includes(cb.value)) {
                                this.selectedApplications.push(cb.value);
                            }
                        }
                    });
                },
                sendBulkInvite() {
                    if (this.selectedApplications.length === 0) {
                        alert('Pilih minimal 1 {{ __('messages.candidates') }}!');
                        return;
                    }
                    if (!this.selectedTest) {
                        alert('Pilih tes TPA terlebih dahulu!');
                        return;
                    }
                    if (confirm(`Kirim undangan TPA online ke ${this.selectedApplications.length} {{ __('messages.candidates') }}?`)) {
                        this.$refs.bulkForm.submit();
                    }
                },
                sendBulkInviteOffline() {
                    if (this.selectedApplications.length === 0) {
                        alert('Pilih minimal 1 {{ __('messages.candidates') }}!');
                        return;
                    }

                    // Validasi form offline
                    const form = document.getElementById('offlineForm');
                    if (!form) {
                        alert('Form offline tidak ditemukan!');
                        return;
                    }

                    const instructions = form.querySelector('[name="offline_instructions"]').value;
                    const scheduledAt = form.querySelector('[name="offline_scheduled_at"]').value;
                    const location = form.querySelector('[name="offline_location"]').value;

                    if (!instructions) {
                        alert('Isi instruksi tes!');
                        form.querySelector('[name="offline_instructions"]').focus();
                        return;
                    }
                    if (!scheduledAt) {
                        alert('Isi tanggal & waktu tes!');
                        form.querySelector('[name="offline_scheduled_at"]').focus();
                        return;
                    }
                    if (!location) {
                        alert('Isi lokasi tes!');
                        form.querySelector('[name="offline_location"]').focus();
                        return;
                    }

                    if (confirm(`Kirim undangan TPA offline ke ${this.selectedApplications.length} {{ __('messages.candidates') }}?`)) {
                        form.submit();
                    }
                }
            }
        }
    </script>
    @vite(['resources/js/quill.js'])
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var quillInstructions = new Quill('#quill-offline_instructions', {
            theme: 'snow',
            placeholder: 'Jelaskan instruksi tes, apa yang perlu dibawa, materi yang diuji, dll...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingI = document.getElementById('offline_instructions').value;
        if (existingI) quillInstructions.root.innerHTML = existingI;

        var quillNotes = new Quill('#quill-offline_notes', {
            theme: 'snow',
            placeholder: 'Catatan tambahan (opsional)...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingN = document.getElementById('offline_notes').value;
        if (existingN) quillNotes.root.innerHTML = existingN;

        var form = document.getElementById('quill-offline_instructions').closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('offline_instructions').value = quillInstructions.root.innerHTML;
                document.getElementById('offline_notes').value = quillNotes.root.innerHTML;
            });
        }
    });
    </script>
</x-app-layout>