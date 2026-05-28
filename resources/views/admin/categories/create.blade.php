<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="p-2 text-gray-500 hover:text-blue-600 bg-white shadow rounded-xl transition rotate-180">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">Buat Kategori Baru</h2>
                        <p class="mt-1 text-sm text-gray-500">Isi detail kategori sesuai dengan jenis master data.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Kategori</label>
                        <input type="text" name="name" id="name" required placeholder="Contoh: Teknis (Technical)" 
                               class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition px-4 py-3 bg-gray-50/50">
                    </div>
                    
                    <div>
                        <label for="type" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Kategori</label>
                        <select name="type" id="type" required 
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition px-4 py-3 bg-gray-50/50">
                            <option value="competency">Kompetensi</option>
                            <option value="position">Jabatan (Position)</option>
                            <option value="industry">Industri</option>
                            <option value="education">Pendidikan</option>
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Keterangan (Opsional)</label>
                        <textarea name="description" id="description" rows="4" placeholder="Jelaskan penggunaan kategori ini..." 
                                  class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition px-4 py-3 bg-gray-50/50"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition duration-300">Batal</a>
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition duration-300 shadow-lg hover:shadow-blue-200">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
