<x-app-layout>
<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}</style>

<script>
window.searchableDropdown = function(config) {
    return {
        open: false,
        search: '',
        selected: config.selected || '',
        selectedLabel: '',
        options: config.options || [],
        placeholder: config.placeholder || '-- Pilih --',
        required: config.required || false,
        init() {
            const match = this.options.find(o => o.value === this.selected);
            if (match) this.selectedLabel = match.label;
        },
        get filtered() {
            if (!this.search) return this.options;
            const q = this.search.toLowerCase();
            return this.options.filter(o => o.label.toLowerCase().includes(q));
        },
        select(opt) {
            this.selected = opt.value;
            this.selectedLabel = opt.label;
            this.open = false;
            this.search = '';
        }
    };
};
</script>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4 anim-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.users') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Pengguna</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Edit</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 anim-1">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Pengguna</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Perbarui informasi dan role untuk {{ $user->name }}.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>
    <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden anim-2">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('email')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                {{-- Role Radio Cards --}}
                @php $isSelfAdmin = $user->isAdmin() && auth()->id() === $user->id; @endphp
                <div class="md:col-span-2" x-data="{ role: '{{ old('role', $user->role) }}', disabled: {{ $isSelfAdmin ? 'true' : 'false' }} }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <!-- Job Seeker -->
                        <label class="relative flex flex-col p-4 border rounded-xl transition duration-155"
                            :class="[
                                disabled ? 'opacity-60 cursor-not-allowed bg-gray-50 dark:bg-slate-800' : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50',
                                role === 'job_seeker' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'
                            ]">
                            <input type="radio" name="role" value="job_seeker" class="sr-only" x-model="role" :disabled="disabled" required>
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Job Seeker</span>
                            <span class="block text-[10px] text-gray-500 dark:text-gray-400 mt-1">Pencari kerja</span>
                        </label>
                        <!-- Industry -->
                        <label class="relative flex flex-col p-4 border rounded-xl transition duration-155"
                            :class="[
                                disabled ? 'opacity-60 cursor-not-allowed bg-gray-50 dark:bg-slate-800' : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50',
                                role === 'industry' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'
                            ]">
                            <input type="radio" name="role" value="industry" class="sr-only" x-model="role" :disabled="disabled" required>
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Industry</span>
                            <span class="block text-[10px] text-gray-500 dark:text-gray-400 mt-1">Perusahaan/Mitra</span>
                        </label>
                        <!-- Education -->
                        <label class="relative flex flex-col p-4 border rounded-xl transition duration-155"
                            :class="[
                                disabled ? 'opacity-60 cursor-not-allowed bg-gray-50 dark:bg-slate-800' : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50',
                                role === 'education' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'
                            ]">
                            <input type="radio" name="role" value="education" class="sr-only" x-model="role" :disabled="disabled" required>
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Education</span>
                            <span class="block text-[10px] text-gray-500 dark:text-gray-400 mt-1">Institusi Pendidikan</span>
                        </label>
                        <!-- Admin -->
                        <label class="relative flex flex-col p-4 border rounded-xl transition duration-155"
                            :class="[
                                disabled ? 'opacity-60 cursor-not-allowed bg-gray-50 dark:bg-slate-800' : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50',
                                role === 'admin' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'
                            ]">
                            <input type="radio" name="role" value="admin" class="sr-only" x-model="role" :disabled="disabled" required>
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Admin</span>
                            <span class="block text-[10px] text-gray-500 dark:text-gray-400 mt-1">Administrator</span>
                        </label>
                    </div>
                    @if($isSelfAdmin)
                        <p class="mt-2 text-xs text-amber-600 dark:text-amber-400 font-medium">⚠️ Anda tidak dapat mengubah role sendiri.</p>
                        <input type="hidden" name="role" value="{{ $user->role }}">
                    @endif
                    @error('role')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-700 pt-5">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-1">Ubah Password <span class="text-xs font-normal text-gray-400">(Opsional)</span></h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah password.</p>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password Baru</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Minimal 8 karakter">
                    @error('password')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Ulangi password baru">
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('admin.users') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</div>
</x-app-layout>
