<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Mulai Asesmen Kompetensi</h2>
                <p class="mt-2 text-gray-600">Pilih posisi karir atau lowongan target untuk menganalisis kesenjangan skill.</p>
            </div>

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-slate-100 dark:border-slate-800">
                <!-- Error Messages -->
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
                @endif
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @php
                $userSkills = auth()->user()->skills ?? [];
                if (is_string($userSkills)) {
                    $userSkills = json_decode($userSkills, true) ?? [];
                }
                
                $mappedPositions = [];
                foreach ($positions as $p) {
                    $mappedPositions[] = ['id' => (string)$p->id, 'name' => $p->name];
                }

                $mappedJobs = [];
                foreach ($jobListings as $j) {
                    $mappedJobs[] = [
                        'id' => (string)$j->id,
                        'name' => $j->title . ' - ' . $j->company_name,
                        'skills' => $j->required_skills ?? []
                    ];
                }
                @endphp

                @php
                $previousData = null;
                if ($previousAssessment) {
                    $previousData = [
                        'position_id' => $previousAssessment->position_id ? (string)$previousAssessment->position_id : null,
                        'job_listing_id' => $previousAssessment->job_listing_id ? (string)$previousAssessment->job_listing_id : null,
                        'position_name' => $previousAssessment->position?->name,
                        'job_listing_name' => $previousAssessment->jobListing ? $previousAssessment->jobListing->title . ' - ' . $previousAssessment->jobListing->company_name : null,
                    ];
                }
                @endphp

                <!-- Data initialization -->
                <script>
                    window.assessmentData = {
                        positions: @json($mappedPositions),
                        jobs: @json($mappedJobs),
                        userSkills: @json(array_values($userSkills)),
                        previousAssessment: @json($previousData)
                    };
                </script>

                <form action="{{ route('seeker.assessment.store') }}" method="POST" x-data="assessmentForm()">
                    @csrf

                    <!-- Step Indicator -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">1</div>
                            <span class="text-xs mt-2 font-semibold text-blue-600 dark:text-blue-400">Data Diri</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                        <div class="flex flex-col items-center opacity-50">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-500 dark:text-slate-400 flex items-center justify-center font-bold">2</div>
                            <span class="text-xs mt-2 font-semibold text-gray-500 dark:text-slate-400">Penilaian Skill</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                        <div class="flex flex-col items-center opacity-50">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-500 dark:text-slate-400 flex items-center justify-center font-bold">3</div>
                            <span class="text-xs mt-2 font-semibold text-gray-500 dark:text-slate-400">Hasil</span>
                        </div>
                    </div>

                    <!-- Mode Toggle -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">Mulai Assessment Berdasarkan</label>
                        <div class="flex gap-3">
                            <button type="button" @click="mode = 'position'; jobSelected = ''; jobName = 'Pilih lowongan...'; selectedJobSkills = []"
                                :class="mode === 'position' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                                class="flex-1 py-3 px-4 border-2 rounded-xl font-medium transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Posisi Karir
                            </button>
                            <button type="button" @click="mode = 'job'; positionSelected = ''; positionName = 'Pilih posisi...'"
                                :class="mode === 'job' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                                class="flex-1 py-3 px-4 border-2 rounded-xl font-medium transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Lowongan Kerja
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Position Dropdown -->
                        <div x-show="mode === 'position'" x-transition>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Posisi Target Karir</label>
                            <div class="relative">
                                <input type="hidden" name="position_id" :value="positionSelected">
                                <div @click="positionOpen = !positionOpen; if(positionOpen) $nextTick(() => $refs.posSearch.focus())" @click.away="positionOpen = false"
                                    class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 transition shadow-sm cursor-pointer flex justify-between items-center">
                                    <span x-text="positionName" :class="positionSelected === '' ? 'text-gray-500 dark:text-slate-400' : 'text-gray-900 dark:text-white'"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="positionOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div x-show="positionOpen" x-transition class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl max-h-60 flex flex-col overflow-hidden">
                                    <div class="p-3 border-b border-gray-100 dark:border-slate-700">
                                        <input x-model="positionSearch" type="text" x-ref="posSearch" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-sm" placeholder="Cari posisi...">
                                    </div>
                                    <ul class="flex-1 overflow-y-auto py-2">
                                        <template x-for="opt in filteredPositions" :key="opt.id">
                                            <li @click="positionSelected = opt.id; positionName = opt.name; positionOpen = false; positionSearch = ''"
                                                class="px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-700/50 cursor-pointer text-gray-700 dark:text-slate-200 text-sm flex items-center transition-colors"
                                                :class="positionSelected === opt.id ? 'bg-blue-50/50 dark:bg-slate-700/30 font-medium text-blue-700 dark:text-blue-400' : ''">
                                                <span x-text="opt.name"></span>
                                                <svg x-show="positionSelected === opt.id" class="w-4 h-4 ml-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </li>
                                        </template>
                                        <li x-show="filteredPositions.length === 0" class="px-4 py-3 text-center text-gray-500 text-sm">Posisi tidak ditemukan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Job Listing Dropdown -->
                        <div x-show="mode === 'job'" x-transition>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Lowongan Kerja Target</label>
                            <div class="relative">
                                <input type="hidden" name="job_listing_id" :value="jobSelected">
                                <div @click="jobOpen = !jobOpen; if(jobOpen) $nextTick(() => $refs.jobSearch.focus())" @click.away="jobOpen = false"
                                    class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 transition shadow-sm cursor-pointer flex justify-between items-center">
                                    <span x-text="jobName" :class="jobSelected === '' ? 'text-gray-500 dark:text-slate-400' : 'text-gray-900 dark:text-white'"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="jobOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div x-show="jobOpen" x-transition class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl max-h-60 flex flex-col overflow-hidden">
                                    <div class="p-3 border-b border-gray-100 dark:border-slate-700">
                                        <input x-model="jobSearch" type="text" x-ref="jobSearch" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-sm" placeholder="Cari lowongan...">
                                    </div>
                                    <ul class="flex-1 overflow-y-auto py-2">
                                        <template x-for="opt in filteredJobs" :key="opt.id">
                                            <li @click="selectJob(opt)"
                                                class="px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-700/50 cursor-pointer text-gray-700 dark:text-slate-200 text-sm flex items-center transition-colors"
                                                :class="jobSelected === opt.id ? 'bg-blue-50/50 dark:bg-slate-700/30 font-medium text-blue-700 dark:text-blue-400' : ''">
                                                <span x-text="opt.name"></span>
                                                <svg x-show="jobSelected === opt.id" class="w-4 h-4 ml-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </li>
                                        </template>
                                        <li x-show="filteredJobs.length === 0" class="px-4 py-3 text-center text-gray-500 text-sm">Lowongan tidak ditemukan</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Skill Comparison Panel -->
                            <div x-show="selectedJobSkills.length > 0 && missingSkills.length > 0" x-transition class="mt-4">
                                <div class="rounded-xl border-2 overflow-hidden border-amber-200 bg-amber-50">
                                    <div class="px-4 py-3 font-medium text-sm bg-amber-100 text-amber-800 border-b border-amber-200">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Anda belum memiliki beberapa skill yang dibutuhkan
                                        </span>
                                    </div>
                                    <div class="p-4 space-y-2">
                                        <template x-for="skill in missingSkills" :key="skill">
                                            <div class="flex items-center justify-between py-1.5 px-3 rounded-lg text-sm bg-red-100 text-red-800">
                                                <span x-text="skill" class="font-medium"></span>
                                                <span class="text-xs flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Belum ada
                                                </span>
                                            </div>
                                        </template>
                                    </div>
                                    <template x-if="missingSkills.length > 0">
                                        <div class="px-4 pb-4">
                                            <div class="p-3 bg-white rounded-lg border border-amber-200">
                                                <p class="text-sm text-amber-800 font-medium mb-2">Tindakan yang diperlukan:</p>
                                                <ol class="text-sm text-amber-700 space-y-1 list-decimal list-inside">
                                                    <li>Pelajari skill berikut: <strong x-text="missingSkills.join(', ')"></strong></li>
                                                    <li>Update profil Anda dengan skill tersebut</li>
                                                    <li>Baru kemudian ambil assessment untuk lowongan ini</li>
                                                </ol>
                                                <div class="mt-4 flex flex-col sm:flex-row items-center gap-3">
                                                    <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto px-4 py-2 bg-white border border-amber-300 text-amber-700 rounded-lg shadow-sm hover:bg-amber-50 hover:border-amber-400 hover:shadow transition-all duration-200 flex items-center justify-center gap-2 font-medium text-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Update Profil
                                                    </a>
                                                    <span class="text-sm text-amber-600/70 font-medium italic hidden sm:block">atau</span>
                                                    <a href="{{ url('/seeker/courses') }}" class="w-full sm:w-auto px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg shadow hover:shadow-md hover:from-amber-600 hover:to-orange-600 transition-all duration-200 flex items-center justify-center gap-2 font-medium text-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                        Ambil Kursus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Pendidikan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pendidikan Terakhir</label>
                            <div class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-lg text-gray-600 dark:text-slate-400 shadow-sm">
                                {{ auth()->user()->education_level ?? 'Belum diisi' }}
                            </div>
                            <input type="hidden" name="education_level" value="{{ auth()->user()->education_level ?? 'SMA/SMK' }}">
                        </div>

                        <!-- Pengalaman -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pengalaman Kerja (Tahun)</label>
                            <div class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-lg text-gray-600 dark:text-slate-400 shadow-sm">
                                {{ auth()->user()->experience_years ?? 0 }} Tahun
                            </div>
                            <input type="hidden" name="experience_years" value="{{ auth()->user()->experience_years ?? 0 }}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <!-- Debug info -->
                        <div class="mb-4 p-3 bg-gray-100 rounded text-xs">
                            <p>Mode: <span x-text="mode"></span></p>
                            <p>Position Selected: <span x-text="positionSelected"></span></p>
                            <p>Job Selected: <span x-text="jobSelected"></span></p>
                            <p>Button disabled: <span x-text="mode === 'position' && positionSelected === '' || mode === 'job' && jobSelected === ''"></span></p>
                        </div>

                        <button type="submit"
                            :disabled="mode === 'position' && positionSelected === '' || mode === 'job' && jobSelected === ''"
                            :class="mode === 'position' && positionSelected === '' || mode === 'job' && jobSelected === '' ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                            Lanjut ke Penilaian Skill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function assessmentForm() {
            const data = window.assessmentData || {
                positions: [],
                jobs: [],
                userSkills: [],
                previousAssessment: null
            };
            const prev = data.previousAssessment;

            let initMode = 'position';
            let initPositionSelected = '';
            let initJobSelected = '';
            let initPositionName = 'Pilih posisi...';
            let initJobName = 'Pilih lowongan...';
            let initSelectedJobSkills = [];

            if (prev) {
                if (prev.position_id) {
                    initMode = 'position';
                    initPositionSelected = prev.position_id;
                    initPositionName = prev.position_name || 'Pilih posisi...';
                } else if (prev.job_listing_id) {
                    initMode = 'job';
                    initJobSelected = prev.job_listing_id;
                    initJobName = prev.job_listing_name || 'Pilih lowongan...';
                    const matchedJob = data.jobs.find(j => j.id === prev.job_listing_id);
                    if (matchedJob) {
                        initSelectedJobSkills = matchedJob.skills || [];
                    }
                }
            }

            return {
                mode: initMode,
                positionSelected: initPositionSelected,
                jobSelected: initJobSelected,
                positionName: initPositionName,
                jobName: initJobName,
                positionOpen: false,
                jobOpen: false,
                positionSearch: '',
                jobSearch: '',
                selectedJobSkills: initSelectedJobSkills,
                userSkills: data.userSkills,
                positions: data.positions,
                jobs: data.jobs,
                get filteredPositions() {
                    if (this.positionSearch === '') return this.positions;
                    return this.positions.filter(i => i.name.toLowerCase().includes(this.positionSearch.toLowerCase()));
                },
                get filteredJobs() {
                    if (this.jobSearch === '') return this.jobs;
                    return this.jobs.filter(i => i.name.toLowerCase().includes(this.jobSearch.toLowerCase()));
                },
                selectJob(opt) {
                    this.jobSelected = opt.id;
                    this.jobName = opt.name;
                    this.selectedJobSkills = opt.skills || [];
                    this.jobOpen = false;
                    this.jobSearch = '';
                },
                userHasSkill(skill) {
                    return this.userSkills.some(u => u.toLowerCase() === skill.toLowerCase());
                },
                get missingSkills() {
                    return this.selectedJobSkills.filter(s => !this.userHasSkill(s));
                },
                get hasAllSkills() {
                    return this.selectedJobSkills.length > 0 && this.missingSkills.length === 0;
                }
            };
        }
    </script>
</x-app-layout>