<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <input wire:model.debounce.300ms="search" type="text" placeholder="Search users..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button wire:click="create()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New User
                </button>
            </div>
        </div>

        <!-- Status Messages -->
        @if(session()->has('message'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Summary Cards -->
        @php
            $system = $users->where('id', '>=', 1)->where('id', '<=', 5);
            $teacher = $users->where('teacher_id', '>', 0);
            $requested = $users->filter(function($u){ return (bool)($u->is_requested ?? false); });
            $student = $users->filter(function($u){ return ($u->studentdb_id > 0) && ($u->teacher_id <= 0) && (bool)!($u->is_requested ?? false); });
            $suspendedTeachers = $users->filter(function($u){ return ($u->status === false || $u->status === 'inactive') && ($u->teacher_id > 0); });
            $suspendedStudents = $users->filter(function($u){ return ($u->status === false || $u->status === 'inactive') && ($u->studentdb_id > 0); });
            $suspended = $suspendedTeachers->count() + $suspendedStudents->count();
            $unknown = $users->filter(function($u){ return ($u->studentdb_id <= 0) && ($u->teacher_id <= 0) && (bool)!($u->is_requested ?? false); });
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="rounded-xl p-4 bg-gradient-to-br from-gray-700 to-gray-600 text-white">
                <div class="text-xs uppercase opacity-90">System</div>
                <div class="text-3xl font-bold">{{ $system->count() }}</div>
                <div class="text-xs opacity-80 mt-1">IDs 1-5</div>
            </div>
            <div class="rounded-xl p-4 bg-gradient-to-br from-blue-600 to-indigo-600 text-white">
                <div class="text-xs uppercase opacity-90">Teacher</div>
                <div class="text-3xl font-bold">{{ $teacher->count() }}</div>
                <div class="text-xs opacity-80 mt-1">teacher_id > 0</div>
            </div>
            <div class="rounded-xl p-4 bg-gradient-to-br from-yellow-500 to-amber-600 text-white">
                <div class="text-xs uppercase opacity-90">Requested</div>
                <div class="text-3xl font-bold">{{ $requested->count() }}</div>
                <div class="text-xs opacity-80 mt-1">is_requested = true</div>
            </div>
            <div class="rounded-xl p-4 bg-gradient-to-br from-green-600 to-emerald-600 text-white">
                <div class="text-xs uppercase opacity-90">Student</div>
                <div class="text-3xl font-bold">{{ $student->count() }}</div>
                <div class="text-xs opacity-80 mt-1">studentdb_id > 0, teacher_id <= 0, not requested</div>
            </div>
            <div class="rounded-xl p-4 bg-gradient-to-br from-red-600 to-rose-600 text-white">
                <div class="text-xs uppercase opacity-90">Suspended</div>
                <div class="text-3xl font-bold">{{ $suspended }}</div>
                <div class="text-xs opacity-80 mt-1">Inactive teachers & students</div>
            </div>
            <div class="rounded-xl p-4 bg-gradient-to-br from-slate-500 to-slate-600 text-white">
                <div class="text-xs uppercase opacity-90">Unknown</div>
                <div class="text-3xl font-bold">{{ $unknown->count() }}</div>
                <div class="text-xs opacity-80 mt-1">No teacher/student, not requested</div>
            </div>
        </div>

        <!-- Categorized Users -->
        <div x-data="{cat: 'system'}" class="mb-6">
            <div class="flex flex-wrap gap-2 mb-3">
                <button @click="cat='system'" :class="cat==='system' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700'" class="px-3 py-1.5 rounded">System</button>
                <button @click="cat='teacher'" :class="cat==='teacher' ? 'bg-blue-700 text-white' : 'bg-blue-50 text-blue-700'" class="px-3 py-1.5 rounded">Teacher</button>
                <button @click="cat='requested'" :class="cat==='requested' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700'" class="px-3 py-1.5 rounded">Requested</button>
                <button @click="cat='student'" :class="cat==='student' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-700'" class="px-3 py-1.5 rounded">Student</button>
                <button @click="cat='suspended'" :class="cat==='suspended' ? 'bg-rose-700 text-white' : 'bg-rose-50 text-rose-700'" class="px-3 py-1.5 rounded">Suspended</button>
                <button @click="cat='unknown'" :class="cat==='unknown' ? 'bg-slate-700 text-white' : 'bg-slate-50 text-slate-700'" class="px-3 py-1.5 rounded">Unknown</button>
            </div>

            <!-- Table Template -->
            <template x-if="cat==='system'">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($system as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $user->status ?: 'N/A' }}</span></td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex gap-2 justify-end opacity-50 cursor-not-allowed">
                                                <button class="text-gray-400" disabled>Edit</button>
                                                <button class="text-gray-400" disabled>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No users</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-2 bg-gray-50 border-t">{{ $users->links() }}</div>
                </div>
            </template>

            <template x-if="cat==='teacher'">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50"><tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-700 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-700 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-700 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-blue-700 uppercase">Teacher</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-blue-700 uppercase">Actions</th>
                            </tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($teacher as $user)
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ optional($user->teacher)->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex gap-2 justify-end">
                                                @if($user->id > 5)
                                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                                @else
                                                    <span class="text-gray-400 text-xs">Protected</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No users</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-2 bg-blue-50 border-t">{{ $users->links() }}</div>
                </div>
            </template>

            <template x-if="cat==='requested'">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-amber-50"><tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase">Requested</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-amber-700 uppercase">Actions</th>
                            </tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($requested as $user)
                                    <tr class="hover:bg-amber-50/40">
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">Yes</span></td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex gap-2 justify-end">
                                                @if($user->id > 5)
                                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                                @else
                                                    <span class="text-gray-400 text-xs">Protected</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No users</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-2 bg-amber-50 border-t">{{ $users->links() }}</div>
                </div>
            </template>

            <template x-if="cat==='student'">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50"><tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-emerald-700 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-emerald-700 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-emerald-700 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-emerald-700 uppercase">Student</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-emerald-700 uppercase">Actions</th>
                            </tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($student as $user)
                                    <tr class="hover:bg-emerald-50/40">
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ optional($user->studentdb)->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex gap-2 justify-end">
                                                @if($user->id > 5)
                                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                                @else
                                                    <span class="text-gray-400 text-xs">Protected</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No users</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-2 bg-emerald-50 border-t">{{ $users->links() }}</div>
                </div>
            </template>

            <template x-if="cat==='suspended'">
                <div class="space-y-4">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="px-4 py-2 font-semibold bg-rose-50 text-rose-700 border-b">Suspended Teachers</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-rose-50"><tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">Teacher</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-rose-700 uppercase">Actions</th>
                                </tr></thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($suspendedTeachers as $user)
                                        <tr class="hover:bg-rose-50/40">
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ optional($user->teacher)->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-right">
                                                <div class="flex gap-2 justify-end">
                                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No suspended teachers</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="px-4 py-2 font-semibold bg-rose-50 text-rose-700 border-b">Suspended Students</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-rose-50"><tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-rose-700 uppercase">Student</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-rose-700 uppercase">Actions</th>
                                </tr></thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($suspendedStudents as $user)
                                        <tr class="hover:bg-rose-50/40">
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ optional($user->studentdb)->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-right">
                                                <div class="flex gap-2 justify-end">
                                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No suspended students</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="cat==='unknown'">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-slate-50"><tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-slate-700 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-slate-700 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-slate-700 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-slate-700 uppercase">Requested</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-slate-700 uppercase">Actions</th>
                            </tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($unknown as $user)
                                    <tr class="hover:bg-slate-50/40">
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_requested ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800' }}">{{ $user->is_requested ? 'Requested' : 'No' }}</span></td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex gap-2 justify-end">
                                                @if($user->id > 5)
                                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                                @else
                                                    <span class="text-gray-400 text-xs">Protected</span>
                                                @endif
                                                
                                        <div class="flex space-x-3 justify-end">
                                            <button wire:click="edit({{ $user->id }})"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900"
                                                onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No users</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-2 bg-slate-50 border-t">{{ $users->links() }}</div>
                </div>
            </template>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teacher</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users->where('teacher_id', '>=', 0) as $user)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->role ? $user->role->name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->teacher ? $user->teacher->name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->studentdb ? $user->studentdb->first_name . ' ' . $user->studentdb->last_name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->status ?: 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($user->status != 'inactive' && $user->id > 5 )
                                        <div class="flex space-x-3 justify-end">
                                            <button wire:click="edit({{ $user->id }})"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900"
                                                onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        </div>


        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teacher</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users->where('teacher_id', '<=', 0) as $user)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->role ? $user->role->name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->teacher ? $user->teacher->name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->studentdb ? $user->studentdb->first_name . ' ' . $user->studentdb->last_name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->status ?: 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($user->status != 'inactive' && $user->id > 5 )
                                        <div class="flex space-x-3 justify-end">
                                            <button wire:click="edit({{ $user->id }})"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900"
                                                onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div x-data="{ isOpen: @entangle('isOpen') }" x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&nbsp;

            <div x-show="isOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                {{ $isEdit ? 'Edit User' : 'Add New User' }}
                            </h3>
                            <div class="mt-4 w-full">
                                <form wire:submit.prevent="store">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" wire:model.defer="name" id="name"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror"
                                                placeholder="Enter name">
                                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" wire:model.defer="email" id="email"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                                                placeholder="Enter email" {{ $isEdit ? 'readonly' : '' }}>
                                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700">
                                                Password
                                                {{ !$isEdit ? '(Required)' : '(Leave blank to keep current password)' }}
                                            </label>
                                            <input type="password" wire:model.defer="password" id="password"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror"
                                                placeholder="Enter password">
                                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="role_id"
                                                class="block text-sm font-medium text-gray-700">Role</label>
                                            <select wire:model.defer="role_id" id="role_id"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('role_id') border-red-500 @enderror">
                                                <option value="">-- Select Role --</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id') <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="teacher_id"
                                                class="block text-sm font-medium text-gray-700">Teacher</label>
                                            <select wire:model.defer="teacher_id" id="teacher_id"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">-- Select Teacher --</option>
                                                @foreach($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="studentdb_id"
                                                class="block text-sm font-medium text-gray-700">Student</label>
                                            <select wire:model.defer="studentdb_id" id="studentdb_id"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">-- Select Student --</option>
                                                @foreach($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->first_name }}
                                                        {{ $student->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="status"
                                                class="block text-sm font-medium text-gray-700">Status</label>
                                            <select wire:model.defer="status" id="status"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">-- Select Status --</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="store" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ $isEdit ? 'Update User' : 'Create User' }}
                    </button>
                    <button @click="isOpen = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
