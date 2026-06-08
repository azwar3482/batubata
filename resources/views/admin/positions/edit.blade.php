<x-app-layout>
<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}</style>
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-1">
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 anim-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.positions.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Jabatan</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Edit</span>
    </nav>
    <div class="mb-6 anim-1">
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Edit Jabatan</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Ubah detail jabatan {{ $position->name }}.</p>
    </div>
    <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden anim-2">
        <form action="{{ route('admin.positions.update', $position) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ $position->name }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori Bidang <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)<option value="{{ $cat->name }}" {{ $position->category===$cat->name?'selected':'' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                    @error('category')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">{{ $position->description }}</textarea>
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('admin.positions.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Update Jabatan</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
