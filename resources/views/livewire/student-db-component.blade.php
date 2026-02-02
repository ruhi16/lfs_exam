<div class="p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Student Database</h2>
            <p class="text-gray-600 mt-1">Manage student records with comprehensive information</p>
        </div>
        <div class="flex space-x-3">
            <button wire:click="toggleDebugPanel"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-bug mr-2"></i>Debug Panel
            </button>
            <button wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Add New Student
            </button>
        </div>
    </div>

    <!-- Debug Panel -->
    @if($showDebugPanel)
    <div class="bg-gray-900 text-green-400 p-4 rounded-lg mb-6 font-mono text-sm">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-white font-bold">Debug Information</h3>
            <button wire:click="toggleDebugPanel" class="text-red-400 hover:text-red-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($debugInfo as $key => $value)
            <div>
                <span class="text-yellow-400">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                <span class="text-white">{{ is_array($value) ? json_encode($value) : ($value === true ? 'true' : ($value
                    === false ? 'false' : $value)) }}</span>
            </div>
            @endforeach
        </div>

        <!-- Storage Setup Instructions -->
        @if(isset($debugInfo['storage_link_exists']) && !$debugInfo['storage_link_exists'])
        <div class="mt-4 p-3 bg-red-900 border border-red-700 rounded">
            <h4 class="text-red-300 font-bold mb-2">⚠️ Storage Link Missing</h4>
            <p class="text-red-200 text-xs">Run: <code class="bg-red-800 px-1 rounded">php artisan storage:link</code>
            </p>
            <p class="text-red-200 text-xs">Or run: <code class="bg-red-800 px-1 rounded">php setup-storage.php</code>
            </p>
        </div>
        @endif

        @if(isset($debugInfo['profiles_dir_exists']) && !$debugInfo['profiles_dir_exists'])
        <div class="mt-2 p-3 bg-yellow-900 border border-yellow-700 rounded">
            <h4 class="text-yellow-300 font-bold mb-2">⚠️ Profiles Directory Missing</h4>
            <p class="text-yellow-200 text-xs">Create: <code
                    class="bg-yellow-800 px-1 rounded">storage/app/public/student-profiles</code></p>
        </div>
        @endif
    </div>
    @endif

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Students</label>
                <input type="text" wire:model.debounce.300ms="searchTerm"
                    placeholder="Search by name, ID, father name, or Aadhar..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Class</label>
                <select wire:model="selectedClass"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Section</label>
                <select wire:model="selectedSection"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Sections</option>
                    @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="$set('searchTerm', '')"
                    class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-refresh mr-2"></i>Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($students->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Student Info
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Parents
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Class & Section
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Documents
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <!-- Student Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    @if($student->img_ref_profile)
                                    <img src="{{ asset('storage/' . $student->img_ref_profile) }}"
                                        alt="{{ $student->name }}"
                                        class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="h-12 w-12 rounded-full bg-gray-300 items-center justify-center border-2 border-gray-200"
                                        style="display:none;">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    @else
                                    <div
                                        class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $student->studentid }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M Y') : 'DOB:
                                        N/A' }}
                                        @if($student->ssex)
                                        • {{ $student->ssex }}
                                        @endif
                                        @if($student->blood_grp)
                                        • {{ $student->blood_grp }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Parents -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-male text-blue-500 w-4 mr-2"></i>
                                    <span>{{ $student->fname ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-female text-pink-500 w-4 mr-2"></i>
                                    <span>{{ $student->mname ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Class & Section -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-school text-indigo-500 w-4 mr-2"></i>
                                    <span>{{ $student->myclass ? $student->myclass->name : 'No Class' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-users text-green-500 w-4 mr-2"></i>
                                    <span>{{ $student->sections ? $student->sections->name : 'No Section' }}</span>
                                </div>
                            </div>
                            @if($student->admDate)
                            <div class="text-xs text-gray-500 mt-1">
                                Adm: {{ \Carbon\Carbon::parse($student->admDate)->format('d M Y') }}
                            </div>
                            @endif
                        </td>

                        <!-- Contact -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($student->mobl1)
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-phone text-green-500 w-4 mr-2"></i>
                                    <span>{{ $student->mobl1 }}</span>
                                </div>
                                @endif
                                @if($student->mobl2)
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-blue-500 w-4 mr-2"></i>
                                    <span>{{ $student->mobl2 }}</span>
                                </div>
                                @endif
                                @if(!$student->mobl1 && !$student->mobl2)
                                <span class="text-gray-400">No contact</span>
                                @endif
                            </div>
                            @if($student->vill1 || $student->dist)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $student->vill1 ? $student->vill1 : '' }}{{ $student->vill1 && $student->dist ? ', '
                                : '' }}{{ $student->dist ? $student->dist : '' }}
                            </div>
                            @endif
                        </td>

                        <!-- Documents -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <div class="text-center">
                                    <i
                                        class="fas fa-image {{ $student->img_ref_profile ? 'text-green-500' : 'text-gray-300' }} text-lg"></i>
                                    <p class="text-xs text-gray-500 mt-1">Photo</p>
                                </div>
                                <div class="text-center">
                                    <i
                                        class="fas fa-certificate {{ $student->img_ref_brthcrt ? 'text-green-500' : 'text-gray-300' }} text-lg"></i>
                                    <p class="text-xs text-gray-500 mt-1">Birth</p>
                                </div>
                                <div class="text-center">
                                    <i
                                        class="fas fa-id-card {{ $student->img_ref_adhaar ? 'text-green-500' : 'text-gray-300' }} text-lg"></i>
                                    <p class="text-xs text-gray-500 mt-1">Aadhar</p>
                                </div>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                                                {{ $student->crstatus === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($student->crstatus ?? 'active') }}
                            </span>
                            @if($student->adhaar)
                            <div class="text-xs text-gray-500 mt-1">
                                Aadhar: {{ substr($student->adhaar, 0, 4) }}****{{ substr($student->adhaar, -4) }}
                            </div>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="grid grid-cols-2 gap-2">
                                <button wire:click="edit({{ $student->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button wire:click="delete({{ $student->id }})"
                                    onclick="return confirm('Are you sure you want to delete this student?')"
                                    class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition-colors">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                                {{-- <a href="{{ route('admin.student-idcard-comp', [ 'uuid' => $student->id ]) }}" target="_blank"
                                class="px-3 py-1 bg-yellow-600 text-white text-xs rounded hover:bg-yellow-700 transition-colors">
                                    <i class="fas fa-bug mr-1"></i>Id Card
                                </a> --}}
                                @if($student->img_ref_profile)
                                <button wire:click="testImagePath({{ $student->id }})"
                                    class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                    <i class="fas fa-bug mr-1"></i>Test
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-users text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Found</h3>
            <p class="text-gray-600 mb-4">Get started by adding your first student record.</p>
            <button wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Add Student
            </button>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $students->links() }}
    </div>

    <!-- 4-Step Modal Form -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $editMode ? 'Edit Student' : 'Add New Student' }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Step {{ $currentStep }} of {{ $totalSteps }}</p>
                </div>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress</span>
                    <span class="text-sm text-gray-500">{{ round(($currentStep / $totalSteps) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                        style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                </div>

                <!-- Step Labels -->
                <div class="flex justify-between mt-3 text-xs">
                    <span class="{{ $currentStep >= 1 ? 'text-blue-600 font-medium' : 'text-gray-400' }}">Basic
                        Info</span>
                    <span class="{{ $currentStep >= 2 ? 'text-blue-600 font-medium' : 'text-gray-400' }}">Address</span>
                    <span
                        class="{{ $currentStep >= 3 ? 'text-blue-600 font-medium' : 'text-gray-400' }}">Academic</span>
                    <span
                        class="{{ $currentStep >= 4 ? 'text-blue-600 font-medium' : 'text-gray-400' }}">Documents</span>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <!-- Step 1: Basic Information -->
                @if($currentStep === 1)
                <div class="space-y-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
                            <input type="text" wire:model="studentid"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student Name *</label>
                            <input type="text" wire:model="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Father's Name</label>
                            <input type="text" wire:model="fname"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('fname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mother's Name</label>
                            <input type="text" wire:model="mname"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('mname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                            <input type="date" wire:model="dob"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('dob') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select wire:model="ssex"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('ssex') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Blood Group</label>
                            <select wire:model="blood_grp"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                            @error('blood_grp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student Aadhar</label>
                            <input type="text" wire:model="adhaar" maxlength="12"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('adhaar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Father's Aadhar</label>
                            <input type="text" wire:model="fadhaar" maxlength="12"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('fadhaar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mother's Aadhar</label>
                            <input type="text" wire:model="madhaar" maxlength="12"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('madhaar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endif

                <!-- Step 2: Address & Contact -->
                @if($currentStep === 2)
                <div class="space-y-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Address & Contact Information</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Village/Area 1</label>
                            <input type="text" wire:model="vill1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('vill1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Village/Area 2</label>
                            <input type="text" wire:model="vill2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('vill2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Post Office</label>
                            <input type="text" wire:model="post"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('post') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Police Station</label>
                            <input type="text" wire:model="pstn"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('pstn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">District</label>
                            <input type="text" wire:model="dist"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('dist') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">PIN Code</label>
                            <input type="text" wire:model="pin" maxlength="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('pin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                            <input type="text" wire:model="state"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile 1</label>
                            <input type="text" wire:model="mobl1" maxlength="10"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('mobl1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile 2</label>
                            <input type="text" wire:model="mobl2" maxlength="10"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('mobl2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endif

                <!-- Step 3: Academic & Personal Details -->
                @if($currentStep === 3)
                <div class="space-y-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Academic & Personal Details</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admission Book No.</label>
                            <input type="number" wire:model="admBookNo"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('admBookNo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admission Sl. No.</label>
                            <input type="number" wire:model="admSlNo"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('admSlNo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admission Date</label>
                            <input type="date" wire:model="admDate"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('admDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Previous Class</label>
                            <input type="text" wire:model="prCls"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('prCls') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Previous School</label>
                            <input type="text" wire:model="prSch"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('prSch') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Class</label>
                            <select wire:model="stclass_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('stclass_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Section</label>
                            <select wire:model="stsection_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                            @error('stsection_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Physical Challenge</label>
                            <input type="text" wire:model="phch"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('phch') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Religion</label>
                            <input type="text" wire:model="relg"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('relg') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Caste</label>
                            <input type="text" wire:model="cste"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('cste') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nationality</label>
                            <input type="text" wire:model="natn" value="Indian"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('natn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endif

                <!-- Step 4: Bank Details & Documents -->
                @if($currentStep === 4)
                <div class="space-y-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Bank Details & Documents</h4>

                    <!-- Bank Details -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-3">Bank Information</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Account Number</label>
                                <input type="text" wire:model="accNo"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('accNo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">IFSC Code</label>
                                <input type="text" wire:model="ifsc" maxlength="11"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('ifsc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">MICR Code</label>
                                <input type="text" wire:model="micr" maxlength="9"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('micr') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bank Name</label>
                                <input type="text" wire:model="bnnm"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('bnnm') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Branch Name</label>
                                <input type="text" wire:model="brnm"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('brnm') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Document Uploads -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-3">Document Uploads</h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                                <input type="file" wire:model="profile_image" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('profile_image') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                                @if($profile_image)
                                <div class="mt-2">
                                    <img src="{{ $profile_image->temporaryUrl() }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                </div>
                                @elseif($img_ref_profile)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $img_ref_profile) }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Birth Certificate</label>
                                <input type="file" wire:model="birth_certificate" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('birth_certificate') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                                @if($birth_certificate)
                                <div class="mt-2">
                                    <img src="{{ $birth_certificate->temporaryUrl() }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                </div>
                                @elseif($img_ref_brthcrt)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $img_ref_brthcrt) }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Aadhar Card</label>
                                <input type="file" wire:model="aadhar_card" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('aadhar_card') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                @if($aadhar_card)
                                <div class="mt-2">
                                    <img src="{{ $aadhar_card->temporaryUrl() }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                </div>
                                @elseif($img_ref_adhaar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $img_ref_adhaar) }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                        <textarea wire:model="remarks" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Any additional remarks or notes..."></textarea>
                        @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-between items-center p-6 border-t border-gray-200">
                <div>
                    @if($currentStep > 1)
                    <button wire:click="previousStep"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    @endif
                </div>

                <div class="flex space-x-3">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>

                    @if($currentStep < $totalSteps) <button wire:click="nextStep"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Next<i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        @else
                        <button wire:click="save"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>{{ $editMode ? 'Update' : 'Save' }} Student
                        </button>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('message') }}
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif
</div>

<script>
    // Auto-hide flash messages
    setTimeout(function () {
        const messages = document.querySelectorAll('[class*="fixed top-4 right-4"]');
        messages.forEach(function (message) {
            message.style.opacity = '0';
            setTimeout(function () {
                message.remove();
            }, 300);
        });
    }, 5000);
</script>