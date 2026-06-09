<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.career-fields.index') }}" class="text-blue-600 hover:underline text-sm mb-2 inline-block">&laquo; Kembali</a>
            <h1 class="text-2xl font-bold">Level Karir: {{ $careerField->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola roadmap level karir untuk bidang ini.</p>
        </div>
        <a href="{{ route('admin.career-fields.create-path', $careerField) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Level
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($careerField->paths->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
        <p class="text-gray-500">Belum ada level karir. Klik "Tambah Level" untuk menambahkan.</p>
    </div>
    @else
    <div class="space-y-4">
        @foreach($careerField->paths as $path)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-{{ $careerField->color }}-50 to-{{ $careerField->color }}-100 border-b flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full bg-{{ $careerField->color }}-500 text-white flex items-center justify-center font-bold">
                        {{ $path->sort_order + 1 }}
                    </span>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $path->level_label }}</h3>
                        <p class="text-xs text-gray-500">
                            {{ $path->level }}
                            @if($path->year_range_min !== null)
                            &middot; {{ $path->year_range_min }}{{ $path->year_range_max ? '-' . $path->year_range_max : '+' }} tahun
                            @endif
                            @if($path->salary_min)
                            &middot; Rp {{ number_format($path->salary_min / 1000000, 0) }}-{{ number_format($path->salary_max / 1000000, 0) }}jt
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.career-fields.edit-path', [$careerField, $path]) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                    <form action="{{ route('admin.career-fields.destroy-path', [$careerField, $path]) }}" method="POST" onsubmit="return confirm('Hapus level ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                    </form>
                </div>
            </div>
            <div class="p-6">
                @if($path->description)
                <p class="text-sm text-gray-600 mb-4">{{ $path->description }}</p>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Skill</h4>
                        <div class="flex flex-wrap gap-1">
                            @foreach($path->skills_required ?? [] as $skill)
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-xs">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Sertifikasi</h4>
                        <ul class="text-xs text-gray-600 space-y-1">
                            @foreach($path->certifications ?? [] as $cert)
                            <li>{{ $cert }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Kursus</h4>
                        <ul class="text-xs text-gray-600 space-y-1">
                            @foreach($path->courses ?? [] as $course)
                            <li>{{ $course }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
</x-app-layout>
