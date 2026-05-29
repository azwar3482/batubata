<!-- Modal Component: resources/views/industry/team-invite-modal.blade.php -->
<!-- Trigger: <button @click="inviteModal = true">Undang Anggota Tim</button> -->

<div x-data="{
    inviteModal: false,
    selectedRole: '',
    permissions: [],
    email: '',
    name: '',
    message: ''
}" @open-invite-modal.window="inviteModal = true" x-show="inviteModal"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <!-- Backdrop -->
    <div x-show="inviteModal" @click="inviteModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity">
    </div>

    <!-- Center Wrapper -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">

        <!-- Modal Content -->
        <div x-show="inviteModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block w-full max-w-2xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-2xl rounded-2xl z-10 border border-slate-200 dark:border-slate-700">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Undang Anggota Tim</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400">Tambahkan rekan untuk membantu proses rekrutmen</p>
                    </div>
                </div>
                <button @click="inviteModal = false"
                    class="text-gray-400 hover:text-gray-600 dark:text-slate-400 dark:hover:text-slate-200 transition p-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('industry.team.invite') }}" method="POST" class="space-y-6"
                @submit.prevent="submitInvite">
                @csrf

                <!-- Step Indicator -->
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                            1</div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Identitas</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-slate-400 flex items-center justify-center font-bold text-sm transition-colors"
                            :class="{ 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white': email && name }">
                            2</div>
                        <span class="text-sm font-medium text-gray-400 dark:text-slate-400 transition-colors"
                            :class="{ 'text-gray-900 dark:text-white': email && name }">Akses</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-slate-400 flex items-center justify-center font-bold text-sm transition-colors"
                            :class="{ 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white': selectedRole && email && name }">
                            3</div>
                        <span class="text-sm font-medium text-gray-400 dark:text-slate-400 transition-colors"
                            :class="{ 'text-gray-900 dark:text-white': selectedRole && email && name }">Kirim</span>
                    </div>
                </div>

                <!-- Section 1: Member Identity -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">1</span>
                        Informasi Anggota
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" x-model="name" required placeholder="Contoh: Budi Santoso"
                                class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition"
                                @input="generateEmailPreview()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Email Kerja <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" x-model="email" required placeholder="nama@perusahaan.com"
                                class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                            Pesan Undangan (Opsional)
                        </label>
                        <textarea name="message" x-model="message" rows="3" placeholder="Tambahkan pesan personal untuk undangan ini..."
                            class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition"></textarea>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Pesan ini akan disertakan dalam email undangan</p>
                    </div>
                </div>

                <!-- Section 2: Role & Permissions -->
                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <h4 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">2</span>
                        Role & Hak Akses
                    </h4>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">
                            Pilih Role <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @php
                            $roles = [
                                'staf_hr_manager' => [
                                    'label' => 'Staf HR Manager',
                                    'desc' => 'Akses penuh ke semua fitur rekrutmen',
                                    'permissions' => [
                                        'post_jobs',
                                        'view_candidates',
                                        'manage_applications',
                                        'schedule_interview',
                                        'view_reports',
                                    ],
                                    'active_box' => 'border-blue-500 bg-blue-50 dark:bg-blue-900/30 dark:border-blue-400',
                                    'active_text' => 'text-blue-800 dark:text-blue-200',
                                    'active_circle' => 'border-blue-500 bg-blue-500 dark:border-blue-400 dark:bg-blue-400',
                                ],
                                'staf_recruiter' => [
                                    'label' => 'Staf Recruiter',
                                    'desc' => 'Dapat melihat kandidat dan menjadwalkan interview',
                                    'permissions' => ['view_candidates', 'schedule_interview', 'submit_feedback'],
                                    'active_box' => 'border-purple-500 bg-purple-50 dark:bg-purple-900/30 dark:border-purple-400',
                                    'active_text' => 'text-purple-800 dark:text-purple-200',
                                    'active_circle' => 'border-purple-500 bg-purple-500 dark:border-purple-400 dark:bg-purple-400',
                                ],
                                'staf_talent_sourcer' => [
                                    'label' => 'Staf Talent Sourcer',
                                    'desc' => 'Hanya dapat melihat profil kandidat',
                                    'permissions' => ['view_candidates'],
                                    'active_box' => 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 dark:border-emerald-400',
                                    'active_text' => 'text-emerald-800 dark:text-emerald-200',
                                    'active_circle' => 'border-emerald-500 bg-emerald-500 dark:border-emerald-400 dark:bg-emerald-400',
                                ],
                                'staf_interviewer' => [
                                    'label' => 'Staf Interviewer',
                                    'desc' => 'Dapat melihat kandidat yang diassign dan memberi feedback',
                                    'permissions' => ['view_candidates', 'submit_feedback'],
                                    'active_box' => 'border-orange-500 bg-orange-50 dark:bg-orange-900/30 dark:border-orange-400',
                                    'active_text' => 'text-orange-800 dark:text-orange-200',
                                    'active_circle' => 'border-orange-500 bg-orange-500 dark:border-orange-400 dark:bg-orange-400',
                                ],
                            ];
                            @endphp
                            @foreach ($roles as $roleName => $roleData)
                            <label class="relative cursor-pointer block">
                                <input type="radio" name="role" value="{{ $roleName }}" x-model="selectedRole"
                                    required class="sr-only"
                                    data-perms="{{ json_encode($roleData['permissions']) }}"
                                    @change="permissions = JSON.parse($el.dataset.perms)">
                                <div
                                    class="p-4 border-2 rounded-xl transition-all duration-200"
                                    :class="selectedRole === '{{ $roleName }}' 
                                        ? '{{ $roleData['active_box'] }} shadow-sm' 
                                        : 'border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 hover:border-gray-300 dark:hover:border-slate-500'">
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold transition-colors"
                                              :class="selectedRole === '{{ $roleName }}' ? '{{ $roleData['active_text'] }}' : 'text-gray-900 dark:text-white'">
                                            {{ $roleData['label'] }}
                                        </span>
                                        
                                        <div
                                            class="w-5 h-5 rounded-full border-2 transition-all flex items-center justify-center"
                                            :class="selectedRole === '{{ $roleName }}' ? '{{ $roleData['active_circle'] }}' : 'border-gray-300 dark:border-slate-500 bg-transparent'">
                                            <div class="w-2 h-2 rounded-full bg-white dark:bg-slate-900" x-show="selectedRole === '{{ $roleName }}'" style="display: none;"></div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-xs transition-colors"
                                       :class="selectedRole === '{{ $roleName }}' ? '{{ $roleData['active_text'] }} opacity-80' : 'text-gray-600 dark:text-slate-400'">
                                       {{ $roleData['desc'] }}
                                    </p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Permissions Preview -->
                    <div x-show="selectedRole" class="p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl border border-gray-200 dark:border-slate-600">
                        <p class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">Hak Akses yang Diberikan:</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="perm in permissions" :key="perm">
                                <span
                                    class="px-3 py-1.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-xs font-medium text-gray-700 dark:text-slate-300 flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span x-text="getPermissionLabel(perm)"></span>
                                </span>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Preview & Submit -->
                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <h4 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">3</span>
                        Preview & Kirim
                    </h4>

                    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800 rounded-xl border border-blue-200 dark:border-slate-700">
                        <p class="text-sm text-gray-700 dark:text-slate-300 mb-2">Undangan akan dikirim ke:</p>
                        <div class="flex items-center gap-3 p-3 bg-white dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                <span x-text="getInitials(name)"></span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white" x-text="name || 'Nama Anggota'"></p>
                                <p class="text-sm text-gray-500 dark:text-slate-400" x-text="email || 'email@perusahaan.com'"></p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-3">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Anggota yang diundang akan menerima email dengan link aktivasi akun. Undangan berlaku selama 7
                            hari.
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="button" @click="inviteModal = false"
                        class="flex-1 px-4 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium text-center focus:outline-none focus:ring-2 focus:ring-slate-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg hover:from-blue-700 hover:to-indigo-800 transition font-medium text-center flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Undangan
                    </button>
                </div>
            </form>
        </div>
    </div> <!-- End Center Wrapper -->
</div>

<!-- JavaScript Helper Functions -->
<script>
    function getInitials(name) {
        if (!name) return '??';
        const names = name.trim().split(' ');
        if (names.length === 1) return names[0].charAt(0).toUpperCase();
        return (names[0].charAt(0) + names[names.length - 1].charAt(0)).toUpperCase();
    }

    function generateEmailPreview() {
        const name = document.querySelector('[x-model="name"]')?.value || '';
        if (name && !this.email) {
            const emailPreview = name.toLowerCase().replace(/\s+/g, '.') + '@perusahaan.com';
            // Optional: auto-fill email preview
        }
    }



    function getPermissionLabel(key) {
        const labels = {
            'post_jobs': 'Posting Lowongan',
            'view_candidates': 'Lihat Kandidat',
            'manage_applications': 'Kelola Lamaran',
            'schedule_interview': 'Jadwalkan Interview',
            'submit_feedback': 'Berikan Feedback',
            'view_reports': 'Lihat Laporan'
        };
        return labels[key] || key;
    }

    function submitInvite(e) {
        e.preventDefault();
        // Add loading state, then submit form
        this.$el.querySelector('button[type="submit"]').disabled = true;
        this.$el.querySelector('button[type="submit"]').innerHTML = 'Mengirim...';
        this.$el.submit();
    }
</script>