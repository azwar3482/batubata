<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-center text-white">
                    <div class="w-20 h-20 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold">Proposal Berhasil Dikirim!</h2>
                    <p class="mt-2 text-green-100">Tim kami akan meninjau proposal Anda</p>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <div class="text-center mb-8">
                        <p class="text-gray-600">
                            Terima kasih telah mengajukan proposal kolaborasi. Tim KOMPASKARIR akan:<br>
                            <span class="font-semibold text-gray-900">1.</span> Meneruskan proposal ke mitra
                            industri<br>
                            <span class="font-semibold text-gray-900">2.</span> Mengkoordinasikan komunikasi awal<br>
                            <span class="font-semibold text-gray-900">3.</span> Memberikan update status dalam
                            <strong>3-5 hari kerja</strong>
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h4 class="font-semibold text-gray-900 mb-3">📧 Apa Selanjutnya?</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Anda akan menerima email konfirmasi segera
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Cek dashboard untuk update status proposal
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Hubungi <a href="mailto:support@kompskarir.id"
                                    class="text-indigo-600 hover:underline">support@kompskarir.id</a> jika ada
                                pertanyaan
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('education.dashboard') }}"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-center">
                            Kembali ke Dashboard
                        </a>
                        <a href="{{ route('education.partners') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                            Jelajahi Mitra Lainnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
