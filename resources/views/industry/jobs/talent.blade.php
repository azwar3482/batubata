<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header -->
            <div class="mb-2 flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                        {{ __('Rekomendasi Talenta untuk: ') }} {{ $job->title }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                        Menampilkan kandidat potensial dengan profil lengkap 100% dan diurutkan berdasarkan keselarasan keahlian (Skill Gap terkecil).
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('industry.jobs.show', $job->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                        Kembali ke Detail Lowongan
                    </a>
                </div>
            </div>

            <!-- Syarat Lowongan Card -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Kebutuhan Keahlian Lowongan</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($job->required_skills as $skill)
                        <span class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg text-sm font-semibold">{{ $skill }}</span>
                    @empty
                        <span class="text-sm text-gray-500">Tidak ada keahlian khusus yang disyaratkan.</span>
                    @endforelse
                </div>
            </div>

            <!-- List Talenta -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Talenta yang Cocok</h3>
                        @if($talents->count() > 0)
                            <div class="flex items-center gap-1 bg-gray-100 dark:bg-slate-700 rounded-lg p-1">
                                <button onclick="switchView('card')" id="btn-card" class="view-toggle px-3 py-1.5 rounded-md text-sm font-medium transition flex items-center gap-1.5 bg-white dark:bg-slate-600 shadow-sm text-gray-900 dark:text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Kartu
                                </button>
                                <button onclick="switchView('table')" id="btn-table" class="view-toggle px-3 py-1.5 rounded-md text-sm font-medium transition flex items-center gap-1.5 text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    Tabel
                                </button>
                            </div>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                            <p class="text-sm text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                            <p class="text-sm text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                        </div>
                    @endif

                    @if($talents->count() > 0)
                        <!-- Card View -->
                        <div id="view-card" class="grid grid-cols-1 gap-6">
                            @foreach($talents as $talent)
                                @php
                                    $user = $talent['user'];
                                    $match = $talent['match_percentage'];
                                    $shortcomings = $talent['shortcomings'];
                                    $existingApp = $talent['existing_app'];
                                @endphp
                                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:shadow-md transition-shadow">
                                    
                                    <!-- Profil & Skill -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start gap-4">
                                            <!-- Avatar -->
                                            <div class="w-14 h-14 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-extrabold text-xl flex-shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            
                                            <!-- Info Utama -->
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</h4>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                                        Profil Lengkap (100%)
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ $user->major ?? 'Jurusan tidak tertera' }} &bull; {{ $user->education_level ?? 'Pendidikan tidak tertera' }}</p>
                                                
                                                <!-- Skills Pencari Kerja -->
                                                <div class="mt-3">
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Keahlian yang dimiliki:</p>
                                                    <div class="flex flex-wrap gap-1.5 mt-1.5">
                                                        @if(is_array($user->skills) && count($user->skills) > 0)
                                                            @foreach($user->skills as $userSkill)
                                                                <span class="px-2 py-0.5 bg-slate-200/75 dark:bg-slate-800 text-gray-700 dark:text-slate-300 rounded-md text-xs font-medium">{{ $userSkill }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-xs text-gray-400">Belum menambahkan keahlian.</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Skill Gap / Shortcomings -->
                                                @if(count($shortcomings) > 0)
                                                    <div class="mt-3">
                                                        <p class="text-xs font-semibold text-rose-500 dark:text-rose-400 uppercase tracking-wider">Kekurangan / Celah (Gap):</p>
                                                        <div class="flex flex-wrap gap-1.5 mt-1">
                                                            @foreach($shortcomings as $short)
                                                                <span class="px-2 py-0.5 bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 rounded-md text-xs font-medium border border-rose-100 dark:border-rose-900/30">
                                                                    {{ $short }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mt-3">
                                                        <span class="inline-flex items-center text-xs font-bold text-green-600 dark:text-green-400">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            Sempurna! Tidak memiliki celah keahlian (Skill Gap 0%)
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kecocokan & Aksi -->
                                    <div class="flex flex-col items-center md:items-end justify-center gap-4 flex-shrink-0 md:border-l md:border-slate-200 dark:md:border-slate-800 md:pl-6">
                                        <div class="text-center md:text-right">
                                            <div class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ round($match) }}%</div>
                                            <div class="text-xs text-gray-500 dark:text-slate-400 font-semibold uppercase tracking-wider">Kecocokan Profil</div>
                                        </div>

                                        <div>
                                            @if($existingApp)
                                                @if($existingApp->is_direct_offer)
                                                    @if($existingApp->direct_offer_status === 'pending')
                                                        <span class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 rounded-xl text-sm font-semibold">
                                                            Menunggu Respon Penawaran
                                                        </span>
                                                    @elseif($existingApp->direct_offer_status === 'accepted')
                                                        <span class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-450 rounded-xl text-sm font-semibold">
                                                            Penawaran Diterima 🎉
                                                        </span>
                                                    @elseif($existingApp->direct_offer_status === 'declined')
                                                        <button onclick="openOfferModal('{{ $user->name }}', '{{ route('industry.jobs.offer', [$job->id, $user->id]) }}')" 
                                                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow hover:shadow-lg transition transform hover:-translate-y-0.5">
                                                            Tawarkan Lagi (Sebelumnya Ditolak)
                                                        </button>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 rounded-xl text-sm font-semibold">
                                                        Sudah Melamar Mandiri ({{ ucfirst($existingApp->status) }})
                                                    </span>
                                                @endif
                                            @else
                                                <button onclick="openOfferModal('{{ $user->name }}', '{{ route('industry.jobs.offer', [$job->id, $user->id]) }}')" 
                                                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-sm font-semibold shadow hover:shadow-lg transition transform hover:-translate-y-0.5">
                                                    Tawarkan Pekerjaan
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- Table View -->
                        <div id="view-table" class="hidden overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 dark:text-slate-400 uppercase bg-gray-50 dark:bg-slate-700/50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">Kandidat</th>
                                        <th class="px-4 py-3 font-semibold">Pendidikan</th>
                                        <th class="px-4 py-3 font-semibold">Keahlian</th>
                                        <th class="px-4 py-3 font-semibold">Skill Gap</th>
                                        <th class="px-4 py-3 font-semibold text-center">Kecocokan</th>
                                        <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                                    @foreach($talents as $talent)
                                        @php
                                            $user = $talent['user'];
                                            $match = $talent['match_percentage'];
                                            $shortcomings = $talent['shortcomings'];
                                            $existingApp = $talent['existing_app'];
                                        @endphp
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                            <!-- Kandidat -->
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm flex-shrink-0">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                                            100% Lengkap
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Pendidikan -->
                                            <td class="px-4 py-4">
                                                <div class="text-gray-900 dark:text-white font-medium">{{ $user->major ?? '-' }}</div>
                                                <div class="text-gray-500 dark:text-slate-400 text-xs">{{ $user->education_level ?? '-' }}</div>
                                            </td>
                                            <!-- Keahlian -->
                                            <td class="px-4 py-4">
                                                <div class="flex flex-wrap gap-1 max-w-xs">
                                                    @if(is_array($user->skills) && count($user->skills) > 0)
                                                        @foreach(array_slice($user->skills, 0, 3) as $userSkill)
                                                            <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded text-[11px] font-medium">{{ $userSkill }}</span>
                                                        @endforeach
                                                        @if(count($user->skills) > 3)
                                                            <span class="px-2 py-0.5 text-gray-400 text-[11px]">+{{ count($user->skills) - 3 }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- Skill Gap -->
                                            <td class="px-4 py-4">
                                                @if(count($shortcomings) > 0)
                                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                                        @foreach(array_slice($shortcomings, 0, 2) as $short)
                                                            <span class="px-2 py-0.5 bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 rounded text-[11px] font-medium border border-rose-100 dark:border-rose-900/30">{{ $short }}</span>
                                                        @endforeach
                                                        @if(count($shortcomings) > 2)
                                                            <span class="px-2 py-0.5 text-gray-400 text-[11px]">+{{ count($shortcomings) - 2 }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center text-xs font-bold text-green-600 dark:text-green-400">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                        0% Gap
                                                    </span>
                                                @endif
                                            </td>
                                            <!-- Kecocokan -->
                                            <td class="px-4 py-4 text-center">
                                                <span class="text-lg font-black text-blue-600 dark:text-blue-400">{{ round($match) }}%</span>
                                            </td>
                                            <!-- Aksi -->
                                            <td class="px-4 py-4 text-center">
                                                @if($existingApp)
                                                    @if($existingApp->is_direct_offer)
                                                        @if($existingApp->direct_offer_status === 'pending')
                                                            <span class="inline-flex items-center px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 rounded-lg text-xs font-semibold">
                                                                Menunggu
                                                            </span>
                                                        @elseif($existingApp->direct_offer_status === 'accepted')
                                                            <span class="inline-flex items-center px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg text-xs font-semibold">
                                                                Diterima
                                                            </span>
                                                        @elseif($existingApp->direct_offer_status === 'declined')
                                                            <button onclick="openOfferModal('{{ $user->name }}', '{{ route('industry.jobs.offer', [$job->id, $user->id]) }}')" 
                                                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">
                                                                Tawarkan Lagi
                                                            </button>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 rounded-lg text-xs font-semibold">
                                                            Melamar ({{ ucfirst($existingApp->status) }})
                                                        </span>
                                                    @endif
                                                @else
                                                    <button onclick="openOfferModal('{{ $user->name }}', '{{ route('industry.jobs.offer', [$job->id, $user->id]) }}')" 
                                                            class="px-3 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg text-xs font-semibold shadow transition">
                                                        Tawarkan
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500 dark:text-slate-400">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <p class="text-lg font-semibold">Tidak Ada Kandidat yang Memenuhi Syarat</p>
                            <p class="text-sm mt-1">Saat ini belum ada Job Seeker dengan profil lengkap 100% terdaftar di sistem.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Offer Modal -->
    <div id="offerModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeOfferModal()"></div>

            <!-- Trick to center modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block align-middle bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border dark:border-slate-700">
                <form id="offerForm" method="POST" action="">
                    @csrf
                    <div class="bg-white dark:bg-slate-800 px-6 pt-6 pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-4.8a2 2 0 012.22 0l8 4.8A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                    Kirim Penawaran Kerja
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-slate-400">
                                        Anda akan mengirimkan penawaran kerja langsung kepada <span id="candidateName" class="font-bold text-blue-600 dark:text-blue-400"></span> untuk bergabung dalam lowongan ini.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Pesan/Catatan Penawaran (Opsional)</label>
                                    <textarea name="notes" id="notes" rows="4" 
                                              class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors px-4 py-3 text-sm" 
                                              placeholder="Tulis detail kompensasi, jam kerja, atau salam pembuka hangat untuk menarik perhatian kandidat..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-900/30 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm transition">
                            Kirim Penawaran
                        </button>
                        <button type="button" onclick="closeOfferModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 dark:border-slate-700 shadow-sm px-5 py-2.5 bg-white dark:bg-slate-800 text-base font-semibold text-gray-750 dark:text-slate-350 hover:bg-gray-50 dark:hover:bg-slate-750 focus:outline-none sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openOfferModal(name, actionUrl) {
            document.getElementById('candidateName').textContent = name;
            document.getElementById('offerForm').action = actionUrl;
            document.getElementById('offerModal').classList.remove('hidden');
        }

        function closeOfferModal() {
            document.getElementById('offerModal').classList.add('hidden');
            document.getElementById('notes').value = '';
        }

        function switchView(mode) {
            const cardView = document.getElementById('view-card');
            const tableView = document.getElementById('view-table');
            const btnCard = document.getElementById('btn-card');
            const btnTable = document.getElementById('btn-table');

            if (mode === 'card') {
                cardView.classList.remove('hidden');
                tableView.classList.add('hidden');
                btnCard.classList.add('bg-white', 'dark:bg-slate-600', 'shadow-sm', 'text-gray-900', 'dark:text-white');
                btnCard.classList.remove('text-gray-500', 'dark:text-slate-400', 'hover:text-gray-700', 'dark:hover:text-slate-300');
                btnTable.classList.remove('bg-white', 'dark:bg-slate-600', 'shadow-sm', 'text-gray-900', 'dark:text-white');
                btnTable.classList.add('text-gray-500', 'dark:text-slate-400', 'hover:text-gray-700', 'dark:hover:text-slate-300');
                localStorage.setItem('talent_view', 'card');
            } else {
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                btnTable.classList.add('bg-white', 'dark:bg-slate-600', 'shadow-sm', 'text-gray-900', 'dark:text-white');
                btnTable.classList.remove('text-gray-500', 'dark:text-slate-400', 'hover:text-gray-700', 'dark:hover:text-slate-300');
                btnCard.classList.remove('bg-white', 'dark:bg-slate-600', 'shadow-sm', 'text-gray-900', 'dark:text-white');
                btnCard.classList.add('text-gray-500', 'dark:text-slate-400', 'hover:text-gray-700', 'dark:hover:text-slate-300');
                localStorage.setItem('talent_view', 'table');
            }
        }

        // Restore saved view preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('talent_view') || 'card';
            if (savedView === 'table') {
                switchView('table');
            }
        });
    </script>
</x-app-layout>
