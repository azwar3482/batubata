<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.positions.index') }}" 
                       class="p-2 text-gray-500 hover:text-purple-600 bg-white shadow rounded-xl transition rotate-180">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">Buat Jabatan Baru</h2>
                        <p class="mt-1 text-sm text-gray-500">Isi detail jabatan yang akan ditambahkan ke sistem.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form action="{{ route('admin.positions.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Jabatan</label>
                        <input type="text" name="name" id="name" required placeholder="Contoh: Web Developer" 
                               class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition px-4 py-3 bg-gray-50/50">
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Bidang</label>
                        <input type="text" name="category" id="category" required placeholder="Contoh: IT, Marketing, HR" 
                               class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition px-4 py-3 bg-gray-50/50">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Jabatan (Opsional)</label>
                        <textarea name="description" id="description" rows="4" placeholder="Jelaskan tanggung jawab atau detail jabatan ini..." 
                                  class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition px-4 py-3 bg-gray-50/50"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('admin.positions.index') }}" 
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition duration-300">Batal</a>
                        <button type="submit" 
                                class="px-8 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition duration-300 shadow-lg hover:shadow-purple-200">
                            Simpan Jabatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
