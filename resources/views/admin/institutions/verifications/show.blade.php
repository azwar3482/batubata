<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ rejectModalOpen: false, rejectType: '', rejectLabel: '' }">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.verifications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Detail Verifikasi: {{ $institution->name }}</h1>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-medium border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Informasi Institusi -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Informasi Institusi</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase">Nama</span>
                            <span class="block mt-1 font-medium text-slate-800 dark:text-slate-200">{{ $institution->name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase">Tipe</span>
                            <span class="block mt-1 font-medium text-slate-800 dark:text-slate-200">{{ ucfirst($institution->type) }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase">Akreditasi</span>
                            <span class="block mt-1 font-medium text-slate-800 dark:text-slate-200">{{ $institution->accreditation ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase">Alamat</span>
                            <span class="block mt-1 font-medium text-slate-800 dark:text-slate-200">{{ $institution->address ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase">Pengguna Pengaju</span>
                            <span class="block mt-1 font-medium text-slate-800 dark:text-slate-200">{{ $institution->user->name ?? '-' }}</span>
                            <span class="block text-sm text-slate-500">{{ $institution->user->email ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Final Action -->
                @if($institution->verification_status === 'pending')
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Keputusan Final</h3>
                        <p class="text-sm text-slate-500 mb-4">
                            Pastikan semua dokumen di bawah sudah diverifikasi (Disetujui) sebelum Anda menyetujui institusi ini secara keseluruhan.
                        </p>
                        <form action="{{ route('admin.institutions.verifications.approve', $institution->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors">
                                Setujui Institusi
                            </button>
                        </form>
                    </div>
                @elseif($institution->verification_status === 'verified')
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h3 class="text-emerald-800 font-bold">Institusi Terverifikasi</h3>
                                <p class="text-emerald-600 text-sm">Disetujui pada {{ $institution->verified_at ? $institution->verified_at->format('d M Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                @elseif($institution->verification_status === 'rejected')
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="text-red-800 font-bold">Pengajuan Ditolak</h3>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Review Dokumen -->
            <div class="md:col-span-2 space-y-6">
                @php
                    $docs = [
                        ['id' => 'npsn', 'label' => 'NPSN / Sertifikat Akreditasi', 'file' => $institution->npsn_document],
                        ['id' => 'sk_pendirian', 'label' => 'SK Pendirian / Izin Operasional', 'file' => $institution->sk_pendirian_document],
                        ['id' => 'ktp_principal', 'label' => 'KTP Kepala Sekolah / Rektor', 'file' => $institution->ktp_principal_document],
                    ];
                @endphp

                @foreach($docs as $doc)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold text-slate-800 dark:text-white">{{ $doc['label'] }}</h4>
                                @php
                                    $docStatus = $institution->getDocumentStatus($doc['id']);
                                    $docReason = $institution->getDocumentReason($doc['id']);
                                @endphp
                                <div class="mt-2">
                                    @if(!$doc['file'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Belum Diunggah</span>
                                    @elseif($docStatus === 'verified')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Dokumen Valid</span>
                                    @elseif($docStatus === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                        <p class="text-xs text-red-600 mt-1 mt-2">Alasan: {{ $docReason }}</p>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Menunggu Review</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($doc['file'])
                                <a href="{{ Storage::url($doc['file']) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-slate-300 rounded text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        @if($doc['file'] && in_array($institution->verification_status, ['pending', 'rejected']))
                            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700 flex gap-3">
                                <form action="{{ route('admin.institutions.verifications.verify-document', [$institution->id, $doc['id']]) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="verified">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 font-medium text-sm rounded hover:bg-emerald-200 transition-colors {{ $docStatus === 'verified' ? 'ring-2 ring-emerald-500 ring-offset-1' : '' }}">
                                        Setujui
                                    </button>
                                </form>
                                <button type="button" 
                                    @click="rejectModalOpen = true; rejectType = '{{ $doc['id'] }}'; rejectLabel = '{{ $doc['label'] }}'"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 font-medium text-sm rounded hover:bg-red-200 transition-colors {{ $docStatus === 'rejected' ? 'ring-2 ring-red-500 ring-offset-1' : '' }}">
                                    Tolak
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal Penolakan Dokumen -->
        <div x-show="rejectModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="rejectModalOpen" @click="rejectModalOpen = false" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div x-show="rejectModalOpen" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form x-bind:action="'/admin/institutions/verifications/{{ $institution->id }}/verify-document/' + rejectType" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
                                Tolak Dokumen: <span x-text="rejectLabel"></span>
                            </h3>
                            <div class="mt-4">
                                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                                <textarea name="reason" id="reason" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required placeholder="Jelaskan mengapa dokumen ini ditolak..."></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Tolak Dokumen
                            </button>
                            <button type="button" @click="rejectModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
