<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('industry.competencies.index') }}" class="hover:text-blue-600 transition-colors">Kompetensi</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">Tambah</span>
    </nav>

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Tambah Kompetensi Perusahaan</h1>
        <p class="text-gray-500 mt-1">Buat standar kompetensi khusus untuk lowongan perusahaan Anda.</p>
    </div>

    <div class="rounded-xl border border-gray-100 bg-white shadow-sm overflow-hidden">
        <form action="{{ route('industry.competencies.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1.5">Kode Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" required value="{{ old('code') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition uppercase" placeholder="Misal: TECH-01">
                    @error('code')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Contoh: Pemrograman Python">
                    @error('name')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="soft_skill" {{ old('category') == 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                    </select>
                    @error('category')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="job_listing_id" class="block text-sm font-medium text-gray-700 mb-1.5">Untuk Lowongan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <select name="job_listing_id" id="job_listing_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="">-- Semua Lowongan --</option>
                        @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ old('job_listing_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                        @endforeach
                    </select>
                    @error('job_listing_id')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="position_id" class="block text-sm font-medium text-gray-700 mb-1.5">Posisi Target <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <select name="position_id" id="position_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="">-- Umum (Semua Posisi) --</option>
                        @foreach($positions as $position)
                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                        @endforeach
                    </select>
                    @error('position_id')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="min_level_required" class="block text-sm font-medium text-gray-700 mb-1.5">Level Minimal (1-10) <span class="text-red-500">*</span></label>
                    <input type="number" name="min_level_required" id="min_level_required" required min="1" max="10" value="{{ old('min_level_required', 5) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    <p class="mt-1 text-xs text-gray-400">1-2=Tidak Tahu, 3-4=Pemula, 5-6=Menengah, 7-8=Mahir, 9-10=Ahli</p>
                    @error('min_level_required')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('industry.competencies.index') }}" class="px-5 py-2.5 border-2 border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg transition-all">Simpan Kompetensi</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
