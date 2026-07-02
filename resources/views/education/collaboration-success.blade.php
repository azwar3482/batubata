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
                    <h2 class="text-2xl font-bold">{{ __('messages.proposal_berhasil_dikirim') }}</h2>
                    <p class="mt-2 text-green-100">{{ __('messages.tim_kami_meninjau_proposal') }}</p>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <div class="text-center mb-8">
                        <p class="text-gray-600">
                            {!! __('messages.terima_kasih_mengajukan_proposal') !!}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h4 class="font-semibold text-gray-900 mb-3">📧 {{ __('messages.apa_selanjutnya') }}</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('messages.anda_menerima_email_konfirmasi') }}
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('messages.cek_dashboard_update_status') }}
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('messages.hubungi_email_pertanyaan') }}
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('education.dashboard') }}"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-center">
                            {{ __('messages.kembali_ke_dashboard') }}
                        </a>
                        <a href="{{ route('education.partners') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                            {{ __('messages.jelajahi_mitra_lainnya') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
