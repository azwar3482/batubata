<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('industry.dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Panduan Posting Lowongan Efektif</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">Tingkatkan kualitas pelamar dengan strategi penulisan lowongan yang tepat.</p>
            </div>

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl border border-slate-100 dark:border-slate-800">
                <div class="p-8">
                    <div class="prose dark:prose-invert max-w-none">
                        <h3>1. Tulis Deskripsi yang Jelas dan Menarik</h3>
                        <p>Pastikan Anda menyertakan tanggung jawab utama dan ekspektasi peran secara detail. Hindari deskripsi yang terlalu umum.</p>

                        <h3>2. Sebutkan Skill Spesifik</h3>
                        <p>Kandidat yang berkualitas akan mencari kata kunci skill yang sesuai. Pastikan Anda menyertakan keahlian teknis dan non-teknis (soft skill) yang benar-benar dibutuhkan.</p>

                        <h3>3. Jelaskan Benefit dan Budaya Perusahaan</h3>
                        <p>Gaji bukan satu-satunya hal yang dicari oleh kandidat berkualitas tinggi. Fleksibilitas, asuransi, lingkungan kerja, dan kesempatan pengembangan karir sangat penting untuk disebutkan.</p>

                        <h3>4. Jaga Proses Rekrutmen Transparan</h3>
                        <p>Berikan estimasi waktu proses lamaran dan langkah-langkah yang akan dilalui oleh kandidat, seperti tes teknis, wawancara, dsb.</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-800 px-8 py-6 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('industry.jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                        Mulai Posting Lowongan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
