<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('teacher.classes.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; Kembali ke Kelas</a>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">Buka Kelas Baru</h2>
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($courses->isEmpty())
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
                <p class="text-yellow-700 dark:text-yellow-300">Anda belum memiliki kursus yang dipublikasikan. <a href="{{ route('teacher.courses.create') }}" class="underline font-medium">Buat kursus</a> terlebih dahulu.</p>
            </div>
            @else
            <form action="{{ route('teacher.classes.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Kelas</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kursus *</label>
                            <select name="course_id" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Kursus</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Kelas *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Kelas Web Development Batch 1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Deskripsi kelas...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Pengaturan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Maks. Siswa *</label>
                            <input type="number" name="max_students" value="{{ old('max_students', 30) }}" min="1" max="500" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Link Meeting</label>
                            <input type="url" name="meeting_link" value="{{ old('meeting_link') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://meet.google.com/...">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Jadwal Kelas</label>
                            <textarea name="schedule_info" rows="2" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Setiap Selasa & Kamis, 19:00-21:00 WIB">{{ old('schedule_info') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('teacher.classes.index') }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Buka Kelas</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>
