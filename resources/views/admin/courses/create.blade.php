<x-app-layout>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<style>
    @keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}
    trix-editor { min-height: 150px; }
    .dark trix-editor { background-color: #1e293b; color: #f8fafc; border-color: #334155; }
    .dark .trix-button-group { background: #1e293b; border-color: #334155; }
    .dark trix-toolbar [data-trix-button] { color: #cbd5e1; border-color: #334155; }
    .dark trix-toolbar [data-trix-button]:hover { background: #334155; }
    .dark trix-toolbar [data-trix-button].trix-active { background: #475569; color: white; }
    .trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .trix-content a { color: #3b82f6; text-decoration: underline; }
</style>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 anim-1">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">Tambah Kursus Baru</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Buat data kursus baru untuk rekomendasi kompetensi.</p>
        </div>
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 anim-2">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Judul Kursus <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('title')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Platform <span class="text-red-500">*</span></label>
                    <input type="text" name="platform" value="{{ old('platform') }}" placeholder="Contoh: Coursera, Udemy" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('platform')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="technical" {{ old('category')=='technical'?'selected':'' }}>Teknis</option>
                        <option value="soft_skill" {{ old('category')=='soft_skill'?'selected':'' }}>Soft Skill</option>
                    </select>
                    @error('category')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div x-data='{open:false,search:"",selectedId:"{{ old('competency_id') }}",selectedName:"-- Pilih Kompetensi --",options:[@foreach($competencies as $comp){id:"{{ $comp->id }}",name:{{ json_encode($comp->name.' ('.$comp->category.')') }}},@endforeach],get filteredOptions(){if(this.search==="")return this.options;return this.options.filter(i=>i.name.toLowerCase().includes(this.search.toLowerCase()))},init(){if(this.selectedId){let o=this.options.find(i=>i.id==this.selectedId);if(o)this.selectedName=o.name}},selectOption(o){this.selectedId=o.id;this.selectedName=o.name;this.open=false;this.search=""}}' class="md:col-span-2 relative" @click.away="open=false">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kompetensi Terkait</label>
                    <input type="hidden" name="competency_id" x-model="selectedId">
                    <button type="button" @click="open=!open" class="w-full flex justify-between items-center px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition text-left">
                        <span x-text="selectedName" :class="{'text-gray-400 dark:text-gray-500':selectedId===''}"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180':open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg max-h-60 overflow-hidden flex flex-col">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" placeholder="Cari kompetensi..." class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <ul class="overflow-y-auto max-h-48 py-1">
                            <li x-show="filteredOptions.length===0" class="px-4 py-2 text-sm text-gray-400 text-center">Tidak ditemukan</li>
                            <template x-for="option in filteredOptions" :key="option.id">
                                <li @click="selectOption(option)" class="px-4 py-2 text-sm cursor-pointer transition-colors" :class="{'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium':selectedId==option.id,'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700':selectedId!=option.id}"><span x-text="option.name"></span></li>
                            </template>
                        </ul>
                    </div>
                    @error('competency_id')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Level <span class="text-red-500">*</span></label>
                    <select name="level" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="beginner" {{ old('level')=='beginner'?'selected':'' }}>Beginner</option>
                        <option value="intermediate" {{ old('level')=='intermediate'?'selected':'' }}>Intermediate</option>
                        <option value="advanced" {{ old('level')=='advanced'?'selected':'' }}>Advanced</option>
                    </select>
                    @error('level')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Durasi (Jam) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration_hours" value="{{ old('duration_hours') }}" min="1" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('duration_hours')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price',0) }}" min="0" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('price')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free')?'checked':'' }} class="w-4 h-4 text-blue-600 border-gray-300 dark:border-slate-600 rounded focus:ring-blue-500">
                    <label for="is_free" class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Kursus Gratis</label>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">URL Kursus <span class="text-red-500">*</span></label>
                    <input type="url" name="url" value="{{ old('url') }}" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('url')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                    <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                    <trix-editor input="description" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Tuliskan deskripsi kursus..."></trix-editor>
                    @error('description')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('admin.courses.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Kursus</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
