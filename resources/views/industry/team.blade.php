<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">{{ __('messages.team_management') }}</h2>
                        <p class="mt-2 text-gray-600">{{ __('messages.team_desc') }}</p>
                    </div>
                    <button @click="$dispatch('open-invite-modal')"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-800 transition shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        {{ __('messages.invite_member') }}
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">{{ __('messages.total_members') }}</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">{{ __('messages.active_members') }}</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->where('status', 'active')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500">{{ __('messages.pending_invitations') }}</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->where('status', 'invited')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">{{ __('messages.total_roles') }}</p>
                    <p class="text-2xl font-bold">{{ count($availableRoles) }}</p>
                </div>
            </div>

            <!-- Team Members Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('messages.team_management') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-16">{{ __('messages.no') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.member') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.role') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.permissions') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.last_active') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($teamMembers as $member)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ $member['avatar'] }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $member['name'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $member['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <select
                                        class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
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
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($member['permissions'] as $perm)
                                        <span
                                            class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded">{{ $permissions[$perm] ?? $perm }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($member['status'] == 'active')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        {{ __('messages.active') }}
                                    </span>
                                    @elseif ($member['status'] == 'inactive')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                        {{ __('messages.inactive') }}
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span
                                            class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5 animate-pulse"></span>
                                        {{ __('messages.invited') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $member['last_active'] ? \Carbon\Carbon::parse($member['last_active'])->diffForHumans() : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($member['status'] == 'invited')
                                        <button class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                                            onclick="resendInvite({{ $member['id'] }})">
                                            {{ __('messages.resend_invite') }}
                                        </button>
                                        @endif
                                        <button class="text-gray-400 hover:text-blue-500 transition"
                                            onclick="editMember({{ $member['id'] }}, '{{ addslashes($member['name']) }}', '{{ $member['email'] }}', '{{ $member['role'] }}', '{{ $member['status'] }}', {{ json_encode($member['permissions']) }})"
                                            title="{{ __('messages.edit') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-500 transition"
                                            onclick="removeMember({{ $member['id'] }}, '{{ addslashes($member['name']) }}')"
                                            title="{{ __('messages.delete') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
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
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Panduan Role & Permissions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($availableRoles as $role => $label)
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900">{{ $label }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $roleDescriptions[$role] ?? '' }}</p>
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
                                class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs rounded">{{ $permissions[$permKey] }}</span>
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
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block w-full max-w-3xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-2xl sm:my-8 sm:align-middle">
                
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2" id="modal-title">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        {{ __('messages.edit_member') }}
                    </h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div class="px-6 py-6 space-y-8 bg-white">
                        
                        <!-- Informasi Profil -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">{{ __('messages.full_name') }} & {{ __('messages.email') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.full_name') }}</label>
                                    <input type="text" name="name" id="editMemberNameInput" required class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.email') }}</label>
                                    <input type="email" name="email" id="editMemberEmailInput" required class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Peran & Status -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">{{ __('messages.base_role') }} & {{ __('messages.status') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.base_role') }}</label>
                                    <select name="role" id="editMemberRole" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm bg-gray-50">
                                        @foreach ($availableRoles as $role => $label)
                                        <option value="{{ $role }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">{{ __('messages.role_hint') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.status_keaktifan') }}</label>
                                    <select name="status" id="editMemberStatus" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                                        <option value="active">{{ __('messages.active') }}</option>
                                        <option value="inactive">{{ __('messages.inactive') }}</option>
                                        <option value="invited">{{ __('messages.invited') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Hak Akses Spesifik -->
                        <div>
                            <div class="flex items-center justify-between mb-4 border-b pb-2">
                                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">{{ __('messages.specific_permissions') }}</h4>
                                <span class="text-xs font-medium text-blue-700 bg-blue-50 px-2 py-1 rounded-md">{{ __('messages.override_hint') }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($permissions as $key => $label)
                                <label class="relative flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 transition group">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="permissions[]" value="{{ $key }}" class="edit-permission-checkbox h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition">
                                    </div>
                                    <div class="ml-3 text-sm flex-1">
                                        <span class="font-medium text-gray-900 group-hover:text-blue-700 transition">{{ $label }}</span>
                                        <p class="text-gray-500 text-xs mt-0.5">{{ __('messages.permission_allow_prefix') }} {{ strtolower($label) }}.</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 sm:flex sm:flex-row-reverse rounded-b-xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            {{ __('messages.save_changes') }}
                        </button>
                        <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
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