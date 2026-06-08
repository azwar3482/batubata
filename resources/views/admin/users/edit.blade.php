<x-app-layout>
<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}</style>
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-1">
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 anim-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.users') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Pengguna</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Edit</span>
    </nav>
    <div class="mb-6 anim-1">
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Edit Pengguna</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Perbarui informasi dan role untuk {{ $user->name }}.</p>
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
                <div class="md:col-span-2">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" id="role" required {{ $user->isAdmin() && auth()->id()===$user->id ? 'disabled' : '' }} class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition {{ $user->isAdmin() && auth()->id()===$user->id ? 'bg-gray-100 dark:bg-slate-600 cursor-not-allowed' : '' }}">
                        <option value="job_seeker" {{ old('role',$user->role)=='job_seeker'?'selected':'' }}>Job Seeker</option>
                        <option value="industry" {{ old('role',$user->role)=='industry'?'selected':'' }}>Industry</option>
                        <option value="education" {{ old('role',$user->role)=='education'?'selected':'' }}>Education</option>
                        <option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>Admin</option>
                    </select>
                    @if($user->isAdmin() && auth()->id()===$user->id)<p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Anda tidak dapat mengubah role sendiri.</p><input type="hidden" name="role" value="{{ $user->role }}">@endif
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
</x-app-layout>
