<div class="w-full bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center gap-5 p-4">
        <!-- Avatar + basic info -->
        <div class="relative flex-shrink-0">
            @if(isset($teacher) && $teacher->img_ref)
                <img class="h-16 w-16 rounded-full object-cover border-2 border-white shadow"
                     src="{{ asset('storage/' . $teacher->img_ref) }}" alt="{{ $user->name }}">
            @else
                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-2xl shadow">
                    {{ mb_substr($user->name ?? '', 0, 1) }}
                </div>
            @endif
            <span class="absolute -bottom-0.5 -right-0.5 h-4 w-4 bg-green-500 rounded-full border-2 border-white"></span>
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-lg font-semibold text-gray-900 truncate">{{ $user->name ?? '—' }}</h2>
                @if(isset($role) && $role->name)
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">
                        {{ $role->name }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full
                    {{ ($user->status ?? 'active') === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    <span class="h-2 w-2 rounded-full {{ ($user->status ?? 'active') === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                    {{ ucfirst($user->status ?? 'Active') }}
                </span>
            </div>

            <div class="mt-1 text-sm text-gray-600 flex flex-wrap gap-x-4 gap-y-1">
                <span>{{ $user->email ?? '—' }}</span>
                @if(isset($teacher))
                    <span>• {{ $teacher->desig ?: '—' }}</span>
                    @if($teacher->mobno)
                        <span>• {{ $teacher->mobno }}</span>
                    @endif
                    @if(isset($teacher->school))
                        <span>• {{ $teacher->school->name ?? '—' }}</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>