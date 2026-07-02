<x-app-layout>
@include('partials.quill-styles')
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
                <a href="{{ route('education.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.dashboard') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('education.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.kelola_kursus') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('education.courses.show', $course) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ Str::limit($course->title, 20) }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ __('messages.edit') }}</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.edit_kursus') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.perbarui_informasi_kursus') }} <span class="font-semibold">{{ $course->title }}</span></p>
                </div>
                <a href="{{ route('education.courses.show', $course) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; {{ __('messages.kembali') }}
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

            <form action="{{ route('education.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf @method('PUT')

                <!-- Informasi Dasar -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ __('messages.informasi_dasar') }}
                    </h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.judul_kursus') }} *</label>
                            <input type="text" name="title" value="{{ old('title', $course->title) }}" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.deskripsi') }} *</label>
                            <input type="hidden" name="description" id="description" value="{{ old('description', $course->description) }}">
                            <div id="quill-description"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.tujuan_pembelajaran') }}</label>
                            <input type="hidden" name="objectives" id="objectives" value="{{ old('objectives', $course->objectives) }}">
                            <div id="quill-objectives"></div>
                        </div>
                    </div>
                </div>

                <!-- Pengaturan Kursus -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ __('messages.pengaturan_kursus') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.kompetensi_terkait') }}</label>
                            <select name="competency_id" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">{{ __('messages.pilih_kompetensi') }}</option>
                                @foreach($competencies as $comp)
                                <option value="{{ $comp->id }}" {{ old('competency_id', $course->competency_id) == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.kategori') }} *</label>
                            <select name="category" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="technical" {{ old('category', $course->category) === 'technical' ? 'selected' : '' }}>{{ __('messages.teknis') }}</option>
                                <option value="soft_skill" {{ old('category', $course->category) === 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.level') }} *</label>
                            <select name="level" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.durasi_jam') }} *</label>
                            <input type="number" name="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" min="1" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.maks_siswa_per_kelas') }}</label>
                            <input type="number" name="max_students" value="{{ old('max_students', $course->max_students) }}" min="0" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags', $course->tags ? implode(', ', $course->tags) : '') }}" placeholder="{{ __('messages.pisahkan_dengan_koma') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Harga & Thumbnail -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('messages.harga_dan_thumbnail') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.harga_rp') }}</label>
                            <label class="flex items-center gap-2 mb-2">
                                <input type="checkbox" name="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('messages.gratis') }}</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price', $course->price) }}" min="0" step="1000" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.thumbnail') }}</label>
                            @if($course->thumbnail_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="Thumbnail" class="w-40 h-24 object-cover rounded-lg border border-gray-200 dark:border-slate-700">
                            </div>
                            @endif
                            <input type="file" name="thumbnail" accept="image/*" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('education.courses.show', $course) }}" class="inline-flex items-center px-4 py-2 text-gray-700 dark:text-slate-300 hover:text-gray-900 dark:hover:text-white transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('messages.kembali') }}
                    </a>
                    <div class="flex gap-3">
                        <a href="{{ route('education.courses.index') }}" class="px-5 py-2.5 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">
                            {{ __('messages.batal') }}
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('messages.perbarui_kursus') }}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/quill.js'])
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var quillDesc = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: '{{ __("messages.jelaskan_rinci_kursus_ini") }}',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingDesc = document.getElementById('description').value;
        if (existingDesc) quillDesc.root.innerHTML = existingDesc;

        var quillObj = new Quill('#quill-objectives', {
            theme: 'snow',
            placeholder: '{{ __("messages.kompetensi_materi_utama_dicapai_siswa") }}',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingObj = document.getElementById('objectives').value;
        if (existingObj) quillObj.root.innerHTML = existingObj;

        var form = document.getElementById('quill-description').closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('description').value = quillDesc.root.innerHTML;
                document.getElementById('objectives').value = quillObj.root.innerHTML;
            });
        }
    });
    </script>
</x-app-layout>
