<x-app-layout>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow { border-color: #e5e7eb; border-radius: 0.5rem 0.5rem 0 0; background: #f9fafb; }
        .ql-container.ql-snow { border-color: #e5e7eb; border-radius: 0 0 0.5rem 0.5rem; min-height: 150px; font-size: 0.875rem; }
        .ql-editor { min-height: 150px; }
        .dark .ql-toolbar.ql-snow { background: #1e293b; border-color: #334155; }
        .dark .ql-toolbar.ql-snow .ql-stroke { stroke: #cbd5e1; }
        .dark .ql-toolbar.ql-snow .ql-fill { fill: #cbd5e1; }
        .dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
        .dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
        .dark .ql-toolbar.ql-snow .ql-active .ql-stroke { stroke: #3b82f6; }
        .dark .ql-toolbar.ql-snow .ql-active .ql-fill { fill: #3b82f6; }
        .dark .ql-container.ql-snow { background: #1e293b; border-color: #334155; color: #f8fafc; }
        .dark .ql-editor.ql-blank::before { color: #64748b; }
        .dark .ql-snow .ql-picker { color: #cbd5e1; }
        .dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #334155; }
        .ql-snow .ql-tooltip { z-index: 50; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kursus</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Edit</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Kursus</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Perbarui data kursus: <strong>{{ $course->title }}</strong></p>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; Kembali
                </a>
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

            <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Section 1: Basic Information -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">Informasi Dasar</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Judul Kursus <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $course->title) }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-lg">
                            @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Platform -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Platform <span class="text-red-500">*</span></label>
                            <input type="text" name="platform" value="{{ old('platform', $course->platform) }}" placeholder="Contoh: Coursera, Udemy" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('platform')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="technical" {{ old('category', $course->category) == 'technical' ? 'selected' : '' }}>Teknis</option>
                                <option value="soft_skill" {{ old('category', $course->category) == 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                            </select>
                            @error('category')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Competency -->
                        <div x-data="{
                            open: false,
                            search: '',
                            selectedId: '{{ old('competency_id', $course->competency_id) }}',
                            selectedName: '-- Pilih Kompetensi --',
                            options: [
                                @foreach($competencies as $comp)
                                    { id: '{{ $comp->id }}', name: {{ json_encode($comp->name . ' (' . $comp->category . ')') }} },
                                @endforeach
                            ],
                            get filteredOptions() {
                                if (this.search === '') return this.options;
                                return this.options.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            init() {
                                if (this.selectedId) {
                                    let o = this.options.find(i => i.id == this.selectedId);
                                    if (o) this.selectedName = o.name;
                                }
                            },
                            selectOption(o) {
                                this.selectedId = o.id;
                                this.selectedName = o.name;
                                this.open = false;
                                this.search = '';
                            }
                        }" class="relative" @click.away="open = false">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Kompetensi Terkait</label>
                            <input type="hidden" name="competency_id" x-model="selectedId">
                            <button type="button" @click="open = !open"
                                class="w-full flex justify-between items-center px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition text-left">
                                <span x-text="selectedName" :class="{'text-gray-400': selectedId === ''}"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg max-h-60 overflow-hidden flex flex-col">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input type="text" x-model="search" placeholder="Cari kompetensi..."
                                        class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <ul class="overflow-y-auto max-h-48 py-1">
                                    <li x-show="filteredOptions.length === 0" class="px-4 py-2 text-sm text-gray-400 text-center">Tidak ditemukan</li>
                                    <template x-for="option in filteredOptions" :key="option.id">
                                        <li @click="selectOption(option)" class="px-4 py-2 text-sm cursor-pointer transition-colors"
                                            :class="{'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium': selectedId == option.id, 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700': selectedId != option.id}">
                                            <span x-text="option.name"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            @error('competency_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Level <span class="text-red-500">*</span></label>
                            <select name="level" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('level')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Durasi (Jam) <span class="text-red-500">*</span></label>
                            <input type="number" name="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" min="1" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('duration_hours')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" value="{{ old('price', $course->price) }}" min="0" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('price')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Is Free -->
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 dark:border-slate-600 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-slate-300">Kursus Gratis</span>
                            </label>
                        </div>

                        <!-- URL -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">URL Kursus <span class="text-red-500">*</span></label>
                            <input type="url" name="url" value="{{ old('url', $course->url) }}" required placeholder="https://..."
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Description -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">Deskripsi Kursus</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                        <input type="hidden" name="description" id="description" value="{{ old('description', $course->description) }}">
                        <div id="quill-description"></div>
                        @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('admin.courses.index') }}"
                            class="px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-800 transition shadow-lg">
                            Update Kursus
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-description', {
        theme: 'snow',
        placeholder: 'Tuliskan deskripsi kursus...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var existing = document.getElementById('description').value;
    if (existing) quill.root.innerHTML = existing;
    var form = document.getElementById('quill-description').closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('description').value = quill.root.innerHTML;
        });
    }
});
</script>
</x-app-layout>
