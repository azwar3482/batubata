<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen" x-data="{ 
        rejectModal: false,
        rejectDocType: '',
        rejectDocName: '',
        rejectCompanyModal: false
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.companies.verifications.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-700 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Detail Verifikasi: {{ $company->name }}</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Tinjau dokumen legalitas perusahaan sebelum menyetujui pendaftaran.</p>
                    </div>
                </div>
                <div>
                    @if($company->isPending())
                        @php
                            // Check if all uploaded documents are approved
                            $requiredDocs = ['nib', 'siup', 'npwp', 'ktp_director'];
                            $allApproved = true;
                            $hasDocs = false;
                            foreach($requiredDocs as $docType) {
                                $docField = $docType . '_document';
                                if($company->$docField) {
                                    $hasDocs = true;
                                    if($company->getDocumentStatus($docType) !== 'approved') {
                                        $allApproved = false;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <button @click="rejectCompanyModal = true" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 font-semibold rounded-lg text-sm mr-2 transition-colors border border-red-200">Tolak Perusahaan</button>
                        @if($hasDocs && $allApproved)
                        <form action="{{ route('admin.companies.verifications.approve', $company->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 font-semibold rounded-lg text-sm shadow-sm transition-colors">Setujui Verifikasi Akhir</button>
                        </form>
                        @else
                            <button disabled class="px-4 py-2 bg-gray-300 text-gray-500 font-semibold rounded-lg text-sm shadow-sm transition-colors cursor-not-allowed">Setujui Verifikasi Akhir</button>
                        @endif
                    @elseif($company->isVerified())
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1.5 bg-green-100 text-green-700 text-sm font-semibold rounded-lg border border-green-200">Terverifikasi</span>
                            <form action="{{ route('admin.companies.verifications.re-review', $company->id) }}" method="POST" onsubmit="return confirm('Yakin ingin melakukan tinjau ulang? Semua status dokumen akan direset ke pending untuk review kembali.')">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-amber-600 bg-amber-50 border border-amber-200 hover:bg-amber-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Tinjau Ulang
                                </button>
                            </form>
                        </div>
                    @elseif($company->isRejected())
                        <span class="px-3 py-1.5 bg-red-100 text-red-700 text-sm font-semibold rounded-lg border border-red-200">Ditolak</span>
                    @endif
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                <div class="p-1 bg-green-500 text-white rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Modal Tolak Perusahaan -->
            <div x-show="rejectCompanyModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('admin.companies.verifications.reject', $company->id) }}" method="POST">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Tolak Perusahaan</h3>
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan Keseluruhan</label>
                                    <textarea name="rejection_reason" rows="3" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Jelaskan alasan perusahaan ditolak..."></textarea>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Tolak Perusahaan
                                </button>
                                <button type="button" @click="rejectCompanyModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Tolak Dokumen -->
            <div x-show="rejectModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form x-bind:action="'{{ url('/admin/companies/verifications/'.$company->id.'/document') }}/' + rejectDocType" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Tolak Dokumen <span x-text="rejectDocName"></span></h3>
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                                    <textarea name="reason" rows="3" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Jelaskan alasan dokumen ditolak..."></textarea>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Tolak Dokumen
                                </button>
                                <button type="button" @click="rejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Info Perusahaan -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Informasi Perusahaan</h3>
                        <dl class="space-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Nama Perusahaan</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $company->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Industri</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $company->industry ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Ukuran Perusahaan</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $company->company_size ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Alamat</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $company->address ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Website</dt>
                                <dd class="font-medium text-indigo-600 mt-1"><a href="{{ $company->website }}" target="_blank">{{ $company->website ?? '-' }}</a></dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Deskripsi</dt>
                                <dd class="text-gray-900 mt-1 line-clamp-3">{{ $company->description ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Dokumen Verifikasi -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-6">Dokumen Legalitas</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIB -->
                            @php $nibStatus = $company->getDocumentStatus('nib'); @endphp
                            <div class="border rounded-xl p-4 flex flex-col justify-between {{ $nibStatus === 'approved' ? 'bg-green-50 border-green-200' : ($nibStatus === 'rejected' ? 'bg-red-50 border-red-200' : '') }}">
                                <div>
                                    <div class="text-sm font-bold text-gray-900 mb-1">NIB (Nomor Induk Berusaha)</div>
                                    @if($company->nib_document)
                                        <div class="text-xs flex items-center gap-1 mb-3 {{ $nibStatus === 'approved' ? 'text-green-600' : ($nibStatus === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                            @if($nibStatus === 'approved')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Disetujui
                                            @elseif($nibStatus === 'rejected')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak
                                            @else
                                                Menunggu Verifikasi
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-xs text-red-500 mb-3">Tidak ada dokumen</div>
                                    @endif
                                </div>
                                <div>
                                    @if($company->nib_document)
                                    <a href="{{ Storage::url($company->nib_document) }}" target="_blank" class="text-center w-full block py-2 bg-indigo-50 text-indigo-700 text-sm font-semibold rounded-lg hover:bg-indigo-100 transition-colors mb-3">Lihat Dokumen</a>
                                    
                                    @if($nibStatus === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.companies.verifications.verify-document', [$company->id, 'nib']) }}" method="POST" class="w-1/2">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="w-full p-2 bg-green-100 text-green-700 text-sm font-semibold rounded-lg hover:bg-green-200">Setujui</button>
                                        </form>
                                        <button @click="rejectModal = true; rejectDocType = 'nib'; rejectDocName = 'NIB'" class="w-1/2 p-2 bg-red-100 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-200">Tolak</button>
                                    </div>
                                    @elseif($nibStatus === 'rejected')
                                        <div class="text-xs text-red-700 bg-red-100 p-2 rounded-lg mt-2"><strong>Alasan:</strong> {{ $company->getDocumentReason('nib') }}</div>
                                    @endif
                                    @else
                                    <button disabled class="text-center w-full block py-2 bg-gray-50 text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">Tidak Tersedia</button>
                                    @endif
                                </div>
                            </div>

                            <!-- SIUP -->
                            @php $siupStatus = $company->getDocumentStatus('siup'); @endphp
                            <div class="border rounded-xl p-4 flex flex-col justify-between {{ $siupStatus === 'approved' ? 'bg-green-50 border-green-200' : ($siupStatus === 'rejected' ? 'bg-red-50 border-red-200' : '') }}">
                                <div>
                                    <div class="text-sm font-bold text-gray-900 mb-1">SIUP</div>
                                    @if($company->siup_document)
                                        <div class="text-xs flex items-center gap-1 mb-3 {{ $siupStatus === 'approved' ? 'text-green-600' : ($siupStatus === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                            @if($siupStatus === 'approved')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Disetujui
                                            @elseif($siupStatus === 'rejected')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak
                                            @else
                                                Menunggu Verifikasi
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-xs text-red-500 mb-3">Tidak ada dokumen</div>
                                    @endif
                                </div>
                                <div>
                                    @if($company->siup_document)
                                    <a href="{{ Storage::url($company->siup_document) }}" target="_blank" class="text-center w-full block py-2 bg-indigo-50 text-indigo-700 text-sm font-semibold rounded-lg hover:bg-indigo-100 transition-colors mb-3">Lihat Dokumen</a>
                                    
                                    @if($siupStatus === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.companies.verifications.verify-document', [$company->id, 'siup']) }}" method="POST" class="w-1/2">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="w-full p-2 bg-green-100 text-green-700 text-sm font-semibold rounded-lg hover:bg-green-200">Setujui</button>
                                        </form>
                                        <button @click="rejectModal = true; rejectDocType = 'siup'; rejectDocName = 'SIUP'" class="w-1/2 p-2 bg-red-100 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-200">Tolak</button>
                                    </div>
                                    @elseif($siupStatus === 'rejected')
                                        <div class="text-xs text-red-700 bg-red-100 p-2 rounded-lg mt-2"><strong>Alasan:</strong> {{ $company->getDocumentReason('siup') }}</div>
                                    @endif
                                    @else
                                    <button disabled class="text-center w-full block py-2 bg-gray-50 text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">Tidak Tersedia</button>
                                    @endif
                                </div>
                            </div>

                            <!-- NPWP -->
                            @php $npwpStatus = $company->getDocumentStatus('npwp'); @endphp
                            <div class="border rounded-xl p-4 flex flex-col justify-between {{ $npwpStatus === 'approved' ? 'bg-green-50 border-green-200' : ($npwpStatus === 'rejected' ? 'bg-red-50 border-red-200' : '') }}">
                                <div>
                                    <div class="text-sm font-bold text-gray-900 mb-1">NPWP Perusahaan</div>
                                    @if($company->npwp_document)
                                        <div class="text-xs flex items-center gap-1 mb-3 {{ $npwpStatus === 'approved' ? 'text-green-600' : ($npwpStatus === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                            @if($npwpStatus === 'approved')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Disetujui
                                            @elseif($npwpStatus === 'rejected')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak
                                            @else
                                                Menunggu Verifikasi
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-xs text-red-500 mb-3">Tidak ada dokumen</div>
                                    @endif
                                </div>
                                <div>
                                    @if($company->npwp_document)
                                    <a href="{{ Storage::url($company->npwp_document) }}" target="_blank" class="text-center w-full block py-2 bg-indigo-50 text-indigo-700 text-sm font-semibold rounded-lg hover:bg-indigo-100 transition-colors mb-3">Lihat Dokumen</a>
                                    
                                    @if($npwpStatus === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.companies.verifications.verify-document', [$company->id, 'npwp']) }}" method="POST" class="w-1/2">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="w-full p-2 bg-green-100 text-green-700 text-sm font-semibold rounded-lg hover:bg-green-200">Setujui</button>
                                        </form>
                                        <button @click="rejectModal = true; rejectDocType = 'npwp'; rejectDocName = 'NPWP'" class="w-1/2 p-2 bg-red-100 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-200">Tolak</button>
                                    </div>
                                    @elseif($npwpStatus === 'rejected')
                                        <div class="text-xs text-red-700 bg-red-100 p-2 rounded-lg mt-2"><strong>Alasan:</strong> {{ $company->getDocumentReason('npwp') }}</div>
                                    @endif
                                    @else
                                    <button disabled class="text-center w-full block py-2 bg-gray-50 text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">Tidak Tersedia</button>
                                    @endif
                                </div>
                            </div>

                            <!-- KTP -->
                            @php $ktpStatus = $company->getDocumentStatus('ktp_director'); @endphp
                            <div class="border rounded-xl p-4 flex flex-col justify-between {{ $ktpStatus === 'approved' ? 'bg-green-50 border-green-200' : ($ktpStatus === 'rejected' ? 'bg-red-50 border-red-200' : '') }}">
                                <div>
                                    <div class="text-sm font-bold text-gray-900 mb-1">KTP Direktur / Penanggung Jawab</div>
                                    @if($company->ktp_director_document)
                                        <div class="text-xs flex items-center gap-1 mb-3 {{ $ktpStatus === 'approved' ? 'text-green-600' : ($ktpStatus === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                            @if($ktpStatus === 'approved')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Disetujui
                                            @elseif($ktpStatus === 'rejected')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak
                                            @else
                                                Menunggu Verifikasi
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-xs text-red-500 mb-3">Tidak ada dokumen</div>
                                    @endif
                                </div>
                                <div>
                                    @if($company->ktp_director_document)
                                    <a href="{{ Storage::url($company->ktp_director_document) }}" target="_blank" class="text-center w-full block py-2 bg-indigo-50 text-indigo-700 text-sm font-semibold rounded-lg hover:bg-indigo-100 transition-colors mb-3">Lihat Dokumen</a>
                                    
                                    @if($ktpStatus === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.companies.verifications.verify-document', [$company->id, 'ktp_director']) }}" method="POST" class="w-1/2">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="w-full p-2 bg-green-100 text-green-700 text-sm font-semibold rounded-lg hover:bg-green-200">Setujui</button>
                                        </form>
                                        <button @click="rejectModal = true; rejectDocType = 'ktp_director'; rejectDocName = 'KTP Direktur'" class="w-1/2 p-2 bg-red-100 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-200">Tolak</button>
                                    </div>
                                    @elseif($ktpStatus === 'rejected')
                                        <div class="text-xs text-red-700 bg-red-100 p-2 rounded-lg mt-2"><strong>Alasan:</strong> {{ $company->getDocumentReason('ktp_director') }}</div>
                                    @endif
                                    @else
                                    <button disabled class="text-center w-full block py-2 bg-gray-50 text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">Tidak Tersedia</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
