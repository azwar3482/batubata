<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ __('messages.team_management') }}</h2>
                        <p class="mt-2 text-gray-500 dark:text-slate-400">{{ __('messages.team_desc') }}</p>
                    </div>
                    <button @click="$dispatch('open-invite-modal')"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        {{ __('messages.invite_member') }}
                    </button>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 border border-amber-100 dark:border-amber-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900 dark:text-amber-200 mb-1">Tentang Manajemen Tim</h4>
                        <p class="text-sm text-amber-700 dark:text-amber-300 leading-relaxed">Kelola anggota tim rekrutmen perusahaan Anda. <strong>Undang anggota baru</strong> melalui email dan atur <strong>role mereka</strong> (HR Manager, Recruiter, Talent Sourcer, Interviewer). Setiap role memiliki <strong>hak akses yang berbeda</strong> dalam mengelola lowongan dan kandidat.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-800 border-l-4 border-l-blue-500 hover:shadow-md transition-shadow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 font-medium">{{ __('messages.total_members') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $teamMembers->count() }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-800 border-l-4 border-l-green-500 hover:shadow-md transition-shadow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 font-medium">{{ __('messages.active_members') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $teamMembers->where('status', 'active')->count() }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-800 border-l-4 border-l-amber-500 hover:shadow-md transition-shadow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 font-medium">{{ __('messages.pending_invitations') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $teamMembers->where('status', 'invited')->count() }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-800 border-l-4 border-l-purple-500 hover:shadow-md transition-shadow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 font-medium">{{ __('messages.total_roles') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ count($availableRoles) }}</p>
                </div>
            </div>

            <!-- Team Members Table -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.team_management') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-800/50">
                        <thead class="bg-gray-50 dark:bg-slate-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">{{ __('messages.no') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider min-w-[200px]">{{ __('messages.member') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider min-w-[160px]">{{ __('messages.role') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-[40%] min-w-[300px]">{{ __('messages.permissions') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap">{{ __('messages.status') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap">{{ __('messages.last_active') }}</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-24">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-100 dark:divide-slate-800/50">
                            @foreach ($teamMembers as $member)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-slate-300">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full shadow-sm flex items-center justify-center text-white font-bold text-sm shrink-0">
                                            {{ $member['avatar'] }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $member['name'] }}</p>
                                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ $member['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <select
                                        class="text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        onchange="updateRole({{ $member['id'] }}, this.value)">
                                        @foreach ($availableRoles as $role => $label)
                                        <option value="{{ $role }}"
                                            {{ $member['role'] == $role ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($member['permissions'] as $perm)
                                        <span
                                            class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium rounded-md border border-blue-100 dark:border-blue-800/50">{{ $permissions[$perm] ?? $perm }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($member['status'] == 'active')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                        {{ __('messages.active') }}
                                    </span>
                                    @elseif ($member['status'] == 'inactive')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/50">
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mr-1.5"></span>
                                        {{ __('messages.inactive') }}
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span>
                                        {{ __('messages.invited') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                    {{ $member['last_active'] ? \Carbon\Carbon::parse($member['last_active'])->diffForHumans() : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @if ($member['status'] == 'invited')
                                        <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium transition-colors"
                                            onclick="resendInvite({{ $member['id'] }})">
                                            {{ __('messages.resend_invite') }}
                                        </button>
                                        @endif
                                        <button class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors p-1"
                                            onclick="editMember({{ $member['id'] }}, '{{ addslashes($member['name']) }}', '{{ $member['email'] }}', '{{ $member['role'] }}', '{{ $member['status'] }}', {{ json_encode($member['permissions']) }})"
                                            title="{{ __('messages.edit') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors p-1"
                                            onclick="removeMember({{ $member['id'] }}, '{{ addslashes($member['name']) }}')"
                                            title="{{ __('messages.delete') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Roles & Permissions Guide -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Panduan Role & Permissions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($availableRoles as $role => $label)
                    <div class="p-4 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $label }}</h4>
                        <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ $roleDescriptions[$role] ?? '' }}</p>
                        <div class="mt-3 flex flex-wrap gap-1">
                            @php
                            $rolePermissions = [
                            'staf_hr_manager' => ['post_jobs', 'view_candidates', 'manage_applications', 'schedule_interview', 'submit_feedback', 'view_reports'],
                            'staf_recruiter' => ['view_candidates', 'schedule_interview', 'submit_feedback'],
                            'staf_talent_sourcer' => ['view_candidates'],
                            'staf_interviewer' => ['view_candidates', 'submit_feedback']
                            ][$role] ?? [];
                            @endphp
                            @foreach ($rolePermissions as $permKey)
                            @if (isset($permissions[$permKey]))
                            <span
                                class="px-2 py-0.5 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 text-xs rounded">{{ $permissions[$permKey] }}</span>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Include External Invite Modal -->
    @include('industry.team-invite-modal')

    <!-- Edit Role Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-slate-900 dark:bg-opacity-80" aria-hidden="true" onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block w-full max-w-3xl overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-slate-800 rounded-xl shadow-2xl sm:my-8 sm:align-middle">
                
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2" id="modal-title">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        {{ __('messages.edit_member') }}
                    </h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-slate-300 focus:outline-none transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div class="px-6 py-6 space-y-8 bg-white dark:bg-slate-800">
                        
                        <!-- Informasi Profil -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4 border-b border-gray-200 dark:border-slate-700 pb-2">{{ __('messages.full_name') }} & {{ __('messages.email') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.full_name') }}</label>
                                    <input type="text" name="name" id="editMemberNameInput" required class="block w-full px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.email') }}</label>
                                    <input type="email" name="email" id="editMemberEmailInput" required class="block w-full px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Peran & Status -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4 border-b border-gray-200 dark:border-slate-700 pb-2">{{ __('messages.base_role') }} & {{ __('messages.status') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.base_role') }}</label>
                                    <select name="role" id="editMemberRole" class="block w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm bg-gray-50 dark:bg-slate-700 dark:text-white">
                                        @foreach ($availableRoles as $role => $label)
                                        <option value="{{ $role }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">{{ __('messages.role_hint') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.status_keaktifan') }}</label>
                                    <select name="status" id="editMemberStatus" class="block w-full px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                                        <option value="active">{{ __('messages.active') }}</option>
                                        <option value="inactive">{{ __('messages.inactive') }}</option>
                                        <option value="invited">{{ __('messages.invited') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Hak Akses Spesifik -->
                        <div>
                            <div class="flex items-center justify-between mb-4 border-b border-gray-200 dark:border-slate-700 pb-2">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">{{ __('messages.specific_permissions') }}</h4>
                                <span class="text-xs font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded-md">{{ __('messages.override_hint') }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($permissions as $key => $label)
                                <label class="relative flex items-start p-4 border border-gray-200 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="permissions[]" value="{{ $key }}" class="edit-permission-checkbox h-5 w-5 text-blue-600 dark:text-blue-500 border-gray-300 dark:border-slate-600 dark:bg-slate-700 rounded focus:ring-blue-500 transition">
                                    </div>
                                    <div class="ml-3 text-sm flex-1">
                                        <span class="font-medium text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-400 transition">{{ $label }}</span>
                                        <p class="text-gray-500 dark:text-slate-400 text-xs mt-0.5">{{ __('messages.permission_allow_prefix') }} {{ strtolower($label) }}.</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900 border-t border-gray-200 dark:border-slate-700 sm:flex sm:flex-row-reverse rounded-b-xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            {{ __('messages.save_changes') }}
                        </button>
                        <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-slate-600 shadow-sm px-6 py-2.5 bg-white dark:bg-slate-800 text-base font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            {{ __('messages.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Functions -->
    <script>
        function editMember(id, name, email, role, status, userPermissions) {
            document.getElementById('editForm').action = '/industry/team/' + id + '/role';
            document.getElementById('editMemberNameInput').value = name;
            document.getElementById('editMemberEmailInput').value = email;
            document.getElementById('editMemberRole').value = role;
            document.getElementById('editMemberStatus').value = status;
            
            // Reset checkboxes
            document.querySelectorAll('.edit-permission-checkbox').forEach(cb => {
                cb.checked = false;
            });
            // Set checkboxes if userPermissions is valid array
            if(Array.isArray(userPermissions)) {
                userPermissions.forEach(perm => {
                    const cb = document.querySelector(`.edit-permission-checkbox[value="${perm}"]`);
                    if(cb) cb.checked = true;
                });
            }

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function updateRole(memberId, newRole) {
            if (confirm('Ubah role anggota ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/industry/team/${memberId}/role`;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);

                const roleInput = document.createElement('input');
                roleInput.type = 'hidden';
                roleInput.name = 'role';
                roleInput.value = newRole;
                form.appendChild(roleInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function resendInvite(memberId) {
            if (confirm('Kirim ulang undangan ke anggota ini?')) {
                // AJAX call or route handling
                alert('Undangan berhasil dikirim ulang!');
            }
        }

        function removeMember(memberId, memberName) {
            if (confirm('Hapus ' + memberName + ' dari tim rekrutmen?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/industry/team/${memberId}`;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>